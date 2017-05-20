<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resources extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $this->load->view('resources/resources');
    }
}
