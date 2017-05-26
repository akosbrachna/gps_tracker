<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style>
#main_pic{
    position: fixed;
    top: 34px;
    left: 0px;
    width: 100%;
    height: 100%;
    z-index: -1;
    border: 2px solid rgb(50,50,150);
    /*opacity: 0.8;*/
}
#main_text{
    position: absolute;
    top: 5px;
    left: 5px;
    z-index: 1;    
}
#main_view{
    overflow: hidden !important;
}
</style>

<div id="main_text">
    <h4 style="color: yellow; font-weight: bolder;"></h4>
</div>

<img id="main_pic" src="<?php echo base_url('web/pics/world_map.jpg'); ?>" />