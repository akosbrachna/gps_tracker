<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function check_input($input, $records)
    {
        if (isset($_POST["$input"])) return $_POST["$input"];
        else return $records["$input"];
    }
?>
<style>
#user_settings{
    float: left;
    width: 70%;
    background: rgb(245,245,245) !important;
    border: none !important;
}
#user_settings input[type="text"]{
    width: 65% !important;
}
#user_settings table td{
    border: none !important;
    padding-right: 15px !important;
}
#user_settings table td:first-child{
    width: 50% !important;
}
#user_settings table td:last-child{
    width: 50% !important;
}
#user_image{
    position: absolute;
    top: 0px;
    right: 10px;
    margin-top: 10px !important;
    width: 30%;
    margin-bottom: 15px !important;
    z-index: 10;
}
#geocode{
    text-decoration: underline;
}
#resize_map_user{
    position: absolute !important;
    bottom: 0px;
    padding-left: 5px;
    padding-right: 5px;
    right: 10px;
    z-index: 10001;
    color: red;
    border: 1px solid rgb(200,200,255);
    background: rgb(245,245,155);
    text-decoration: underline;
    font-weight: bold !important;
}
.coords{
    display: none;
}
#map_canvas_user div{
    margin: 0 !important;
}
#map_canvas_user .gm-style img{
    max-width: none !important;
}
#map_canvas_user .gm-style>div>div>div>div>div>img{
    top: -336px !important;
    left: -2px !important;
}
#map_canvas_user {
    position: absolute !important;
    margin-top: 15px !important;
    bottom: 10px;
    right: 10px;
    width: 30%;
    height: 50%;
    border: 2px solid rgb(200,200,255);
    z-index: 100;
}
</style>

<div id="user_settings">
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
                <br />If the password is empty it won't be changed.
            </td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><?php echo form_textarea('address', check_input('address', $records),
                                         'id="site_address" style="width:430px !important; height: 70px;"'); ?>
            
            </td>
        </tr>
        <tr>
            <td>Phone number:</td>
            <td><?php echo form_input('phone_number', check_input('phone_number', $records)); ?>
            </td>
        </tr>
        <tr>
            <td>Upload photo:</td>
            <td><input type="file" name="userfile" id="userfile" size="100" /></td>
        </tr>
        </tbody>
    </table>
<form_message></form_message>
<message></message>
<p><?php echo form_submit('submit', 'Save'); ?></p>
<?php echo form_close(); ?>
</div>

<?php if(file_exists($photo)): ?>
        <a id="resize_user_image" 
           title="Click to enlarge!"
           href="<?php echo base_url(str_replace('\\', '/', $photo)); ?>" target="_blank">
           <img id="user_image" src="<?php echo base_url(str_replace('\\', '/', $photo)); ?>" />
        </a>
<?php else: ?>
        <a id="resize_user_image" 
           title="Click to enlarge!"
           href="<?php echo base_url('web/pics/users/default.jpg'); ?>" target="_blank">
           <img id="user_image" src="<?php echo base_url('web/pics/users/default.jpg'); ?>" />
        </a>
<?php endif; ?>

<script>
$('#resize_user_image').tooltip({position: {my: "top-40", at: "right"}});
var j = 0;
$('#resize_user_image').click(function(e){
    e.preventDefault();
    $('#user_image').css({'z-index': 102});
    if (j == 0)
    {
        j = 1;
        $("#user_image").animate({
            width : '95%'
        }, 200);
        $( "#resize_user_image" ).tooltip( "option", "content", "Click to reduce!" );
    }
    else
    {
        j = 0;
        $("#user_image").animate({
            width : '30%'
        }, 200);
        $( "#resize_user_image" ).tooltip( "option", "content", "Click to enlarge!" );
    }
});
</script>