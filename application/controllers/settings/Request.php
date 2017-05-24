<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request extends Base_Controller
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('settings/user_model');
        $this->load->model('settings/request_model');
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
                        $this->send_email();
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
        $this->load->view('settings/request/request', $this->data);
    }
    
    private function send_email()
    {
        $this->load->library('email');

        $message = 'Dear '.$this->input->post('first_name').'!<br /><br/>'
                  .$this->session->userdata('email').' has sent you a friend request from '
                  .'<a href="'.base_url().'" >GPS tracker</a>.';
        $this->email->to($this->input->post('email'));
        $this->email->from('gps_tracker@gmail.com', 'GPS Tracker support');
        $this->email->subject('Friend request from GPS tracker from '.$this->session->userdata('email'));
        $this->email->message($message);

        if ($this->email->send())
        {
            $this->data['message'].= 'Email has been sent.';
            return true;
        }
        else
        {
            $this->data['message'].= 'Email has not been sent. <br />'
                                    .'Please send an email to your friend including '
                                    .'the website address: '.base_url();
            return false;
        }
    }
    
    public function get_request($id)
    {
        $this->data['records'] = $this->request_model->get_request($id);
        $this->data['categories'] = $this->request_model->get_categories();
        $this->load->library('my_photo');
        $this->data['photo'] = $this->my_photo->get_photo_relative_path($this->data['records']['email']);
        if ($this->data['records']['direction'] == 'incoming')
        {
            $this->load->view('settings/request/incoming_request', $this->data);
        }
        else
        {
            $this->load->view('settings/request/outgoing_request', $this->data);
        }
    }
    
    public function accept_request()
    {
        if ($this->request_model->accept_request())
        {
            $this->data['message'] = 'Contact has been added to your contacts.';
        }
        else
        {
            $this->data['message'] = 'Something went wrong.';
        }
        $this->send_messages();
    }
    
    public function cancel_request()
    {
        if ($this->request_model->cancel_request())
        {
            $this->data['message'] = 'Request has been cancelled.';
        }
        else
        {
            $this->data['message'] = 'Something went wrong.';
        }
        $this->send_messages();
    }
}
