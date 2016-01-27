<?php
include_once('../controller/UserController.php');
$reg = new UserController();

$error = "OK";
$user_created = false;
if (isset($_POST["login"]) && isset($_POST["pass"])) {
    $error = $reg->createUser($_POST["login"], $_POST["pass"]);
    if ($error == "OK")
        $user_created = true;
}


echo '<div id="login">
        <h1>Registration</h1>';

if (!$user_created && !isset($_SESSION["user"])) {

    echo '<form name="registration" method="post" action="layout.php?selected=register">
          <input type="text" placeholder="Login" name="login"/>
          <input type="password" placeholder="Password" name="pass"/>';

    if ($error != "OK") {

        echo '<div class="alert alert-danger" role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>'
              . $error .
              '</div>';
    }
    echo '
        <input type="submit" value="Register"/>
    </form>';
}
else
{
    echo '<div class="alert alert-success" role="alert"> <b>Registration success !</b></br> Welcome ' . $_SESSION["user"] . '</div>';
}
echo '</div>';
