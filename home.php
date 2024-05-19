<?php

require dirname(__FILE__, 1) . '/php/controller.php';

$email = $_SESSION['email'];
$password = $_SESSION['password'];

if ($email != false && $password != false) {
    $query = $conn->prepare("SELECT * FROM classadmin WHERE email = :email");
    $result = $query->execute([':email' => $email]);
    if ($result) {
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $fetch_status = $fetch['status'];
        /*  $fetch_code = $fetch['code']; */
        $fetch_classcode = $fetch['classcode'];
        /* for admin */
        $_SESSION["classcode"] = $fetch_classcode;
        if ($fetch_status == "notverified") {
            $info = "It's look like you haven't still verify your email - $email";
            $_SESSION['info'] = $info;
            header('Location: account/otp');
        }
    }
} else {
    header('Location: account/login');
}

if (!empty($fetch['images'])) {
    $background = 'data:image/png;base64,' . base64_encode($fetch['images']);
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
    <title>AraLink: <?php echo $fetch['classname'] ?></title>
    <?php include "php/import.php" ?>

    <!-- Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div class="mainContent">

        <!-- Navbar -->
        <?php include "php/navbar.php" ?>

        <!-- Jumbotron -->
        <div class="background-image">
            <div class="jumbotron d-flex align-items-center text-center">
                <div class="container">
                    <h1 class="jumbotron-heading"><?php echo $fetch['classname'] ?><a data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#copy_code_modal"><i class="fas fa-share" aria-hidden="true"></i></a></h1>
                </div>
            </div>
        </div>

        <!-- Videos -->
        <div class="videos">
            <div id="selection" class="video-selection sticky-top text-center">
                <div class="text-center">
                    <div class="filter">
                        <form id="form1" method="POST" class="owl-carousel radio-buttons m-0">
                            <label class="filter-selection" value='ALL'>
                                <input class="radio-filter subject" type="radio" name="subject" value="ALL">ALL</input>
                            </label>
                            <?php
                            $query = $conn->prepare("SELECT * FROM classsubject WHERE subjectcode = :codihe");
                            $result  =  $query->execute([':codihe' => $fetch_classcode]);
                            echo "<style>.filter-selection[value='ALL']{background-color: rgb(31, 155, 95); color:white!important;}>filter-selection[value='ALL']:hover {color:white}</style>";
                            if ($result) {
                                if ($query->rowCount() > 0) {
                                    while ($row = $query->fetch(PDO::FETCH_BOTH)) {
                            ?>
                                        <label class="filter-selection" value='<?php echo $row['subjects']; ?>'>
                                            <input class="radio-filter subject" type="radio" name="subject" value="<?php echo $row['subjects']; ?>" for=<?php echo $row['subjects']; ?>><?php echo $row['subjects']; ?> </input>
                                        </label>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class=" video-show">
                <div class="row">
                    <?php
                    if (isset($_SESSION['selected'])) {
                        $selected = $_SESSION['selected'];
                        if ($selected == "ALL") {
                            $query = $conn->prepare("SELECT * FROM classvideo WHERE linkcode = :codihe");
                            $result  =  $query->execute([':codihe' => $fetch_classcode]);
                            echo "<style>.filter-selection[value='ALL']{background-color: rgb(31, 155, 95);color:white!important; border:solid 1px rgb(31, 155, 95)!important;}></style>";
                            if ($result) {
                                if ($query->rowCount() > 0) {
                                    while ($row = $query->fetch(PDO::FETCH_BOTH)) {
                    ?>
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="card box-shadow">
                                                <iframe class="card-img-top" src="<?php echo $row['links']; ?>" allowfullscreen="true" loading="lazy"></iframe>
                                                <div class="card-body">
                                                    <div class="card-subtitle text-muted"> <?php echo $row['subjects']; ?></div>
                                                    <div class="card-title"> <?php echo $row['titles']; ?></div>

                                                    <div class="card-subtitle text-muted"> <?php echo $row['dates']; ?> </div>
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
                            $result  =  $query->execute([':subject' => $selected, ':codihe' => $fetch_classcode]);
                            echo "<style>.filter-selection[value='$selected']{background-color: rgb(31, 155, 95);color:white!important; border:solid 1px rgb(31, 155, 95)!important;}.filter-selection[value=ALL]{background-color: white; color:#6c757d!important;}.filter-selection[value='ALL']:hover {color:white!important}</style>";
                            if ($result) {
                                if ($query->rowCount() > 0) {
                                    while ($row = $query->fetch(PDO::FETCH_BOTH)) {
                                    ?>
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="card box-shadow">
                                                <iframe class="card-img-top" src="<?php echo $row['links']; ?>" allowfullscreen="true" loading="lazy"></iframe>
                                                <div class="card-body">
                                                    <div class="card-subtitle text-muted"> <?php echo $row['subjects']; ?></div>
                                                    <div class="card-title"> <?php echo $row['titles']; ?></div>
                                                    <div class="card-subtitle text-muted"> <?php echo $row['dates']; ?> </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div class="error-text m-auto">No lesson in <?php echo $selected; ?> </div>
                                <?php
                                }
                            }
                        }
                    } else {
                        $query = $conn->prepare("SELECT * FROM classvideo WHERE linkcode = :codihe");
                        $result  =  $query->execute([':codihe' => $fetch_classcode]);
                        if ($result) {
                            if ($query->rowCount() > 0) {
                                while ($row = $query->fetch(PDO::FETCH_BOTH)) {
                                ?>
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card box-shadow">
                                            <iframe class="card-img-top" src="<?php echo $row['links']; ?>" allowfullscreen="true" loading="lazy"></iframe>
                                            <div class="card-body">
                                                <div class="card-subtitle text-muted"> <?php echo $row['subjects']; ?></div>
                                                <div class="card-title"> <?php echo $row['titles']; ?></div>
                                                <div class="card-subtitle text-muted"> <?php echo $row['dates']; ?> </div>
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
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include "php/footer.php" ?>

    </div>
    <!-- Copied Message -->
    <div class="copied btn btn-dark" id="copied">Copied to Clipboard!</div>

    <!-- Copy Modal -->
    <div class="modal fade" id="copy_code_modal" tabindex="-1" role="dialog" aria-labelledby="copy_code_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-min px-3 my-sm-4" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title mx-auto">Class Code</h5>
                </div>
                <div class="modal-body  text-center">
                    <h3 id="select_txt" class="class-code"><?php echo $fetch['classcode']  ?></h3>
                    <div class="modal-footerr text-right pt-2">
                        <input type="button" class="btn btn-primaryy" id="copy-code" data-dismiss="modal" value="Copy" onclick="copy_data(select_txt)">
                        <input type="button" class="btn btn-dangerr" data-dismiss="modal" value="Close">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>