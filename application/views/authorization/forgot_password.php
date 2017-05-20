<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo base_url('web/favicon.ico');?>">
    <meta name="viewport" content="width=device-width, user-scalable = no">
    <meta charset="utf-8">
    <title>Reset password</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('web/css/libs/gumby/css/gumby.css');?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('web/css/style.css');?>" media="screen" />
    <style>
     body{
        background: rgb(235,235,235);
        background-image: url("<?php echo base_url('web/pics/world_map.jpg'); ?>");
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    #forgot_password
    {
        position: fixed;
        top: 50%;
        left: 50%;
        margin-top: -170px;
        margin-left: -290px;
        color: rgb(0,0,205);
        font-weight: bold;
        padding: 10px 30px 40px 50px;
        border: 2px rgb(200,200,255) solid;
        background-color: rgb(255,255,255);
    }
    </style>
</head>
<body>

<div id="forgot_password">
    
<h3>Password reset</h3>

<h5>Please type in your email address and check your mailbox.</h5>
<h5>You might need to check your spam folder too.</h5>

<br />
<?php echo form_open(); ?>

<p>Email: <?php echo form_input('email', $this->input->post('email')); ?></p>

<p><?php echo form_submit('submit', 'Reset password'); ?></p>

<?php echo form_close(); ?>

<?php echo validation_errors(); ?>
<?php if (isset($message)) echo $message; ?>

</div>
</body>
</html>
