<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style>
#main
{
    position: relative !important;
    width: 100%;
    border: 2px solid rgb(200,200,255);
}
</style>

<?php
echo draw_table($this->data['records']);
?>
<script>
    form_attr.form_ref     = 'settings/contact/get_contact/';
    form_attr.dialog_title = 'Contact Form';
    form_attr.table_row = table_row;

    table_row();
</script>
