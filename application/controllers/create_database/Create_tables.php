<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Create_tables extends Base_Controller
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->load->dbforge($this->db);
    }
    
    public function create_tables()
    {
        $this->category();
        $this->contacts();
        $this->user();
        $this->requests();
        $this->navigation();
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
        $this->dbforge->add_field("forgot_password_hash varchar(255) DEFAULT NULL");
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
            $this->init_navigation_table();
        }
        
    }
    
    private function init_navigation_table()
    {
        $data = array(
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