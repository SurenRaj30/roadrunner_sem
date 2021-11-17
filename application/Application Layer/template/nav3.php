<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
	<a class="navbar-brand" href="<?php echo site_url('page');?>"><img src="<?php echo base_url('favicon-32x32.png');?>" alt="">RoadRunner</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarsExampleDefault">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item <?php if($this->uri->uri_string() == 'page') { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo site_url('page');?>">Home<span class="sr-only"><?php if($this->uri->uri_string() == 'page') { echo '(current)'; } ?></span></a>
			</li>
			<li class="nav-item <?php if($this->uri->uri_string() == 'foods' || $this->uri->uri_string() == 'foods/products/' . $this->uri->segment(3)) { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo site_url('foods');?>">Foods<span class="sr-only"><?php if($this->uri->uri_string() == 'foods') { echo '(current)'; } ?></span></a>
			</li>
			<li class="nav-item <?php if($this->uri->uri_string() == 'goods') { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo site_url('goods');?>">Goods<span class="sr-only"><?php if($this->uri->uri_string() == 'goods') { echo '(current)'; } ?></span></a>
			</li>
			<li class="nav-item <?php if($this->uri->uri_string() == 'pharma') { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo site_url('pharma');?>">Pharma<span class="sr-only"><?php if($this->uri->uri_string() == 'pharma') { echo '(current)'; } ?></span></a>
			</li>
			<li class="nav-item <?php if($this->uri->uri_string() == 'pet' || $this->uri->uri_string() == 'pet/products/' . $this->uri->segment(3)) { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo site_url('pet');?>">Pet<span class="sr-only"><?php if($this->uri->uri_string() == 'pet') { echo '(current)'; } ?></span></a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item <?php if($this->uri->uri_string() == 'order' || $this->uri->uri_string() == 'order/manage-order/' . $this->uri->segment(3)) { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo site_url('order/manage-order');?>"><i class="fas fa-tasks"></i> Orders<span class="sr-only"><?php if($this->uri->uri_string() == 'order/manage-order') { echo '(current)'; } ?></span></a>
			</li>
			<li class="nav-item <?php if($this->uri->uri_string() == 'order' || $this->uri->uri_string() == 'order/cart/' . $this->uri->segment(3)) { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo site_url('order/cart');?>"><i class="fas fa-shopping-cart"></i> Cart <span class="badge badge-danger"><?php echo count($this->cart->contents()); ?></span><span class="sr-only"><?php if($this->uri->uri_string() == 'order/cart') { echo '(current)'; } ?></span></a>
			</li>
			<li class="nav-item <?php if($this->uri->uri_string() == 'profile') { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo site_url('profile');?>"><i class="fas fa-user-circle mr-1"></i><?php echo $this->session->userdata("username"); ?> <span class="sr-only"><?php if($this->uri->uri_string() == 'profile') { echo '(current)'; } ?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo site_url('login/logout');?>">Sign Out</a>
			</li>
		</ul>
	</div>
</nav>