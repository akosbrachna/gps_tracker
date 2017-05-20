<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $db;
    public function __construct()
    {
            parent::__construct();
            $this->db = $this->load->database('default', TRUE);
    }
    
    // user/register
    public function save_user_form_on_first_login()
    {
        $user = array(
           'address'      => $this->input->post('address', true),
           'phone_number' => $this->input->post('phone_number', true),
           'password'     => md5($this->input->post('password', true)),
           'first_login'  => 1
        );
        $id = $this->session->userdata('id');
        
        if ($this->db->where('id', $id)->update('user', $user))
        {
            return true;
        }
        else
        {
            return false;
        }
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
}