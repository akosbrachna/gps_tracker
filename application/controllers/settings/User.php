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
                switch ($this->user_model->save_user_settings_form()) 
                {
                    case 0:
                        $this->data['message'] = 'Something went wrong. Please try again. ';
                        break;
                    case 1:
                        $this->data['message'] = 'Form has been succesfully modified. ';
                        break;
                    case 2:
                        if ($this->send_email())
                            $this->data['message'] = 'Email has been sent to your new email address. '
                                                    . 'You need to verify it before it is permanently saved.';
                        break;
                    case 3:
                        $this->data['message'] = 'This email address already exists. '
                                                . 'Please try some other email address.';
                        break;
                    default:
                        break;
                }
                $this->my_photo->save_my_photo($this->session->userdata('email'));
            }
            $this->send_messages();
            return;
        }
        $this->data['photo'] = $this->my_photo->get_photo_relative_path($this->session->userdata('email'));
        $this->data['records'] = $this->user_model->get_user($this->session->userdata('id'));
        $this->load->view('settings/user/user_settings', $this->data);
    }
    
    private function send_email()
    {
        $this->load->library('email');

        $email = strtolower($this->input->post('email', true));
        $hash  = md5($email).$this->session->userdata('session_id');
        
        $message = 'Dear '.$this->input->post('first_name').',<br /><br/>'
                 . 'You\'ve changed your email address on our website. <br />'
                 . 'Please follow <a href="'.base_url('new_email').'/'.$hash.'" >this link</a> '
                 . 'to confirm your new email address.';
        
        $this->email->to($email);
        $this->email->from('gps.tracker.webhost@gmail.com', 'GPS Tracker support');
        $this->email->subject('Email modification request on GPS tracker website.');
        $this->email->message($message);

        return $this->email->send();
    }
    
    public function save_new_email_address($hash)
    {
        if ($this->user_model->save_new_email_address($hash))
        {
            $this->data['message'] = 'New email address has been confirmed.<br /><br/>'
                                    .'Back to <a href="'.base_url().'" >main page</a>';
        }
        else
        {
            $this->data['message'] = 'Something went wrong. '
                                   . 'Please try to modify your email address again.';
        }
        $this->load->view('templates/message', $this->data);
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