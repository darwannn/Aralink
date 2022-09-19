<?php 
$errors = array();
require dirname(__FILE__, 1).'/php/controller.php';
unset($_SESSION['selected']);
$inIndex = true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>AraLink</title>
    <?php include "php/import.php" ?>
</head>

<body>

    <!-- Navbar -->
    <?php include "php/navbar.php" ?>

    <div class="brand">
    <div class="jumbotron d-flex align-items-center particles m-0" id="particles-js">
        <div class="container text-center ">
            <h1 class="jumbotron-heading ">AraLink</h1>
            <div class="description">is a website where you can compile the video recordings of your classes through embed links.

        </div>
            <input id="remove-ani" type="submit" class="btn btn-primaryy enter-animation" data-toggle="modal"
                data-backdrop="static" data-keyboard="false" data-target="#code_modal" value="Enter Code" onclick="removeButtonAni(this.class);"/>
          
        </div>
    </div>
    </div>

    <!-- Code Modal -->
    <div class="modal fade " id="code_modal" tabindex="-1" role="dialog" aria-labelledby="code_modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-min modal-dialog-centered px-3 my-sm-4" role="document">
            <div class="modal-content ">
                <div class="modal-header ">
                    <h5 class="modal-title mx-auto">Enter Code</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action=""> <!-- http://aralink.xyz/ -->
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
                        <div class="form-group">
                            <input class="form-control  text-center" type="text" name="c" id="c" placeholder="••••••••"
                                onkeypress="return event.charCode != 32" maxlength="8" required>
                        </div>
                        <div class="modal-footerr text-right">
                            <input type="submit" class="btn btn-primaryy" name="submit" value="Continue">
                            <input type="button" class="btn btn-dangerr" data-dismiss="modal" id="close" value="Close" onclick="addButtonAni(this.class)">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Particle -->
    <script src="js/particles.js"></script>
    <script src="js/app.js"></script>

    <script>
        var error;
        error == "error"? document.querySelector("#remove-ani").click():"";
    </script>

</body>
</html>