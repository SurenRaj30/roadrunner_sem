<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo $meta_title ?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
	<link href="<?php echo base_url();?>assets/fontawesome5/css/all.css" rel="stylesheet" >
	<link href="<?php echo base_url();?>assets/toastr/jquery.toast.min.css" rel="stylesheet" >
	<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" >
	<link rel="icon" href="<?=base_url()?>/favicon-32x32.png" type="image/gif">

	<!-- Putting scripts at the top of the page slows loading down, but necessary due to how the views are split into several sections. Scripts in footer section won't be detected by views loaded before it. -->
    <script src="<?php echo base_url();?>assets/jquery/jquery-3.5.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/toastr/jquery.toast.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
	<div class="dashboard-wrapper">
		<div class="main-content">