<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id='top_bar'>
    <img id="bgWave" src="web/pics/background.jpg">
    <ul id="nav">
        <li><a class="user_settings" href="settings/user/change_user_settings">
                <?php echo $this->session->userdata('email'); ?></a>
        <?php if ($this->router->class != 'Auth' && $this->router->method != 'login'): ?>
        <a href="<?php echo base_url() ?>authorization/login/logout">Logout</a></li>
        <?php endif; ?>
      
        <?php $this->load->helper('navigation');?>
        <?php if (isset($topmenu)) nav_top_menu($topmenu);?>
   </ul>
    <ul id="link_rows">
        <li id="link_name"></li>
        <li id="rows"></li>
    </ul>
</div>

<script>
var elem;
$('#nav li').click(function(){
            if (elem)
            {
                elem.css({background:'none'});
                elem.hover(function(){
                        $(this).css({background:'rgb(255,255,255)'});
                    }, function(){
                        $(this).css({background:'none'});
                    });
            }
            elem = $(this);
            elem.css({background:'rgb(250,250,250)'});
            elem.hover(function(){
                        $(this).css({background:'rgb(253,253,253)'});
                    }, function(){
                        $(this).css({background:'rgb(253,253,253)'});
                    });
});
$(".user_settings").click(function(e)
 {
    var ref = $(this).attr('id');
    $('#spinning_wheel').fadeIn(200);
    e.preventDefault();
    e.stopPropagation();
    $.get('settings/user/change_user_settings' , function(data) {
        $('#spinning_wheel').fadeOut(200);
        $('#main_form').html(data);
        $('#main_form').dialog({autoOpen: true,
                                draggable: true,
                                resizable: true,
                                modal: true,
                                position: { my: "center top", 
                                            at: "center top", 
                                            of: "body"},
                                width:'900px',
                                title: 'User Form'
                        });
        submit_form('#main_form');
    });
});
</script>
<script>
$('.nav_menu').click(function (event)
{
    event.preventDefault();
    event.stopPropagation();
    $('#sidebar').show();
    var url = $(this).attr('href');
    $.each($(".nav_menu"), function(){
        $(this).css('color', '#069');
    });
    $(this).css('color', 'rgb(255,55,55)');

    var url = $(this).attr('href');
    $.each($(".side_menu_div"), function(key, value){
        $(this).css('display', 'none');
    });
    $(url + '.side_menu_div').css('display', 'block');
 });    
</script>