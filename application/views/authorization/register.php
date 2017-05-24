<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo favicon_path;?>?v=4">
    <meta name="viewport" content="width=device-width, user-scalable = no">
    <meta charset="utf-8">
    <title>GPS Tracker</title>
<style>
#main_pic{
    position: fixed;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    z-index: -1;
}
#register_user
{
    position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -245px;
    margin-left: -180px;
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
    width: 130px;
}
#register_user table td:last-child{
    width: 170px;
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
.login_footer{
    background: rgb(245,245,245);
    border: 2px rgb(200,200,255) solid;
    position: fixed;
    bottom: 0px;
    left: 0px;
    width: 100%;
    height: 30px;
}
.login_footer a{
    position: absolute;
    left: 50%;
    margin-left: -80px;
    font-weight: bold;
}
</style>
</head>
<body>
<img id="main_pic" src="<?php echo base_url('web/pics/world_map.jpg'); ?>" />
<div id="register_user">
<h2>Registration</h2>
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
        <td>Profile photo:</td>
        <td><input type="file" name="userfile" id="userfile" size="100" />
            File size less than 300 kilobytes.<br />
        </td>
      </tr>
      </tbody>
</table>
<?php echo validation_errors();
      if (isset($message)) echo $message;
?>
<p><?php echo form_submit('submit', 'Register'); ?></p>
<?php echo form_close(); ?>
<message></message>
</div>
<div class="login_footer">
    <a href="https://github.com/akosbrachna/gps_tracker/" target="_blank">About GPS Tracker</a>
</div>
</body>
</html>