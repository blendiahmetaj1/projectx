<?php
#!/usr/local/bin/php

if(!empty($_GET['bg']) and !empty($_GET['portal'])) {

/*_______________-=TheSilenT.CoM=-_________________*/

function LoadJpeg($imgname)
{global $mes;
   $im = @imagecreatefromjpeg($imgname); /* Attempt to open */
   if (!$im) { /* See if it failed */
       $im  = imagecreatetruecolor(100, 100); /* Create a black image */
       $bgc = imagecolorallocate($im, 255, 255, 255);
       $tc  = imagecolorallocate($im, 0, 0, 0);
       imagefilledrectangle($im, 0, 0, 100, 100, $bgc);
       imagestring($im, 1, 5, 5, $mes, $tc);
   }
   return $im;
}

/*_______________-=TheSilenT.CoM=-_________________*/

function LoadGif ($imgname)
{global $mes;
   $im = @imagecreatefromgif ($imgname); /* Attempt to open */
   if (!$im) { /* See if it failed */
       $im = imagecreatetruecolor (100, 100); /* Create a blank image */
       $bgc = imagecolorallocate ($im, 255, 255, 255);
       $tc = imagecolorallocate ($im, 0, 0, 0);
       imagefilledrectangle ($im, 0, 0, 100, 100, $bgc);
       imagestring ($im, 1, 5, 5, $mes, $tc);
   }
   return $im;
}

/*_______________-=TheSilenT.CoM=-_________________*/

function watermark($jpegimg, $wmimg, $transparency = 50, $margin = 5) {
$wmx = (bool)rand(0,1) ? $margin : (imagesx($jpegimg) - imagesx($wmimg)) - $margin;
$wmy = (bool)rand(0,1) ? $margin : (imagesy($jpegimg) - imagesy($wmimg)) - $margin;

imagecopymerge($jpegimg, $wmimg, $wmx, $wmy, 0, 0, imagesx($wmimg), imagesy($wmimg), $transparency);
return $jpegimg;
}
/*_______________-=TheSilenT.CoM=-_________________*/

function image_overlap($background, $foreground){
$insertWidth = imagesx($foreground);
$insertHeight = imagesy($foreground);

$imageWidth = imagesx($background);
$imageHeight = imagesy($background);

$overlapX = $imageWidth-$insertWidth-5;
$overlapY = $imageHeight-$insertHeight-5;
imagecolortransparent($foreground,imagecolorat($foreground,0,0));

imagecopymerge($background,$foreground,$overlapX,$overlapY,0,0,$insertWidth,$insertHeight,100);
return $background;
}
$bg=$_GET['bg'];
$portal=$_GET['portal'];
$mes = 'Error dude!';

if(!empty($_GET['mes'])){$mes = $_GET['mes'];}

header("content-type: image/jpeg");
$image = loadjpeg($bg);
$insert = loadgif($portal);

$image = watermark($image, $insert);

//$image = image_overlap($image, $insert);

imagejpeg($image);

/*_______________-=TheSilenT.CoM=-_________________*/

}
?>