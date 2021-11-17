<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4">Deliver Orders:</h1>
				<div class="row">
					<div class="col-3">
						<a href="<?php echo site_url('order/manage-order') ?>">
							<div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
								<img class="card-img-top cart-row align-self-center" src="<?php echo base_url('assets/pics/parcel.png') ?>" alt="">
								<div class="row px-3 justify-content-between">
									<div class="card-header col-9 pr-0">Take Order</div>
									<div class="card-header col-3"><i class="fas fa-arrow-right fa-lg"></i></div>
								</div>
								<div class="card-body bg-secondary">
									<h5 class="card-title">Start delivery by taking at least 1 order</h5>
								</div>
							</div>
						</a>
					</div>
					<div class="col-3">
						<a href="<?php echo site_url('order/current-delivery') ?>">
							<div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
								<img class="card-img-top cart-row align-self-center" src="<?php echo base_url('assets/pics/list2.png') ?>" alt="">
								<div class="row px-3 justify-content-between">
									<div class="card-header col-9 pr-0">Current Delivery</div>
									<div class="card-header col-3"><i class="fas fa-arrow-right fa-lg"></i></div>
								</div>
								<div class="card-body bg-secondary">
									<h5 class="card-title">View your current delivery</h5>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>