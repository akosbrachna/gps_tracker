<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Base_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('navigation');

        $data['topbar']['topmenu'] = $this->navigation->get_top_menu();
        
        $nav = $this->navigation->get_top_menu();
        foreach ($nav->result() as $key => $value)
        {
            $data['sidebar'][$value->navigation_menu] = $this->navigation->get_side_menu($value->navigation_menu);
        }

        $data['main_view'] = 'templates/main/start';
        $this->load->view('templates/main/template', $data);
    }
}
