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
</head>
<body>

<div id="login">
    
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
