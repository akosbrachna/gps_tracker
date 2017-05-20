<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map_model extends CI_Model
{
        private $db;
    public function __construct()
    {
            parent::__construct();
            $this->db = $this->load->database('default', TRUE);
    }
    
    public function show_users_on_map()
    {
        $select = 'user.id, '
                . 'first_name, '
                . 'last_name, '
                . 'email, '
                . 'phone_number, '
                . 'gps_update_time, '
                . 'latitude, '
                . 'longitude ';
        $users = $this->db->select($select)
                          ->from('user')
                          ->where('longitude IS NOT NULL')
                          ->join('contacts', 'contacts.member = user.email')
                          ->where('contacts.owner', $this->session->userdata('email'))
                          ->where('contacts.status', 'visible')
                          ->join('(SELECT name, status FROM category WHERE owner="akos.brachna@gmail.com") as cat', 'cat.name = contacts.category')
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
