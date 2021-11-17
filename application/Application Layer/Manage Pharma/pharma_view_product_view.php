<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<div class="alert alert-danger" id="errorAlert" role="alert" hidden></div>
				<div class="container pt-5">
					<?php
					$id = $prod_info->id;
					$store_id = $prod_info->store_id;
					$name = $prod_info->prod_name;
					$descr = $prod_info->prod_descr;
					$qty = $prod_info->prod_qty;
					$price = $prod_info->prod_price;
					$pic = $prod_info->prod_pic;
					$qty_left = $prod_info->prod_qty;

					if(!$pic){
						$picLink = base_url('assets/pics/def_placeholder.jpg');
					}else{
						$picLink = base_url('upload/'.$pic);
					}

					echo '<div class="row justify-content-md-center">';
					echo	'<div class="col-4">';
					echo		'<img class="product-large" src="'. $picLink .'">';
					echo		'<span class="badge badge-pill badge-secondary float-right">'.$qty.' items remaining</span>';
					echo	'</div>';
					echo	'<div class="col-3">';
					echo		'<p class="lead font-weight-bold">'.$name.'</p>';
					echo		'<p class="lead text-success font-weight-bold">RM '. $price .'</p>';
					echo		'<form action="'.site_url('order/add-to-cart').'" method="POST">';
					echo		'<input type="hidden" name="id" value="'.$id.'">';
					echo		'<input type="hidden" name="store_id" value="'.$store_id.'">';
					echo		'<input type="hidden" name="name" value="'.$name.'">';
					echo		'<input type="hidden" name="price" value="'.$price.'">';
					echo		'<input type="hidden" name="pic" value="'.$pic.'">';
					echo		'<input type="hidden" name="store_type" value="'.$store_type.'">';
					echo		'<input type="hidden" name="qty_left" value="'.$qty_left.'">';
					echo		'<input type="number" name="qty" class="form-control" value="1" min="1" max="'.$qty.'">';
					echo		'<button class="btn btn-primary btn-block">ADD TO CART</button>';
					echo		'</form>';
					echo		'<p class="lead pt-3">'.$descr.'</p>';
					echo	'</div>';
					echo '</div>';
					?>

				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
			//TODO Remove flashdata for user id. This is for testing a part of query in login_model where 1 query is performed right after the first one. Do query 1, take user_id from query 1 to be inserted into query 2.
			var error = "<?php echo $this->session->flashdata('msg');?>";

			if(error){
				$('#errorAlert').attr("hidden",false);
				$('#errorAlert').html(error);
			}

		});
</script>