
<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-3 text-center py-2">Shopping Cart</h1>

				<div id="text" class="lead text-center">
					<?php $cart_check = $this->cart->contents();

					// If cart is empty, this will show below message.
					if(empty($cart_check)) {
					echo 'To add products to your shopping cart, browse for products then click on the "ADD TO CART" Button';
				} ?> </div>


				<?php
				// All values of cart store in "$cart".
				if ($cart = $this->cart->contents()): ?>
				<div class="container">
					<table id="table" class="table table-striped" border="0" cellpadding="5px" cellspacing="1px">

						<tr id="main_heading">
							<th colspan="2" width="500px">Product</th>
							<th width="160px">Price</th>
							<th width="150px">Qty</th>
							<th class="text-right" width="160px">Amount</th>
						</tr>
						<?php
						// Create form and send all values in "shopping/update_cart" function.
						echo form_open('order/update_cart');
						$grand_total = 0;
						$i = 1;


						foreach ($cart as $item):
						// echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
						// Will produce the following output.
						// <input type="hidden" name="cart[1][id]" value="1" />

						if(!$item['pic']){
							$picLink = base_url('assets/pics/goods/shipping-box.jpg');
						}else{
							$picLink = base_url('upload/'.$item['pic']);
						}


						//Takes store_type from session, then turn it into controller name to link to product page
						if($item['store_type']=='food'){
							$storeController = 'foods';
						}else if($item['store_type']=='good'){
							$storeController = 'goods';
						}else if($item['store_type']=='med'){
							$storeController = 'pharma';
						}else if($item['store_type']=='pet'){
							$storeController = 'pet';
						}

						echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
						echo form_hidden('cart[' . $item['id'] . '][store_id]', $item['store_id']);
						echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
						echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
						echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
						echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
						?>
						<tr>
							<td width="50px">
								<?php //echo $i++; ?>
								<a href="<?php echo site_url($storeController.'/view-product/'. $item['id']);?>"><img class="cart-row" src="<?php echo $picLink?>"></a>
							</td>
							<td class="align-middle">
								<a href="<?php echo site_url($storeController.'/view-product/'. $item['id']);?>"><?php echo $item['name']; ?></a>
							</td>
							<td class="align-middle text-success font-weight-bold">
								RM <?php echo number_format($item['price'], 2); ?>
							</td>
							<td class="align-middle">
								<?php
								echo '<input type="number" name="cart['.$item['id'].'][qty]" class="form-control text-right" value="'.$item['qty'].'" min="0" max="'.$item['qty_left'].'">'; ?>
							</td >
							<?php $grand_total = $grand_total + $item['subtotal']; ?>
							<td class="text-right align-middle text-success font-weight-bold">
								RM <?php echo number_format($item['subtotal'], 2) ?>
							</td>
							<?php endforeach; ?>
						</tr>
						<tr>
							<td colspan="6" align="right"><b>Order Total: <span class="text-success">RM <?php
								//Grand Total.
								echo number_format($grand_total, 2); ?></span></b></td>
							</tr>
						</table>
						<?php // "clear cart" button call javascript confirmation message ?>
						<div class="row pt-0 mt-0">
							<div class="col-4 ml-auto">
								<input class='btn btn-secondary mt-0' type="button" value="Clear Cart" onclick="clear_cart()">

								<?php //submit button. ?>
								<input class ='btn btn-secondary mt-0 mx-2'  type="submit" value="Update Cart" formaction="<?php echo site_url('order/update-cart'); ?>">

								<!-- "Place order button" on click send "billing" controller -->
								<input class ='btn btn-secondary mt-0' type="submit" value="Place Order" formaction="<?php echo site_url('order/place-order'); ?>" >
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
			// To confirm clear all data in cart.
			function clear_cart() {
				var result = confirm('Are you sure want to empty your cart?');

				if (result) {
					window.location = "<?php echo site_url(); ?>/order/empty-cart";
				} else {
					return false; // cancel button
				}
			}

			function place_order() {
				window.location = "<?php echo site_url('order/place-order') ?>";
			}
		</script>