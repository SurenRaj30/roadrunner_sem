<!-- HTML header stuff -->
<?php $this->load->view('template/header'); ?>

<!-- Nav for different user levels -->
<?php if($meta_user_level==='1'):?>
	<?php $this->load->view('template/nav'); ?>
<?php elseif($meta_user_level==='2'):?>
	<?php $this->load->view('template/nav2'); ?>
<?php elseif($meta_user_level==='3'):?>
	<?php $this->load->view('template/nav3'); ?>
	<?php elseif($meta_user_level==='4'):?>
	<?php $this->load->view('template/nav4'); ?>
<?php endif;?>

<!-- Main content of page -->
<?php $this->load->view($main_content); ?>
<!-- Footer -->
<?php $this->load->view('template/footer'); ?>