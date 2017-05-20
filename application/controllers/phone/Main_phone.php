<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_phone extends Base_Controller
{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $this->load->view('phone', $this->data);
    }
}