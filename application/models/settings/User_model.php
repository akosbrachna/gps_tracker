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
        $id            = $this->session->userdata('id');
        $current_email = $this->session->userdata('email');
        $new_email     = strtolower($this->input->post('email', true));
        $password      = $this->input->post('password', true);
        $result        = 0;
        $user = array(
           'first_name'   => $this->input->post('first_name', true),
           'last_name'    => $this->input->post('last_name', true),
           'address'      => $this->input->post('address', true),
           'phone_number' => $this->input->post('phone_number', true),
        );
        if ($current_email != $new_email)
        {
            $check = $this->db->where('email', $new_email)
                              ->get('user')
                              ->num_rows();
            if ($check != 0) return 3;
            $result = 1;
            $user['new_email'] = $new_email;
            $user['change_email']   = md5($new_email).$this->session->userdata('session_id');
        }
        if (!empty($password))
        {
            $user['password'] = md5($password);
        }
        if ($this->db->where('id', $id)->update('user', $user))
        {
                $result++;
        }
        else{
            $result = 0;
        }
        
        return $result;
    }
    
    public function save_new_email_address($hash)
    {
        $user = $this->db->where('change_email', $hash)
                          ->get('user')
                          ->result_array();
        if (count($user) == 0)
        {
            return false;
        }
        $current_email = $user[0]['email'];
        $new_email = $user[0]['new_email'];
        $this->db->trans_start();
        
        $this->db->where('owner', $current_email)
                 ->update('category', array('owner' => $new_email));
        
        $this->db->where('owner', $current_email)
                 ->update('contacts', array('owner' => $new_email));
        
        $this->db->where('member', $current_email)
                 ->update('contacts', array('member' => $new_email));
        
        $this->db->where('request_to', $current_email)
                 ->update('requests', array('request_to' => $new_email));

        $this->db->where('request_from', $current_email)
                 ->update('requests', array('request_from' => $new_email));
        
        $data = array(
                      'email'     => $new_email, 
                      'change_email'   => '',
                      'new_email' => ''
            );
        
        $this->db->where('email', $current_email)
                 ->update('user', $data);

        $result = $this->db->affected_rows();
        
        if ($result > 0) 
        {
            $this->load->library('my_photo');
            $this->my_photo->rename_photo($current_email, $new_email);
            $this->session->set_userdata('email', $new_email);
        }
        
        $this->db->trans_complete();
        
        return $result;
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
                 ->or_where('request_from', $user)
                 ->delete('requests');
        
        $this->db->where('email', $user)
                 ->delete('user');
        
        return $this->db->trans_complete();
    }
}