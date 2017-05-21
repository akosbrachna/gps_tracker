<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('phone/map_model');
    }
    public function show_contacts_on_map()
    {
        if ($this->input->post('json', true)) 
        {
            $this->map_model->set_my_location();
            
            $this->data['records'] = $this->map_model->show_contacts_on_map();
            echo json_encode($this->data['records']);
        }else
        {
            $this->load->view('map/contacts_location', $this->data);
        }
    }
}
