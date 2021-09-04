<?php 
session_start();

require "db.php";
require 'php/PHPMailer.php';
require 'php/SMTP.php';
require 'php/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();
$mail->SMTPDebug  = 2;  
$mail->Port       = 587;
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true; 
$mail->SMTPSecure = 'tls';            
$mail->isHTML(true);
$mail->Username = "aralink.xyz@gmail.com";
$mail->Password = 'khpdauesnaeizzmv'; 
$mail->setFrom('aralink.xyz@gmail.com','AraLink');

$errors = array();

$email = "";
$classname = "";
$name = "";

    /* Signup */
    if(isset($_POST['signup'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $classname = $_POST['classname'];
        if(preg_match("~@gmail\.com$~",$email)){
            $query = $conn->prepare("SELECT * FROM classadmin WHERE email = :email");
            $query->execute([':email' => $email]);
            if( $query->rowCount() > 0){
                $errors[':email'] = "The email you have entered is already registered!";
            } else {
                if($password !== $cpassword){
                    $errors['password'] = "The password you entered did not match!";
                } else {
                    if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/', $password)) {
                        if(count($errors) === 0){
                            $classcode =    substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,8))), 1, 8);
                            $encpass = password_hash($password, PASSWORD_BCRYPT);
                            $code = rand(999999, 111111);
                            $status = "notverified";
                            $query = $conn->prepare("SELECT * FROM classadmin WHERE classcode = :classcode");
                            $query->execute([':classcode' => $classcode]);
                            if( $query->rowCount() > 0){
                                $classcode =    substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,8))), 1, 8);
                            } else {
                                $query = $conn->prepare("INSERT INTO classadmin (name, email, password, code, status, classname, classcode)VALUES(:name, :email, :password, :code, :status, :classname, :classcode)");
                                $result=$query->execute([':name' => $name, ':email' => $email, ':password' => $encpass, ':code' => $code,':status' => $status,':classname' => $classname,':classcode' => $classcode]);
                                if($result){
                                    $mail->addAddress($email);
                                    $mail->Subject='Verification Code';
                                    $mail->Body="Your verification code is <b>$code</b>";
                                    if($mail->send()){
                                        $info = "Verification code has been sent to $email";
                                        $_SESSION['info-otp'] = $info;
                                        $_SESSION['email'] = $email;
                                        $_SESSION['password'] = $password;
                                        header('location: otp');
                                        exit();
                                    } else{
                                        $errors['otp-error'] = "Something went wrong! Please try again later.";
                                    }
                                } else{
                                    $errors['db-error'] = "Something went wrong! Please try again later.";
                                }
                            }
                        }
                    } else{
                        $errors['password'] = "Password does not meet the requirements!";
                    }
                }
            }
        } else{
            $errors['email'] = "Please use a gmail account!";
        }
    }


    /* Click Verification Button */
     if(isset($_POST['check'])){
        $otp_code = $_POST['otp'];
        if (preg_match('/^([0-9]*)$/', $otp_code)) {
            $query = $conn->prepare("SELECT * FROM classadmin WHERE code = :code");
            $query->execute([':code' => $otp_code]);
            if($query->rowCount() > 0){
                $fetch = $query->fetch(PDO::FETCH_ASSOC);
                $fetch_code = $fetch['code'];
                $email = $fetch['email'];
                $code = 0;
                $status = 'verified';
                $query  = $conn->prepare("UPDATE classadmin SET code = :newCode, status = :status WHERE code = :oldCode");
                $result = $query->execute([':newCode' => $code, ':status' => $status, ':oldCode' => $fetch_code]);
                if($result){
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    header('location: home');
                    exit();
                }else{
                    $errors['otp-error'] = "Registration failed! Please try again later.";
                }
            }else{
                $errors['otp-error'] = "Incorrect verification code!";
            }
        }else{
            $errors['otp-error'] = "Incorrect verification code!";
        }
    } 

    /* Login */
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password =  $_POST['password'];
        if(preg_match("~@gmail\.com$~",$email)){
            $query  = $conn->prepare("SELECT * FROM classadmin WHERE email = :email");
            $query->execute([':email' => $email]);
            if($query->rowCount() > 0){
                $fetch = $query->fetch(PDO::FETCH_ASSOC);
                $fetch_pass = $fetch['password'];
                if(password_verify($password, $fetch_pass)){
                    $_SESSION['email'] = $email;
                    $status = $fetch['status'];
                    if($status == 'verified'){
                        $_SESSION['email'] = $email;
                        $_SESSION['password'] = $password;
                        header('location: home');
                    }else{
                        $info = "Verification code has been sent to $email";
                        $_SESSION['info-otp'] = $info;
                        header('location: otp');
                     }
                }else{
                     $errors['email'] = "Incorrect  password!";
                }
            }else{
                 $errors['email'] = "It looks like the email you have entered is not yet registered!";
            }
        }
        else{
            $errors['email'] = "Please use a gmail account!";
        } 
    }

    /* Forgot Password Check Email */
    if(isset($_POST['check-email'])){
        $femail = $_POST['email'];
        if(preg_match("~@gmail\.com$~",$femail)){
            $query = $conn->prepare("SELECT * FROM classadmin WHERE email = :email");
            $query->execute([':email' => $femail]);
            if($query->rowCount() > 0){
                $code = rand(999999, 111111);
                $query=  $conn->prepare("UPDATE classadmin SET code = :code WHERE email = :email");
                $result = $query->execute([':code' => $code, ':email' => $femail]);       
                if($result){
                    $mail->addAddress($femail);
                    $mail->Subject='Verification Code';
                    $mail->Body="Your verification code is <b>$code</b>";
                    if($mail->send()){
                        $info = "Verification code has been sent to $femail";
                        $_SESSION['info-rotp'] = $info;
                        $_SESSION['femail'] = $femail;
                        header('location: reset-otp');
                        exit();
                    }else{
                        $errors['otp-error'] = "Something went wrong! Please try again later.";
                    }
                }else{
                    $errors['db-error'] = "Something went wrong! Please try again later.";
                }
            }else{
                $errors['email'] = "It looks like the email you have entered is not yet registered!";
            }
        }else{
            $errors['email'] = "Please use a gmail account!";
        }
    }

    /* Check Reset OTP */
    if(isset($_POST['check-reset-otp'])){
        /* $_SESSION['info'] = ""; */
        $otp_code = $_POST['otp'];
        $query  = $conn->prepare("SELECT * FROM classadmin WHERE code = :code");
        $query->execute([':code' => $otp_code]);
        if (preg_match('/^([0-9]*)$/', $otp_code)) {
            if($query->rowCount() > 0){
                $fetch =  $query->fetch(PDO::FETCH_ASSOC);
                $code = 0;
                $femail = $fetch['email'];
                $_SESSION['femail'] = $femail;
                $info = "Enter your new password";
                $_SESSION['info-np'] = $info;
                $query = $conn->prepare("UPDATE classadmin SET code = :code WHERE email = :email");
                $result=$query->execute([':code' => $code, ':email' => $femail]);
                if ($result) {
                    header('location: new-password');
                } else {
                    $errors['code'] = "Something went wrong! Please try again later.";
                }
                exit();
            }else{
                $errors['otp-error'] = "Incorrect verification code!";
            }
        }else{
            $errors['otp-error'] = "Incorrect verification code!";
        }
    }

    /* Change Password */
    if(isset($_POST['change-password'])){
 /*        $_SESSION['info'] = ""; */
        $password = $_POST['password'];
        $cpassword =  $_POST['cpassword'];

            if($password !== $cpassword){
                $errors['password'] = "The password you entered did not match!";
            } else{ 
                if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/', $password)) {
            /* $code = 0; */
            $femail = $_SESSION['femail'];
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            $query = $conn->prepare("UPDATE classadmin SET password = :password WHERE email = :email");
            $result=$query->execute([':password' => $encpass, ':email' => $femail]);
      
                if($result){
                    $success = "Your password has been changed! Please login with your new password.";
                    $_SESSION['info-success'] = $success;
                    header('Location: login');
                }else{
                    $errors['db-error'] = "Failed to change your password! Please try again later.";
                }
            }else {
                $errors['password'] = "Password does not meet the requirements!";
        }
    }
}

    /* Login Now */
    if(isset($_POST['login-now'])){
        header('Location: php/login');
    }


    /* Admin */
    /* Class Change Name */
    if(isset($_POST['change-name'])){
         $varivari =  $_POST['varivari'];
         $id =  $_POST['id'];
         $changename = $_POST['change-name'];
         $query  = $conn->prepare("UPDATE classadmin SET classname = :classname WHERE id = :id");
        $query->execute([':classname' => $changename, ':id' => $id]);
     }

    /* Upload Image */
    if(isset($_POST["upload-image"])){ 
        $varivari= $_SESSION["classcode"];
        $img_size = $_FILES['image']['size'];
       
            if(!empty($_FILES["image"]["name"])) { 
                $fileName = basename($_FILES["image"]["name"]); 
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                $allowTypes = array('png'); 
                if(in_array($fileType, $allowTypes)){ 
                    if ($img_size < 16000000) {
                    $image = $_FILES['image']['tmp_name']; 
                    $imgContent = addslashes(file_get_contents($image)); 
                    $query  = $conn->prepare("UPDATE classadmin SET images = '$imgContent' WHERE classcode = '$varivari'");
                    $result = $query->execute(); 
                    if($result){ 
                        $info = "Image has been changed!";
                        $_SESSION['info-image'] = $info;
                    }else{ 
                        $errors['images'] = "Something went wrong! Please try again later."; 
                    }  
                
                }else{ 
                    $errors['images'] = "Upload a PNG image that is smaller than 4 MB!"; 
                }
                }else{ 
                    $errors['images'] = 'Sorry, only PNG files are allowed!'; 
                } 
            }else{ 
                $errors['images'] = 'Select a PNG file to upload!'; 
            }
        ?>
            <script>
                var message = "e";
            </script>
        <?php  
    } 

    /* Remove Image */
    if(isset($_POST['remove-image'])) {
        $varivari= $_SESSION["classcode"];
        $query  = $conn->prepare("UPDATE classadmin SET images = '' WHERE classcode = '$varivari'");
       $query->execute(); 
    }

    /* Resend OTP */
    if(isset($_POST['resend'])) {
        $email = $_POST['email'];
        $code = rand(999999, 111111);
        $query=  $conn->prepare("UPDATE classadmin SET code = :code WHERE email = :email");
        $result = $query->execute([':code' => $code, ':email' => $email]);       
        if($result){
            $mail->addAddress($email);
            $mail->Subject='Verification Code';
            $mail->Body="Your verification code is <b>$code</b>";
            if($mail->send()){
                $info = "Verification code resent to $email";
                $_SESSION['info-otp'] = $info;
                $_SESSION['email'] = $email;
                header('location: otp');
                exit();
            }else{
                $errors['otp-error'] = "Something went wrong! Please try again later.";
            }
        }else{
            $errors['db-error'] = "Something went wrong! Please try again later.";
        }
    }

    /* Resend Reset-OTP */
    if(isset($_POST['resendd'])) {
        $femail = $_POST['email'];
        $code = rand(999999, 111111);
        $query=  $conn->prepare("UPDATE classadmin SET code = :code WHERE email = :email");
        $result = $query->execute([':code' => $code, ':email' => $femail]);       
        if($result){
            $mail->addAddress($femail);
            $mail->Subject='Verification Code';
            $mail->Body="Your verification code is <b>$code</b>";
            if($mail->send()){
                $info = "Verification code resent to $femail";
                $_SESSION['info-rotp'] = $info;
                $_SESSION['femail'] = $femail;
                header('location: reset-otp');
                exit();
            }else{
                $errors['otp-error'] = "Something went wrong! Please try again later.";
            }
        }else{
            $errors['db-error'] = "Something went wrong! Please try again later.";
        }
    } 
    
    /* Index */
    if(isset($_POST['submit'])){
        $codihe = $_POST['c'];
            $query = $conn->prepare("SELECT * FROM classadmin WHERE classcode  = :classcode");
            $query->execute([':classcode' => $codihe]);
            if($query->rowCount() > 0){
                header('location: guest?c='.$codihe);   
            } else {
            $errors['classcode'] = "Code doesn't exist!";
            ?>
                <script>
                    var error = "error";
                </script>
            <?php 
        }
    }
?>