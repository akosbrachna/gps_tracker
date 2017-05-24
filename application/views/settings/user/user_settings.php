<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function check_input($input, $records)
    {
        if (isset($_POST["$input"])) return $_POST["$input"];
        else return $records["$input"];
    }
?>
<style>
.account_settings{
    float: left;
    width: 70%;
    background: rgb(245,245,245) !important;
    border: solid 2px rgb(100,100,255);
    padding: 15px 15px 0px 25px;
    margin-bottom:5px;
}
.account_settings input[type="text"]{
    width: 65% !important;
}
.account_settings table td{
    border: none !important;
    padding-right: 15px !important;
}
.account_settings table td:first-child{
    width: 150px !important;
}
.account_settings table td:last-child{
    /*width: 60% !important;*/
}
.account_picture{
    position: absolute;
    top: 0px;
    right: 0px;
    padding: 2px;
    margin-top: 10px !important;
    width: 30%;
    margin-bottom: 15px !important;
    z-index: 10;
}
</style>

<div id="change_account_settings" class="account_settings">
<?php echo form_open_multipart(); ?>
    <table>
        <tbody>
        <tr>
        <td>First name:</td>
            <td><?php echo form_input('first_name', check_input('first_name', $records)); ?>
            </td>
        </tr>
        <tr>
            <td>Last name:</td>
            <td><?php echo form_input('last_name', check_input('last_name', $records)); ?>
            </td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo form_input('email', check_input('email', $records)); ?>
            </td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><?php echo form_input('password', $this->input->post('password')); ?>
                <br />If the password is left empty it won't be changed.
            </td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><?php echo form_textarea('address', check_input('address', $records),
                                         'id="site_address" style="height: 50px;"'); ?>
            
            </td>
        </tr>
        <tr>
            <td>Phone number:</td>
            <td><?php echo form_input('phone_number', check_input('phone_number', $records)); ?>
            </td>
        </tr>
        <tr>
            <td>Profile photo:</td>
            <td><input type="file" name="userfile" id="userfile" size="100" /><br/>
                File size should be less than 300KB
            </td>
        </tr>
        </tbody>
    </table>
<message></message>
<p style="margin-top: 10px;"><?php echo form_submit('submit', 'Change'); ?></p>
<?php echo form_close(); ?>
</div>

<div id="delete_my_account" class="account_settings">
    <h5 style="margin-bottom: 10px; font-weight: bold; color: black;">Delete my account</h5>
<?php echo form_open('settings/user/delete_account'); ?>
<message></message>
<p><?php echo form_submit('submit', 'Delete'); ?></p>
<?php echo form_close(); ?>
</div>

<a href="<?php echo base_url($photo); ?>" target="_blank">
   <img class="account_picture" src="<?php echo base_url($photo); ?>" />
</a>

