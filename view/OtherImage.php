<?php
include_once('../controller/ImageController.php');
$upload = new ImageController();

include_once('../controller/UserController.php');
$reg = new UserController();

include_once('../controller/RssController.php');
$rss = new RssController();
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 27/04/15
 * Time: 01:30
 */

$value = "";

if (isset($_POST["q"]))
    $value = htmlspecialchars($_POST["q"]);
else if (isset($_GET["q"]))
    $value = htmlspecialchars($_GET["q"]);

if ($value != "" && $reg->checkUserExist($value)) {
    $xml_file = new DOMDocument("1.0");
    $channel = $rss->init_news_rss($xml_file, $value);

    $stack = $upload->listImage($value);
    $id = 0;
    foreach ($stack as &$img) {
        $rss->addItem($xml_file, $channel, $id, $value, $img);
        $id++;
    }
    $xml_file->save('../feeds/' . $value . '.xml');
    echo '<div id="login"><h1 class="page-header"> ' . $value . '\'s Gallery <a href="../feeds/' . $value . '.xml"><img src="../scripts/image/feed-icon-28x28.png"/></a></h1>
</div>';

    echo '<div class="col-lg-12">

      </div>';

    foreach ($stack as &$img) {
        echo '<div class="col-lg-3 col-md-4 col-xs-6">
                <div class="thumbnail">
                        <a href="../uploads/' . $img . '">
                            <img class="img-responsive" src="../uploads/' . $img . '"/>
                        </a>
                </div>
          </div>';
    }
} else if (isset($_POST['q'])) {
    echo '<div id="login"><h1>Error</h1><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
  User ' . htmlspecialchars($_POST['q']) . ' doesn\'t exist
</div></div></div>';
}
?>