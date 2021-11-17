	<div class="container">
		<!-- <img src="<?php //echo base_url(); ?>images/dodrio.png" alt=""> -->
		<div class="container h-100">
			<div class="row h-100 justify-content-center align-items-center">
				<div class="card login-form">
					<div class="card-body">
						<h3 class="card-title text-center">Log in to Your Account</h3>
						<div class="card-text">
							<div class="alert alert-info" id="errorAlert" role="alert" hidden>
							</div>
							<!-- <div class="alert alert-danger fade show" role="alert">Incorrect username or password.</div> -->
							<form class="form-signin form" action="<?php echo site_url('login/auth');?>" method="post">
								<!-- to error: add class "has-danger" -->
								<div class="form-group">
									<label for="email">Email address</label>
									<input type="email" name="email" id="email" class="form-control form-control-sm">
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<!-- <a href="#" style="float:right;font-size:12px;">Forgot password?</a> -->
									<input type="password" name="password" id="password" class="form-control form-control-sm">
								</div>
								<button type="submit" id="loginBtn" class="btn btn-primary btn-block">Sign in</button>

								<div class="sign-up">
									Don't have an account? <a href="<?php echo site_url('register/');?>">Create One</a>
								</div>
							</form>
							<div>Login as:</div>
							<div>
								<div>
									<button type="button" class="btn btn-sm btn-primary" onclick="login(1)">Admin</button>
								</div>
								<div>
									<button type="button" class="btn btn-sm btn-secondary" onclick="login(2)">SP-Food</button>
									<button type="button" class="btn btn-sm btn-secondary" onclick="login(3)">SP-Good</button>
									<button type="button" class="btn btn-sm btn-secondary" onclick="login(4)">SP-Med</button>
									<button type="button" class="btn btn-sm btn-secondary" onclick="login(5)">SP-Pet</button>
								</div>
								<div>
									<button type="button" class="btn btn-sm btn-success" onclick="login(6)">Cust1</button>
								</div>
								<div>
									<button type="button" class="btn btn-sm btn-danger" onclick="login(7)">Runner1</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<!-- 		<img src="<?php //echo base_url(); ?>images/dodrio.png" alt="">

		<div class="alert-danger sticky-bottom">
			<i class="fas fa-user-circle mr-1"></i>
			<?php //foreach($this->session->userdata() as $key => $value): ?>
				<?php //echo $key . '=>' . $value . ', '; ?>
			<?php //endforeach;?>
		</div> -->
	</div>

	<script>
		$(document).ready(function() {
			//TODO Remove flashdata for user id. This is for testing a part of query in login_model where 1 query is performed right after the first one. Do query 1, take user_id from query 1 to be inserted into query 2.
			var userId = "<?php echo $this->session->flashdata('user-id');?>";
			var loginError = "<?php echo $this->session->flashdata('login-error');?>";

			console.log("Last inserted user_id: " + userId);

			if(loginError){
				$('#errorAlert').attr("hidden",false);
				$('#errorAlert').html(loginError);
			}

		});

		function login(level){
			if(level == 1){
				$("#email").val("1@gmail.com");
				$("#password").val("123456");
				$("#loginBtn").click();
			}else if(level == 2){
				$("#email").val("food@gmail.com");
				$("#password").val("123456");
				$("#loginBtn").click();
			}else if(level == 3){
				$("#email").val("good@gmail.com");
				$("#password").val("123456");
				$("#loginBtn").click();
			}else if(level == 4){
				$("#email").val("med@gmail.com");
				$("#password").val("123456");
				$("#loginBtn").click();
			}else if(level == 5){
				$("#email").val("pet@gmail.com");
				$("#password").val("123456");
				$("#loginBtn").click();
			}else if(level == 6){
				$("#email").val("cust1@gmail.com");
				$("#password").val("123456");
				$("#loginBtn").click();
			}else if(level == 7){
				$("#email").val("runner1@gmail.com");
				$("#password").val("123456");
				$("#loginBtn").click();
			}
		}
	</script>
