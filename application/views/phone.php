<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en" manifest="<?php // echo base_url('offline.manifest'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable = no">
    <link rel="icon" href="<?php echo favicon_path;?>">
    <title>GPS Tracker</title>
    <script><?php $this->load->view('phone/js/libs/jquery-1.11.1.min.js');?></script>
    <script><?php $this->load->view('phone/js/libs/jquery.storageapi.min.js');?></script>
    <script><?php $this->load->view('phone/js/libs/sorttable.min.js'); ?></script>
    <script><?php $this->load->view('phone/js/libs/jquery.cookie.js'); ?></script>
    <script src="https://maps.google.com/maps/api/js"></script>
</head>
<body>
<?php $this->load->view('phone/js/modules/map'); ?>
</body>
</html>