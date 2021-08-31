<?php 
require 'php/php-controller.php'; 
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
                    <form action="forgot-password" method="POST" autocomplete="" onsubmit="hidebutton()">
                        <div class="text-center"><a href="http://aralink.xyz/"><img src="img/src-logo.png" width="190px"
                                    height="50px"></a></div>
                        <!-- <h2 class="text-center">Forgot Password</h2> -->
                        <p class="text-center">Enter your email address to reset your passwork</p>
                        <?php
                        if(count($errors) > 0){
                            ?>
                        <div class="alert alert-danger text-center">
                            <?php 
                                    foreach($errors as $error){
                                        echo $error;
                                    }
                                ?>
                        </div>
                        <?php
                        }
                    ?>
                        <div class="form-group">
                            <input class="form-control" type="email" name="email"
                                onchange="this.setAttribute('value', this.value);" value="<?php echo $email ?>"
                                required>
                            <label>Email Address</label>
                        </div>
                        <div class="form-group mb-3">
                            <button id="button-show" class="form-control button" type="submit" style="display:none;"
                                disabled><i class="fas fa-spinner fa-spin"></i> </button>
                            <input id="button-hide" class="form-control button" type="submit" name="check-email"
                                value="Continue">
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

        /* Remove Confirm Form Resubmission  */
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>