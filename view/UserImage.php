<?php
include('../controller/ImageController.php');
$upload = new ImageController();

/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 27/04/15
 * Time: 01:30
 */

if (isset($_POST["removeImage"]) && isset($_SESSION["user"]))
{
    $path_remove = $_POST["removeImage"];
    $upload->deleteImage($_SESSION["user"], $path_remove);
}

echo '<div class="col-lg-12">
        <h1 class="page-header"> ' . $_SESSION["user"] . '\'s Gallery </h1>
      </div>';

$stack = $upload->listImage($_SESSION["user"]);
foreach ($stack as &$value) {
    echo '<div class="col-lg-3 col-md-4 col-xs-6">
                <div class="thumbnail">
                        <a href="../uploads/' . $value . '">
                            <img class="img-responsive" src="../uploads/' . $value . '?' . rand() .'"/>
                        </a>
                        <div class="section">
                            <form method="post" id="form_force" action="layout.php?selected=Editor">
                                    <button type="submit" class="btn btn-success btn-md" name="q" value="' . $value .'">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                                    </button>
                            </form>
                            <form method="post" id="form_force" action="layout.php?selected=UserImage">
                                    <button type="submit" class="btn btn-danger btn-md" name="removeImage" value="' . $value .'">
                                        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Remove
                                    </button>
                            </form>

                        </div>
                </div>
          </div>';
}
?>