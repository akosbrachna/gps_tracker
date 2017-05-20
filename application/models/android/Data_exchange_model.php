<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_exchange_model extends CI_Model
{
    private $db;
    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }
    
    public function check_user($email, $password)
    {
        $data = $this->db->where('email', $email)
                         ->where('password', $password)
                         ->get('user');
        
        if ($data->num_rows() > 0 )
        {
            return true;
        }
        return false;
    }
    
    public function get_coordinates($email, $password, $latitude, $longitude)
    {
        //date_default_timezone_set('UTC');
        $data = array(
            'latitude'        => $latitude,
            'longitude'       => $longitude,
            'gps_update_time' => date("Y-m-d H:i:s")
        );
        $result = $this->db->where('email', $email)
                           ->where('password', $password)
                           ->update('user', $data);
        
        return $result;
    }
    
    public function get_user_coordinates($email, $password)
    {
        $select = 'first_name, last_name, email, latitude, longitude, gps_update_time';
        
        $users = $this->db->select($select)
                          ->from('user')
                          ->join('contacts', 'user.email = contacts.member')
                          ->where('owner', $this->session->userdata('email'))
                          ->order_by('first_name')
                          ->get()
                          ->result_array();
        
        $me = $this->db->select($select)
                       ->from('user')
                       ->where('email', $this->session->userdata('email'))
                       ->get()
                       ->result_array();
        
        $users[] = $me[0];
        return $users;
    }
}