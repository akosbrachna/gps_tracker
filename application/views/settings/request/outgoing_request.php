<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style>
.get_request{
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
.get_request table td{
    border: none !important;
}
.get_request table td input{
    width: 90% !important;
}
.get_request table td select{
    width: 90% !important;
}
.get_request table td:first-child{
    width: 50% !important;
    font-weight:normal;
}
.get_request table td:last-child{
    width: 50% !important;
    font-weight: bold;
}
.photo{
    float: left;
/*    height: 150px;*/
    width: 28%;
    margin: auto;
    margin-left: 5px;
}
h5{
    font-weight: bold;
    color: black;
}
</style>

<div class="get_request">
    <h5>I've sent a request to <font style="color:blue"><?php echo $records['email']; ?></font></h5>
    <br/><br/>
    <h5 style="margin-bottom: 10px;">Cancel my request</h5>
    <?php echo form_open('settings/request/cancel_request'); ?>
    <?php echo form_hidden('id', $records['id']); ?>
    <?php echo form_hidden('email', $records['email']); ?>
    <message></message>
    <p><?php echo form_submit('submit', 'Cancel'); ?></p>
    <?php echo form_close(); ?>
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

<script>
    callback = function(){
        document.getElementById("settings/request/send_request").click();
    }
</script>