<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $db;
    public function __construct()
    {
            parent::__construct();
            $this->db = $this->load->database('default', TRUE);
    }
    
    // user/change_user_settings
    public function save_user_settings_form()
    {
        $user = array(
           'first_name'   => $this->input->post('first_name', true),
           'last_name'    => $this->input->post('last_name', true),
           'email'        => strtolower($this->input->post('email', true)),
           'address'      => $this->input->post('address', true),
           'phone_number' => $this->input->post('phone_number', true),
        );
        if ($this->input->post('password', true))
        {
            $user['password'] = md5($this->input->post('password'));
        }    
        if ($this->db->where('id', $this->session->userdata('id'))->update('user', $user))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
     
    public function get_user($id)
    {
        $data = $this->db->where('id', $id)
                         ->get('user')
                         ->result_array();
        return $data[0];
    }
    
    public function delete_account()
    {
        $user = $this->session->userdata('email');
        
        $this->db->trans_start();
        
        $this->db->where('owner', $user)
                 ->delete('category');
        
        $this->db->where('owner', $user)
                 ->or_where('member', $user)
                 ->delete('contacts');
        
        $this->db->where('request_to', $user)
                 ->or_where('request_from')
                 ->delete('requests');
        
        $this->db->where('email', $user)
                 ->delete('user');
        
        return $this->db->trans_complete();
    }
}