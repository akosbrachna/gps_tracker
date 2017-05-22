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
        return $this->db->where('email', strtolower($email))
                        ->where('password', md5($password))
                        ->get('user')
                        ->num_rows();
    }
    
    public function set_my_location($email, $password, $latitude, $longitude)
    {
        //date_default_timezone_set('UTC');
        $data = array(
            'latitude'        => $latitude,
            'longitude'       => $longitude,
            'gps_update_time' => date("Y-m-d H:i:s")
        );
        return $this->db->where('email', strtolower($email))
                        ->where('password', md5($password))
                        ->update('user', $data);
    }
    
    public function get_contacts_locations($email, $password)
    {
        $my_email = strtolower($email);
        $select = 'first_name, last_name, email, latitude, longitude, gps_update_time';
        
        $owner = $this->db->select($select)
                          ->where('email', $my_email)
                          ->where('password', md5($password))
                          ->get('user')
                          ->result_array();
        if (count($owner) != 1) return array();

        $users = $this->db->select($select)
                          ->from('user')
                          ->join('contacts','contacts.owner = user.email')
                          ->join('category', 'category.owner = contacts.owner')
                          ->where('category.permission', 'enabled')
                          ->where('contacts.permission','enabled')
                          ->where('member', $owner)
                          ->where('longitude IS NOT NULL')          
                          ->order_by('email')
                          ->get()
                          ->result_array();
        $categories = $this->db->select('member')
                               ->from('contacts')
                               ->join('category', 'category.name = contacts.category')
                               ->where('contacts.owner', $owner)
                               ->where('category.owner', $owner)
                               ->where('contacts.status', 'visible')
                               ->where('category.status', 'visible')
                               ->order_by('member')
                               ->get()
                               ->result_array();
        $contacts = array();
        for ($i = 0; $i < count($users); $i++)
        {
            for ($j = 0; $j < count($categories); $j++)
            {
                if ($users[$i]['email'] == $categories[$j]['member'])
                {
                    $contacts[] = $users[$i];
                }
            }
        }
        $contacts[] = $owner[0];
        return $contacts;
    }
}