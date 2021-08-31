<?php 
require 'php/php-controller.php';
unset($_SESSION['selected']);
$errors = array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>AraLink</title>
    <link rel="icon" href="img/logo.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Loading -->
    <link rel="stylesheet" href="css/pace-theme-minimal.css">

    <style>
        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0px;
            padding: 0px;
            overflow: hidden;
        }

        .jumbotron {

            color: white;
            height: 102%;
            padding-top: 10px;
            position: relative;
            align-items: center;
            justify-content: center;
            background-image: url(img/error.gif);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: center center;
            box-shadow: inset 0 0 0 9999px rgba(15, 144, 105, .5);
        }

        .jumbotron .container {
            position: relative;
            z-index: 999;
            margin-top: -60px;

        }
        .description {
            font-size: 18px;
            width: 550px;
            margin: 30px auto auto auto;
        }

        @media (max-width:770px) {
            .jumbotron .container {
         
            margin-top: -80px;

        }
            .description {
                font-size: 18px;
                width: 100%;
                margin: 30px auto auto auto;
            }
        }

        .jumbotron-heading {
            margin-top: 60px;
            font-size: 150px;
            font-weight: 700;
            margin-bottom: -35px !important;

        }

        .jumbotron-subheading {

            font-size: 37px;
            font-weight: 600;
        }

        .jumbotron .container .btn {
            width: 200px;
            background: none;
            transition: 0.2s;
            border: 2px solid white !important;
            color: white;
            margin-top: 15px !important;
            font-weight: 500;
        }

        .jumbotron .container .btn:hover {
            background-color: white;
            color: rgb(31, 155, 95);
            border: 2px solid white;
            font-weight: 500;
        }
      
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light sticky-top nav-index">
        <a href="http://aralink.xyz/" class="navbar-brand pl-3"><img src="img/nav-logo.png" width="190px" height="50px"></a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navigation_bar"
            aria-controls="navigation_bar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse " id="navigation_bar">
            <ul class="navbar-nav ml-auto flex-sm-row pr-2">
                <div class="nav-item left  "> <a href="login" class="btn btn-light"> <i
                            class="fas fa-sign-in-alt"></i>Login</a></div>
                <div class="nav-item right "> <a href="register" class="btn btn-light"> <i
                            class="fas fa-user-plus"></i>Register</a></div>
            </ul>
        </div>
    </nav>

    <div class="jumbotron d-flex align-items-center particles">
        <div class="container text-center">
            <h1 class="jumbotron-heading ">404</h1>
            <h1 class="jumbotron-subheading ">Page Not Found</h1>
            <div class="description">The page you were looking for could not be found.</div>
            <a class="btn btn-primaryy" href="http://aralink.xyz/">Go Back</a>
        </div>
    </div>

    <!-- Loading -->
    <script src="js/pace.js"></script>

    <!-- Particle -->
    <script src="js/particles.js"></script>
    <script src="js/app.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>