<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4 mb-5"><?php echo $content_heading ?></h1>
				<p class="lead"><?php if(!$order_data) echo "You have no orders"; ?></p>
				<!-- <h3 class="display-5"><?php //echo $content_subheading ?></h3> -->
				<!-- Template order item to be used with php-->
				<!-- <div class="card">
					<div class="card-header">
						<div class="container">#ORDERID<button class="btn btn-primary mt-0 ml-auto float-right">Pay Now</button></div>
					</div>
					<div class="card-body">
						<fieldset class="border p-2 mb-3">
							<div class="row justify-content-center">
								<div class="col-2">
									<img class="img-fluid" src="<?php //echo base_url('assets/pics/def_placeholder.jpg'); ?>" alt="img">
								</div>
								<div class="col-6 align-self-center">
									<div class="row">
										<div class="col-2"><span class="small">Name: </span></div>
										<div class="col-8"><span class="small">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque velit et sequi reprehenderit, enim laudantium dicta amet ad molestias, sint ut commodi veniam voluptates fuga recusandae quos, id similique vel.</span></div>
									</div>
									<div class="row">
										<div class="col-2"><span class="small">Quantity: </span></div>
										<div class="col-8"><span class="small">2</span></div>
									</div>
									<div class="row">
										<div class="col-2"><span class="small">Price: </span></div>
										<div class="col-8"><span class="small">RM20.00</span></div>
									</div>
									<div class="row">
										<div class="col-2"><span class="small">Store: </span></div>
										<div class="col-8"><span class="small">Seller Z</span></div>
									</div>
								</div>
								<div class="col-2 align-self-center">
									<div class="row">
										<div class="col-6"><span class="small">Order Date: </span></div>
										<div class="col-6"><span class="small">2020-04-07</span></div>
									</div>
									<div class="row">
										<div class="col-6"><span class="small">Order status: </span></div>
										<div class="col-6"><span class="small">To pay</span></div>
									</div>
									<div class="row">
										<div class="col-6"><span class="">Subtotal: </span></div>
										<div class="col-6"><span class="text-success">RM 40.00</span></div>
									</div>
								</div>
							</div>
						</fieldset>
						<div class="row">
							<div class="row col-3 ml-auto">
								<div class="col-4"><span class="lead font-weight-bold">Total: </span></div>
								<div class="col-8"><span class="lead font-weight-bold text-success">RM 40.00</span></div>
							</div>
						</div>
					</div>
				</div> -->
				<?php
				// print_r($order_data);
				$grand_total_price;
				$btn_action;


				foreach ($order_data as $outerRow => $value) {
					global $grand_total_price;
					$grand_total_price = 0;
					$order_id = $outerRow;

					foreach ($value as $row) {
						global $btn_action;
						$order_status = $row->order_status;
						if($order_status=="to-pay")
							$btn_action="unpaid";
						else if($order_status=="paid")
							$btn_action="paid";
						else if($order_status=="confirmed")
							$btn_action="confirmed";
						else if($order_status=="delivered")
							$btn_action="delivered";
						else
							$btn_action="cancelled";
					}

					echo	'<div class="card mb-5">';
					echo		'<div class="card-header">';
					if($btn_action=="unpaid")
						echo			'<div class="container">Order ID#'.$order_id.'<button class="btn btn-danger mt-0 ml-auto float-right" onclick="cancel_order('.$order_id.')">Cancel</button><button class="btn btn-primary mr-2 mt-0 ml-auto float-right" onclick="pay_order('.$order_id.')">Pay Now</button></div>';
					else if($btn_action=="paid")
						echo			'<div class="container">Order ID#'.$order_id.'<button class="btn btn-danger mt-0 ml-auto float-right" onclick="cancel_order('.$order_id.')">Cancel</button></div>';
					else if($btn_action=="confirmed")
						echo			'<div class="container">Order ID#'.$order_id.'<button class="btn btn-success mt-0 ml-auto float-right" disabled>Confirmed</button></div>';
					else if($btn_action=="delivered")
						echo			'<div class="container">Order ID#'.$order_id.'<button class="btn btn-success mt-0 ml-auto float-right" disabled>Delivered</button></div>';
					else if($btn_action=="cancelled")
						echo			'<div class="container">Order ID#'.$order_id.'<button class="btn btn-success mt-0 ml-auto float-right" disabled>Cancelled</button></div>';
					echo		'</div>';
					echo		'<div class="card-body">';

					foreach ($value as $row) {
						global $grand_total_price;

						$order_id   = $row->order_id;
						$user_id   = $row->user_id;
						$store_id   = $row->store_id;
						$store_name   = $row->store_name;
						$store_type   = $row->store_type;

						if($store_type=='food'){
							$storeController = 'foods';
						}else if($store_type=='good'){
							$storeController = 'goods';
						}else if($store_type=='med'){
							$storeController = 'pharma';
						}else if($store_type=='pet'){
							$storeController = 'pet';
						}

						$prod_id = $row->prod_id;
						$prod_name = $row->prod_name;
						$prod_pic = $row->prod_pic;
						if($prod_pic)
							$prod_pic_url = base_url('upload/'.$prod_pic);
						else
							$prod_pic_url = base_url('assets/pics/def_placeholder.jpg');
						$runner_id = $row->runner_id;
						$order_qty = $row->order_qty;
						$price = $row->price;
						$total_price = $price*$order_qty;
						$total_price_2dp = number_format($total_price, 2);
						$grand_total_price += $total_price;
						$grand_total_price_2dp = number_format($grand_total_price, 2);
						$order_date = $row->order_date;
						$order_time = $row->order_time;
						$order_status = ucwords($row->order_status);

						//redirect('payment/receipt/'.$order_id.'');

						//test
						$runner_id = $row->runner_id;
						$runner_name = $row->runner_name;

						echo	'<fieldset class="border p-2 mb-3">';
						echo		'<!-- <legend  class="w-auto"></legend> -->';
						echo		'<div class="row justify-content-center">';
						echo			'<div class="col-2 align-self-center">';
						echo				'<a href="'. site_url($storeController.'/view-product/'. $prod_id) .'"><img class="img-fluid cart-row" src="'.$prod_pic_url.'" alt="$prod_pic"></a>';
						echo			'</div>';
						echo			'<div class="col-6 align-self-center">';
						echo				'<div class="row">';
						echo					'<div class="col-2"><span class="small">Name: </span></div>';
						echo					'<div class="col-8"><a href="'. site_url($storeController.'/view-product/'. $prod_id) .'"><span class="small">'.$prod_name.'</span></div></a>';
						echo				'</div>';
						echo				'<div class="row">';
						echo					'<div class="col-2"><span class="small">Quantity: </span></div>';
						echo					'<div class="col-8"><span class="small">'.$order_qty.'</span></div>';
						echo				'</div>';
						echo				'<div class="row">';
						echo					'<div class="col-2"><span class="small">Price: </span></div>';
						echo					'<div class="col-8"><span class="small text-success">RM '.$price.'</span></div>';
						echo				'</div>';
						echo				'<div class="row">';
						echo					'<div class="col-2"><span class="small">Store: </span></div>';
						echo					'<div class="col-8"><span class="small">'.$store_name.'</span></div>';
						echo				'</div>';
						if($runner_id && $order_status=='Delivered'){
							echo				'<div class="row">';
							echo					'<div class="col-2"><span class="small">Delivered by: </span></div>';
							echo					'<div class="col-8"><span class="small">'.$runner_name.'</span></div>';
							echo				'</div>';
						}
						echo			'</div>';
						echo			'<div class="col-2 align-self-center">';
						echo				'<div class="row">';
						echo					'<div class="col-6"><span class="small">Order Date: </span></div>';
						echo					'<div class="col-6"><span class="small">'.$order_date.'</span></div>';
						echo				'</div>';
						echo				'<div class="row">';
						echo					'<div class="col-6"><span class="small">Order Time: </span></div>';
						echo					'<div class="col-6"><span class="small">'.$order_time.'</span></div>';
						echo				'</div>';
						echo				'<div class="row">';
						echo					'<div class="col-6"><span class="small">Order status: </span></div>';
						echo					'<div class="col-6"><span class="small">'.$order_status.'</span></div>';
						echo				'</div>';
						echo				'<div class="row">';
						echo					'<div class="col-6"><span class="">Subtotal: </span></div>';
						echo					'<div class="col-6"><span class="text-success">RM '.$total_price_2dp.'</span></div>';
						echo				'</div>';
						echo			'</div>';
						echo		'</div>';
						echo	'</fieldset>';
					}
					echo		'<div class="row">';
					echo			'<div class="row col-3 ml-auto">';
					echo				'<div class="col-4"><span class="lead font-weight-bold">Total: </span></div>';
					echo				'<div class="col-8"><span class="lead font-weight-bold text-success">RM '.$grand_total_price_2dp.'</span></div>';
					echo			'</div>';
					echo		'</div>';
					echo	'</div>';
					echo'</div>';
				}
				?>

			</div>
		</div>
	</div>
</div>

<script>
	var save_method;//string to tell whether to add or update
	var table;
	var base_url = '<?php echo base_url();?>';

	$(document).ready(function() {


		$("input").keydown(function(){
			$(this).removeClass('is-invalid');
			$(this).next().empty();
		});
		$("textarea").keydown(function(){
			$(this).removeClass('is-invalid');
			$(this).next().empty();
		});
		$("select").change(function(){
			$(this).removeClass('is-invalid');
			$(this).next().empty();
		});
		$("input").change(function(){
			$(this).removeClass('is-invalid');
			$(this).next().empty();
		});

	});

	function pay_order(id){
		var url = "<?php echo site_url('order/pay-now/') ?>";
		var new_url = url+id;
		window.location = new_url;
	}

	function cancel_order(id){
		var url = "<?php echo site_url('order/cancel_order/') ?>";
		var new_url = url+id;
		console.log(new_url);
		window.location = new_url;
	}



</script>
