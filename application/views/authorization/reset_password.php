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
    #save_password{
        position: fixed;
        top: 50%;
        left: 50%;
        margin-top: -180px;
        margin-left: -200px;
    }
    #save_password table, td, tr{
        border: none !important;
    }
    #save_password table td:first-child{
        width: 180px;
    }
    </style>
</head>
<body>

<div id="save_password">
<h3>Save new password</h3>
<?php echo form_open(); ?>
<table>
    <tbody>
        <tr>
            <td>New password:</td>
            <td><?php echo form_password('password', $this->input->post('password')); ?></td>
        </tr>
        <tr>
            <td>Confirm password:</td>
            <td><?php echo form_password('confirm_password', $this->input->post('confirm_password')); ?></td>
        </tr>
    </tbody>
</table>
<p><?php echo form_submit('submit', 'Save password'); ?></p>
<?php echo form_close(); ?>
<?php echo validation_errors(); ?>
<?php if (isset($message)) echo $message; ?>
</div>