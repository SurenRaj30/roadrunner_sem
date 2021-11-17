<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body bg-secondary">
				<h1 class="display-4 text-light text-center"><?php echo $content_heading ?></h1>
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
					</ol>
					<div class="carousel-inner">
						<div class="carousel-item active">
							<a href="<?php echo site_url('foods');?>"><img class="d-block w-100" src="<?php echo base_url('assets/pics/foods/fried-comfort-food-chicken.jpg'); ?>" alt="First slide"></a>
							<a href="<?php echo site_url('foods');?>">
								<div class="carousel-caption d-none d-md-block bg-dark">
									<h5 class="display-4">Browse Food Stores</h5>
								</div>
							</a>
						</div>
						<div class="carousel-item">
							<a href="<?php echo site_url('goods');?>"><img class="d-block w-100" src="<?php echo base_url('assets/pics/goods/empty-boxes-on-table.jpg'); ?>" alt="First slide"></a>
							<a href="<?php echo site_url('goods');?>">
								<div class="carousel-caption d-none d-md-block bg-dark">
									<h5 class="display-4">Browse Goods Stores</h5>
								</div>
							</a>
						</div>
						<div class="carousel-item">
							<a href="<?php echo site_url('pharma');?>"><img class="d-block w-100" src="<?php echo base_url('assets/pics/pharma/pills-pill-container.jpg'); ?>" alt="First slide"></a>
							<a href="<?php echo site_url('pharma');?>">
								<div class="carousel-caption d-none d-md-block bg-dark">
									<h5 class="display-4">Browse Pharma Stores</h5>
								</div>
							</a>
						</div>
						<div class="carousel-item">
							<a href="<?php echo site_url('pet');?>"><img class="d-block w-100" src="<?php echo base_url('assets/pics/pet/cat-poses-perfectly.jpg'); ?>" alt="First slide"></a>
							<a href="<?php echo site_url('pet');?>">
								<div class="carousel-caption d-none d-md-block bg-dark">
									<h5 class="display-4">Browse Pet Stores</h5>
								</div>
							</a>
						</div>
					</div>
					<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>
		<div class="py-3">
			<div class="card">
				<div class="row">
					<div class="col-md-2 pr-0 pl-5 text-center justify-content-center align-self-center">
						<i class="fas fa-tasks" style="font-size: 6rem;"></i>
					</div>
					<div class="col-md-10 px-3 align-self-center">
						<div class="card-block px-3">
							<h4 class="card-title display-4">View Your Orders</h4>
							<p class="card-text lead">Here's where you can view all of your orders.</p>
							<a href="<?php echo site_url('order/manage-order') ?>" class="btn btn-primary mb-2">Orders</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="py-3">
			<div class="card">
				<div class="row">
					<div class="col-md-2 pr-0 pl-5 text-center justify-content-center align-self-center">
						<i class="fas fa-shopping-cart" style="font-size: 6rem;"></i>
					</div>
					<div class="col-md-10 px-3 align-self-center">
						<div class="card-block px-3">
							<h4 class="card-title display-4">View Your Cart</h4>
							<p class="card-text lead">Here's where you can view your items in cart.</p>
							<a href="<?php echo site_url('order/cart') ?>" class="btn btn-primary mb-2">Cart</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script>
	$(document).ready(function() {
		$('#carouselExampleIndicators').carousel({
			interval: 3000
		});

	});
</script>