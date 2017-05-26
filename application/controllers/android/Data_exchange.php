<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_exchange extends Base_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('android/data_exchange_model');
    }
    
    public function check_my_connection($email, $password)
    {
        echo $this->data_exchange_model->check_my_connection($email, $password);
    }
    
    public function set_my_location($email, $password, $latitude, $longitude)
    {
        echo $this->data_exchange_model->set_my_location($email, $password, $latitude, $longitude);
        
    }
    
    public function get_contacts_locations($email, $password)
    {
        $data = $this->data_exchange_model->get_contacts_locations($email, $password);
        
        echo json_encode($data);
    }
    
        public function get_all_contacts($email, $password)
    {
        $data = $this->data_exchange_model->get_all_contacts($email, $password);
        
        echo json_encode($data);
    }
}