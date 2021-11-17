<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4 mb-5"><?php echo $content_heading ?></h1>
				<div class="row col-12">
					<button type="button" class="btn btn-primary ml-2" onclick="reloadTable()"> Reload</button>
					<button type="button" id="btnFilterClear" class="btn btn-success ml-5" > All</button>
					<button type="button" id="btnFilterToPay" class="btn btn-success ml-2" > To Pay</button>
					<button type="button" id="btnFilterPaid" class="btn btn-success ml-2" > Paid</button>
					<button type="button" id="btnFilterConfirmed" class="btn btn-success ml-2" > Confirmed</button>
					<button type="button" id="btnFilterOutForDelivery" class="btn btn-success ml-2" > Out for Delivery</button>
					<button type="button" id="btnFilterDelivered" class="btn btn-success ml-2" > Delivered</button>

				</div>
				<!-- DataTables -->
				<table class="table table-striped table-hover" id="dataTable">
					<thead>
						<tr>
							<th>Order ID</th>
							<th>User Name</th>
							<th>User Contact No.</th>
							<th>Product</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
							<th>Order Date</th>
							<th>Order Time</th>
							<th>Runner Name</th>
							<th>Runner Contact No.</th>
							<th>Order Status</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	var save_method;//string to tell whether to add or update
	var table;
	var base_url = '<?php echo base_url();?>';
	var store_id = '<?php echo $store_id; ?>'; //Get sp_id via session from profile controller

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

		//Datatables
		table = $('#dataTable').DataTable({

	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [], //Initial no order.
	        "lengthMenu": [ 10, 25, 50 ],
	        "pageLength": 10,
	        "search": {
				"regex": true
			},

	        // Load data for the table's content from an Ajax source
	        "ajax": {
	        	"url": "<?php echo site_url('order/ajax_list_sp_orders')?>/" + store_id,
	        	"type": "POST"
	        },

	        //Set column definition initialisation properties.
	        "columnDefs": [
	        {
	                "targets": [ -1,-2 ], //last column
	                "orderable": false, //set not orderable
	            },
	            {
	            	"width": "2%", "targets": -1,
	            },
	            {
	            	"targets": [ 4,6 ],
	            	"render": $.fn.dataTable.render.number( ',', '.', 2, 'RM' ),
	            },
	            // {
	            // 	"targets": [ 1 ],
	            // 	"visible": false
	            // },
	            ],
	        });



		$( "#dataTable_filter" ).addClass( "float-md-right" );
		$( "#dataTable_paginate" ).addClass( "float-md-right" );
		$( "#dataTable_length" ).addClass( "form-inline" );
		$( "#dataTable_length" ).parent().addClass( "my-md-auto" );

		$('#btnFilterClear').on( 'click', function () {
		    table.search("", true, false, true).draw();
		} );

		$('#btnFilterToPay').on( 'click', function () {
		    table.search("to-pay", true, false, true).draw();
		} );

		$('#btnFilterPaid').on( 'click', function () {
		    table.search("paid", true, false, true).draw();
		} );

		$('#btnFilterConfirmed').on( 'click', function () {
		    table.search("confirmed", true, false, true).draw();
		} );

		$('#btnFilterOutForDelivery').on( 'click', function () {
		    table.search("out-for-delivery", true, false, true).draw();
		} );

		$('#btnFilterDelivered').on( 'click', function () {
		    table.search("delivered", true, false, true).draw();
		} );

	});

	function reloadTable()
	{
		table.ajax.reload(null,false); //reload datatable ajax
	}

	function cancel_order(id,prod_id){
		var url = "<?php echo site_url('order/cancel-order-sp/') ?>";
		var new_url = url+id+"/"+prod_id;
		window.location = new_url;
		reloadTable();
	}

	function confirm_order(id,prod_id){
		var url = "<?php echo site_url('order/confirm-order-sp/') ?>";
		var new_url = url+id+"/"+prod_id;
		window.location = new_url;
		reloadTable();
	}



</script>
