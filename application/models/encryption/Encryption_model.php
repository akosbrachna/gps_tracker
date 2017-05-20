<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Encryption_model extends CI_Model 
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->load->library('myencryption');
    }
    
    public function generate_keys()
    {
        $keys = $this->myencryption->generate_keys();
        $this->db->where('session_id', $this->session->userdata('session_id'))
                 ->update('ci_sessions', array('private_key' => $keys["private"]));
        return $keys["public"];
    }
}
