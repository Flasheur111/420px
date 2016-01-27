<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 30/04/15
 * Time: 15:05
 */

include_once('../controller/ImageController.php');
include_once('../controller/UserController.php');

$user = new UserController();
$image = new ImageController();

$lines = file('../dataset/pseudoDataset.txt');
$stack_pseudo = array();
foreach ($lines as $line_num => $line) {
    array_push($stack_pseudo, $line);
}

$lines = file('../dataset/imageDataset.txt');
$stack_image = array();

foreach ($lines as $line_num => $line) {
    array_push($stack_image, $line);
    /*
    $get = substr($line, 0, strlen($line) - 1);
    $imageString = file_get_contents($get);
    $save = file_put_contents('../dataset/image_download/' . basename($get), $imageString);
    */
}

foreach ($stack_pseudo as $pseudo)
{
    $user->createUser(substr($pseudo, 0, strlen($pseudo) - 1), 'testAccount');
}






