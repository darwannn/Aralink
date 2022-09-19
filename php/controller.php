<?php 
session_start();

require "db.php";

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

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
$class_name = "";
$name = "";
$root_directory =  dirname(__FILE__, 2);

/* check if the current file is inside the account folder */
if (strpos(dirname($_SERVER['SCRIPT_NAME']),"/account" )) { 
    $logo ="../img/src-logo.png";
    $directory =   "../";
} else {
    $logo ="img/src-logo.png";
    $directory =   "../";
}

/* function to generate class code */
function generateCode () {
   return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,8))), 1, 8);
}
    
/* Account ---------------------------------------- */

    /* Signup */
    if(isset($_POST['signup'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $check_password = $_POST['cpassword'];
        $class_name = $_POST['classname'];
        /* check if the email address is gmail */
        if(preg_match("~@gmail\.com$~",$email)){
            $query = $conn->prepare("SELECT * FROM classadmin WHERE email = :email");
            $query->execute([':email' => $email]);
            if( $query->rowCount() > 0){
                $errors[':email'] = "The email you have entered is already registered!";
            } else {
                /* check if the password fields matches */
                if($password !== $check_password){
                    $errors['password'] = "The password you entered did not match!";
                } else {
                    /* regex for password requirements */
                    if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/', $password)) {
                        if(count($errors) === 0){
                            $code_generated = generateCode();
                            $encrypt_password = password_hash($password, PASSWORD_BCRYPT);
                            /* generates verification code */
                            $code = rand(999999, 111111);
                            $status = "notverified";
                            $query = $conn->prepare("SELECT * FROM classadmin WHERE classcode = :classcode");
                            $query->execute([':classcode' => $code_generated]);
                            /* check if the class code generated is taken or not */
                            if( $query->rowCount() > 0){
                                $code_generated = generateCode();
                            } else {
                                $query = $conn->prepare("INSERT INTO classadmin (name, email, password, code, status, classname, classcode)VALUES(:name, :email, :password, :code, :status, :classname, :classcode)");
                                $result=$query->execute([':name' => $name, ':email' => $email, ':password' => $encrypt_password, ':code' => $code,':status' => $status,':classname' => $class_name,':classcode' => $code_generated]);
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


    /* Registration: Verify Email Ownership*/
     if(isset($_POST['check'])){
        $otp_code = $_POST['otp'];
        /* if (preg_match('/^([0-9]*)$/', $otp_code)) { */
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
                    header('location: ../home');
                    exit();
                }else{
                    $errors['otp-error'] = "Registration failed! Please try again later.";
                }
            }else{
                $errors['otp-error'] = "Incorrect verification code!";
            }
        /* }else{
            $errors['otp-error'] = "Incorrect verification code!";
        } */
    } 

    /* Login */
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password =  $_POST['password'];
      /*   if(preg_match("~@gmail\.com$~",$email)){ */
            $query  = $conn->prepare("SELECT * FROM classadmin WHERE email = :email");
            $query->execute([':email' => $email]);
            if($query->rowCount() > 0){
                $fetch = $query->fetch(PDO::FETCH_ASSOC);
                $fetch_pass = $fetch['password'];
                /* check if the password matches the password stored in the database */
                if(password_verify($password, $fetch_pass)){
                    $_SESSION['email'] = $email;
                    $status = $fetch['status'];
                    if($status == 'verified'){
                        $_SESSION['email'] = $email;
                        $_SESSION['password'] = $password;
                        header('location: ../home');
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
       /*  }
        else{
            $errors['email'] = "Please use a gmail account!";
        }  */
    }

    /* Forgot Password: Sends OTP to Email*/
    if(isset($_POST['check-email'])){
        $forgot_email = $_POST['email'];
        /* if(preg_match("~@gmail\.com$~",$forgot_email)){ */
            $query = $conn->prepare("SELECT * FROM classadmin WHERE email = :email");
            $query->execute([':email' => $forgot_email]);
            if($query->rowCount() > 0){
                $code = rand(999999, 111111);
                $query=  $conn->prepare("UPDATE classadmin SET code = :code WHERE email = :email");
                $result = $query->execute([':code' => $code, ':email' => $forgot_email]);       
                if($result){
                    $mail->addAddress($forgot_email);
                    $mail->Subject='Verification Code';
                    $mail->Body="Your verification code is <b>$code</b>";
                    if($mail->send()){
                        $info = "Verification code has been sent to $forgot_email";
                        $_SESSION['info-otp'] = $info;
                        $_SESSION['forgot-email'] = $forgot_email;
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
      /*   }else{
            $errors['email'] = "Please use a gmail account!";
        } */
    }

    /* Forgot Password: Verify Email Ownership*/
    if(isset($_POST['check-reset-otp'])){
        /* $_SESSION['info'] = ""; */
        $otp_code = $_POST['otp'];
        $query  = $conn->prepare("SELECT * FROM classadmin WHERE code = :code");
        $query->execute([':code' => $otp_code]);
        /* if (preg_match('/^([0-9]*)$/', $otp_code)) { */
            if($query->rowCount() > 0){
                $fetch =  $query->fetch(PDO::FETCH_ASSOC);
                $code = 0;
                $forgot_email = $fetch['email'];
                $_SESSION['forgot-email'] = $forgot_email;
                $info = "Enter your new password";
                $_SESSION['info-np'] = $info;
                $query = $conn->prepare("UPDATE classadmin SET code = :code WHERE email = :email");
                $result=$query->execute([':code' => $code, ':email' => $forgot_email]);
                if ($result) {
                    header('location: new-password');
                } else {
                    $errors['code'] = "Something went wrong! Please try again later.";
                }
                exit();
            }else{
                $errors['otp-error'] = "Incorrect verification code!";
            }
        /* }else{
            $errors['otp-error'] = "Incorrect verification code!";
        } */
    }

    /* Change Password */
    if(isset($_POST['change-password'])){
        /* $_SESSION['info'] = ""; */
        $password = $_POST['password'];
        $check_password =  $_POST['cpassword'];
            if($password !== $check_password){
                $errors['password'] = "The password you entered did not match!";
            } else{ 
                if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/', $password)) {
            $forgot_email = $_SESSION['forgot-email'];
            $encrypt_password = password_hash($password, PASSWORD_BCRYPT);
            $query = $conn->prepare("UPDATE classadmin SET password = :password WHERE email = :email");
            $result=$query->execute([':password' => $encrypt_password, ':email' => $forgot_email]);
                if($result){
                    $info = "Your password has been changed! Please login with your new password.";
                    $_SESSION['info-success'] = $info;
                    header('Location: login');
                }else{
                    $errors['db-error'] = "Failed to change your password! Please try again later.";
                }
            }else {
                $errors['password'] = "Password does not meet the requirements!";
        }
    }
}

    /* Resend OTP */
    if(isset($_POST['resend']) || isset($_POST['forgot-resend'])) {
        $email = $_POST['email'];
        /* generates verification code */
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
                if (isset($_POST['resend'])){
                    header('location: otp');
                } else {
                    header('location: reset-otp');  
                }
                exit();
            }else{
                $errors['otp-error'] = "Something went wrong! Please try again later.";
            }
        }else{
            $errors['db-error'] = "Something went wrong! Please try again later.";
        }
    }
    
/* Index---------------------------------------- */

    if(isset($_POST['submit'])){
        $class_code = $_POST['c'];
        $query = $conn->prepare("SELECT * FROM classadmin WHERE classcode  = :classcode");
        $query->execute([':classcode' => $class_code]);
        if($query->rowCount() > 0){
            header('location: guest?c='.$class_code);   
        } else {
        $errors['classcode'] = "Code doesn't exist!";
        ?>
        <!-- keeps modal open -->
            <script>
                var error = "error";
            </script>
        <?php 
        }
    }

/* Home---------------------------------------- */

    /* Subject Selected */
    if (isset($_POST['subject'])) {
        $_SESSION['selected'] = $_POST['subject'];
    }


/* Admin---------------------------- */

    /* Change Class Name */
    if(isset($_POST['change-name'])){
        $id =  $_POST['id'];
        $change_name = $_POST['change-name'];
        $query  = $conn->prepare("UPDATE classadmin SET classname = :classname WHERE id = :id");
        $query->execute([':classname' => $change_name, ':id' => $id]);
    }

    /* Upload Class Background Image */
    if(isset($_POST["upload-image"])){ 
        $class_code= $_SESSION["classcode"];
        $image_size = $_FILES['image']['size'];
            if(!empty($_FILES["image"]["name"])) { 
                $file_name = basename($_FILES["image"]["name"]); 
                $file_type = pathinfo($file_name, PATHINFO_EXTENSION); 
                $allow_types = array('png'); 
                /* check image format */
                if(in_array($file_type, $allow_types)){ 
                    /* check if the image size is less than 4MB */
                    if ($image_size < 16000000) {
                    $image = $_FILES['image']['tmp_name']; 
                    $image_content = addslashes(file_get_contents($image)); 
                    $query  = $conn->prepare("UPDATE classadmin SET images = :images WHERE classcode = :classcode");
                    $result = $query->execute([':images'=> $image_content, ':classcode'=> $class_code]); 
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
            <!-- keeps modal open -->
            <script>
                var message = "error";
            </script>
        <?php  
   } 

   /* Remove Class Background Image */
   if(isset($_POST['remove-image'])) {
       $class_code= $_SESSION["classcode"];
       $query  = $conn->prepare("UPDATE classadmin SET images = '' WHERE classcode = :classcode");
       $query->execute([':classcode' => $class_code]); 
   }

/* Crud---------------------------------------- */

    if(isset($_POST["video-operation"])) {
        /* Add Video */
		if($_POST["video-operation"] == "Add") {
			$titles=$_POST['titles'];
			$subjects=$_POST['subjects'];
			$dates=$_POST['dates'];
			$links=$_POST['links'];
			$linkcode=$_POST['linkcode'];
			$query = $conn->prepare("INSERT INTO classvideo (titles, subjects, dates, links, linkcode) VALUES (:titles, :subjects, :dates, :links, :linkcode)");
			$result = $query->execute([':titles' =>	$titles,':subjects' => $subjects,':dates' => $dates,':links' => $links,':linkcode' => $linkcode]);
		}

        /* Edit Video*/
		if($_POST["video-operation"] == "Edit") {
			$titles=$_POST['titles'];
			$subjects=$_POST['subjects'];
			$dates=$_POST['dates'];
			$links=$_POST['links'];
			$linkcode=$_POST['linkcode'];
			$video_id = $_POST['video_id'];
			$query = $conn->prepare("UPDATE classvideo SET titles = :titles, subjects = :subjects, dates = :dates, links = :links, linkcode = :linkcode WHERE id = :id");
			$result = $query->execute([':titles' => $titles,':subjects'	=> $subjects,':dates' => $dates,':links' => $links,':linkcode' => $linkcode,':id' => $video_id]);
		}
	} else {
        /* Delete Video */
		if(isset($_POST["video_id"])) {
			$video_id = $_POST['video_id'];
			$query = $conn->prepare("DELETE FROM classvideo WHERE id = :id");
			$result = $query->execute([':id' => $video_id]);
		}
	}
    /* Add Subject */
	if(isset($_POST["subject-operation"])) {
		if($_POST["subject-operation"] == "Add") {
			$subjects=$_POST['subjects'];
			$subjectcode=$_POST['subjectcode'];
			$query = $conn->prepare("INSERT INTO classsubject (subjects, subjectcode) VALUES (:subjects, :subjectcode)");
			$result = $query->execute([':subjects' => $subjects, ':subjectcode' => $subjectcode]);
		}
	} else {
        /* Delete Subject */
		if(isset($_POST["subject_id"])) {
			$subject_id = $_POST['subject_id'];
			$query = $conn->prepare("DELETE FROM classsubject WHERE id = :id");
			$result = $query->execute([':id' => $subject_id]);
		}
	}
?>