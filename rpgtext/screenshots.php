<?php
#!/usr/local/bin/php
require_once 'MaiN/www.main.php';
require_once 'MaiN/site.header.php';

$shot_dir = 'images/screenshots';
$files=array();
if ($handle = opendir($shot_dir)) {
while (false !== ($file = readdir($handle))) {
if (preg_match("/.*?\.jpg$/",$file)) {
$files[]=$file;
}
}
closedir($handle);
}


if(!empty($files)){
sort($files);
foreach ($files as $val){
print '<img src="'.$shot_dir.'/'.$val.'" border=0><br>';
}
}

require_once 'MaiN/site.footer.php';
?>