<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
body{
    background: rgb(253,253,253);
}
#sidebar
{
   position: absolute;
   top: 34px;
   left: 0px;
   width: 190px;
   height: 90%;
   margin: 0;
   padding-left: 5px;
   border-right: 1px solid #ccc; 
   background: rgb(250,250,255);
   display: none;
   overflow-y: hidden;
}
#sidebar ol.side_menu{
    margin-left:0px;
    width: 180px;
}
#sidebar ol.side_menu li.menu_section{
    border-bottom: 1px solid rgb(228,228,228);
}
#sidebar ol.side_menu li{
    position: relative;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 14px;
}
#sidebar li.file a:hover{
    background-color: rgb(245,245,255);
}
#sidebar .side_menu_item{
    color: #069;
    font-size: 14px;
}
#side_pic{
    position: absolute;
    top: 0px;
    left: 0px;
    height: 100%;
    overflow: hidden;
}
#sidebar_toggle{
    position: absolute; 
    top: 34px; 
    left: 140px; 
    z-index: 10;
    padding-right: 2px;
}
#sidebar_toggle:hover{
    cursor: pointer;
}
</style>

<?php $this->load->helper('navigation');?>

<!--<div id="sidebar_toggle">Close</div>-->

<div id='sidebar'>
<?php 
foreach ($sidebar as $key => $value)
{
    nav_side_menu($value);
}
?>
</div>

<script>
$('#sidebar').height($(window).height()-34);
$('#sidebar_toggle').click(function(){
    if ($('#sidebar').width()>100)
    {
        $('#sidebar').animate({ width: "1px"}, 200);
        $('#main_view').css({left: "1px"});
        $('#main_view').animate({ width: $('#main_view').width()+190+'px'}, 200);
        $('#sidebar_toggle').html('Open');
        $('#sidebar_toggle').css({left: "1px"});
        $('#sidebar_toggle').css({background: "rgb(245,245,255)"});
    }
    else
    {
        $('#main_view').css({left: "192px"});
        $('#main_view').animate({ width: $('#main_view').width()-190+'px'}, 200);
        $('#sidebar').animate({ width: "190px"}, 200);
        $('#sidebar_toggle').html('Close');
        $('#sidebar_toggle').css({left: "140px"});
    }
});
</script>
<script>
$('.side_menu_item').click(function (event)
{
    $('#rows').empty();
    $('#link_name').html($(this).html());
    $.each($(".side_menu_item"), function(){
        $(this).css('color', '#069');
    });
    $(this).css('color', 'rgb(255,55,55)');
    $.each($(".side_menu_item"), function(){
        $(this).css('color', '#069');
    });
    $(this).css('color', 'rgb(255,55,55)');
    
    var url = $(this).attr('href');
    $('#spinning_wheel').fadeIn(200);
    event.preventDefault();
    $.get(url, function(data) 
    {
        if ($(data).filter('#login_start_page').length)
        {
            location.reload(window.location.origin+'/gps_tracker');
        }
        $('#main_view').html(data);
        $('rows').remove();
        $('#spinning_wheel').fadeOut(200);
        submit_form('#main_view');
        sorttable.makeSortable($('body').find(".sortable").get(0));
    });
});
</script>