<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings/category_model');
    }
        
    public function create_category()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Group name', 'trim|required');
            
            if ($this->form_validation->run())
            {
                if ($this->category_model->category_exists(false))
                {
                    $this->data['message'] = 
                            '<font color="red">This category already exists.</font><br />'
                            . 'Please, use some other name.';                    
                }
                else
                {
                    if ($this->category_model->create_category() == false)
                    {
                        $this->data['message'] = 'Something went wrong. Please try again';
                    }
                    else
                    {
                        $this->data['message'] = 'Category has been successfully created.<br />'
                                               . 'You can start adding contacts to the category.';
                    }
                }
            }
            $this->send_messages();
            return;
        }
        $this->data['records'] = $this->category_model->get_categories();
        $this->load->view('settings/category/create_category', $this->data);
    }

    public function get_categories()
    {
        $this->data['records'] = $this->category_model->get_categories();
        if (count($this->data['records']) == 0)
        {
            $this->data['message'] = 'No category.';
            $this->send_messages();
        }
        $this->load->view('settings/category/category', $this->data);
    }
    
    public function get_category($id)
    {
        $this->data['records'] = $this->category_model->get_category($id);
        $this->load->view('settings/category/get_category', $this->data);
    }
    
    public function modify_category()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            
            if ($this->form_validation->run())
            {
                if ($this->category_model->category_exists($this->input->post('id', true)))
                {
                    $this->data['message'] = 
                            '<font color="red">This category already exists.</font><br />'
                            . 'Please, use some other name.';                    
                }
                else
                {
                    if ($this->category_model->modify_category())
                        {
                        $this->data['message'] = 'Group has been successfully modified. ';
                    }
                    else
                    {
                        $this->data['message'] = 'Something went wrong. '
                                               . 'The category name may already exist. '
                                               . 'Please try another name.';
                    }
                }
            }
            $this->send_messages();
        }
    }
    
    public function delete_category()
    {
        if ($this->category_model->delete_category())
        {
            $this->data['message'] = 'Group has been successfully deleted.';
        }
        else 
        {
            $this->data['message'] = 'Something went wrong. Please try again.';
        }
        $this->send_messages();
    }
}