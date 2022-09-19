<?php 
require dirname(__FILE__, 2).'/php/controller.php';
unset($_SESSION['forgot-email']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <?php include $root_directory."/php/import.php" ?>
</head>

<body>
    <div class="account d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="form ">
                    <form action="login" method="POST" onsubmit="hidebutton()">
                        <div class="text-center"><a href="<?php echo $directory ?>"><img src="<?php echo $logo ?>" width="190px"
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
                                <span class="fas fa-eye-slash input-group-text " id="togglePassword" onclick="togglePass(this.id, 'password')"></span>
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

</body>

</html>