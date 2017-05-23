<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings/user_model');
        $this->load->library('my_photo');
    }
    
    public function change_user_settings()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', 'First name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('phone_number', 'Phone number', 'required');
            
            if ($this->form_validation->run())
            {
                if ($this->user_model->save_user_settings_form())
                {
                    $this->data['message'] .= 'Form has been succesfully saved. ';
                    $this->my_photo->save_my_photo($this->session->userdata('email'));
                }
                else
                {
                    $this->data['message'] .= 'Something went wrong. '
                                           . 'The username or email may address already exists. '
                                           . 'Please try another username and/or email address. ';
                }
            }
            $this->send_messages();
            return;
        }
        $this->data['photo'] = $this->my_photo->get_photo_relative_path($this->session->userdata('email'));
        $this->data['records'] = $this->user_model->get_user($this->session->userdata('id'));
        $this->load->view('settings/user/user_settings', $this->data);
    }
    
    public function delete_account()
    {
        if ($this->user_model->delete_account())
        {
            $photo   = $this->my_photo->get_photo_absolute_path($this->session->userdata('email'));
            $default = $this->my_photo->get_photo_absolute_path('default');
            if ($photo != $default)
            {
                unlink($photo);
            }
            $this->session->sess_destroy();
            redirect();
        }
        else
        {
            $this->data['message'] .= 'Something went wrong. Please refresh your browser and try again.';
            $this->send_messages();
        }
    }
}