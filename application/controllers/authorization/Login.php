<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Base_Controller
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('encryption/encryption_model');
    }

    public function sign_in()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email address', 
                                              'trim|required');
            $this->form_validation->set_rules('password', 'Password', 
                                              'trim|required|min_length[4]|max_length[16]');

            if ($this->form_validation->run())
            {
                if ($this->login_model->login() == false)
                {
                    $this->data['message'] = 'Incorrect username or password. '
                                           . '<br/>'
                                           . 'Please refresh the page and try again.';
                }
                else
                {
                    if ($this->session->userdata('phone') == 1)
                    {
                        redirect('phone');
                    }
                    else
                    {
                        redirect('main');
                    }
                    return;
                }
            }
        }
        $this->login_model->update_last_activity();
        $this->data['pubkey'] = $this->encryption_model->generate_keys();
        $this->load->view('authorization/login', $this->data);
    }
    
    public function logout()
    {
        $this->session->sess_destroy();
        redirect();
    }
}
