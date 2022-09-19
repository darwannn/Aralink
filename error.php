<?php 
require 'php/controller.php';
unset($_SESSION['selected']);
$errors = array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>AraLink</title>
    <?php include "php/import.php" ?>

</head>

<body>

    <!-- <?php include "navbar.php" ?> -->
    <div class="error">
        <div class="jumbotron d-flex align-items-center m-0">
            <div class="container text-center  ">
                <h1 class="jumbotron-heading ">404</h1>
                <h1 class="jumbotron-subheading ">Page Not Found</h1>
                <div class="description">The page you were looking for could not be found.</div>
                <a class="btn btn-primaryy" href="<?php echo $directory?>AraLink">Go Back</a>
            </div>
        </div>
    </div>


</body>

</html>