<?php
include('../controller/ImageController.php');
$upload = new ImageController();

if (isset($_FILES["fileToUpload"]) && isset($_SESSION["user"])) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . $_SESSION["user"]. '-' . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    $error = "";
    if (isset($_POST["submit"]) && isset($_POST["fileToUpload"]["tmp_name"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check != false) {
            $uploadOk = 1;
        } else {
            $error = "File is not an image.";
            $uploadOk = 0;
        }
    }

    if ($error == "" && file_exists($target_file)) {
        $error = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if ($error == "" && $_FILES["fileToUpload"]["size"] > 1000000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if ($error == "" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"
    ) {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($error == "" && $upload->checkImageExist($target_file))
    {
        $error = "Image with same name exist";
        $uploadOk = 0;
    }

    if ($error == "" && $uploadOk)
    {
        $moved_ok = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        if ($moved_ok) {
                $thumb = new Imagick();
                $thumb->readImage($target_file);
                $thumb->resizeImage(420, 420, imagick::FILTER_LANCZOS, 0.9, false);
                $save_file = str_replace("../uploads/", "", $target_file);
                $thumb->writeImage($target_file);

                $error = "The file has been uploaded.";
                $upload->addImage($_SESSION["user"], $save_file);
        }
    }
}
?>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Upload Files</strong></div>
        <div class="panel-body">
            <?php
            if (isset($_FILES["fileToUpload"]) && $uploadOk) {
                echo '<div class="alert alert-success" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                            ' . $error . '
                      </div>';
            } else if (isset($_FILES["fileToUpload"])) {
                echo '<div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                            ' . $error . '
                      </div>';
            }
            ?>
            <!-- Standar Form -->
            <h4>Select images from your computer</h4>

            <form action="layout.php?selected=Upload" method="post" enctype="multipart/form-data">
                <div class="form-inline">
                    <div class="form-group">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Image" name="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> <!-- /container -->
<!--
<form action="Upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>-->