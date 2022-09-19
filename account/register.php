<?php 
require dirname(__FILE__, 2).'/php/controller.php';
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
                    <form action="register" method="POST" onsubmit="hidebutton()">
                        <div class="text-center"><a href="<?php echo $directory ?>"><img src="<?php echo $logo ?>" width="190px"
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
                                onchange="this.setAttribute('value', this.value);" value="<?php echo $class_name?>"
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
                                data-content="Password must contain 8 to 20 alphanumeric character" required>
                            <label>Password</label>
                            <div class="input-group-append">
                                <span class="fas fa-eye-slash input-group-text" id="togglePassword"  onclick="togglePass(this.id, 'password')"></span>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <input class="form-control" type="password" name="cpassword" id="cpassword"
                                onchange="this.setAttribute('value', this.value);" value="" required>
                            <label>Retype Password</label>
                            <div class="input-group-append">
                                <span class="fas fa-eye-slash input-group-text" id="togglecPassword"  onclick="togglePass(this.id, 'cpassword')"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button id="button-show" class="form-control button" type="submit" style="display:none;"
                                disabled><i class="fas fa-spinner fa-spin"></i> </button>
                            <input id="button-hide" class="form-control button" type="submit" name="signup"
                                value="Register">
                        </div>
                        <div class="link login-link text-center">Have an Account? <a href="login">Login</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#email').popover();
        $('#password').popover();
    </script>

</body>

</html>