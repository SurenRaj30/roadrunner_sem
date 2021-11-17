<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4"><?php echo $content_heading ?></h1>
				<h3 class="display-5"><?php echo $content_subheading ?></h3>
				<div class="row col-12">
					<button type="button" class="btn btn-primary ml-2" onclick="reloadTable()"> Reload</button>
				</div>
				<!-- DataTables -->
				<table class="table table-striped table-hover" id="dataTable">
					<thead>
						<tr>
							<th>Order ID</th>
							<th>User Name</th>
							<th>User Contact No.</th>
							<th>User Address</th>
							<th>Order Date</th>
							<th>Order Time</th>
							<th>Order Status</th>
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
	var runner_id = '<?php echo $user_id; ?>';

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

	        // Load data for the table's content from an Ajax source
	        "ajax": {
	        	"url": "<?php echo site_url('order/ajax_list_runner_orders')?>/" + runner_id + "/" + 1,//1 for runner take order page, 2 for current delivery page
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
	            // {
	            // 	"targets": [ -2 ],
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

		$('#btnFilterCompleted').on( 'click', function () {
		    table.column(12).search("confirmed|delivered", true, true).draw();
		} );

	});

	function reloadTable()
	{
		table.ajax.reload(null,false); //reload datatable ajax
	}

	function confirm_pickup(id){
		var url = "<?php echo site_url('order/confirm-pickup/') ?>";
		var new_url = url+id+"/"+runner_id;
		window.location = new_url;
		reloadTable();
	}



</script>
