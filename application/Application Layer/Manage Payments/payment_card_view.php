	<div class="container">
		<div class="container h-100">
			<div class="row h-100 justify-content-center align-items-center">
				<div class="card login-form">
					<div class="card-body">
						<h3 class="card-title text-center"><center><?php echo $content_heading ?></center></h3>
						<p class="lead"><center><?php echo $content_subheading ?></center></p>
						<form action="#" id="form" novalidate>
							<div class="form-row">
								<div class="col-sm-12">
										<div class="form-group">
										<label for="card_no">Card No</label>
										<input name="card_no" placeholder="Card No" class="form-control" type="text">
										<div class="invalid-feedback"></div>
									</div>
									<div class="form-group">
										<label for="card_holder_name">Card Holder Name</label>
										<input name="card_holder_name" placeholder="Card Holder Name" class="form-control" type="text">
										<div class="invalid-feedback"></div>
									</div>
									<div class="form-group">
										<label for="bank_card_type">Bank Card Type</label></br>
										<select id="bank_card_type" style="max-width:50%;">
										<option value="" disabled selected>-Select Card Type-</option>
										<option value="VISACARD">VISACARD</option>
										<option value="MASTERCARD">MASTERCARD</option>
                  						</select>&nbsp;
										<div class="invalid-feedback"></div>
									</div>
									<div class="form-group">
										<label for="CVV">CVV</label>
										<input name="CVV" placeholder="CVV" class="form-control" type="number">
										<div class="invalid-feedback"></div>
									</div>
									<div class="form-group">
										<label for="expired_date">Expired Date</label></br>
										<select id="month" style="position: relative;max-width:50%; top: 0px; left: 5px;">
										<option value="" disabled selected>-Please Select Month-</option>
										<?php
        								$months = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
        								foreach($months as $month){
        								?>
        								<option value=""><?php echo $month;?></option>
        								<?php
        								}
        								?>
                  						</select>&nbsp;
										<div class="invalid-feedback"></div>
									</div>
									<div class="form-group">
                  						<select id="year" style="position: relative;max-width:50%; top: -41px; left: 155px;">
										<option value="" disabled selected>-Please Select Year-</option>
										<?php
        								$years = array("2020", "2021", "2022", "2023", "2024", "2025", "2026", "2027", "2028");
        								foreach($years as $year){
        								?>
        								<option value="$year"><?php echo $year;?></option>
        								<?php
        								}
        								?>
                  						</select>
										<div class="invalid-feedback"></div>
									</div>
							<button type="button" id="btnSave" class="btn btn-primary btn-block" onclick="save()"><i class="glyphicon glyphicon-ok"></i> Proceed</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>

<script>
	var order_id = '<?php echo $order_id; ?>';

	function save()
	{
		window.location.href = "<?php echo site_url('order/payment-complete/')?>"+order_id; // redirect to receipt
	}
</script>
