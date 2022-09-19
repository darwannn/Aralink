<?php 
require dirname(__FILE__, 2).'/php/controller.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password</title>
    <?php include $root_directory."/php/import.php" ?>
</head>

<body>
    <div class="account d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="form">
                    <form action="forgot-password" method="POST" autocomplete="" onsubmit="hidebutton()">
                        <div class="text-center"><a href="<?php echo $directory ?>"><img src="<?php echo $logo ?>" width="190px"
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

</body>

</html>