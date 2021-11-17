<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4"><?php echo $content_heading ?></h1>
				<h3 class="display-5"><?php echo $content_subheading ?></h3>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="store-info-tab" data-toggle="tab" href="#store-info" role="tab" aria-controls="store-info" aria-selected="true">Store Info</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="products-tab" href="<?php echo site_url('profile/manage-products/'.$store_id)?>">Products</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="store-info" role="tabpanel" aria-labelledby="store-info-tab">
						<form action="#" id="storeInfoForm" novalidate>
							<div class="form-row">
								<div class="col-sm-6">
									<input type="hidden" value="" name="store_id"/>
									<input type="hidden" value="" name="sp_id"/>
									<div class="form-group">
										<label for="store_name">Store Name</label>
										<input name="store_name" placeholder="Store Name" class="form-control" type="text">
										<div class="invalid-feedback"></div>
									</div>
									<div class="form-group">
										<label for="store_descr">Store Description</label>
										<textarea name="store_descr" id="store_descr" class="form-control" placeholder="Store Description" rows="5" ></textarea>
										<div class="invalid-feedback"></div>
									</div>
									<div class="form-group">
										<label for="store_type">Store Type</label>
										<input name="store_type" placeholder="Store Type" class="form-control" type="text" readonly>
										<div class="invalid-feedback"></div>
										<small class="form-text text-muted">Can be changed in <a href="<?php echo site_url('profile'); ?>"><span>Profile</span></a></small>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group" id="photo-preview">
										<label for="store_pic">Store Picture</label>
										<div class="col-sm-5">
											<img src="<?php echo base_url('assets/pics/512x512_placeholder.png'); ?>" alt="Image Preview" id="photo-preview-img" width="200px" height="200px">
											<div class="invalid-feedback"></div>
										</div>
										<div class="col-sm-6 pr-0">
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="store_pic" name="store_pic">
												<div class="invalid-feedback"></div>
												<label class="custom-file-label" for="store_pic">Choose file</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row justify-content-center">
								<button type="button" id="btnSaveStoreInfo" class="btn btn-primary btn-wide" onclick="saveStoreInfo()">Save Changes</button>
							</div>
						</form>
					</div>
					<div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
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

		$("#store_pic").change(function() {
			photoPreview(this,"store");
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

//Store info
function saveStoreInfo()
{
	var url = "<?php echo site_url('profile/editStoreProfile')?>";

	$('#btnSaveStoreInfo').html('Updating...'); //change button text
	$('#btnSaveStoreInfo').attr('disabled',true); //set button disable

	// ajax adding data to database
	var formData = new FormData($('#storeInfoForm')[0]);
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
				alert("Updated successfully!");
				window.location.href = "<?php echo site_url('profile/manage-store')?>";
			}
			else
			{
				for (var i = 0; i < data.inputerror.length; i++)
				{
					$('[name="'+data.inputerror[i]+'"]').addClass("is-invalid"); //select input and add is-invalid class
					$('[name="'+data.inputerror[i]+'"]').next().html(data.error_string[i]); //select error div and set text error string
				}
			}
			$('#btnSaveStoreInfo').html('Update Changes'); //change button text
			$('#btnSaveStoreInfo').attr('disabled',false); //set button disable
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Register failed');
			$('#btnSaveStoreInfo').html('Update Changes'); //change button text
			$('#btnSaveStoreInfo').attr('disabled',false); //set button disable
		}
	});
}

</script>
