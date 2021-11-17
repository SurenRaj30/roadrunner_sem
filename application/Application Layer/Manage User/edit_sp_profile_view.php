<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4"><?php echo $content_heading ?></h1>
				<h3 class="display-5">Service Provider Information</h3>
				<form action="#" id="form" novalidate>
					<div class="form-row">
						<div class="col-sm-6">
							<input type="hidden" value="" name="user_id"/>
							<div class="form-group">
								<label for="name">Name</label>
								<input name="name" placeholder="Name" class="form-control" type="text">
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label for="address">Address</label>
								<textarea name="address" id="address" class="form-control" placeholder="Address" rows="5" ></textarea>
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group margin-top-40px">
								<label for="contact_no">Contact No.</label>
								<input name="contact_no" placeholder="Contact No." class="form-control" type="text">
								<div class="invalid-feedback"></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="ssm_no">Business Registration No. (BRN / SSM)</label>
								<input name="ssm_no" placeholder="eg: 201901000005" class="form-control" type="text">
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label for="business_name">Business Name</label>
								<input name="business_name" placeholder="Business name" class="form-control" type="text">
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label for="business_contact_no">Business Contact No. </label>
								<input name="business_contact_no" placeholder="Contact No." class="form-control" type="text">
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label for="business_address">Business Address</label>
								<textarea name="business_address" id="business_address" class="form-control" placeholder="Business Address" rows="5" ></textarea>
								<div class="invalid-feedback"></div>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="same_address">
									<label class="form-check-label" for="same_address">
										Same as home address
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="business_type">Business Type</label>
								<select name="business_type" class="form-control">
									<option value="">--Select Business Type--</option>
									<option value="food">Food</option>
									<option value="good">Good</option>
									<option value="med">Med</option>
									<option value="pet">Pet</option>
								</select>
								<div class="invalid-feedback"></div>
							</div>
						</div>
					</div>
					<div class="row justify-content-center">
						<button type="button" id="btnSave" class="btn btn-primary btn-wide" onclick="save()">Save Changes</button>
					</div>
				</form>
				<h3 class="display-5 margin-top-40px">Login Details</h3>
				<form action="#" id="form2" novalidate>
					<input type="hidden" value="" name="user_id"/>
					<div class="form-group">
						<label for="email">Email</label>
						<input name="email" placeholder="Email" class="form-control" type="email">
						<div class="invalid-feedback"></div>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input name="password" placeholder="Password" class="form-control" type="password">
						<div class="invalid-feedback"></div>
					</div>
					<div class="row justify-content-center">
						<button type="button" id="btnSave2" class="btn btn-primary btn-wide" onclick="saveEmailPass()">Update Login Details</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	var user_id = '<?php echo $user_id ?>'; //Get user_id via session from profile controller

	$(document).ready(function() {
		viewProfile(user_id); //Load user profile info

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

		$('#same_address[type="checkbox"]').click(function(){
			var address = $.trim($("#address").val());
			if($(this).is(":checked")){
				if(address != ""){
					$("#business_address").val(address);
					$("#business_address").prop('readonly', true);
					$("#business_address").removeClass('is-invalid');
					$("#business_address").next().empty();
				}
			}
			else if($(this).is(":not(:checked)")){
				$("#business_address").val("");
				$("#business_address").prop('disabled', false);
			}
		});
	});

	function viewProfile(user_id)
	{
    //Ajax Load data from ajax
    $.ajax({
    	url : "<?php echo site_url('profile/loadProfile')?>/" + user_id,
    	type: "GET",
    	dataType: "JSON",
    	success: function(data)
    	{
    		$('[name="user_id"]').val(data.user_id);
    		$('[name="name"]').val(data.user_name);
    		$('[name="email"]').val(data.user_email);
    		$('[name="address"]').val(data.user_address);
    		$('[name="contact_no"]').val(data.user_contact_no);
    		$('[name="ssm_no"]').val(data.sp_ssm_no);
    		$('[name="business_name"]').val(data.sp_business_name);
    		$('[name="business_contact_no"]').val(data.sp_business_contact_no);
    		$('[name="business_address"]').val(data.sp_business_address);
    		$('[name="business_address"]').val(data.sp_business_address);
    		$('[name="business_type"]').val(data.sp_business_type);

    		if(data.photo)
    		{
                $('#photo-preview-img').attr('src', base_url+'upload/'+data.photo);// show photo
                $('#photo-preview div:last').append('<input type="checkbox" name="remove_photo" value="'+data.photo+'"/> Remove photo when saving'); // remove photo
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        	alert('Error get data from ajax');
        }
    });
}

function save()
{
	var url = "<?php echo site_url('profile/editSPProfile')?>";

	$('#btnSave').html('Updating...'); //change button text
	$('#btnSave').attr('disabled',true); //set button disable

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
				alert("Updated successfully!");
				window.location.href = "<?php echo site_url('profile')?>";
			}
			else
			{
				for (var i = 0; i < data.inputerror.length; i++)
				{
					$('[name="'+data.inputerror[i]+'"]').addClass("is-invalid"); //select input and add is-invalid class
					$('[name="'+data.inputerror[i]+'"]').next().html(data.error_string[i]); //select error div and set text error string
				}
			}
			$('#btnSave').html('Update Changes'); //change button text
			$('#btnSave').attr('disabled',false); //set button disable
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Register failed');
			$('#btnSave').html('Update Changes'); //change button text
			$('#btnSave').attr('disabled',false); //set button disable
		}
	});
}

function saveEmailPass()
{
	var url = "<?php echo site_url('profile/editSPProfileEmailPass')?>";

	$('#btnSave2').html('Updating...'); //change button text
	$('#btnSave2').attr('disabled',true); //set button disable

	// ajax adding data to database
	var formData = new FormData($('#form2')[0]);
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
				//window.location.href = "<?php //echo site_url('profile')?>";
			}
			else
			{
				for (var i = 0; i < data.inputerror.length; i++)
				{
					$('[name="'+data.inputerror[i]+'"]').addClass("is-invalid"); //select input and add is-invalid class
					$('[name="'+data.inputerror[i]+'"]').next().html(data.error_string[i]); //select error div and set text error string
				}
			}
			$('#btnSave2').html('Update Changes'); //change button text
			$('#btnSave2').attr('disabled',false); //set button disable
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Register failed');
			$('#btnSave2').html('Update Changes'); //change button text
			$('#btnSave2').attr('disabled',false); //set button disable
		}
	});
}
</script>