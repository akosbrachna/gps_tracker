<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo base_url('web/favicon.ico');?>">
    <meta name="viewport" content="width=device-width, user-scalable = no">
    <meta charset="utf-8">
    <title>Reset password</title>
    <style>
    #forgot_password
    {
        position: fixed;
        top: 50%;
        left: 50%;
        margin-top: -130px;
        margin-left: -160px;
        color: rgb(0,0,205);
        font-weight: bold;
        padding: 20px 30px 20px 40px;
        border: 2px rgb(100,100,255) solid;
        background-color: rgb(255,255,255);
    }
    #main_pic{
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        z-index: -1;
        border: 2px solid rgb(50,50,150);
    }
    .login_footer{
        background: rgb(240,245,245);
        opacity: 0.7;
        filter: alpha(opacity = 70);
        border-bottom: 2px rgb(100,100,155) solid;
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 30px;
        padding-top:5px;
    }
    .login_footer a{
        position: absolute;
        left: 50%;
        margin-left: -80px;
        font-weight: bold;
        color: rgb(0,25,125);
    }
    </style>
</head>
<body>
<img id="main_pic" src="<?php echo base_url('web/pics/world_map.jpg'); ?>" />
<div id="forgot_password">
    
<h2>Password reset</h2>
<?php echo form_open(); ?>

<p>Email: <?php echo form_input('email', $this->input->post('email')); ?></p>

<p><?php echo form_submit('submit', 'Reset password'); ?></p>

<?php echo form_close(); ?>

<?php echo validation_errors(); ?>
<?php if (isset($message)) echo $message; ?>

<p>Please check your mailbox.<br/>
Email may be in spam folder.</p>

</div>

<div class="login_footer">
    <a href="https://github.com/akosbrachna/gps_tracker/" target="_blank">About GPS Tracker</a>
</div>

</body>
</html>
