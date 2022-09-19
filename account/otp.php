<?php 
require dirname(__FILE__, 2).'/php/controller.php';
$email = $_SESSION['email'];

if($email == false){
  header('Location: login');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  
    <title>Register</title>
    <?php include $root_directory."/php/import.php" ?>
</head>

<body>
<div class="account d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="form">
                    <form id="resend" action="otp" method="post"> </form>
                    <form action="otp" method="POST" onsubmit="hidebutton()">
                    <div class="text-center"><a href="<?php echo $directory ?>"><img src="<?php echo $logo ?>" width="190px"
                                    height="50px"></a></div>
                        <?php 
                    if(isset($_SESSION['info-otp'])){
                        ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info-otp']; ?>
                        </div>
                        <?php
                    }
                    ?>
                        <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <style type="text/css">
                                .alert-success {
                                    display: none;
                                }
                            </style>
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
                            <input class="form-control" type="text" name="otp" id="otp-pass" maxlength="6"
                                onchange="this.setAttribute('value', this.value);" value="" required>
                            <label>Verification Code</label>
                        </div>
                        <input class="form-control" type="hidden" name="email" value="<?php echo $email ?>"
                            form="resend">
                        <input type="submit" class="btn reset-code text-center py-1 text-left link forget-pass "
                            name="resend" value="Resend Code" form="resend">
                        <div class="form-group mb-3">
                            <button id="button-show" class="form-control button" type="submit" style="display:none;"
                                disabled><i class="fas fa-spinner fa-spin"></i> </button>
                            <input id="button-hide" class="form-control button" type="submit" name="check"
                                value="Continue">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>