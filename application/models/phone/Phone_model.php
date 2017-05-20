<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Phone_model extends CI_Model
{
    private $db;
    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }
}