<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 07/05/15
 * Time: 02:11
 */

include_once('../controller/ImageController.php');
$image_controller = new ImageController();

include_once('../controller/UserController.php');
$user_controller = new UserController();

if (isset($_POST['q']))
{
    $path = htmlspecialchars($_POST['q']);

    if (isset($_POST['action']))
    {
        $action = htmlspecialchars($_POST['action']);
        if ($action == "lesscontrast")
            $image_controller->contrastImage(false, $path);
        else if ($action == "morecontrast")
            $image_controller->contrastImage(true, $path);
        else if ($action =="lessluminosity")
            $image_controller->brightnessImage(false, $path);
        else if ($action =="moreluminosity")
            $image_controller->brightnessImage(true, $path);
        else if ($action =="sepia")
            $image_controller->sepiaImage($path);
        else if ($action =="gray")
            $image_controller->grayImage($path);
        else if ($action =="blur")
            $image_controller->gaussianImage($path);
        else if ($action =="noise")
            $image_controller->countourImage($path);
    }

    echo '<a href="layout.php?selected=UserImage" class=""><button type="submit" class="btn btn-danger btn-md" name="action" value="lesscontrast">
                                        <span class="glyphicon glyphicon-th" aria-hidden="true"></span> Back to gallery
                                    </button></a>';
    echo '<div class="row"><form method="post" id="form_force" action="layout.php?selected=Editor">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Contrast</h3>
                                    </div>
                                    <div class="panel-body">
                                        <button type="submit" class="btn btn-success btn-md" name="action" value="lesscontrast">
                                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Contrast
                                        </button>
                                        <button type="submit" class="btn btn-success btn-md" name="action" value="morecontrast">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Contrast
                                        </button>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Brightness</h3>
                                    </div>
                                    <div class="panel-body">
                                        <button type="submit" class="btn btn-success btn-md" name="action" value="lessluminosity">
                                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Brightness
                                        </button>
                                        <button type="submit" class="btn btn-success btn-md" name="action" value="moreluminosity">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Brightness
                                        </button>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Others</h3>
                                    </div>
                                    <div class="panel-body">
                                        <button type="submit" class="btn btn-success btn-md" name="action" value="sepia">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Sepia
                                    </button>
                                    <button type="submit" class="btn btn-success btn-md" name="action" value="gray">
                                        <span class="glyphicon glyphicon-sort" aria-hidden="true"></span> Grayscale
                                    </button>
                                    <button type="submit" class="btn btn-success btn-md" name="action" value="blur">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Blur
                                    </button>
                                    <button type="submit" class="btn btn-success btn-md" name="action" value="noise">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Noise
                                    </button>
                                    </div>
                                </div>



                                    <input type="hidden" name="q" value="' . $path . '"/>
          </form>
            <img style="float:left;" src="../uploads/' . $path . '?' . rand() .'"/>
        </div>';
    /*
    $stack = $image_controller->compareWithOtherImages($colors);

    echo '<h1> Color major near : ' . $_POST['q'] . '</h1>';
    foreach ($stack as &$row)
    {
        echo '<div class="col-lg-3 col-md-4 col-xs-6">
                <div class="thumbnail">
                        <a href="../uploads/' . $row[4] . '">
                            <img class="img-responsive" src="../uploads/' . $row[4] . '"/>
                        </a>
                </div>
          </div>';
        echo "User : " . $row[0] . '</br>' .
             'Last edit : ' . $row[1] . '</br>' .
             'Main color : ' . $row[2] . '</br>' .
             'Difference : ' . $row[3] . '</br>' .
             'Path : ' . $row[4] . '</br>';
    }*/

}
