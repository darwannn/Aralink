<?php 
$errors = array();
require 'php/php-controller.php';
unset($_SESSION['selected']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="AraLink is a website where you can compile the video recordings of your classes through embed links.">

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
            background-image: url(img/bg1.jpg);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: center center;
            box-shadow: inset 0 0 0 9999px rgba(15, 144, 105, .6);
        }

        /* Particles in Jumbotron */
        .jumbotron .container {
            position: relative;
            z-index: 999;
        }

        .description {
            font-size: 18px;
            width: 450px;
            margin: auto;
        }

        @media (max-width:530px) {
            .description {
                font-size: 18px;
                width: 100%;
                margin: auto;
            }
        }

        .jumbotron-heading {
            padding: 0;
            margin: 0;
        }

        #particles-js {
            position: relative;
            z-index: 2;
            background-color: #4398FF;
        }

        canvas.particles-js-canvas-el {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            width: 100%;
            height: 100%;
        }

        /* Jumbotron Button */
        .jumbotron .container .btn {
            width: 200px;
            background: none;
            transition: 0.2s;
            border: 2px solid white !important;
            color: white;
            margin-top: 13px;
            font-weight: 500;
        }

        .jumbotron .container .btn:hover {
            background-color: white;
            color: rgb(31, 155, 95);
            border: 2px solid white;
            font-weight: 500;


        }

        ::-webkit-input-placeholder {
            text-align: center;

        }

        input {
            text-align: center;

        }

        form {
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light sticky-top nav-index">
        <a href="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1" target="_blank" class="navbar-brand pl-3"><img
                src="img/nav-logo.png" width="190px" height="50px"></a>
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

    <div class="jumbotron d-flex align-items-center particles" id="particles-js">
        <div class="container text-center">
            <h1 class="jumbotron-heading ">AraLink</h1>
            <div class="description">is a website where you can compile the video recordings of your classes through embed links.
            </div>
            <input id="remove-ani" type="submit" class="btn btn-primaryy enter-animation" data-toggle="modal"
                data-backdrop="static" data-keyboard="false" data-target="#code_modal" value="Enter Code">
            </input>
        </div>
    </div>

    <!-- Code Modal -->
    <div class="modal fade " id="code_modal" tabindex="-1" role="dialog" aria-labelledby="code_modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-min modal-dialog-centered px-3" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mx-auto">Enter Code</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action=""> <!-- http://aralink.xyz/ -->
                        <?php
                            if(count($errors) > 0){
                            ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                            }
                            ?>
                        <div class="form-group">
                            <input class="form-control" type="text" name="c" id="c" placeholder="••••••••"
                                onkeypress="return event.charCode != 32" maxlength="8" required>
                        </div>
                        <div class="modal-footerr text-right">
                            <input type="submit" class="btn btn-primaryy" name="submit" value="Continue">
                            <input type="button" class="btn btn-dangerr" data-dismiss="modal" id="close" value="Close">
                        </div>
                    </form>
                </div>
            </div>
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

    <script>
        var error;
        if (error == "error") {
            $('#remove-ani').click();
        }

        document.getElementById("remove-ani").addEventListener("click", function () {
            document.getElementById("remove-ani").classList.remove("enter-animation");
        });
        document.getElementById("close").addEventListener("click", function () {
            document.getElementById("remove-ani").classList.add("enter-animation");
        });

        /* Remove Confirm Form Resubmission  */
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>