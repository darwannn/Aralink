<?php 
require 'php/php-controller.php';
unset($_SESSION['femail']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Login</title>
    <link rel="icon" href="img/logo.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Loading -->
    <link rel="stylesheet" href="css/pace-theme-minimal.css">

    <style>
        html,
        body {
            background-color: rgb(31, 155, 95);
            color: rgb(46, 50, 51);
        }
    </style>
</head>

<body>
    <div class="account">
        <div class="container">
            <div class="row p-4 justify-content-center">
                <div class="form ">
                    <form action="login" method="POST" onsubmit="hidebutton()">
                        <div class="text-center"><a href="http://aralink.xyz/"><img src="img/src-logo.png" width="190px"
                                    height="50px"></a></div>
                        <p class="text-center">Login with your email and password.</p>
                        <?php 
                    if(isset($_SESSION['info-success'])){
                        ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info-success']; ?>
                        </div>
                        <?php
                    } unset($_SESSION["info-success"]);
                    ?>
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
                        <div class="form-group ">
                            <input class="form-control " type="email" name="email" id="email"
                                onchange="this.setAttribute('value', this.value);" value="<?php echo $email ?>"
                                required>
                            <label>Email Address</label>
                        </div>
                        <div class="form-group ">
                            <input class="form-control" type="password" name="password" id="password"
                                onchange="this.setAttribute('value', this.value);" value="" required>
                            <label>Password</label>
                            <div class="input-group-append">
                                <span class="far fa-eye-slash input-group-text " id="togglePassword"></span>
                            </div>
                        </div>
                        <div class="link forget-pass text-left"><a href="forgot-password">Forgot password?</a></div>
                        <div class="form-group">
                            <button id="button-show" class="form-control button" type="submit" style="display:none;"
                                disabled><i class="fas fa-spinner fa-spin"></i> </button>
                            <input id="button-hide" class="form-control button" type="submit" name="login"
                                value="Login">
                        </div>
                        <div class="link login-link text-center ">Dont have an account? <a href="register">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Loading -->
    <script src="js/pace.js"></script>

    <script>
        function hidebutton() {
            document.getElementById("button-hide").style.display = "none";
            document.getElementById("button-show").style.display = "block";
        }
        
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        /* Remove Confirm Form Resubmission  */
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>