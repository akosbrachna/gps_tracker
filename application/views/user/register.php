<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
body{
    background: rgb(240,240,240) !important;
}
#register_user{
    position: absolute;
    top: 0px;
    left: 0px;
    width: 55%;
    background: rgb(245,245,245) !important;
    padding: 20px;
    padding-top: 5px ;
    border: 2px rgb(200,200,255) solid;
}
table{
    background: rgb(245,245,245) !important;
}
#register_user td{
    border: none !important;
    border-collapse: collapse !important;
    border-spacing: 0 !important;
}
#register_user table td:first-child{
    width: 200px;
}
#register_user table td:last-child{
    width: 400px;
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
#geocode{
    text-decoration: underline;
}
.coords{
    display: none;
}
#map_canvas_register .gm-style img{
    max-width: none !important;
}
#map_canvas_register {
    position: absolute !important;
    top: 0px !important;
    right: 0px;
    width: 45%;
    height: 500px;
    border: 2px rgb(200,200,255) solid;
    display: none;
}
.reg_photo{
    height: 200px;
}
</style>
<div id="map_canvas_register"></div>

<?php echo form_open_multipart(); ?>
<div id="register_user">
<h3>Registration</h3>
<h5>Please, take a moment to fill in the below form as this is your first time here.</h5>
<br />
<table border="0" cellpadding="4" cellspacing="0">
    <tbody>
    <tr>
        <td>Address (City, street):</td>
        <td><?php echo form_input('address', $this->input->post('address'), 
                                  'id="site_address" title=""'); ?>
        </td>
    </tr>
    <tr>
        <td>Phone number:</td>
        <td><?php echo form_input('phone_number', $this->input->post('phone_number')); ?></td>
    </tr>
    <tr>
        <td>New password:</td>
        <td><?php echo form_password('password', $this->input->post('password')); ?></td>
    </tr>
    <tr>
        <td>Confirm password:</td>
        <td><?php echo form_password('confirm_password', $this->input->post('confirm_password')); ?></td>
    </tr>
    <tr>
        <td>Upload photo (optional):</td>
        <td><input type="file" name="userfile" id="userfile" size="100" />
            File size should be less than 300KB.<br />
            Default photo:<br />
            <img class='reg_photo' src="<?php echo base_url('web/pics/users/default.jpg'); ?>"/>
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

<img id="spinning_wheel" src="<?php echo base_url('web/pics/spinning_wheel.gif');?>" />
