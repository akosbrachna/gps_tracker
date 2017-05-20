<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request_model extends CI_Model
{
    private $db;
    public function __construct()
    {
            parent::__construct();
            $this->db = $this->load->database('default', TRUE);
    }
    
    public function user_exists() 
    {  
        $user = $this->db->where('email', strtolower($this->input->post('email', true)))
                         ->get('user');
        
        return $user->num_rows();
    }
    
    public function get_categories()
    {
        $categories = $this->db->select('name')
                           ->where('owner', $this->session->userdata('email'))
                           ->get('category')
                           ->result_array();
        $data = array();
        foreach($categories as $value)
        {
            $data[$value['name']] = $value['name'];
        }
        return $data;
    }
    
    public function send_request()
    {
        $request_to   = $this->input->post('email', true);
        $request_from = $this->session->userdata('email');
        $category     = $this->input->post('category', true);
        
        $contacts = $this->db->where('owner', $request_to)
                             ->where('member', $request_from)
                             ->get('contacts');
        
        if ($contacts->num_rows() > 0)
        {
            return 3;
        }
        $request = $this->db->where('request_to', $request_to)
                            ->where('request_from', $request_from)
                            ->get('requests');
        if ($request->num_rows() > 0)
        {
            return 2;
        }
        
        $data = array(
            'request_to'   => $request_to,
            'request_from' => $request_from,
            'category'     => $category
        );
        return $this->db->insert('requests', $data);
    }
    
    public function incoming_requests()
    {
        $select = 'requests.id, '
                . 'first_name, '
                . 'last_name, '
                . 'email, '
                . 'request_from,'
                . 'date_created';        
        $requests = $this->db->select($select)
                             ->from('requests')
                             ->join('user', 'requests.request_from = user.email')
                             ->where('request_to', $this->session->userdata('email'))
                             ->get()
                             ->result_array();
        $data = array();
        foreach ($requests as $key => $value) 
        {
            $data[$key]['id'] = $value['id'];
            $data[$key]["Request from"] = $value['first_name'].' '.$value['last_name'].' '.$value['request_from'];
            $data[$key]['Date sent'] = $value['date_created'];
        }
        return $data;
    }
    
    public function outgoing_requests()
    {
        $select = 'requests.id, '
                . 'first_name, '
                . 'last_name, '
                . 'email, '
                . 'category, '
                . 'request_to,'
                . 'date_created';        
        $requests = $this->db->select($select)
                             ->from('requests')
                             ->join('user', 'requests.request_to = user.email', 'left')
                             ->where('request_from', $this->session->userdata('email'))
                             ->get()
                             ->result_array();
        $data = array();
        foreach ($requests as $key => $value) 
        {
            $data[$key]['id'] = $value['id'];
            $data[$key]["Request sent to"] = $value['first_name'].' '.$value['last_name'].' '.$value['request_to'];
            $data[$key]['My category'] = $value['category'];
            $data[$key]['Date sent'] = $value['date_created'];
        }
        return $data;
    }
    
    public function get_request($id)
    {
        $request = $this->db->where('id', $id)
                            ->get('requests')
                            ->result_array();
        if ($request[0]['request_from'] == $this->session->userdata('email'))
        {
            //outgoing
            $request[0]['email'] = $request[0]['request_to'];
            $request[0]['direction'] = 'outgoing';
            return $request[0];
        }
        else
        {
            //incoming
            $in = $this->db->select('first_name, last_name, email')
                           ->where('email', $request[0]['request_from'])
                           ->get('user')
                           ->result_array();
            $data[0]['id'] = $request[0]['id'];
            $data[0]['name'] = $in[0]['first_name'].' '.$in[0]['last_name'];
            $data[0]['email'] = $in[0]['email'];
            $data[0]['direction'] = 'incoming';
            return $data[0];
        }
    }

    public function accept_request()
    {
        $request = $this->db->where('id', $this->input->post('id', true))
                            ->get('requests')
                            ->result_array();
        $from = array(
            'owner' => $request[0]['request_from'],
            'member' => $request[0]['request_to'],
            'category' => $request[0]['category']
        );
        $to = array(
            'owner' => $request[0]['request_to'],
            'member' => $request[0]['request_from'],
            'category' => $this->input->post('category', true)
        );
        $this->db->trans_start();
        $this->db->insert('contacts', $from);
        $this->db->insert('contacts', $to);
        $this->db->where('id', $this->input->post('id', true))->delete('requests');
        return $this->db->trans_complete();
    }
    
    public function cancel_request()
    {
        return $this->db->where('id', $this->input->post('id', true))->delete('requests');
    }
}
