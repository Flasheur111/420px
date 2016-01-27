<?php
session_start();
include_once('../controller/UserController.php');

$user_controller = new UserController();
function isLogged()
{
    if (isset($_SESSION["user"]))
        return true;
    else
        return false;
}

function isActive($askActive)
{
    if (isset($_GET["selected"])) {
        $selected = htmlspecialchars($_GET["selected"]);
        if ($selected == $askActive)
            return true;
        else
            return false;
    }
}

function isHome()
{
    return !isset($_GET["selected"]);
}

if (isActive("logout")) {
    unset($_SESSION["user"]);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../scripts/css/site.css">
    <link rel="stylesheet" type="text/css" href="../scripts/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../scripts/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="../scripts/jscolor/jscolor.js"></script>
    <title>420PX</title>

    <?php
    echo '
    <script>
        $(function() {
            var availableTags = [' . $user_controller->listUsers() . '
            ];
            $( "#user-list" ).autocomplete({
                source: availableTags
            });
        });
    </script>'
    ?>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="layout.php">Accueil</a>
        </div>
        <div class="navbar-form navbar-left">
            <a href="layout.php?selected=UserList">
                <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-th-list"></i> User list
                </button>
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div class="col-sm-6 col-md-6">

                <form method="post" class="navbar-form navbar-inverse" role="search"
                      action="layout.php?selected=Colors">
                    <div class="input-group">
                        <input type="text" class=" color form-control" placeholder="Find user images" name="q"
                               id="user-list">

                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li></li>
                <?php if (!isLogged()) {
                    if (isActive("login")) {
                        echo '<li class="active"><a href="layout.php?selected=login">Log in</a></li>
                              <li><a href="layout.php?selected=register">Register</a></li>';
                    } else if (isActive("register")) {
                        echo '<li><a href="layout.php?selected=login">Log in</a></li>
                              <li class="active"><a href="layout.php?selected=register">Register</a></li>';
                    } else {
                        echo '<li><a href="layout.php?selected=login">Log in</a></li>
                              <li><a href="layout.php?selected=register">Register</a></li>';
                    }
                } else {
                    echo
                        '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $_SESSION['user'] . '
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="layout.php?selected=UserImage">List my images</a></li>
                        <li><a href="layout.php?selected=Upload">Upload image</a></li>
                    </ul>
                    </li>';
                    echo '<li><a href="layout.php?selected=logout">Log Out</a></li>';
                }
                ?>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<?php if (isActive("login")) {
    include('Login.php');
} else if (isActive("register")) {
    include('Register.php');
} else if (isActive("UserImage")) {
    include('UserImage.php');
} else if (isActive("Upload")) {
    include('Upload.php');
} else if (isActive("OtherImage")) {
    include('OtherImage.php');
} else if (isActive("UserList")) {
    include('UserList.php');
} else if (isActive("Colors")) {
    include('Colors.php');
} else if (isActive("Editor")) {
    include('Editor.php');
} else {
    include('Home.php');
}
?>


<script src="../scripts/js/bootstrap.min.js"></script>
</body>
</html>