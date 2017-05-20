<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request extends Base_Controller
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('admin/user_model');
        $this->load->model('admin/request_model');
    }
    
    public function send_request()
    {           
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('category', 'Category', 'trim|required');
            
            if ($this->form_validation->run())
            {
                switch ($this->request_model->send_request()) 
                {
                    case true:
                        if ($this->send_email())
                        {
                            $this->data['message'] .= 'Request has been sent.';
                        }
                        break;
                    case false:
                        $this->data['message'] = 'Something went wrong. Please try again';
                        break;
                    case 2:
                        $this->data['message'] = 'You have already sent a request.';
                        break;
                    case 3:
                        $this->data['message'] = 'Requested person is already in your contacts.';
                        break;
                    default:
                        break;
                }
            }
            $this->send_messages();
            return;
        }
        $this->data['categories']        = $this->request_model->get_categories();
        $this->data['incoming_requests'] = $this->request_model->incoming_requests();
        $this->data['outgoing_requests'] = $this->request_model->outgoing_requests();
        $this->load->view('admin/request/request', $this->data);
    }
    
    private function send_email()
    {
        $this->load->library('email');

        $message = 'Dear '.$this->input->post('first_name').'!<br />'
                  .'You are invited to join the GPS tracking group by '.$this->session->userdata('email')
                  .' <br />You can register on the website here: '
                . '<a href="'.base_url('signup').'" >GPS tracker registration</a>';
        $this->email->to($this->input->post('email'));
        $this->email->from('gps_tracker@gmail.com', 'GPS Tracker support');
        $this->email->subject('Invitation');
        $this->email->message($message);

        if ($this->email->send())
        {
            $this->data['message'].= 'Email has been sent to the user.';
            return true;
        }
        else
        {
            $this->data['message'].= 
                    //$this->email->print_debugger().
                    '<br />'
                . 'It seems that email has not been sent. <br />'
                . 'Please send an email to the user including the '
                . 'user\'s password and the website address: '.base_url();
            return false;
        }
    }
    
    public function get_request($id)
    {
        $this->data['records'] = $this->request_model->get_request($id);
        $this->data['categories'] = $this->request_model->get_categories();
        
        if ($this->data['records']['direction'] == 'incoming')
        {
            $this->data['photo'] = "web\pics\users\\".$this->data['records']['email'].".jpg";
            $this->load->view('admin/request/incoming_request', $this->data);
        }
        else
        {
            $this->data['photo'] = "web\pics\users\\".$this->data['records']['email'].".jpg";
            $this->load->view('admin/request/outgoing_request', $this->data);
        }
    }
    
    public function accept_request()
    {
        $this->request_model->accept_request();
    }
    
    public function cancel_request()
    {
        $this->request_model->cancel_request();
    }
}
