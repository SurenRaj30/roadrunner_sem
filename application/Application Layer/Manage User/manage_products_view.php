<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4"><?php echo $content_heading ?></h1>
				<h3 class="display-5"><?php echo $content_subheading ?></h3>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link" id="store-info-tab" href="<?php echo site_url('profile/manage-store')?>">Store Info</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-controls="products" aria-selected="true">Products</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="products" role="tabpanel" aria-labelledby="products-tab">
						<div class="row col-12">
							<button type="button" class="btn btn-success" onclick="addProduct()"> Add Product</button>
							<button type="button" class="btn btn-primary ml-2" onclick="reloadTable()"> Reload</button>
							<button type="button" class="btn btn-dark ml-2" onclick="reloadTable()"><a href="<?php echo site_url('/promo')?>">Promotion</a></button>
						</div>
						<!-- DataTables -->
						<table class="table table-striped table-hover" id="dataTable">
							<thead>
								<tr>
									<th>ID</th>
									<th>Prod. ID</th>
									<th>Prod. Name</th>
									<th>Prod. Description</th>
									<th>Prod. Quantity</th>
									<th>Prod. Price</th>
									<th>Prod. Pic</th>
									<th>Update</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="tab-pane fade" id="store-info" role="tabpanel" aria-labelledby="store-info-tab">
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<script>
	var save_method;//string to tell whether to add or update
	var table;
	var base_url = '<?php echo base_url();?>';
	var sp_id = '<?php echo $sp_id ?>'; //Get sp_id via session from profile controller
	var store_id = '<?php echo $store_id; ?>'; //Get sp_id via session from profile controller

	$(document).ready(function() {
		viewStore(sp_id); //Load user profile info

		$("#prod_pic").change(function() {
			photoPreview(this,"product");
		});

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
	        "lengthMenu": [ 5, 10, 25, 50 ],
	        "pageLength": 5,

	        // Load data for the table's content from an Ajax source
	        "ajax": {
	        	"url": "<?php echo site_url('profile/ajax_list_products')?>/" + store_id,
	        	"type": "POST"
	        },

	        //Set column definition initialisation properties.
	        "columnDefs": [
	        {
	                "targets": [ -1,-2,-3 ], //last column
	                "orderable": false, //set not orderable
	            },
	            {
	            	"width": "2%", "targets": -1,
	            },
	            {
	            	"targets": [ 1 ],
	            	"visible": false
	            },
	            {
	            	"targets": [ 5 ],
	            	"render": $.fn.dataTable.render.number( ',', '.', 2, 'RM' ),
	            },
	            ],
	        });

		$( "#dataTable_filter" ).addClass( "float-md-right" );
		$( "#dataTable_paginate" ).addClass( "float-md-right" );
		$( "#dataTable_length" ).addClass( "form-inline" );
		$( "#dataTable_length" ).parent().addClass( "my-md-auto" );
	});


	//Store info
	function photoPreview(input,type) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				if(type == "store")
					$('#photo-preview-img').attr('src', e.target.result);
				else
					$('#prod-photo-preview-img').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	//Store info
	function viewStore(sp_id)
	{
    //Ajax Load data from ajax
    $.ajax({
    	url : "<?php echo site_url('profile/loadStore')?>/" + sp_id,
    	type: "GET",
    	dataType: "JSON",
    	success: function(data)
    	{
    		$('[name="store_id"]').val(data.store_id);
    		$('[name="sp_id"]').val(data.sp_id);
    		$('[name="store_name"]').val(data.store_name);
    		$('[name="store_descr"]').val(data.store_descr);
    		$('[name="store_type"]').val(data.store_type);

    		if(data.store_pic)
    		{
                $('#photo-preview-img').attr('src', base_url+'upload/'+data.store_pic);// show photo
                $('#photo-preview').append('<input type="checkbox" name="remove_photo" value="'+data.store_pic+'"/> Remove photo when saving'); // remove photo
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        	alert('Error get data from ajax');
        }
    });
}

//Product
function addProduct()
{
	save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid'); // clear error class
    $('.invalid-feedback').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Product'); // Set Title to Bootstrap modal title

    $('#remove_photo_chkbox').remove(); // Get rid of remove photo checkbox
     $('#prod-photo-preview-img').attr('src', base_url+'assets/pics/50x50_placeholder.png');// show default photo

    $('#label-photo').text('Upload Photo'); // label photo upload
}

function updateProduct(id)
{
	save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid'); // clear error class
    $('.invalid-feedback').empty(); // clear error string

    $('#remove_photo_chkbox').remove(); // Get rid of remove photo checkbox


    //Ajax Load data from ajax
    $.ajax({
    	url : "<?php echo site_url('profile/loadProduct')?>/" + id,
    	type: "GET",
    	dataType: "JSON",
    	success: function(data)
    	{
    		$('[name="id"]').val(data.id);
    		$('[name="prod_name"]').val(data.prod_name);
    		$('[name="prod_descr"]').val(data.prod_descr);
    		$('[name="prod_qty"]').val(data.prod_qty);
    		$('[name="prod_price"]').val(data.prod_price);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Update Product'); // Set title to Bootstrap modal title

            $('#prod-photo-preview').show(); // show photo preview modal

            if(data.prod_pic)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#prod-photo-preview-img').attr('src', base_url+'upload/'+data.prod_pic);// show photo
                $('#prod-photo-preview').append('<div id="remove_photo_chkbox"><input type="checkbox" name="remove_photo" value="'+data.prod_pic+'"/> Remove photo when saving<div>'); // remove photo

            }
            else
            {
            	$('#prod-photo-preview-img').attr('src', base_url+'assets/pics/50x50_placeholder.png');// default photo
                $('#label-photo').text('Upload Photo'); // label photo upload
            }


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        	alert('Error get data from ajax');
        }
    });
}

