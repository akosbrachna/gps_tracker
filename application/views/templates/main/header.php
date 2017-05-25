<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo favicon_path;?>?v=344">
    <meta name="viewport" content="width=device-width, user-scalable = no">
    <meta charset="utf-8">
    <title>GPS tracker</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('web/css/libs/gumby/css/gumby.css');?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('web/js/libs/jquery-ui-1.11.1/jquery-ui.min.css');?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('web/js/libs/jquery-ui-1.11.1/jquery-ui.theme.min.css');?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('web/js/libs/jquery-ui-1.11.1/jquery-ui.structure.min.css');?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('web/css/style.css');?>" media="screen" />
    <script src="<?php echo base_url('web/js/libs/jquery-1.11.1.min.js');?>"></script>
    <script src="<?php echo base_url('web/css/libs/gumby/js/gumby.min.js');?>"></script>
    <script src="<?php echo base_url('web/js/libs/sorttable.js');?>"></script>
    <script src="<?php echo base_url('web/js/libs/jquery.cookie.js');?>"></script>
    <script src="<?php echo base_url('web/js/libs/jquery-ui-1.11.1/jquery-ui.min.js');?>"></script>
    <script src="https://maps.google.com/maps/api/js"></script>
    <style>
        #site_message{
            position: absolute;
            top: 0px;
            left: 50%;
            width: 80%;
            margin-left: -40%;
            padding: 10px;
            border: 2px solid rgb(200,200,255);
            color: red;
            font-size: 16px;
            font-weight: bold;
            z-index: 10000;
            display: none;
            background: rgb(250,250,250);
            text-align: center;
        }
    </style>
</head>
<body>
<div id='site_message'></div>