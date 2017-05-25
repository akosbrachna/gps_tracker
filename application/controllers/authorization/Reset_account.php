<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset_account extends Base_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('authorization/reset_account_model');
    }
    
    public function forgot_password()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            if ($this->form_validation->run())
            {
                if ($this->reset_account_model->email_address_exists() == false)
                {
                    $this->data['message'] = '<font color="red">Please check if the email address is correct.</font><br />';
                    $this->data['message'].= '<font color="red">It does not exist in the database.</font><br />';
                }  
                else
                {
                    $hash = sha1('06Y7fnSmcx2u5LIKj9sM85H6ZItyqV0f'.random_string());
                    if ($this->reset_account_model->save_password_reset_hash_in_db($hash) == false)
                    {
                        $this->data['message'] = 'Something went wrong. Please try again. '
                                               . 'You may need to refresh the page.';
                    }
                    else
                    {
                        $this->load->library('email');
                        $message = 'Hello '.$this->input->post('email').'!<br /><br />'
                                 . 'There was a request to change your password. '
                                 . 'If you did not make this request, just ignore this email.<br />'
                                 . 'Otherwise, please click the following link '
                                 . 'to change your password on the GPS Tracker website:<br />'
                                 . '<a href="'.base_url("change_password/$hash").'" >Change password</a>';

                        $this->email->from('gps_tracker@gmail.com', 'GPS Tracker support');
                        $this->email->to($this->input->post('email'));
                        $this->email->subject('Password reset');
                        $this->email->message($message);

                        if ($this->email->send())
                        {
                            $this->data['message'] = 'Email has been sent to you with reset password link.';
                        }
                        else
                        {
                            $this->data['message'] = 'Something went wrong. Please try again.'
                                                   . 'You may need to refresh the page.';
                        }
                    }
                }
            }
        }
        $this->load->view('authorization/forgot_password', $this->data);
    }
    
    public function reset_password($hash = 'no hash')
    {
        if ($this->reset_account_model->check_hash($hash) == false)
        {
            redirect();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[16]|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required');

            if ($this->form_validation->run())
            {
                if ($this->reset_account_model->save_new_password($hash))
                {
                    $this->data['message'] = 'Password has been successfully saved <br />';
                    $this->data['message'].= '<a href="'.base_url().'">Back to the login page.</a> <br />';
                }
                else
                {
                    $this->data['message'] = 'Something went wrong.<br />';
                    $this->data['message'].= 'Please go back to the <a href="'.base_url()
                                     .'authorization/authorization/forgot_password">'
                                    . 'password reset page</a> and try again.<br />';
                }
            }
        }
        $this->load->view('authorization/reset_password', $this->data);
    }
}
