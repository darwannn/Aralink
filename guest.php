<?php 
require dirname(__FILE__, 1).'/php/controller.php';

$get_code = $_GET['c'];
if ($get_code == '') {
    header('Location: error');
}

$query = $conn->prepare("SELECT * FROM classadmin WHERE classcode = :getCode");
$query->execute([':getCode' => $get_code]);  
if($query->rowCount() > 0) { 
    if($query){
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
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
    <title>AraLink: <?php echo $fetch['classname'] ?></title>
    <?php include "php/import.php" ?>

    <!-- Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="mainContent">
    
    <!-- Navbar -->
    <?php include "php/navbar.php" ?>

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
                            $query = $conn->prepare("SELECT * FROM classsubject WHERE subjectcode = :getCode");
                            $result  =  $query->execute([':getCode' => $get_code]);
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
                            $query = $conn->prepare("SELECT * FROM classvideo WHERE linkcode = :getCode");
                            $result  =  $query->execute([':getCode' => $get_code]);
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
                            $query = $conn->prepare("SELECT * FROM classvideo WHERE subjects = :subject AND linkcode = :getCode");
                            $result  =  $query->execute([':subject' => $selected, ':getCode' => $get_code]);
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
                        $query = $conn->prepare("SELECT * FROM classvideo WHERE linkcode = :getCode");
                        $result  =  $query->execute([':getCode' => $get_code]);
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
    <?php include "php/footer.php" ?>

    </div>

    <!-- Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>