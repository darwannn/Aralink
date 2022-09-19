<?php 
require dirname(__FILE__, 2).'/php/controller.php';
$forgot_email = $_SESSION['forgot-email'];

if($forgot_email == false){
  header('Location: login.php');
}
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
                    <form id="resend" action="reset-otp" method="post"> </form>
                    <form action="reset-otp" method="POST" onsubmit="hidebutton()">
                        <!-- <h2 class="text-center">Code Verification</h2> -->
                        <div class="text-center mb-2"><a href="<?php echo $directory ?>"><img src="<?php echo $logo ?>" width="190px"
                                    height="50px"></a></div>
                        <?php 
                    if(isset($_SESSION['info-rotp'])){
                        ?>
                        <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
                            <?php echo $_SESSION['info-rotp']; ?>
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
                            <input class="form-control" type="text" name="otp" maxlength="6"
                                onchange="this.setAttribute('value', this.value);" value="" required>
                            <label>Verification Code</label>
                        </div>
                        <input class="form-control" type="hidden" name="email" value="<?php echo $forgot_email ?>"
                            form="resend">
                        <input type="submit" class="btn reset-code text-center py-1 text-left link forget-pass"
                            name="forgot-resend" value="Resend Code" form="resend">
                        <div class="form-group mb-3">
                            <button id="button-show" class="form-control button" type="submit" style="display:none;"
                                disabled><i class="fas fa-spinner fa-spin"></i> </button>
                            <input id="button-hide" class="form-control button" type="submit" name="check-reset-otp"
                                value="Continue">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>