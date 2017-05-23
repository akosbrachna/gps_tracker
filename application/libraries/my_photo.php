<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class my_photo
{
    private $file_path;
    private $folder;
    
    function __construct() {
        $this->folder = 'web/pics/users/';
    }
    
    public function save_my_photo($email)
    {        
        $config['upload_path']   = realpath(FCPATH.$this->folder);
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '300';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload() == false)
        {
            $this->upload->display_errors();
            return false;
        }
        else
        {
            $this->file_path = realpath(FCPATH.$this->folder.$email.'.jpg');
            
            $upload_data = $this->upload->data();
            $file = $upload_data['full_path'];
            rename($file, $this->file_path);
            return true;
        }
    }
    
    public function get_photo_absolute_path($email)
    {
        $path = realpath(FCPATH.$this->folder.$email.'.jpg');
        if (file_exists($path))
        {
            return $path;
        }
        else
        {
            return false;
        }
    }
    
    public function get_photo_relative_path($email)
    {
        $path = realpath(FCPATH.$this->folder.$email.'.jpg');
        if (file_exists($path))
        {
            return $this->folder.$email.'.jpg';
        }
        else
        {
            return false;
        }
    }
}