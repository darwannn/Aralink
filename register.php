<?php 
require 'php/php-controller.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Register</title>
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
                <div class="form">
                    <form action="register" method="POST" onsubmit="hidebutton()">
                        <div class="text-center mb-3"><a href="http://aralink.xyz/"><img src="img/src-logo.png" width="190px"
                                    height="50px"></a></div>
                        <p class="text-center">Fill out the form to register.</p>
                        <?php
                    if(count($errors) == 1){
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
                            <input class="form-control" type="classname" name="classname"
                                onchange="this.setAttribute('value', this.value);" value="<?php echo $classname?>"
                                autocomplete="new-password" required>
                            <label>Class Name</label>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" name="name"
                                onchange="this.setAttribute('value', this.value);" value="<?php echo $name ?>"
                                autocomplete="new-password" required>
                            <label>Username</label>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="email" name="email" id="email"
                                onchange="this.setAttribute('value', this.value);" value="<?php echo $email ?>"
                                data-toggle="popover" data-trigger="hover" data-placement="top"
                                data-content="Use a gmail account" required>
                            <label>Email Address</label>
                        </div>
                        <div class="form-group ">
                            <input class="form-control" type="password" name="password" id="password"
                                onchange="this.setAttribute('value', this.value);" value="" data-toggle="popover"
                                data-trigger="hover" data-placement="top"
                                data-content="Password must contain 8 to 20 characters consisting a letter and a number" required>
                            <label>Password</label>
                            <div class="input-group-append">
                                <span class="far fa-eye-slash input-group-text" id="togglePassword"></span>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <input class="form-control" type="password" name="cpassword" id="cpassword"
                                onchange="this.setAttribute('value', this.value);" value="" required>
                            <label>Retype Password</label>
                            <div class="input-group-append">
                                <span class="far fa-eye-slash input-group-text" id="togglecPassword"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button id="button-show" class="form-control button" type="submit" style="display:none;"
                                disabled><i class="fas fa-spinner fa-spin"></i> </button>
                            <input id="button-hide" class="form-control button" type="submit" name="signup"
                                value="Signup">
                        </div>
                        <div class="link login-link text-center">Have an Account? <a href="login">Login</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading -->
    <script src="js/pace.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $('#email').popover();
        $('#password').popover();

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
        const togglecPassword = document.querySelector('#togglecPassword');
        const cpassword = document.querySelector('#cpassword');
        togglecPassword.addEventListener('click', function (e) {
            const type = cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
            cpassword.setAttribute('type', type);
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