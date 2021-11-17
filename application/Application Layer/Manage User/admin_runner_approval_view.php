	<div class="container">
		<div class="container">
			<div class="card">
				<div class="card-body">
					<h1 class="display-4" id="heading"><?php echo $content_heading ?></h1>
					<div class="row col-12">
						<button class="btn btn-primary" onclick="reloadTable()"> Reload</button>
					</div>
					<!-- DataTables -->
					<table class="table table-striped table-hover" id="dataTable">
						<thead>
							<tr>
								<th>User ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Address</th>
								<th>Contact No.</th>
								<th>Vehicle Plate No.</th>
								<th>Action</th>
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
		var table;
		$(document).ready(function() {

			//Datatables
			table = $('#dataTable').DataTable({

		        "processing": true, //Feature control the processing indicator.
		        "serverSide": true, //Feature control DataTables' server-side processing mode.
		        "order": [], //Initial no order.
		        "lengthMenu": [ 5, 10, 25, 50 ],
		        "pageLength": 5,
		        "language": {
		        	"infoFiltered": ""
		        },

		        // Load data for the table's content from an Ajax source
		        "ajax": {
		        	"url": "<?php echo site_url('admin/ajax_list_runner')?>",
		        	"type": "POST"
		        },

		        //Set column definition initialisation properties.
		        "columnDefs": [
		        {
		                "targets": [ -1 ], //last column
		                "orderable": false, //set not orderable
		            },
		            {
		            	"width": "2%", "targets": -1,
		            },
		            ],
		        });

			$( "#dataTable_filter" ).addClass( "float-md-right" );
			$( "#dataTable_paginate" ).addClass( "float-md-right" );
			$( "#dataTable_length" ).addClass( "form-inline" );
			$( "#dataTable_length" ).parent().addClass( "my-md-auto" );
		});


		var url = "<?php echo site_url("admin/approve_user");?>"

		function approveUser(userId){
			$.ajax({
				url : url + "/" + userId,
				type: "POST",
				contentType: false,
				processData: false,
				success: function(data)
				{
					$.toast({
						text: "Successfully approved user."
					})
					reloadTable();
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$.toast({
						text: "Failed to approve user."
					})
				}
			});
		}

		function reloadTable()
		{
	    table.ajax.reload(null,false); //reload datatable ajax
	}

</script>

<!-- id=dataTable_filter, id=dataTable_paginate -->