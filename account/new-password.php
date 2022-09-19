<?php 
require dirname(__FILE__, 2).'/php/controller.php';
$forgot_email = $_SESSION['forgot-email'];

if($forgot_email == false){
  header('Location: login');
}

if($forgot_email != false){
    $query = $conn->prepare("SELECT * FROM classadmin WHERE email = :email");
    $result=$query->execute([':email' => $forgot_email]);
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
    <title>Reset Password</title>
    <?php include $root_directory."/php/import.php" ?>
</head>

<body>
<div class="account d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="form">
                    <form action="new-password" method="POST" autocomplete="off" onsubmit="hidebutton()">
                        <div class="text-center"><a href="<?php echo $directory ?>"><img src="<?php echo $logo ?>" width="190px"
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
                                <span class="fas fa-eye-slash input-group-text" id="togglePassword" onclick="togglePass(this.id, 'password')"></span>
                            </div>
                        </div>
                        <div class="form-group ">
                            <input class="form-control" type="password" name="cpassword" id="cpassword" 
                                onchange="this.setAttribute('value', this.value);" value="" required>
                            <label>Retype Password</label>
                            <div class="input-group-append">
                                <span class="fas fa-eye-slash input-group-text" id="togglecPassword" onclick="togglePass(this.id, 'cpassword')"></span>
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

    <script>
        $('#password').popover();
    </script>
</body>

</html>