<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Navigation extends CI_Model
{
    private $db;
    public function __construct()
    {
            parent::__construct();
            $this->db = $this->load->database('default', TRUE);
    }
    
    public function get_side_menu($menu)
    {
        return $this->db->select('controller, '
                               . 'navigation_menu, '
                               . 'submenu, '
                               . 'title')
                        ->distinct()
                        ->from('navigation')
                        ->where('navigation_menu', $menu)
                        ->order_by('navigation_menu, submenu, sort_order')
                        ->get();
    }
    
    public function get_top_menu()
    {
        return $this->db->select('navigation_menu')
                        ->distinct()
                        ->from('navigation')
                        ->order_by('navigation_menu', 'desc')
                        ->get();
    }
}