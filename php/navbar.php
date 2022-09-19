<?php
$email = isset($_SESSION['email']);
$password = isset($_SESSION['password']);
$file_default_name=dirname($_SERVER['REQUEST_URI']).'/';
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-md navbar-light sticky-top nav-index">
    <?php
    if($file_default_name.basename($_SERVER['PHP_SELF']) == $file_default_name."index.php" ){
        ?>
    <a href="<?php echo $_SERVER['REQUEST_URI'].''?>" class="navbar-brand pl-3"><img src="img/nav-logo.png"
            width="190px" height="50px"></a>
    <?php
    } else {
        ?>
    <a href="<?php echo $file_default_name?>" class="navbar-brand pl-3"><img src="img/nav-logo.png" width="190px"
            height="50px"></a>
    <?php
    }
    ?>
    <button id="toggler" class="navbar-toggler collapsed" onclick="navToggler()" type="button" data-toggle="collapse"
        data-target="#navigation_bar" aria-controls="navigation_bar" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <?php
  if(isset($_GET['c'])){
    ?>
    <div class="collapse navbar-collapse " id="navigation_bar">
        <ul class="navbar-nav ml-auto flex-sm-row pr-2">
            <div class="nav-item left  "> <a href="account/login" class="btn btn-light"> <i
                        class="fas fa-sign-in-alt"></i>Login</a></div>
            <div class="nav-item right "> <a href="account/register" class="btn btn-light"> <i
                        class="fas fa-user-plus"></i>Register</a></div>
        </ul>
    </div>
    <?php
} else if(($email != false && $password != false) ){ 
    if($_SERVER['REQUEST_URI'] == $file_default_name.'home' ){
?>
    <div class="collapse navbar-collapse " id="navigation_bar">
        <ul class="navbar-nav ml-auto flex-sm-row pr-2">
            <div class="nav-item left"> <a href="admin" class="btn btn-light"><i class="fas fa-user-edit"></i>Admin</a>
            </div>
            <div class="nav-item right"> <a href="account/logout" class="btn btn-light"><i
                        class="fas fa-sign-out-alt"></i>Logout</a></div>
        </ul>
    </div>
    <?php
    } else {
    ?>
    <div class="collapse navbar-collapse " id="navigation_bar">
        <ul class="navbar-nav ml-auto flex-sm-row pr-2">
            <div class="nav-item left "> <a href="home" class="btn btn-light"> <i class="fas fa-house-user"></i>Home</a>
            </div>
            <div class="nav-item right "> <a href="account/logout" class="btn btn-light"> <i
                        class="fas fa-sign-out-alt"></i>Logout</a></div>
        </ul>
    </div>
    <?php
    }
    } else { 
?>
    <div class="collapse navbar-collapse " id="navigation_bar">
        <ul class="navbar-nav ml-auto flex-sm-row pr-2">
            <div class="nav-item left  "> <a href="account/login" class="btn btn-light"> <i
                        class="fas fa-sign-in-alt"></i>Login</a></div>
            <div class="nav-item right "> <a href="account/register" class="btn btn-light"> <i
                        class="fas fa-user-plus"></i>Register</a></div>
        </ul>
    </div>
    <?php
}
?>
</nav>