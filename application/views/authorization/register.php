<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo favicon_path;?>?v=4">
    <meta name="viewport" content="width=device-width, user-scalable = no">
    <meta charset="utf-8">
    <title>GPS Tracker</title>
<style>
body{
    background: rgb(235,235,235) !important;
}
#register_user
{
    margin-left: auto;
    margin-right: auto;
    width: 50% !important;
    background: rgb(255,255,250) !important;
    padding: 20px;
    padding-top: 5px ;
    border: 2px rgb(200,200,255) solid;
    color: rgb(0,0,205);
    font-weight: bold;
}
table
{
    background: rgb(255,255,250) !important;
}
#register_user td{
    border: none !important;
    border-collapse: collapse !important;
    border-spacing: 0 !important;
}
#register_user table td:first-child{
    width: 150px;
}
#register_user table td:last-child{
    width: 300px;
}
#register_user input{
    width: 100%;
}
#register_user input[type="submit"]{
    width: 80px;
}
#register_user a{
    margin-left: 40px;
}
.reg_photo{
    height: 200px;
}
</style>

<div id="register_user">
<h2>Registration on the GPS tracker website is free</h2>
<?php echo form_open_multipart(); ?>
<br />
<table border="0" cellpadding="4" cellspacing="0">
    <tbody>
    <tr>
        <td>First name:</td> <td><?php echo form_input('first_name', $this->input->post('first_name')); ?></td>
    </tr>
    <tr>
        <td>Last name:</td> <td><?php echo form_input('last_name', $this->input->post('last_name')); ?></td>
    </tr>
    <tr>
        <td>Email address:</td> <td><?php echo form_input('email', $this->input->post('email')); ?></td>
    </tr>
    <tr>
        <td>Password:</td>
        <td><?php echo form_password('password', $this->input->post('password')); ?></td>
    </tr>
    <tr>
        <td>Confirm password:</td>
        <td><?php echo form_password('confirm_password', $this->input->post('confirm_password')); ?></td>
    </tr>
    <tr>
        <td>Address:</td>
        <td><?php echo form_input('address', $this->input->post('address'), 'id="site_address" title=""'); ?>
        </td>
    </tr>
    <tr>
        <td>Phone number:</td>
        <td><?php echo form_input('phone_number', $this->input->post('phone_number')); ?></td>
    </tr>
    <tr>
        <td>Upload profile photo:</td>
        <td><input type="file" name="userfile" id="userfile" size="100" />
            File size should be less than 300 kilobytes.<br />
<!--            Default photo:<br />
            <img class='reg_photo' src="<?php echo base_url('web/pics/users/default.jpg'); ?>"/>-->
        </td>
      </tr>
      </tbody>
</table>
<?php echo validation_errors();
      if (isset($message)) echo $message;
?>
<form_message></form_message>
<p><?php echo form_submit('submit', 'Save'); ?></p>
<?php echo form_close(); ?>
<message></message>
</div>
</body>
</html>