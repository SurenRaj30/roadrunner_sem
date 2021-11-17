<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4">Your Store: <?php if($store_data->store_name) echo $store_data->store_name; else echo "You need to set up your store first!"; ?></h1>
				<p class="lead"><?php if($store_data->store_descr) echo $store_data->store_descr; else echo "Your store doesn't have a description!"; ?></p>
				<div class="row">
					<div class="col-3">
						<img class="card-img-top w-100" src="<?php if($store_data->store_pic) echo base_url('upload/' . $store_data->store_pic); else echo base_url('assets/pics/def_placeholder.jpg'); ?>" alt="">
					</div>
					<div class="col-3">
						<a href="<?php echo site_url('profile/manage-store/'.$store_id) ?>">
							<div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
								<img class="card-img-top cart-row align-self-center" src="<?php echo base_url('assets/pics/info2.png') ?>" alt="">
								<div class="row px-3 justify-content-between">
									<div class="card-header col-9 pr-0">Manage Store Info</div>
									<div class="card-header col-3"><i class="fas fa-arrow-right fa-lg"></i></div>
								</div>
								<div class="card-body bg-secondary">
									<h5 class="card-title">Manage your store's details</h5>
								</div>
							</div>
						</a>
					</div>
					<div class="col-3">
						<a href="<?php echo site_url('profile/manage-products/') ?>">
							<div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
								<img class="card-img-top cart-row align-self-center" src="<?php echo base_url('assets/pics/parcel.png') ?>" alt="">
								<div class="row px-3 justify-content-between">
									<div class="card-header col-9 pr-0">Manage Store Products</div>
									<div class="card-header col-3"><i class="fas fa-arrow-right fa-lg"></i></div>
								</div>
								<div class="card-body bg-secondary">
									<h5 class="card-title">Manage your store's products</h5>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="py-3">
			<div class="card">
				<div class="card-body">
					<h1 class="display-4">Your Orders:</h1>
					<div class="row">
						<div class="col-3">
							<a href="<?php echo site_url('order/manage-order') ?>">
								<div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
									<img class="card-img-top cart-row align-self-center" src="<?php echo base_url('assets/pics/list2.png') ?>" alt="">
									<div class="row px-3 justify-content-between">
										<div class="card-header col-9 pr-0">Manage Customer Orders</div>
										<div class="card-header col-3"><i class="fas fa-arrow-right fa-lg"></i></div>
									</div>
									<div class="card-body bg-secondary">
										<h5 class="card-title">View, confirm or cancel customer orders</h5>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>