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
    $colors = htmlspecialchars($_POST['q']);
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
        /*echo "User : " . $row[0] . '</br>' .
             'Last edit : ' . $row[1] . '</br>' .
             'Main color : ' . $row[2] . '</br>' .
             'Difference : ' . $row[3] . '</br>' .
             'Path : ' . $row[4] . '</br>';*/
    }

}
