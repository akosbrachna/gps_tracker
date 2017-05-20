<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style>
message{
    position: absolute;
    top: 30px;
}
.main_menu_item{
    padding: 3px;
    background: rgb(220,220,220);
    border: 1px solid rgb(100,100,255);
    margin: auto;
    line-height: 50px;
    font-size: 20px;
    width: 100%;
    margin-top: 15px;
}
.main_menu_item span{
    display: block;
    vertical-align: middle;
}
#main_menu{
    display: block;
}
#back_to_call, #back_to_module, #delete_form{
    position: absolute;
    top: 0px;
    left:0px;
    background: rgb(205,205,205);
    color: rgb(0,0,255);
    padding-top: 5px;
    padding-bottom: 5px;
    width: 100%;
    overflow: hidden;
    text-align: center;
}
#back_to_module{
    right: 0px !important;
    width: auto !important;
}
#delete_form{
    left: 0px;
    width: auto !important;
}
#back_to_call:hover, #back_to_module:hover{
    background: rgb(225,225,225);
    cursor: pointer;
}
.time_buttons{
    padding: 3px;
    background: rgb(220,220,220);
    border: 1px solid rgb(100,100,255);
    font-size: 20px;
    margin-top: 15px;
    line-height: 50px;
}
.time_buttons input{
    width: 0;
    opacity: 0;
}
.time_buttons.right{
    float: right;
    width: 45%;
}
.time_buttons.left{
    float: left;
    width: 45%;
}
</style>

<div class="menu">
    <div id="sync" href="phone/main_phone/sync">
        Fetch
    </div>

    <div id="menu" style="display: inline; margin-left: 80px;">
        Menu
    </div>
    
    <?php if ($this->router->class != 'Auth' && $this->router->method != 'login'): ?>
        <a style="float:right;margin-right: 5px;" href="<?php echo base_url() ?>authorization/authorization/logout">Logout</a>
    <?php endif; ?>
    <div id="version_number" style="float: right;">
    </div>
</div>

<div style="display: none;" id="back_to_call">
    Back to call
</div>

<div style="display: none;" id="back_to_module">
    Back
</div>

<div style="display: none;" id="delete_form">
    Delete
</div>

<div id="main_menu">
    <div class="main_menu_item" id="calls_menu" href="calls">
        <span>Calls</span>
    </div>
    <div class="main_menu_item" id="stock_menu" href="stock">
        <span>Stock</span>
    </div>
    <div class="main_menu_item" id="pm_menu" href="pm">
        <span>PM</span>
    </div>
        <div class="time_buttons right" id='fw'>
        <span>Finish work<input type="time" id="finish_work" /></span>
    </div>
    
    <div class="time_buttons left" id="travel_start">
        <span>Start time</span>
    </div>

</div>

<message></message>
<img id="spinning_wheel" src="<?php echo base_url('web/pics/spinning_wheel.gif');?>" />
<img class="please_wait" src="<?php echo base_url('web/pics/please_wait.gif');?>" />

<script>
$("#version_number").html($.localStorage.get("version_number"));

var active_menu = null;
$('.main_menu_item').click(function(){
    $('#main_menu').hide();
    var id = $(this).attr('href');
    $('#'+id).css({display:'block'});
    active_menu = $('#'+id);
    window.modules[id].init();
    $('#sync').show();
});
$('#sync').click(function(){
    $('.please_wait').show();
    $('message').html('Loading...').show();
    setTimeout(folytasd, 500);
});

folytasd = function() {
    rec.fetch();
//    rec.sync();
    shAlert();      //alert many times distrupts the program flow, so moved to another function
    $('message').html('done.');
    $('.please_wait').hide();
    setTimeout(function() {$('message').fadeOut()}, 2000)       // because chaining not working properly
};

shAlert = function() {
    alert('Sync completed');
}

$('#back_to_call').click(function(){
    $('#calls_menu').trigger('click');
    module = modules.calls
    form.create(form.id, module.data[form.id]);
    form.id = null;
    form.calls_id = null;
    $('#back_to_call').hide();
    $('.stock_menu').hide();
    $('.calls_menu').hide();
});
$('#back_to_module').click(backToModule);

$('#delete_form').click(function(){
    var del_form = confirm("Do you really want to delete the form?");
    if (del_form) {
        module.data.splice(form.index, 1);
        $.localStorage.set(module.id, module.data);
        backToModule();
    }
});

$('#menu').click(function(){
    active_menu.hide();
    $('#main_menu').show();
});
$('#travel_start').click(function(){
    var d = new Date();
    var mins = (d.getMinutes() < 10)?'0'+d.getMinutes():d.getMinutes();
    var time = d.getHours()+':'+mins;
    $.localStorage.set('travel_start', time);
    alert('Start time is set to '+time);
});
$('#finish_work').on('input', function(){
    $.localStorage.set('travel_start', '');
    $.localStorage.set('finish_work', $(this).val());
    var swd_reference = $.localStorage.get('swd_reference');
    if (!swd_reference) return;
    var elem = {};
    elem.finish_work = $(this).val();
    elem.swd_reference = swd_reference;
    elem.url = "phone/call_phone/finish_work";
    send_time(elem);
});

document.getElementById('fw').onclick = function(){document.getElementById('finish_work').focus()};
</script>