<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('map/map_model');
    }
    public function show_contacts_on_map()
    {
        if ($this->input->post('json', true)) 
        {
            $this->data['records'] = $this->map_model->show_contacts_on_map();
            echo json_encode($this->data['records']);
        }else
        {
            $this->load->view('map/users_location', $this->data);
        }
    }
}
