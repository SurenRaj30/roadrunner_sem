<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center">Add product promotion</h3>
                    <form class="form-signin form" action="<?php echo site_url('login/auth');?>" method="post">
								<!-- to error: add class "has-danger" -->
								<div class="form-group">
									<label for="email">Enter the product</label>
									<input type="email" name="email" id="email" class="form-control form-control-sm">
								</div>
								<div class="form-group">
									<label for="password">Product price</label>
									<!-- <a href="#" style="float:right;font-size:12px;">Forgot password?</a> -->
									<input type="password" name="password" id="password" class="form-control form-control-sm">
								</div>
                                <div class="form-group">
									<label for="email">Enter the product</label>
									<input type="email" name="email" id="email" class="form-control form-control-sm">
								</div>
                                <div class="form-group">
									<label for="email">Quantity</label>
									<input type="number" name="email" id="email" class="form-control form-control-sm">
								</div>
                                <div class="form-group">
									<label for="email">Variation</label>
									<input type="text" name="email" id="email" class="form-control form-control-sm">
								</div>
                                <div class="form-group">
									<label for="email">Product details</label>
									<input type="text" name="email" id="email" class="form-control form-control-sm">
								</div>
                                <div class="form-group">
									<label for="email">Promotion valid until:</label>
									<input type="date" name="email" id="email" class="form-control form-control-sm">
								</div>
								<button type="submit" id="loginBtn" class="btn btn-primary btn-block mt-3">Add Product</button>
						</form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
