<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_model extends CI_Model
{
    private $db;
    public function __construct()
    {
            parent::__construct();
            $this->db = $this->load->database('default', TRUE);
    }
    
    public function get_users()
    {
        if ($this->input->post('status', true))
        {
            $this->db->where('user.status', $this->input->post('status'));
        }
        $select = 'user.id, '
                . 'email, '
                . 'first_name, '
                . 'last_name,'
                . 'status, '
                . 'permission, '
                . 'category, '
                . 'latitude, '
                . 'longitude, '
                . 'gps_update_time';
        $user = $this->db->select($select)
                         ->from('user')
                         ->join('contacts', 'user.email = contacts.member')
                         ->where('owner', $this->session->userdata('email'))
                         ->order_by('first_name')
                         ->get()
                         ->result_array();
        $users = array();
        $json = array();
        foreach ($user as $key=>$value)
        {
            $users[$key]['id']         = $value['id'];
            $users[$key]['Name']       = $value['first_name'].' '.$value['last_name'];
            $users[$key]['Email']      = $value['email'];
            $users[$key]['Category']   = $value['category'];
            $users[$key]['Visibility']     = $value['status'];
            $users[$key]['Permission'] = $value['permission'];
            $users[$key]['Last seen']  = $value['gps_update_time'];
            if (file_exists(FCPATH.'web\pics\users\\'.$value['email'].'.jpg'))
            {
                $users[$key]['Photo'] = '<img src="web/pics/users/'
                                        .$value['email'].'.jpg" style="height:60px;">';
            }
            else
            {
                $users[$key]['Photo'] = '<img src="web/pics/users/default.jpg" style="height:60px;">';
            }
            if ($value['latitude'])
            {
                $json[$key]['id']        = $value['id'];
                $json[$key]['name']      = $value['first_name'].' '.$value['last_name'];
                $json[$key]['latitude']  = $value['latitude'];
                $json[$key]['longitude'] = $value['longitude'];
            }
        }
        return $users;
    }
    
    public function get_user($id)
    {
        $user = $this->db->from('user')
                         ->join('contacts', 'contacts.member = user.email')
                         ->where('user.id', $id)
                         ->get()
                         ->result_array();
        return $user[0];
    }
    
    public function modify_contact_settings()
    {
        $contact = array(
            'status'     => $this->input->post('status', true),
            'category'   => $this->input->post('category', true),
            'permission' => $this->input->post('permission', true)
        );

        return $this->db->where('id', $this->input->post('id'))->update('contacts', $contact);
    }
    
    public function remove_user()
    {
        $me = $this->session->userdata('email');
        $contact = $this->input->post('email', true);
        
        $this->db->trans_start();
        
        $result = $this->db->where('owner', $me)
                           ->where('member', $contact)
                           ->delete('contacts');
        
        $result1 = $this->db->where('owner', $contact)
                            ->where('member', $me)
                            ->delete('contacts');
        
        $this->db->trans_complete();
        
        return $result&&$result1;
    }
}