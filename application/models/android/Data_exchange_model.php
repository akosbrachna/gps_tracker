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
                          ->where('member', $my_email)
                          ->where('longitude IS NOT NULL')          
                          ->order_by('email')
                          ->get()
                          ->result_array();
        $categories = $this->db->select('member')
                               ->from('contacts')
                               ->join('category', 'category.name = contacts.category')
                               ->where('contacts.owner', $my_email)
                               ->where('category.owner', $my_email)
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
    
    public function get_all_contacts($email, $password)
    {
        $select = 'first_name, last_name, email';
        
        $owner = $this->db->select($select)
                          ->where('email', $email)
                          ->where('password', $password)
                          ->get('user')
                          ->result_array();
        if (count($owner) != 1) return array();
        $owner[0]['status'] = 'visible';
                
        $contacts = $this->db->select($select.', status')
                             ->from('user')
                             ->join('contacts', 'contacts.member = user.email')
                             ->where('contacts.owner', $email)
                             ->get()
                             ->result_array();
        $contacts[] = $owner[0];
        return $contacts;
    }
    
    public function change_contact_settings($email, $password, $contact_email, $status)
    {
        $this->db->set('contacts.status', $status)
                 ->where('contacts.owner', $email)
                 ->where('user.password', $password)
                 ->where('contacts.member', $contact_email)
                 ->update('contacts JOIN user ON contacts.owner= user.email');
        return $this->db->affected_rows();
    }
}