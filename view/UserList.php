<?php

include_once('../controller/UserController.php');

$user_control = new UserController();
$stack = $user_control->listUsersStack();

if ($stack != null) {
    echo '<div id="login">
    <h1>User List</h1>
    <ul class="list-group">';
    foreach ($stack as $value) {
        echo '<li class="list-group-item"><a href="layout.php?selected=OtherImage&q=' . $value . '">' . $value . '</a></li>';
    }
    echo '</ul></div>';
}

?>

