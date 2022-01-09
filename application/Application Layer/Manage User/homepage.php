<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<style>
    #card-info1{
        background-color: #D05663;
        color:white;
    }
    #card-info2{
        background-color: #2A4032;
        color:white;
    }#card-info3{
        background-color: #748B6F;
        color:white;
    }#card-info4{
        background-color: #888870;
        color:white;
    }
   
</style>
<body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="#!">RoadRunner</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link text-light" href="<?php echo site_url('register/runner/');?>">Be Our Runner</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center my-5">
                            <h1 class="display fw-bolder text-white mb-2">From essential services to earning opportunities. We're an all-in-one platform.</h1>
                            <p class="lead text-white-50 mb-4"></p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                                <a class="btn btn-primary btn-lg px-4 me-sm-3" href="<?php echo site_url('login/');?>">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Features section-->
        <section id="features">
            <div class="container px-5 my-5">
                <div class="row gx-5">
                <div id="card-info1" class="card shadow" style="width:15rem; height:200px; margin-left:100px;">
                        <div class="card-body">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                        <h2 class="h4 fw-bolder">Foods</h2>
                        <p>Have your cravings delivered to your doorstep</p>
                        <a class="text-decoration-none" href="#!">
                            <!-- Call to action manage food -->
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        </div>
                    </div>
                    
                    <div id="card-info2" class="card shadow" style="width:15rem; height:200px; margin-left:40px">
                        <div  class="card-body">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                        <h2 class="h4 fw-bolder">Goods</h2>
                        <p>Send packages, documents, and beyond</p>
                        <a class="text-decoration-none" href="#!">
                            <!-- Call to action manage food -->
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        </div>
                    </div>
                    <div id="card-info3" class="card shadow" style="width:15rem; height:200px; margin-left:50px">
                        <div class="card-body">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                        <h2 class="h4 fw-bolder">Pets</h2>
                        <p>All your pet needs and services</p>
                        <a class="text-decoration-none" href="#!">
                            <!-- Call to action manage food -->
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        </div>
                    </div>
                    <div id="card-info4" class="card shadow" style="width:15rem; height:200px; margin-left:50px">
                        <div class="card-body">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                        <h2 class="h4 fw-bolder">Pharmacy</h2>
                        <p>Healthcare at your fingertips</p>
                        <a class="text-decoration-none" href="#!">
                            <!-- Call to action manage food -->
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
