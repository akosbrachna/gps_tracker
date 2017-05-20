<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style>
.modify_category{
    float: left;
    margin: auto;
    padding-right: 5px;
    width: 100%;
    border: solid 2px rgb(100,100,255);
    padding: 15px;
    margin:5px;
}
.ui-dialog{
    overflow-y: hidden !important;
}
input[type="submit"]{
    width: 80px !important;
}
.modify_category table td{
    border: none !important;
}
.modify_category table td input{
    width: 90% !important;
}
.modify_category table td select{
    width: 90% !important;
}
.modify_category table td:first-child{
    width: 40% !important;
}
.modify_category table td:last-child{
    width: 60% !important;
}
h5{
    color: black;
    font-weight: bold;
}
</style>

<div class="modify_category">
    <h5>Category settings</h5>
    <hr>
<?php echo form_open('settings/category/modify_category'); ?>
<?php echo form_hidden('id', $records['id']); ?>
<table>
    <tbody>
    <tr>
    <td>Rename category to:</td>
    <td><?php echo form_input('name', $records['name']); ?>
        </td>
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
<br/>
<p><?php echo form_submit('submit', 'Change'); ?></p>
<?php echo form_close(); ?>
</div>

<div class="modify_category">
    <h5>Delete the <?php echo $records['name']; ?> category</h5>
    <br/>
<?php echo form_open('settings/category/delete_category'); ?>
<?php echo form_hidden('id', $records['id']); ?>
    <?php echo form_hidden('name', $records['name']); ?>
<message></message>
<p><?php echo form_submit('submit', 'Delete'); ?></p>
<?php echo form_close(); ?>
<p><font style="font-weight: bold;">
    Important! Deletion will remove all your contacts from this category.<br/>
    If you wish to keep some contacts from this category then please consider <br/> 
    moving them to another category before you delete the category.
    </font></p>
</div>

