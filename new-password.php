<?php 
require 'php/php-controller.php';
$femail = $_SESSION['femail'];

if($femail == false){
  header('Location: login');
}

if($femail != false){
    $query = $conn->prepare("SELECT * FROM classadmin WHERE email = :email");
    $result=$query->execute([':email' => $femail]);
    if($result){
       $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $fetch_status = $fetch['code'];
        if($fetch_status != "0"){ 
            header('Location: reset-otp');
        } 
    }
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Reset Password</title>
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
            background-color: rgb(15, 165, 100);
        }
    </style>
</head>

<body>
    <div class="account">
        <div class="container">
            <div class="row p-4 justify-content-center">
                <div class="form">
                    <form action="new-password" method="POST" autocomplete="off" onsubmit="hidebutton()">
                        <div class="text-center mb-3"><a href="http://aralink.xyz/"><img src="img/src-logo.png" width="190px"
                                    height="50px"></a></div>
                        <p class="text-center">Enter your new password</p>
                        <?php 
                    if(isset($_SESSION['info-np'])){
                        ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info-np']; ?>
                        </div>
                        <?php
                    }
                    ?>
                        <?php
                    if(count($errors) > 0){
                        ?>
                        <style type="text/css">
                            .alert-success {
                                display: none;
                            }
                        </style>
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
                            <input class="form-control" type="password" name="password" id="password"
                                onchange="this.setAttribute('value', this.value);" value="" data-toggle="popover"
                                data-trigger="hover" data-placement="top"
                                data-content="Password must contain 8 to 20 alphanumeric character" required>
                            <label>Password</label>
                            <div class="input-group-append">
                                <span class="far fa-eye-slash input-group-text" id="togglePassword"></span>
                            </div>
                        </div>
                        <div class="form-group ">
                            <input class="form-control" type="password" name="cpassword" id="cpassword"
                                onchange="this.setAttribute('value', this.value);" value="" required>
                            <label>Retype Password</label>
                            <div class="input-group-append">
                                <span class="far fa-eye-slash input-group-text" id="togglecPassword"></span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <button id="button-show" class="form-control button" type="submit" style="display:none;"
                                disabled><i class="fas fa-spinner fa-spin"></i> </button>
                            <input id="button-hide" class="form-control button" type="submit" name="change-password"
                                value="Change">
                        </div>
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