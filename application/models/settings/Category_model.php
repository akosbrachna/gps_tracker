<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model
{
    private $db;
    public function __construct()
    {
            parent::__construct();
            $this->db = $this->load->database('default', TRUE);
    }
    
    public function get_categories()
    {
        $owner = $this->session->userdata('email');
        $select = 'category.id as id, '
                . 'name as "Category name", '
                . 'category.status as "Visibility on my map", '
                . 'category.permission as "Permission to contacts", '
                . 'count(member) as "Contacts", '
                . 'created_at as "Date created"';
        $categories = $this->db->select($select)
                           ->from('category')
                           ->join("(SELECT category, member FROM contacts WHERE owner = '$owner') as cont", 'category.name = cont.category', 'left')
                           ->where('category.owner', $owner)
                           ->order_by('name')
                           ->group_by('name')
                           ->get()
                           ->result_array();

        return $categories;
    }
    
    public function get_category($id)
    {
        $data = $this->db->where('id', $id)
                         ->get('category')
                         ->result_array();
        return $data[0];
    }
    
    public function category_exists($id)
    {   
        if ($id) 
        {
            $this->db->where('id <>', $id);
        }
        
        $category = $this->db->where('name', $this->input->post('name', true))
                             ->where('owner', $this->session->userdata('email'))
                             ->get('category');
        
        return $category->num_rows();
    }
    
    public function create_category()
    {
        $category = array(
           'name'       => $this->input->post('name', true),
           'owner'      => $this->session->userdata('email'),
           'status'     => 'visible',
           'permission' => 'enabled',
           'created_at' => date('Y-m-d H:i:s')
        );
        return  $this->db->insert('category', $category);
    }
    
    public function modify_category()
    {
        $id       = $this->input->post('id', true);
        $category = $this->get_category($id);
        $old_name = $category['name'];
        $new_name = $this->input->post('name', true);
        
        $data = array(
            'name'       => $new_name,
            'status'     => $this->input->post('status', true),
            'permission' => $this->input->post('permission', true)
        );

        $this->db->trans_start();
        
        $this->db->where('id', $id)->update('category', $data);
        $this->db->where('category', $old_name)
                 ->where('owner', $this->session->userdata('email'))
                 ->update('contacts', array('category' => $new_name));

        return $this->db->trans_complete();
    }
    
    public function delete_category()
    {
        $category = $this->input->post('name', true);
        $owner    = $this->session->userdata('email');
        
        $this->db->trans_start();
        
        $contacts = $this->db->where('category', $category)
                             ->where('owner', $owner)
                             ->get('contacts')
                             ->result_array();
        
        foreach ($contacts as $value) 
        {
            $this->db->where('owner', $value['member'])
                     ->where('member', $owner)
                     ->delete('contacts');
        }
        
        $this->db->where('id', $this->input->post('id', true))
                 ->where('owner', $owner)
                 ->delete('category');
        
        $this->db->where('category', $category)
                 ->where('owner', $owner)
                 ->delete('contacts');
                
        $this->db->trans_complete();
    }
}