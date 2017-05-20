<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php  $this->load->view('templates/main/header'); ?>

<?php $this->load->view('templates/main/topbar', $topbar); ?>

<?php
    $data['sidebar'] = $sidebar;
    $this->load->view('templates/main/sidebar', $data);
?>

<div id='main_view'>
<?php if (isset($main_view)) $this->load->view($main_view); ?>
</div>

<div id="main_form">
</div>

<?php $this->load->view('templates/main/footer'); ?>
