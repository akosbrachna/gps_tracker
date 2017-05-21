<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_exchange_model extends CI_Model
{
    private $db;
    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }
    
    public function check_my_connection($email, $password)
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
    
    public function set_my_location($email, $password, $latitude, $longitude)
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
    
    public function get_contacts_locations($email, $password)
    {
        $select = 'first_name, last_name, email, latitude, longitude, gps_update_time';
        
        $users = $this->db->select($select)
                          ->from('user')
                          ->where('longitude IS NOT NULL')
                          ->join('contacts', 'contacts.member = user.email')
                          ->where('contacts.owner', $email)
                          ->where('contacts.status', 'visible')
                          ->join("(SELECT name, status FROM category WHERE owner='$email') as cat", 'cat.name = contacts.category')
                          ->where('cat.status', 'visible')
                          ->order_by('first_name')
                          ->get()
                          ->result_array();
        $owner = $this->db->where('email', $this->session->userdata('email'))
                          ->get('user')
                          ->result_array();
        $users[] = $owner[0];
        return $users;
    }
}