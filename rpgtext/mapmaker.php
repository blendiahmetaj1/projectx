<?php
exit;
$base_dir = 'images/maps';
if(!empty($_GET['split'])){

$file = '/'.$_GET['split'];
$save_dir = preg_replace("/\..*?$/si","",$file);

$save_dir = $base_dir.'/'.$save_dir.'/';
$file = $base_dir.'/'.$_GET['split'];

if (!file_exists($save_dir)) {
mkdir($save_dir, 0700);
}

if (preg_match("/.*?\.jpg$/",$file)) {
//header('Content-type: image/jpeg') ;
list($width, $height) = getimagesize($file) ;
$tn = imagecreatetruecolor(100, 100) ;
$image = imagecreatefromjpeg($file) ;
imagecopy($tn, $image, 0, 0, 0, 0, $width, $height);
imagejpeg($tn, $save_dir.'c1.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 100, 0, $width, $height);
imagejpeg($tn, $save_dir.'ct.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 200, 0, $width, $height);
imagejpeg($tn, $save_dir.'c2.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 0, 100, $width, $height);
imagejpeg($tn, $save_dir.'cl.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 200, 100, $width, $height);
imagejpeg($tn, $save_dir.'cr.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 100, 100, $width, $height);
imagejpeg($tn, $save_dir.'bg.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 0, 200, $width, $height);
imagejpeg($tn, $save_dir.'c3.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 100, 200, $width, $height);
imagejpeg($tn, $save_dir.'cb.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 200, 200, $width, $height);
imagejpeg($tn, $save_dir.'c4.jpg', 100) ;

imagecopy($tn, $image, 0, 0, 0, 300, $width, $height);
imagejpeg($tn, $save_dir.'a1.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 100, 300, $width, $height);
imagejpeg($tn, $save_dir.'a2.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 200, 300, $width, $height);
imagejpeg($tn, $save_dir.'a3.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 0, 400, $width, $height);
imagejpeg($tn, $save_dir.'a4.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 100, 400, $width, $height);
imagejpeg($tn, $save_dir.'a5.jpg', 100) ;
imagecopy($tn, $image, 0, 0, 200, 400, $width, $height);
imagejpeg($tn, $save_dir.'a6.jpg', 100) ;

if ($handle = opendir($save_dir)) {
	while (false !== ($file = readdir($handle))) {
if (preg_match("/.*?\.jpg$/",$file)) {
print '<img src="'.$save_dir.$file.'">'.$file.' ';
}
}closedir($handle);}

}elseif (preg_match("/.*?\.gif$/",$file)) {
//header('Content-type: image/gif') ;
list($width, $height) = getimagesize($file) ;
$tn = imagecreatetruecolor(100, 100) ;
$image = imagecreatefromgif($file) ;
imagecopy($tn, $image, 0, 0, 0, 0, $width, $height);
imagegif($tn, $save_dir.'c1.gif', 100) ;
imagecopy($tn, $image, 0, 0, 100, 0, $width, $height);
imagegif($tn, $save_dir.'ct.gif', 100) ;
imagecopy($tn, $image, 0, 0, 200, 0, $width, $height);
imagegif($tn, $save_dir.'c2.gif', 100) ;
imagecopy($tn, $image, 0, 0, 0, 100, $width, $height);
imagegif($tn, $save_dir.'cl.gif', 100) ;
imagecopy($tn, $image, 0, 0, 200, 100, $width, $height);
imagegif($tn, $save_dir.'cr.gif', 100) ;
imagecopy($tn, $image, 0, 0, 100, 100, $width, $height);
imagegif($tn, $save_dir.'bg.gif', 100) ;
imagecopy($tn, $image, 0, 0, 0, 200, $width, $height);
imagegif($tn, $save_dir.'c3.gif', 100) ;
imagecopy($tn, $image, 0, 0, 100, 200, $width, $height);
imagegif($tn, $save_dir.'cb.gif', 100) ;
imagecopy($tn, $image, 0, 0, 200, 200, $width, $height);
imagegif($tn, $save_dir.'c4.gif', 100) ;

if ($handle = opendir($save_dir)) {
	while (false !== ($file = readdir($handle))) {
if (preg_match("/.*?\.gif$/",$file)) {
print '<img src="'.$file.'">'.$file.' ';
}
}closedir($handle);}
}

}else{
	//MAPPING
$map_url=$base_dir.'.';

$giffiles=array();$jpgfiles=array();
if ($handle = opendir($map_url)) {
	while (false !== ($file = readdir($handle))) {
if (preg_match("/.*?\.gif$/",$file)) {
	$giffiles[]=$file;}
if (preg_match("/.*?\.jpg$/",$file)) {
	$jpgfiles[]=$file;}
}closedir($handle);}


sort($giffiles);foreach ($giffiles as $val){
print '<a href="?split='.$val.'">'.$val.'</a><br>';
	}
sort($jpgfiles);foreach ($jpgfiles as $val){
print '<a href="?split='.$val.'">'.$val.'</a><br>';
	}

//MAPPING
}
?>