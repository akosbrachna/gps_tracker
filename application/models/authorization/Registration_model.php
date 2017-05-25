<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration_model extends CI_Model
{
    private $db;
    public function __construct()
    {
            parent::__construct();
            $this->db = $this->load->database('default', TRUE);
    }
    
    public function user_exists() 
    {  
        $email = strtolower($this->input->post('email', true));
        
        $user = $this->db->where('email', $email)
                         ->get('user');
        
        if ($user->num_rows() > 0)
        {
            return true;
        }
        return false;
    }
    
    public function register()
    {
        $email    = strtolower($this->input->post('email', true));
        $password = $this->input->post('password', true);
        $session  = $this->session->userdata('session_id');
        
        $user = array(
           'first_name'   => $this->input->post('first_name', true),
           'last_name' 	  => $this->input->post('last_name', true),
           'email'        => $email,
           'address'      => $this->input->post('address', true),
           'phone_number' => $this->input->post('phone_number', true),
           'password' 	  => md5($password),
           'confirm'      => md5($email.$password).$session,
           'createdAt'	  => date('Y-m-d H:i:s')
        );
        
        return $this->db->insert('user', $user);
    }
    
    public function confirm($hash_key)
    {   
        $user = $this->db->where('confirm', $hash_key)
                         ->get('user')
                         ->result_array();
        if (count($user) == 1)
        {
            $category = array(
                'name'  => 'Friends',
                'owner' => $user[0]['email']
            );
            $this->db->trans_start();
            $this->db->insert('category', $category);
            $this->db->where('confirm', $hash_key)->update('user', array('confirm'=>'1'));
            return $this->db->trans_complete();
        }
        else 
        {
            return false;
        }
    }
}
