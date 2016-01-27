<?php

/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 27/04/15
 * Time: 12:41
 */
include_once('../controller/BaseController.php');

class ImageController extends BaseController
{
    public function addImage($user, $image)
    {
        $image_parse = htmlspecialchars($image);
        $user_parse = htmlspecialchars($user);
        $mainColor = $this->getMainColour('../uploads/' . $image_parse);

        if (!$this->checkImageExist($image_parse)) {
            try {
                $query = $this->connection->prepare('INSERT INTO images (user, path, last_edit, majorColor) VALUES (:user,:path,NOW(), :mainColor)');
                $query->bindParam(':user', $user_parse);
                $query->bindParam(':path', $image_parse);
                $query->bindParam(':mainColor', $mainColor);

                $query->execute();
                return true;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        return false;
    }

    function getMainColour($filename, $as_hex_string = true)
    {
        try {
            // Read image file with Image Magick
            $image = new Imagick($filename);
            // Scale down to 1x1 pixel to make Imagick do the average
            $image->scaleimage(1, 1);
            /** @var ImagickPixel $pixel */
            if (!$pixels = $image->getImageHistogram()) {
                return null;
            }
        } catch (ImagickException $e) {
            // Image Magick Error!
            echo $e->getMessage();
            return null;
        } catch (Exception $e) {
            // Unknown Error!
            echo $e->getMessage();
            return null;
        }

        $pixel = reset($pixels);
        $rgb = $pixel->getColor();

        if ($as_hex_string) {
            return sprintf('%02X%02X%02X', $rgb['r'], $rgb['g'], $rgb['b']);
        }

        return $rgb;
    }

    public function checkImageExist($image)
    {
        $path = htmlspecialchars($image);
        try {
            $query = $this->connection->prepare('SELECT * FROM images WHERE path=:path');
            $query->bindParam(':path', $path);
            $query->execute();
            return ($query->rowCount() > 0);
        } catch (Exception $e) {
            return false;
        }
    }

    public function listImage($user)
    {
        $input_user = htmlspecialchars($user);

        try {
            $query = $this->connection->prepare("SELECT * FROM images WHERE user=:user");
            $query->bindParam(':user', $input_user);
            $query->execute();
            $stack = array();

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                array_push($stack, $row['path']);
            }
            return $stack;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteImage($user, $image_path)
    {
        $input_user = htmlspecialchars($user);
        $input_image_path = htmlspecialchars($image_path);
        try {
            $query = $this->connection->prepare('DELETE FROM images WHERE user=:user AND path=:path');
            $query->bindParam(':user', $input_user);
            $query->bindParam(':path', $input_image_path);
            $query->execute();
            unlink("../uploads/" . $input_image_path);
        } catch (Exception $e) {
            $e->getMessage();
        }

    }

    function compareWithOtherImages($rgb)
    {

        try {
            $query = $this->connection->prepare("SELECT * FROM images");
            $query->execute();
            $stack = array();

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $difference = self::colorDiff($rgb, $row['majorColor']);
                array_push($stack, array($row['user'], $row['last_edit'], $row['majorColor'], $difference, $row['path']));
            }

            function mysort($a, $b)
            {
                return $a[3] - $b[3];
            }

            usort($stack, 'mysort');
            return $stack;
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    function colorDiff($rgb1, $rgb2)
    {
        // do the math on each tuple
        // could use bitwise operates more efficiently but just do strings for now.
        $r1 = hexdec(substr($rgb1, 0, 2));
        $g1 = hexdec(substr($rgb1, 2, 2));
        $b1 = hexdec(substr($rgb1, 4, 2));

        $r2 = hexdec(substr($rgb2, 0, 2));
        $g2 = hexdec(substr($rgb2, 2, 2));
        $b2 = hexdec(substr($rgb2, 4, 2));

        return abs($r1 - $r2) + abs($g1 - $g2) + abs($b1 - $b2);
    }

    public function contrastImage($contrast, $imagePath)
    {

        $image = new Imagick();
        $image->readImage('../uploads/' . $imagePath);

        if ($contrast == true)
            $image->contrastImage(1);
        else {
                $image->contrastImage(0);
        }
        $image->writeImage('../uploads/' . $imagePath);
    }

    public function brightnessImage($brightness, $imagePath)
    {
        $image = new Imagick();
        $image->readImage('../uploads/' . $imagePath);

        if ($brightness == false)
            $image->modulateImage(90, 100, 100);
        else {
            $image->modulateImage(110, 100, 100);
        }
        $image->writeImage('../uploads/' . $imagePath);
    }

    function sepiaImage($imagePath) {
        $image = new Imagick();
        $image->readImage('../uploads/' . $imagePath);

        $image->sepiaToneImage(80);
        $image->writeImage('../uploads/' . $imagePath);
    }

    function grayImage($imagePath) {
        $image = new Imagick();
        $image->readImage('../uploads/' . $imagePath);

        $image->setImageColorspace(2);
        $image->writeImage('../uploads/' . $imagePath);
    }

    function gaussianImage($imagePath)
    {
        $image = new Imagick();
        $image->readImage('../uploads/' . $imagePath);

        $image->gaussianBlurImage(1, 2);
        $image->writeImage('../uploads/' . $imagePath);
    }

    function countourImage($imagePath)
    {
        $image = new Imagick();
        $image->readImage('../uploads/' . $imagePath);

        $image->reduceNoiseImage(2);
        $image->writeImage('../uploads/' . $imagePath);
    }
}

;
?>