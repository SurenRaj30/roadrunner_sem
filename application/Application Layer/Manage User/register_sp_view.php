	<div class="container">
		<div class="container h-100">
			<div class="row h-100 justify-content-center align-items-center">
				<div class="card wide-form">
					<div class="card-body">
						<h3 class="card-title text-center">Register as <?php echo $heading;?></h3>
						<form action="#" id="form" novalidate>
							<div class="form-row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="name">Name</label>
										<input name="name" placeholder="Name" class="form-control" type="text">
										<div class="invalid-feedback"></div>
									</div>
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
									<input type="hidden" value="<?php echo $user_level;?>" name="level"/>
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
							<!-- <div class="form-group">
								<label for="user_level">User Level</label>
								<select name="level" class="form-control">
									<option value="">--Select Role Level--</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
								<div class="invalid-feedback"></div>
							</div> -->
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
						<button type="button" id="btnSave" class="btn btn-primary btn-wide" onclick="save()">Register</button>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>
</div>

<?php echo $this->session->flashdata('msg');?>

<script>


	$(document).ready(function() {
	    //set input/textarea/select event when change value, remove class error and remove text help block
	    // $("input").change(function(){
	    // 	$(this).parent().parent().removeClass('has-error');
	    // 	$(this).next().empty();
	    // });
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

	function save()
	{
		var url = "<?php echo site_url('register/registerSP')?>";

	$('#btnSave').html('Registering...'); //change button text
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
				alert("Added successfully!");
				window.location.href = "<?php echo site_url('login')?>";
			}
			else
			{
				for (var i = 0; i < data.inputerror.length; i++)
				{
					$('[name="'+data.inputerror[i]+'"]').addClass("is-invalid"); //select input and add is-invalid class
					$('[name="'+data.inputerror[i]+'"]').next().html(data.error_string[i]); //select error div and set text error string
				}
			}
			$('#btnSave').html('Register'); //change button text
			$('#btnSave').attr('disabled',false); //set button disable
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Register failed');
			$('#btnSave').html('Register'); //change button text
			$('#btnSave').attr('disabled',false); //set button disable
		}
	});
}
</script>
