<?php

//The base controller acts as a firewall for all requests therefore
//it is very important for all controller classes to have inherited from this base controller.

class Base_Controller extends CI_Controller 
{
    public $data = array();
    private $controller;
    public $exceptions = array(
                'authorization/reset_account/forgot_password',
                'authorization/reset_account/reset_password',
                'authorization/registration/register',
                'authorization/registration/confirm',
                'android/data_exchange/get_contacts_locations',
                'android/data_exchange/set_my_location',
                'android/data_exchange/check_my_connection',
                'android/data_exchange/get_all_contacts',
                'android/data_exchange/change_contact_settings',
        );
    function __construct()
    {
        parent::__construct();
        $this->controller = $this->get_controller();
        if ($this->controller == 'database/tables/create')
        {
            return;
        }
        $this->load->library('session');
        $this->load->model('authorization/login_model');
        $this->check_access_rights();
        $this->data['message'] = null;
        $this->load->helper('my_table_helper');
    }
    //firewall
    private function check_access_rights()
    {   
        $controller = $this->controller;
        
        if ($this->router->directory == "android") return;
        
        foreach ($this->exceptions as $exception) 
        {
            if ($controller == $exception)
            {
                return;
            }
        }
        
    	if ($this->session->userdata('logged_in') == true)
    	{
            if ($controller == 'main/index') 
            {
                return;
            }
            if ($controller == 'authorization/login/sign_in') 
            {
                if ($this->session->userdata('phone'))
                {
                    redirect('phone');
                }
                else{
                    redirect('main');
                }
            }
    	}
        else
        {
            if ($controller != 'authorization/login/sign_in')
            {
                redirect();
            }
        }
    }
    
    private function get_controller()
    {
        $controller = lcfirst($this->router->class).'/'.lcfirst($this->router->method);
        
        if (!empty($this->router->directory))
        {
            $controller = $this->router->directory."$controller";
        }
        return $controller;
    }
    
    protected function send_messages()
    {
        if (validation_errors() || $this->data['message'])
        {
            echo '<form_message>';
            echo validation_errors();
            echo $this->data['message'];
            echo '</form_message>';
        }
    }
}