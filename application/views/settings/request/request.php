<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
#register{
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
#register table td{
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
.requests{
    float:left;
    width: 100%;
}
</style>

<div id="register">
<h3>Send a request</h3>to someone that you would like to follow.
<?php echo form_open(); ?>
<table style="margin-top: 10px;">
    <tbody>
    <tr>
        <td>Email:</td> <td><?php echo form_input('email', $this->input->post('email')); ?></td>
    </tr>
    <tr>
        <td>Category:</td>
        <td><?php echo form_dropdown('category', $this->data['categories'], $this->input->post('category'), 
                                     'style="width:200px"'); ?></td>
    </tr>
    </tbody>
</table>
<p style="margin-top: 10px;"><?php echo form_submit('submit', 'Send'); ?></p>
<?php echo form_close(); ?>
<form_message></form_message>
<message></message>
</div>

<div class="requests">
<h5>Incoming requests</h5>
<?php
echo draw_table($this->data['incoming_requests']);
?>
</div>
<div class="requests">
<h5>Outgoing requests</h5>
<?php
echo draw_table($this->data['outgoing_requests']);
?>
</div>
<script>
    form_attr.form_ref     = 'settings/request/get_request/';
    form_attr.dialog_title = 'Request Form';
    form_attr.table_row = table_row;
</script>

<script>
function get_request(id)
{
    $('#spinning_wheel').fadeIn(200);
    $.get('settings/request/get_request/'+ id , function(data) 
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
                                title: 'Request Form'
                               });
        submit_form('#main_form');
    });
}
    table_row();
</script>