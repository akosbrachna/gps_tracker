<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class my_photo
{
    private $folder;
    
    function __construct() {
        $this->folder = 'web/pics/users/';
    }
    
    public function save_my_photo($email)
    {        
        $CI =& get_instance();
        
        $config['upload_path']   = realpath(FCPATH.$this->folder);
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '300';
        $CI->load->library('upload', $config);
        
        if ($CI->upload->do_upload() == false)
        {
            $CI->upload->display_errors();
            return false;
        }
        else
        {
            $upload_data = $CI->upload->data();
            $file = $upload_data['full_path'];
            rename($file, realpath(FCPATH.$this->folder).'/'.$email.'.jpg');
            return true;
        }
    }
    
    public function get_photo_absolute_path($email)
    {
        $path = realpath(FCPATH.$this->folder.$email.'.jpg');
        if ($path)
        {
            return $path;
        }
        else
        {
            return realpath(FCPATH.$this->folder.'default.jpg');;
        }
    }
    
    public function get_photo_relative_path($email)
    {
        $path = realpath(FCPATH.$this->folder.$email.'.jpg');
        if ($path)
        {
            return $this->folder.$email.'.jpg';
        }
        else
        {
            return $this->folder.'default.jpg';;
        }
    }
}
