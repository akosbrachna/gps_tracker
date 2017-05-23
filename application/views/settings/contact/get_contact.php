<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style>
.get_contact{
    float: left;
    margin: auto;
    padding-right: 5px;
    width: 70%;
    border: solid 2px rgb(100,100,255);
    padding: 15px;
    margin-bottom:5px;
}
.ui-dialog{
    overflow-y: hidden !important;
}
input[type="submit"]{
    width: 80px !important;
}
.get_contact table td{
    border: none !important;
}
.get_contact table td input{
    width: 90% !important;
}
.get_contact table td select{
    width: 90% !important;
}
.get_contact table td:first-child{
    width: 50% !important;
    font-weight:normal;
}
.get_contact table td:last-child{
    width: 50% !important;
    font-weight: bold;
}
.photo{
    float: left;
    height: 150px;
    width: 28%;
    margin: auto;
    margin-left: 5px;
}
h5{
    font-weight: bold;
    color: black;
}
</style>

<div class="get_contact">
    <h5>Personal info</h5>
<table>
    <tbody>
    <tr>
    <td>Name:</td>
        <td><?php echo $records['first_name'].' '.$records['last_name']; ?>
        </td>
    </tr>
    <tr>
        <td>Email:</td>
        <td><?php echo $records['email']; ?>
        </td>
    </tr>
    <tr>
    <td>Address:</td>
        <td><?php echo $records['address']; ?></td>
        </td>
    </tr>
    <tr>
        <td>Phone number:</td>
        <td><?php echo $records['phone_number']; ?></td>
        </td>
    </tr>
        </tbody>
</table>
</div>

<div class="photo">
<?php if(file_exists($photo)): ?>
        <a href="<?php echo base_url(str_replace('\\', '/', $photo)); ?>" target="_blank">
            <img src="<?php echo base_url(str_replace('\\', '/', $photo)); ?>" style="width:100%">
        </a>
<?php else: ?>
        <a href="<?php echo base_url('web/pics/users/default.jpg'); ?>" target="_blank">
            <img src="<?php echo base_url('web/pics/users/default.jpg'); ?>" style="width:100%">
        </a>
<?php endif; ?>
</div>
<div class="get_contact">
    <h5 style="margin-bottom: 10px;">Contact settings</h5>
    <?php echo form_open('settings/contact/modify_contact_settings'); ?>
<?php echo form_hidden('id', $records['id']); ?>
    <?php echo form_hidden('email', $records['email']); ?>
    <table>
    <tbody>
    <tr>
        <td>Category:</td>
        <?php
        foreach ($categories as $key => $value) {
            $data[$value['Category name']] = $value['Category name'];
        }
        ?>
        <td><?php echo form_dropdown('category', $data, $records['category'], 
                                     'style="width:200px"'); ?></td>
    </tr>
    <tr>
        <td>Visibility on my map:</td>
        <?php $status = array(
                        'visible'  => 'visible',
                        'invisible' => 'invisible'
                    );
        ?>
        <td><?php echo form_dropdown('status', $status, $records['status'], 
                                     'style="width:200px"'); ?></td>
    </tr>
    <tr>
        <td>Permission to follow me:</td>
        <?php $permission = array(
                        'enabled'  => 'enabled',
                        'disabled' => 'disabled'
                    );
        ?>
        <td><?php echo form_dropdown('permission', $permission, $records['permission'], 
                                     'style="width:200px"'); ?></td>
    </tr>
    </tbody>
</table>
<message></message>
<p style='margin-top: 10px;'><?php echo form_submit('submit', 'Change'); ?></p>
<?php echo form_close(); ?>
</div>

<div class="get_contact">
    <h5 style="margin-bottom: 10px;">Remove <?php echo $records['first_name']; ?> from my contacts</h5>
<?php echo form_open('settings/contact/remove_contact'); ?>
<?php echo form_hidden('id', $records['id']); ?>
    <?php echo form_hidden('email', $records['email']); ?>
<message></message>
<p><?php echo form_submit('submit', 'Remove'); ?></p>
<?php echo form_close(); ?>
</div>
