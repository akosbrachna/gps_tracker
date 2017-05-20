<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
#register_category{
    position: relative;
    top: 0px;
    left: 0px;
    margin-top: 0px !important;
    padding-right: 3px;
    padding-left: 3px;
    margin-left: 0px !important;
    border: solid 2px rgb(200,200,255);
    background: rgb(245,245,245) !important;
}
#register_category table td{
    border: none !important;
    padding-right: 20px !important;
    padding-left: 20px !important;
}
#main
{
    position: relative !important;
    width: 100%;
    margin-top: 3px !important;
    border: 2px solid rgb(200,200,255);
}
</style>

<div id="register_category">
    <h3 style="margin-bottom: 10px;">New category</h3>
<?php echo form_open(); ?>
<table>
    <tbody>
    <tr>
        <td>Name:</td> <td><?php echo form_input('name', $this->input->post('name')); ?></td>
    </tr>
    </tbody>
</table>
<p style="margin-top: 10px;"><?php echo form_submit('submit', 'Create'); ?></p>
<?php echo form_close(); ?>
<form_message></form_message>
<message></message>
</div>
<br />
<?php
echo draw_table($this->data['records']);
?>

<script>
    form_attr.form_ref     = 'settings/category/get_category/';
    form_attr.dialog_title = 'Category Form';
    form_attr.table_row = table_row;
</script>

<script>
function get_user(id)
{
    $('#spinning_wheel').fadeIn(200);
    $.get('settings/category/get_category/'+ id , function(data) 
    {
        $('#spinning_wheel').fadeOut(200);
        $('#main_form').html(data);
        $('#main_form').dialog({autoOpen: true,
                                draggable: true,
                                position: { my: "top center",
                                            at: "top center",
                                            of: "body"},
                                resizable: true,
                                modal: true,
                                width: '700px',
                                title: 'Category Form'
                               });
        submit_form('#main_form');
    });
}
    table_row();
</script>