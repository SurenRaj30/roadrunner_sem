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
			<li class="nav-item <?php if($this->uri->uri_string() == 'admin/admin-sp-approval') { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo site_url("admin/admin-sp-approval"); ?>">Approve Service Provider<span class="sr-only"><?php if($this->uri->uri_string() == 'admin/admin-sp-approval') { echo '(current)'; } ?></span></a>
			</li>
			<li class="nav-item <?php if($this->uri->uri_string() == 'admin/admin-runner-approval') { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo site_url("admin/admin-runner-approval"); ?>">Approve Runner<span class="sr-only"><?php if($this->uri->uri_string() == 'admin/admin-runner-approval') { echo '(current)'; } ?></span></a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item <?php if($this->uri->uri_string() == 'profile') { echo 'active'; } ?>">
				<a class="nav-link" href=""><i class="fas fa-user-circle mr-1"></i><?php echo $this->session->userdata("username"); ?> <span class="sr-only"><?php if($this->uri->uri_string() == 'profile') { echo '(current)'; } ?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo site_url('login/logout');?>">Sign Out</a>
			</li>
		</ul>
	</div>
</nav>