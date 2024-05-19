<?php

require dirname(__FILE__, 1) . '/php/controller.php';
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$classcode = $_SESSION["classcode"];
if ($email != false && $password != false) {
    $query = $conn->prepare("SELECT * FROM classadmin WHERE email = :email");
    $result = $query->execute([':email' => $email]);
    if ($result) {
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $fetch_code = $fetch['code'];
        $fetch_classcode = $fetch['classcode'];
        $_SESSION["classcode"] = $fetch_classcode;
    }
} else {
    header('Location: account/login');
}

if (!empty($fetch['images'])) {
    $background = 'data:image/png;base64,' . base64_encode($fetch['images']);
?>
    <style>
        .jumbotron {
            background-image: url(<?php echo $background; ?>) !important;
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
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <!-- Date Picker -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="mainContent">
        <?php include "php/navbar.php" ?>

        <!-- Jumbotron -->
        <div class="background-image ">
            <div class="jumbotron d-flex align-items-center text-center">
                <div class="container">
                    <h1 class="jumbotron-heading"><?php echo $fetch['classname'] ?><a data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#change_code_modal"><i class="fas fa-edit" aria-hidden="true"></i></a>
                    </h1>
                </div>
                <div class="jumbotron-upload text-right"><a data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#upload-image-modal">
                        <i class="fas fa-image" aria-hidden="true" data-backdrop="static" data-keyboard="false"></i></a>
                </div>
            </div>
        </div>

        <!-- Videos -->
        <div class="table-container">
            <div class="video_menu" id="video_menu">
                <div class="content">
                    <div class="content-row">
                        <button type="button" id="video-add-button" data-toggle="modal" data-target="#video-modal" data-backdrop="static" data-keyboard="false" class="btn btn-primaryy searchbutton"><i class="fas fa-plus"></i> Lesson</button>
                        <input type="seach" class="form-control searchbar" id="input-search" placeholder="Search for lesson">
                    </div>
                    <table id="video-table" class="table dt-responsive nowrap row-border hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th width="40%">Lesson</th>
                                <th width="10%">Subject</th>
                                <th>Date</th>
                                <th class="dipnone">Link</th>
                                <th>Code</th>
                                <th width="0"></th>
                                <th class="table-delete" width="0"></th>
                            </tr>
                        </thead>
                    </table>
                    <div>
                    </div>
                </div>
                <div id="video-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="video-modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered px-3" role="document">
                        <div class="modal-content">
                            <form method="post" id="video-form" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title mx-auto"></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Lesson</label>
                                        <input type="text" name="titles" id="titles" class="form-control" placeholder="Lesson" autocomplete="off" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Subject</label>
                                        <select class="form-control subjects-select" id="subjects-select" style="border: 1px solid rgb(196, 196, 196);" required>
                                            <option selected disabled value="" style="display:none; color:#81898f;">Select a
                                                subject</option>
                                            <?php
                                            $query = $conn->prepare("SELECT * FROM classsubject WHERE subjectcode = :subjectcode");
                                            $result  =  $query->execute([':subjectcode' => $fetch_classcode]);
                                            if ($result) {
                                                if ($query->rowCount() > 0) {
                                                    while ($row = $query->fetch(PDO::FETCH_BOTH)) {
                                            ?>
                                                        <option><?php echo $row['subjects']; ?></option>
                                            <?php
                                                    }
                                                } else {
                                                    echo "Add a Subject.";
                                                }
                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" name="subjects" id="subjects" class="form-control" placeholder="Subject" />
                                    </div>
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="text" id="dates" name="dates" class="form-control" placeholder="Month Date, Year" autocomplete="off" required>
                                    </div>
                                    <div class="form-group pb-1">
                                        <label>Link </label>
                                        <input type="url" name="links" id="links" class="form-control" placeholder="https://" autocomplete="off" required />
                                    </div>
                                    <input type="hidden" name="linkcode" id="linkcode" value="<?php echo $classcode ?>" class="form-control" />
                                    <div class="modal-footerr text-right">
                                        <input type="hidden" name="video_id" id="video_id" />
                                        <input type="hidden" name="video-operation" id="video-operation" />
                                        <input type="submit" name="video-action" id="video-action" class="btn btn-primaryy" value="Add" />
                                        <button type="button" class="btn btn-dangerr" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subject -->
            <div class="subject_menu" id="subject_menu">
                <div class="content">
                    <div class="content-row">
                        <button type="button" id="subject-add-button" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#subject-modal" class="btn btn-primaryy my-0  ">
                            <i class="fas fa-plus"></i> Subject</button>
                        <input type="seach" class="form-control searchbarh" id="input-search" placeholder="Search for Lesson">
                    </div>
                    <table id="subject-table" class="table dt-responsive nowrap row-border hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Code</th>
                                <th></th>
                                <th width="0%"></th>
                            </tr>
                        </thead>
                    </table>
                    <div>
                    </div>
                </div>
                <div id="subject-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="subject-modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered px-3">
                        <div class="modal-content">
                            <form method="post" id="subject-form" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title mx-auto"></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group pb-1">
                                        <label>Subject</label>
                                        <input type="text" name="subjects" id="subjects" placeholder="Subject" class="form-control" autocomplete="off" />
                                        <input type="hidden" name="subjectcode" id="subjectcode" value="<?php echo $classcode ?>" class="form-control" />
                                    </div>
                                    <div class="modal-footerr text-right">
                                        <input type="hidden" name="subject_id" id="subject_id" />
                                        <input type="hidden" name="subject-operation" id="subject-operation" />
                                        <input type="submit" name="subject-action" id="subject-action" class="btn btn-primaryy" value="Add" />
                                        <button type="button" class="btn btn-dangerr" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Code Modal -->
        <div class="name-modal">
            <div class="modal fade" id="change_code_modal" tabindex="-1" role="dialog" aria-labelledby="change_code_modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-min px-3" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mx-auto">Change Name</h5>
                        </div>
                        <form action="admin.php" method="post" class="m-0 p-0">
                            <div class="modal-body text-center">
                                <div class="form-group p-0 m-0">
                                    <input type="hidden" value="<?php echo $fetch['id']  ?>" name="id">
                                    <input type="hidden" value="<?php echo $classcode ?>" name="classcode">
                                    <input class="form-control" type="text" name="change-name" required value="<?php echo $fetch['classname']  ?>">
                                </div>
                                <div class="modal-footerr text-right pt-3">
                                    <input type="submit" class="btn btn-primaryy" name="check-name" value="Change">
                                    <input type="button" class="btn btn-dangerr" data-dismiss="modal" value="Close">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Image Modal -->
        <div class="upload-modal">
            <div class="modal fade" id="upload-image-modal" tabindex="-1" role="dialog" aria-labelledby="upload-image-modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered px-3" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mx-auto">Select Image File</h5>
                        </div>
                        <div class="modal-body ">
                            <?php
                            if (isset($_SESSION['info-image'])) {
                            ?>
                                <div class="alert alert-success text-center">
                                    <?php echo $_SESSION['info-image']; ?>
                                </div>
                            <?php
                            }
                            ?>
                            <?php
                            if (count($errors) > 0) {
                            ?>
                                <div class="alert alert-danger text-center ">
                                    <style type="text/css">
                                        .alert-success {
                                            display: none;
                                        }
                                    </style>
                                    <?php
                                    foreach ($errors as $showerror) {
                                        echo $showerror;
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            unset($_SESSION["info-image"])
                            ?>
                            <!--  <div class="label-notes-in">Please use a png image less than 100kb (Image will automatically fit) -->
                            <form id="deleteForm" action="admin" method="post" enctype="multipart/form-data">
                            </form>
                            <form action="admin" method="post" enctype="multipart/form-data">
                                <input type="file" id="image" name="image" style="display: none;" onchange="document.getElementById('image-preview').src = window.URL.createObjectURL(this.files[0])">
                                <div class="imageContainer">
                                    <div class="imageCenterer">
                                        <img id="image-preview" />
                                    </div>
                                </div>
                                <div class="in-image">
                                    <input type="button" class=" browse btn btn-primaryy mx-1" id="browse" value="Browse" onclick="document.getElementById('image').click();" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Select a PNG file that is smaller than 4 MB" />
                                    <button type="submit" class="btn btn-primaryy btn-icon mr-2" name="upload-image" id="btn" value="Upload"> <i class="fas fa-upload"></i> </button>
                                </div>
                        </div>
                        <div class="modal-footerr  modal-footerr-image text-right ">
                            <input type="submit" form="deleteForm" class="btn btn-primaryy" name="remove-image" value="Remove" onclick="return confirm('Are you sure?');">
                            <input type="button" class="btn btn-dangerr" data-dismiss="modal" value="Close">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include "php/footer.php" ?>
    </div>

    <!-- Datatable -->
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

    <!-- Date Picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
    <script src="js/admin.js" defer></script>
    <script>
        /* keeps modal open */
        var message;
        if (message == "error") {
            $('#upload-image-modal').modal("show");
        }
    </script>

</body>

</html>