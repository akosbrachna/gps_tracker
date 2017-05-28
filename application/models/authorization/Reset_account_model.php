<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset_account_model extends CI_Model 
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }
    
    // authorization/forgot_password
    public function email_address_exists()
    {
        $email = $this->input->post('email');
        $email = strtolower($email);
        $data = $this->db->where('email', $email)
                          ->get('user');
        
        if ($data->num_rows() > 0)
        {
            return true;
        }
        return false;
    }
    
    // auth/forgot_password
    public function save_password_reset_hash_in_db($hash)
    {   
        $email = $this->input->post('email');
        
        if ($this->db->where('email', $email)->update('user', array('confirm' => $hash)))
        {
            return true;
        }
        return false;
    }
    
    // authorization/reset_password
    public function check_hash($hash)
    {
        $query = $this->db->where('confirm', $hash)
                          ->get('user');
        
        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    // authorization/reset_password
    public function save_new_password($hash)
    {
        $data = array(
                'password' => md5($this->input->post('password')),
                'confirm' => ''
            );
        
        if ($this->db->where('confirm', $hash)->update('user', $data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
