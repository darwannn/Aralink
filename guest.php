<?php 
require "db.php"; 
session_start();
$codihe = $_GET['c'];

if ($codihe == '') {
    header('Location: error');
}

$query = $conn->prepare("SELECT * FROM classadmin WHERE classcode = :codihe");
$query->execute([':codihe' => $codihe]);
    
if($query->rowCount() > 0) { 
    if($query){
    $fetch = $query->fetch(PDO::FETCH_ASSOC);
    $scode = $fetch['classcode'];
    }
} else {
    header('Location: error');
}
    
$background = 'data:image/png;base64,'.base64_encode($fetch['images']);  
if (!empty($fetch['images'])) {
    ?>
<style>
    .jumbotron {
        background-image: url(<?php echo $background; ?>);
    }
</style>
<?php
} else {
    ?>
<style>
    .jumbotron {
        background-image: url(img/bg2.png);
    }
</style>
<?php
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>AraLink: <?php echo $fetch['classname'] ?></title>
    <link rel="icon" href="img/logo.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Loading -->
    <link rel="stylesheet" href="css/pace-theme-minimal.css">

    <!-- Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0px;
            padding: 0px;
            display: flex;
            flex-direction: column;
            color: rgb(46, 50, 51);
        }

        @media (min-width: 0px) {
            .videos .shrink {
                top: 126px;
            }
        }

       /*  .videos {
            margin-bottom: 19px;
        } */

        @media (max-width: 699px) {
            .videos {
                margin-bottom: 11px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light sticky-top nav-index">
        <a href="http://aralink.xyz/" class="navbar-brand pl-3"><img src="img/nav-logo.png" width="190px" height="50px"></a>
        <button id="toggler" class="navbar-toggler collapsed" type="button" data-toggle="collapse"
            data-target="#navigation_bar" aria-controls="navigation_bar" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse " id="navigation_bar">
            <ul class="navbar-nav ml-auto flex-sm-row pr-2">
                <div class="nav-item left  "> <a href="login" class="btn btn-light"> <i
                            class="fas fa-sign-in-alt"></i>Login</a></div>
                <div class="nav-item right "> <a href="register" class="btn btn-light"> <i
                            class="fas fa-user-plus"></i>Register</a></div>
            </ul>
        </div>
    </nav>

    <!-- Jumbotron -->
    <div class="background-image ">
        <div class="jumbotron d-flex align-items-center text-center">
            <div class="container">
                <h1 class="jumbotron-heading"><?php  echo $fetch['classname']?></h1>
            </div>
        </div>
    </div>

    <!-- Videos -->
    <div class="videos">
        <div id="selection" class="video-selection sticky-top text-center">
            <div class="text-center">
                <div class="filter">
                    <form id="form1" method="POST" class="owl-carousel radio-buttons m-0">
                        <label class="filter-selection " value='ALL'>
                            <input class="radio-filter subject" type="radio" name="subject" value="ALL">ALL</input>
                        </label>
                        <?php
                            $query = $conn->prepare("SELECT * FROM classsubject WHERE subjectcode = :codihe");
                            $result  =  $query->execute([':codihe' => $codihe]);
                            echo "<style>.filter-selection[value='ALL']{background-color: rgb(31, 155, 95); color:white!important;}></style>"; 
                            if($result){
                                if($query->rowCount() > 0){
                                    while($row = $query->fetch(PDO::FETCH_BOTH)){
                        ?>
                        <label class="filter-selection " value='<?php echo $row['subjects'];?>'>
                            <input class="radio-filter subject" type="radio" name="subject"
                                value="<?php echo $row['subjects'];?>"
                                for=<?php echo $row['subjects'];?>><?php echo $row['subjects'];?> </input>
                        </label>
                        <?php
                                    }
                                } 
                            }
                                ?>
                        <input type="hidden" name="c" value="<?php echo $_POST['c']?>">
                    </form>
                </div>
            </div>
        </div>
        <div class=" video-show">
            <div class="row">
                <?php
                    if(isset($_SESSION['selected'])) {
                        $selected = $_SESSION['selected'];
                        if ($selected == "ALL") {
                            $query = $conn->prepare("SELECT * FROM classvideo WHERE linkcode = :codihe");
                            $result  =  $query->execute([':codihe' => $codihe]);
                            echo "<style>.filter-selection[value='ALL']{background-color: rgb(31, 155, 95);color:white!important; border:solid 1px rgb(31, 155, 95)!important;}></style>"; 
                            if($result){
                                if($query->rowCount() > 0){
                                    while($row = $query->fetch(PDO::FETCH_BOTH)){
                        ?>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card box-shadow ">
                        <iframe class="card-img-top" src="<?php echo $row['links'];?>" allowfullscreen="true"
                            loading="lazy"></iframe>
                        <div class="card-body">
                            <div class="card-subtitle text-muted"> <?php echo $row['subjects'];?></div>
                            <div class="card-title"> <?php echo $row['titles'];?></div>
                            <div class="card-subtitle text-muted"> <?php echo $row['dates'];?> </div>
                        </div>
                    </div>
                </div>
                <?php
                                    }  
                                } else {
                                    ?>
                <div class="error-text m-auto">No lesson found </div>
                <?php
                                } 
                            }
                        } else {
                            $query = $conn->prepare("SELECT * FROM classvideo WHERE subjects = :subject AND linkcode = :codihe");
                            $result  =  $query->execute([':subject' => $selected, ':codihe' => $codihe]);
                            echo "<style>.filter-selection[value='$selected']{background-color: rgb(31, 155, 95);color:white!important; border:solid 1px rgb(31, 155, 95)!important;}.filter-selection[value=ALL]{background-color: white; color:#6c757d!important;}.filter-selection[value='ALL']:hover {color:white!important}</style>";  
                            if($result){
                                if($query->rowCount() > 0){
                                    while($row = $query->fetch(PDO::FETCH_BOTH)){                           
                    ?>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card box-shadow">
                        <iframe class="card-img-top" src="<?php echo $row['links'];?>" allowfullscreen="true"
                            loading="lazy"></iframe>
                        <div class="card-body">
                            <div class="card-subtitle text-muted"> <?php echo $row['subjects'];?></div>
                            <div class="card-title"> <?php echo $row['titles'];?></div>
                            <div class="card-subtitle text-muted"> <?php echo $row['dates'];?> </div>
                        </div>
                    </div>
                </div>
                <?php
                                     } 
                                } else {
                                    ?>
                <div class="error-text m-auto">No lesson in <?php echo $selected;?> </div>
                <?php
                                }
                            }
                        }
                    }
                     else {
                        $query = $conn->prepare("SELECT * FROM classvideo WHERE linkcode = :codihe");
                        $result  =  $query->execute([':codihe' => $codihe]);
                        if($result){
                            if($query->rowCount() > 0){
                                while($row = $query->fetch(PDO::FETCH_BOTH)){
                                    ?>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card box-shadow">
                        <iframe class="card-img-top" src="<?php echo $row['links'];?>" allowfullscreen="true"
                            loading="lazy"></iframe>
                        <div class="card-body">
                            <div class="card-subtitle text-muted"> <?php echo $row['subjects'];?></div>
                            <div class="card-title"> <?php echo $row['titles'];?></div>
                            <div class="card-subtitle text-muted"> <?php echo $row['dates'];?> </div>
                        </div>
                    </div>
                </div>
                <?php
                                }  
                            }else {
                                ?>
                <div class="error-text m-auto">No lesson found </div>
                <?php
                        }
                    }
                }
                            ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="page-footer">
        <div class="footer-text text-center py-2">
            <a href="https://github.com/darwannn/AraLink" target="_blank">Repository</a>
        </div>
    </footer>

    <!-- Loading -->
    <script src="js/pace.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <!-- Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>

        $(document).ready(function () {
            $('.radio-buttons input[type="radio"]').click(function () {
                var subject = $(this).val();
                $.ajax({
                    url: 'php/selection',
                    type: 'POST',
                    data: {
                        subject: subject
                    },
                    success: function (response) {
                        /* Reload div */

                        $(".video-show").load(" .video-show > *");
                    }
                });
            });

            $('.owl-carousel').owlCarousel({
                margin: 0,
                loop: false,
                autoWidth: true,
                items: 1,
                nav: true,
                navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"]
             });
        });

        document.getElementById("toggler").addEventListener("click", function () {
            document.getElementById("selection").classList.toggle("shrink");
        });

        /* Remove Confirm Form Resubmission  */
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        /* Store Scroll Position */
        document.addEventListener("DOMContentLoaded", function (event) {
            var scrollpos = sessionStorage.getItem('scrollpos');
            if (scrollpos) {
                window.scrollTo(0, scrollpos);
                sessionStorage.removeItem('scrollpos');
            }
        });

        window.addEventListener("beforeunload", function (e) {
            sessionStorage.setItem('scrollpos', window.scrollY);
        });
    </script>

</body>

</html>