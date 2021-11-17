<div class="container">
	<div class="container mt-3">
		<div class="row h-100 justify-content-center align-items-center">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4"><center><?php echo $content_heading ?></center></h1>
				<div class="row">
				<form action="#" id="form" novalidate>
					<table style="border: 1px solid black;text-align: center;">
						<thead>
            					<td style="border: 1px solid black;" width="100px">Payment id</th>
            					<td style="border: 1px solid black;" width="100px">User Name</th>
            					<td style="border: 1px solid black;" width="400px">Product Name</th>
            					<td style="border: 1px solid black;" width="100px">Order Qty</th>
            					<td style="border: 1px solid black;" width="100px">Total Price</th>
            			</thead>
							<div class="form-row">
								<div class="col-sm-12">
								<?php
								foreach ($receipt as $row) {
								$payment_id   = $row->payment_id;
								$user_name   = $row->user_name;
								$prod_name   = $row->prod_name;
								$order_qty   = $row->order_qty;
								$total_price   = $row->total_price;
								?>
            					<tr>
            						<td style="border: 1px solid black;" width="100px"><?php echo $payment_id; ?></td>
            						<td style="border: 1px solid black;" width="100px"><?php echo $user_name; ?></td>
            						<td style="border: 1px solid black;" width="400px"><?php echo $prod_name; ?></td>
            						<td style="border: 1px solid black;" width="100px"><?php echo $order_qty; ?></td>
            						<td style="border: 1px solid black;" width="100px"><?php echo $total_price; ?></td>
            					</tr>
						<?php
					}
						?>
					</div>
					</div>
				</table>
				<button type="button" id="btnSave" style="width: 300px; margin: 0 auto;" class="btn btn-primary btn-block mt-4" onclick="save()"><i class="glyphicon glyphicon-ok"></i> Ok</button>
				</form>
				
				</div>
			</div>
		</div>
	</div>
	</div>
</div>

<script>
	var order_id = '<?php echo $order_id; ?>';

	function save()
	{
		window.location.href = "<?php echo site_url('order/manage-order/')?>";// redirect to manage order
	}
</script>
