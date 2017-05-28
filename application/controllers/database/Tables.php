<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tables extends Base_Controller
{
    public $db;
    
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->load->dbforge($this->db);
    }
    
    public function create()
    {
        $this->db->trans_start();
        $this->ci_sessions();
        $this->category();
        $this->contacts();
        $this->user();
        $this->requests();
        $this->navigation();
        if ($this->db->trans_complete()) echo " Tables have been created successfully.";
    }
    
    private function ci_sessions()
    {
        $this->dbforge->add_field("session_id varchar(40) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("ip_address varchar(45) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("user_agent varchar(120) NOT NULL");
        $this->dbforge->add_field("last_activity int(10) unsigned NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("user_data text NOT NULL");
        $this->dbforge->add_field("private_key varchar(2048) DEFAULT NULL");
        $this->dbforge->add_key('session_id', TRUE);
        $this->dbforge->add_key('last_activity', TRUE);
        $this->dbforge->create_table('ci_sessions', TRUE);
    }

    private function category()
    {
        $this->dbforge->add_field("id int(11) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("name varchar(255) NOT NULL");
        $this->dbforge->add_field("owner varchar(255) NOT NULL");
        $this->dbforge->add_field("status varchar(255) NOT NULL DEFAULT 'visible'");
        $this->dbforge->add_field("permission varchar(255) NOT NULL DEFAULT 'enabled'");
        $this->dbforge->add_field("created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('category', TRUE);
    }

    private function contacts()
    {
        $this->dbforge->add_field('id int(11) NOT NULL AUTO_INCREMENT');
        $this->dbforge->add_field('owner varchar(255) NOT NULL');
        $this->dbforge->add_field('member varchar(255) NOT NULL');
        $this->dbforge->add_field('category varchar(255) NOT NULL');
        $this->dbforge->add_field("permission varchar(255) NOT NULL DEFAULT 'enabled'");
        $this->dbforge->add_field("status varchar(255) NOT NULL DEFAULT 'visible'");
        $this->dbforge->add_field('joined_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('contacts', TRUE);
    }
    
    private function user()
    {
        $this->dbforge->add_field("id int(10) unsigned NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("first_name varchar(255) NOT NULL");
        $this->dbforge->add_field("last_name varchar(255) DEFAULT NULL");
        $this->dbforge->add_field("email varchar(255) NOT NULL");
        $this->dbforge->add_field("password varchar(128) NOT NULL");
        $this->dbforge->add_field("address varchar(255) NOT NULL");
        $this->dbforge->add_field("longitude varchar(255) DEFAULT NULL");
        $this->dbforge->add_field("latitude varchar(255) DEFAULT NULL");
        $this->dbforge->add_field("gps_update_time datetime DEFAULT NULL");
        $this->dbforge->add_field("phone_number varchar(255) NOT NULL");
        $this->dbforge->add_field("confirm varchar(255) DEFAULT NULL");
        $this->dbforge->add_field("createdAt timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user', TRUE);
        $this->db->query('ALTER TABLE `user` ADD UNIQUE INDEX (`email`)');
    }
    
    private function requests()
    {
        $this->dbforge->add_field("id int(11) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("request_to varchar(255) NOT NULL");
        $this->dbforge->add_field("request_from varchar(255) NOT NULL");
        $this->dbforge->add_field("category varchar(255) NOT NULL");
        $this->dbforge->add_field("date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('requests', TRUE);
    }
        
    private function navigation()
    {
        $this->dbforge->add_field("id int(11) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("controller varchar(255) DEFAULT NULL");
        $this->dbforge->add_field("navigation_menu varchar(255) NOT NULL");
        $this->dbforge->add_field("submenu varchar(255) DEFAULT NULL");
        $this->dbforge->add_field("title varchar(255) NOT NULL");
        $this->dbforge->add_field("sort_order int(11) DEFAULT NULL");
        $this->dbforge->add_key('id', TRUE);
        if ($this->dbforge->create_table('navigation', TRUE))
        {
            $data = $this->init_navigation_table();
            $this->db->insert_batch('navigation', $data);
        }
        
    }
    
    private function init_navigation_table()
    {
        return array(
            array(
                  "controller"=>"settings/request/send_request",
                  "navigation_menu"=>"settings",
                  "submenu"=>"Contacts",
                  "title"=>"Requests"
                ),
            array(
                  "controller"=>"settings/contact/contacts",
                  "navigation_menu"=>"settings",
                  "submenu"=>"Contacts",
                  "title"=>"Contacts"
                ),
            array(
                  "controller"=>"map/map/show_contacts_on_map",
                  "navigation_menu"=>"Map",
                  "submenu"=>"Contacts",
                  "title"=>"Locations"
                ),
            array(
                  "controller"=>"settings/category/create_category",
                  "navigation_menu"=>"settings",
                  "submenu"=>"Categories",
                  "title"=>"Categories"
                ),
            array(
                  "controller"=>"resources/resources/index",
                  "navigation_menu"=>"resources",
                  "submenu"=>"Resources",
                  "title"=>"Project"
                )
            );
    }
}