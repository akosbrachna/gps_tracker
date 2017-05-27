<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style>
    .resources{
        padding: 20px;
        background: rgb(255,255,255);
        width: 100%;
        height: 100%;
    }
</style>

<div class="resources">
    The web application can be downloaded from
    <a href="https://github.com/akosbrachna/gps_tracker/" target="_blank">github</a>. 
    It can be modified and used freely. There are simple instructions on the installation steps 
    if one wishes to run the website on one's own server.
    <br/><br/>
    An android application is being under development too. That project is also shared on
    <a href="https://github.com/akosbrachna/gps_tracking_android" target="_blank">github</a> 
    and the apk program file can be downloaded from  
    <a href="<?php echo base_url('web/android/gps_tracker.apk'); ?>" target="_blank">here</a> 
    or through the phone interface ("Logging in on phone?" checkbox needs to be ticked 
    on the login page to log in to the phone interface on the website).<br />
    The android application as a foreground service can continuously and seamlessly be sending 
    the gps location from the phone to the server without having to keep the browser window open.<br />
    On the phone's settings page the email and password should be the same as your user name and 
    password on the website and the server address should be the domain name of the website as 
    it is shown in the picture:
    <br/>
    <a href="web/pics/gps_tracker_android.png" target="_blank">
        <img style="width: 200px;" src="web/pics/gps_tracker_android.png" /></a>
    
</div>