function saveProduct()
{
    $('#btnSave').text('Saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
    	url = "<?php echo site_url('profile/saveProduct')?>";
    } else {
    	url = "<?php echo site_url('profile/updateProduct')?>";
    }

    // ajax adding data to database

    var formData = new FormData($('#form')[0]);
    $.ajax({
    	url : url,
    	type: "POST",
    	data: formData,
    	contentType: false,
    	processData: false,
    	dataType: "JSON",
    	success: function(data)
    	{

            if(data.status) //if success close modal and reload ajax table
            {
            	$('#modal_form').modal('hide');
            	reloadTable();
            }
            else
            {
            	for (var i = 0; i < data.inputerror.length; i++) 
            	{
                    $('[name="'+data.inputerror[i]+'"]').addClass("is-invalid"); //select input and add is-invalid class
					$('[name="'+data.inputerror[i]+'"]').next().html(data.error_string[i]); //select error div and set text error string
				}
			}
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        	alert('Error adding / update data');
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function deleteProduct(id)
{
	if(confirm('Are you sure delete this data?'))
	{
        // ajax delete data to database
        $.ajax({
        	url : "<?php echo site_url('profile/deleteProduct')?>/"+id,
        	type: "POST",
        	dataType: "JSON",
        	success: function(data)
        	{
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reloadTable();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
            	alert('Error deleting data');
            }
        });

    }
}


function reloadTable()
{
	table.ajax.reload(null,false); //reload datatable ajax
}
</script>

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form">
	Launch demo modal
</button> -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Product Form</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body form">
				<form action="#" id="form" novalidate>
					<div class="form-row">
						<div class="col-md-12">
							<input type="hidden" value="" name="id"/>
							<input type="hidden" value="" name="store_id"/>
							<div class="form-group">
								<label for="prod_name">Prod. Name</label>
								<input name="prod_name" placeholder="Prod. Name" class="form-control" type="text">
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label for="prod_descr">Prod. Description</label>
								<textarea name="prod_descr" id="prod_descr" class="form-control" placeholder="Prod. Description" rows="5" ></textarea>
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label for="prod_qty">Prod. Qty</label>
								<input name="prod_qty" placeholder="Prod. Quantity" class="form-control" type="text">
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label for="prod_price">Prod. Price (RM)</label>
								<input name="prod_price" placeholder="Prod. Price (RM)" class="form-control" type="text">
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group" id="prod-photo-preview">
								<label for="prod_pic" id="label-photo">Prod. Picture</label>
								<div class="row">
									<div class="col-md-6 pr-2">
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="prod_pic" name="prod_pic">
											<div class="invalid-feedback"></div>
											<label class="custom-file-label" for="prod_pic">Choose file</label>
										</div>
									</div>
									<div class="col-md-6">
										<img src="<?php echo base_url('assets/pics/50x50_placeholder.png'); ?>" alt="Image Preview" id="prod-photo-preview-img" width="50px" height="50px">
										<div class="invalid-feedback"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnSave" onclick="saveProduct()" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->