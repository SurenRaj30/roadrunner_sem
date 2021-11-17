<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4"><?php echo $content_heading ?></h1>
				<p class="lead"><?php echo $content_subheading; ?></p>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-md-3">
							<div class="list-group">
								<a href="#" class="list-group-item visitor">
									<h3 class="float-right">
										<i class="fas fa-eye"></i>
									</h3>
									<h4 class="list-group-item-heading count">
									1000</h4>
									<p class="list-group-item-text">
									Store Views</p>
								</a>
								<a href="#" class="list-group-item facebook-like">
									<h3 class="float-right">
										<i class="fas fa-box"></i>
									</h3>
									<h4 class="list-group-item-heading count">
									1000</h4>
									<p class="list-group-item-text">
									# of Products Sold</p>
								</a>
								<a href="#" class="list-group-item google-plus">
									<h3 class="float-right">
										<i class="fas fa-money-bill"></i>
									</h3>
									<h4 class="list-group-item-heading count">
									1000</h4>
									<p class="list-group-item-text">
									Total Sales</p>
								</a>
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
			// Animate the element's value from x to y:
			$({ someValue: 0 }).animate({ someValue: Math.floor(Math.random() * 100) }, {
				duration: 3000,
			    easing: 'swing', // can be anything
			    step: function () { // called on every step
			        // Update the element's text with rounded-up value:
			        $('.count').text(commaSeparateNumber(Math.round(this.someValue)));
			    }
			});

			function commaSeparateNumber(val) {
				while (/(\d+)(\d{3})/.test(val.toString())) {
					val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
				return val;
			}
		});
	</script>
