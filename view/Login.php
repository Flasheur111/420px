<?php
include_once('../controller/UserController.php');
$reg = new UserController();
$error = "OK";
$user_logged = false;
if (isset($_POST["login"]) && isset($_POST["pass"])) {
    $error = $reg->login($_POST["login"], $_POST["pass"]);
    if ($error == "OK")
        $user_logged = true;
}


echo '<div id="login">
        <h1>Login</h1>';

if (!$user_logged && !isset($_SESSION["user"])) {

    echo '<form name="login" method="post" action="layout.php?selected=login">
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
    echo ' <div class="alert alert-success" role="alert"> <b>Login success !</b></br> Welcome ' . $_SESSION["user"] . ' </br>
            <a href="layout.php"><button type="button" class="btn btn-success">Start !</button></a></div>';
}
echo '</div>';
