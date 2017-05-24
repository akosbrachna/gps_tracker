<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo favicon_path;?>?v=2">
    <meta name="viewport" content="width=device-width, user-scalable = no">
    <meta charset="utf-8">
    <title>GPS Tracker</title>
<style>
.message{
    position: fixed;
    top: 50%;
    left: 50%;
    width: 50%;
    margin-top: -12%;
    margin-left: -25%;
    color: rgb(0,0,205);
    padding: 30px;
    border: 2px rgb(200,200,255) solid;
    background-color: rgb(255,255,255);
    font-size: 18px;
    text-align: center;
}
.main_pic{
    position: fixed;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    z-index: -1;
}
.login_footer{
    background: rgb(245,245,245);
    border: 2px rgb(200,200,255) solid;
    position: fixed;
    bottom: 0px;
    left: 0px;
    width: 100%;
    height: 30px;
}
.login_footer a{
    position: absolute;
    left: 50%;
    margin-left: -80px;
    font-weight: bold;
}
</style>
</head>
<body>
<img class="main_pic" src="<?php echo base_url('web/pics/world_map.jpg'); ?>" />

<div class="message">
<?php 
    if (isset($message)) echo $message; 
?>
</div>
<div class="login_footer">
    <a href="https://github.com/akosbrachna/gps_tracker/" target="_blank">About GPS Tracker</a>
</div>
