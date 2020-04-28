<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends Base_Controller
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('authorization/registration_model');
    }
    
    public function register()
    {   
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', 'First name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 
                                    'trim|required|min_length[4]|max_length[16]|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('phone_number', 'Phone number', 'trim|required');
            
            if ($this->form_validation->run())
            {
                if ($this->registration_model->user_exists())
                {
                    $this->data['message'] = 
                            '<font color="red">This email address already exists.</font><br />'
                           .'Please try some other email address.';                    
                }
                else
                {
                    if ($this->registration_model->register() == false)
                    {
                        $this->data['message'] = 'Something went wrong. Please try to register again';
                    }
                    else
                    {
                        $this->load->library('my_photo');
                        $this->my_photo->save_my_photo($this->input->post('email'));
                        if ($this->send_email())
                        {
                            $this->data['message'].= 'Account has been successfully created.<br/><br/>'
                                                   . 'A confirmation email has been sent to you.<br/>'
                                                   . '(You may need to check your spam folder too.)<br/><br/>'
                                                   . 'You can login to the website after you clicked<br/>'
                                                   . 'the confirmation link in the email.';
                            $this->load->view('templates/message', $this->data);
                            return;
                        }
                        else
                        {
                            $this->data['message'].= //$this->email->print_debugger().
                                                      '<br />Something went wrong. '
                                                    . 'Please try to register again.<br/>'
                                                    . 'Check if your email address is correct.';
                        }
                    }
                }
            }
        }
        $this->load->view('authorization/register', $this->data);
    }
    
    private function send_email()
    {
        $this->load->library('email');

        $email    = strtolower($this->input->post('email', true));
        $password = $this->input->post('password', true);
        $session  = $this->session->userdata('session_id');
        $hash     = md5($email.$password).$session;
        
        $message = 'Dear '.$this->input->post('first_name').',<br /><br/>'
                 . 'You\'ve registered on our website. <br />'
                 . 'If it was not you, ignore this email otherwise please follow this link: '
                 . 'httpscolonslashslashakosbrachnadot000webhostappdotcomslashconfirmslash'.$hash.' '
                 . '<br />Please replace colon, slash and dot respectively to open the above link in your browser '
                 . 'to confirm your registration <br />'
                 . 'The reason why i dont present the link correctly because gmail '
                 . 'would evaluate the link suspicious and it would block the message. This is '
                 . 'why it has to be done manually.';
        
        $this->email->to($email);
        $this->email->from('gps.tracker.webhost@gmail.com', 'GPS Tracker support');
        $this->email->subject('Registration on GPS tracker confirmation email.');
        $this->email->message($message);

        return $this->email->send();
    }
        
    public function confirm($hash_key)
    {
        if ($this->registration_model->confirm($hash_key))
        {
            $this->data['message'] = 'Email confirmed.<br/><br/>'
                                   . 'You can now log in to the website on the  '
                                   .'<a href="'.base_url().'" >login page</a>';
        }
        else
        {
            $this->data['message'] = 'Something went wrong. Please try to register again.';
        }
        $this->load->view('templates/message', $this->data);
    }
}
