<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model 
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }
    
    private function decrypt_password()
    {
        $this->load->library('myencryption');
        
        $pubkey = $this->input->post('pubkey', true);
        $pass = $this->db->select('private_key, last_activity, UNIX_TIMESTAMP() as unix_time', false)
                         ->where('session_id', $this->session->userdata('session_id'))
                         ->get('ci_sessions')
                         ->result_array();
        
        $time_now = (int)$pass[0]['unix_time'];
        $expiry_time = (int)$pass[0]['last_activity'] + 1*60;
        if ($expiry_time < $time_now ){
            return false;
        }
        else 
        {
            $this->db->where('session_id', $this->session->userdata('session_id'))
                     ->update('ci_sessions', array('private_key'=>''));
            $privkey = $pass[0]['private_key'];
        }
        
        return $this->myencryption->decrypt($pubkey, $privkey);
    }

    public function login()
    {
        //$password = $this->decrypt_password(); // only on http - no need for this on https
        $password = $this->input->post('password', true);
        $email    = strtolower($this->input->post('email', true));
        
        $phone    = $this->input->post('phone', true)?1:0;

        $user = $this->db->where('email', $email)
                         ->where('confirm', '1')
                         ->where('password', md5($password))
                         ->get('user')
                         ->result_array();
        
        if(count($user) > 0)
        {
            $user_data = array(
                'logged_in'    => true,
                'id'           => $user[0]['id'],
                'email'        => $user[0]['email'],
                'phone'        => $phone
                );
            $this->session->set_userdata($user_data);
            return true;
        }
        else 
        {
            return false;
        }
    }
    
    public function update_last_activity()
    {
        $this->db->set('last_activity', 'UNIX_TIMESTAMP()', FALSE);
        return $this->db->where('session_id', $this->session->userdata('session_id'))
                        ->update('ci_sessions');
    }
}
