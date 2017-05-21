<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map_model extends CI_Model
{
        private $db;
    public function __construct()
    {
            parent::__construct();
            $this->db = $this->load->database('default', TRUE);
    }
    
    public function show_contacts_on_map()
    {
        $select = 'user.id, '
                . 'first_name, '
                . 'last_name, '
                . 'email, '
                . 'phone_number, '
                . 'gps_update_time, '
                . 'latitude, '
                . 'longitude ';
        $owner = $this->session->userdata('email');
        $users = $this->db->select($select)
                          ->from('user')
                          ->where('longitude IS NOT NULL')
                          ->join('contacts', 'contacts.member = user.email')
                          ->where('contacts.owner', $owner)
                          ->where('contacts.status', 'visible')
                          ->join("(SELECT name, status FROM category WHERE owner='$owner') as cat", 'cat.name = contacts.category')
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
    
    public function set_my_location()
    {
        //date_default_timezone_set('UTC');
        $latitude  = $this->input->post('latitude', true);
        if (empty($latitude)) return;
        $longitude = $this->input->post('longitude', true);
        $email     = strtolower($this->session->userdata('email'));
        
        $location = array(
            'latitude'        => $latitude,
            'longitude'       => $longitude,
            'gps_update_time' => date("Y-m-d H:i:s")
        );
        return $this->db->where('email', $email)
                        ->update('user', $location);
    }
}
