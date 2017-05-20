<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_exchange extends Base_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('android/data_exchange_model');
    }
    
    public function check_user($email, $password)
    {
        if ($this->data_exchange_model->check_user(strtolower($email), md5($password)))
                echo 1;
        else echo 0;
    }
    
    public function get_coordinates($email, $password, $latitude, $longitude)
    {
        echo $this->data_exchange_model->get_coordinates(strtolower($email), 
                                                          md5($password), 
                                                          $latitude, $longitude);
        
    }
    
    public function get_user_coordinates($email, $password)
    {
        $data = $this->data_exchange_model->get_user_coordinates(strtolower($email), md5($password));
    
        echo json_encode($data);
    }
}