<?php
#!/usr/local/bin/php
$search=array("'nigger'i");
$replace=array("");

/*_______________-=TheSilenT.CoM=-_________________*/

function clean_int($in){
$in=preg_replace(array('@,@','@\.@','@\-@','@\+@'),array('','','',''),$in);
if(is_numeric($in) and $in>=1){
return $in;
}else{
return NULL;
}
}

/*_______________-=TheSilenT.CoM=-_________________*/

function clean_post($in){
 global $search,$replace;
$in=preg_replace($search,$replace,$in);
$in=htmlentities("$in",ENT_QUOTES);
$in=strip_tags($in);
$in=trim($in);
$in=addslashes($in);
return $in;
}

/*_______________-=TheSilenT.CoM=-_________________*/

function clean_input($in){
 global $search,$replace;
$in=preg_replace($search,$replace,$in);
$in=strip_tags($in);
$in=trim($in);
$in=addslashes($in);
if(ctype_alnum($in) and strlen($in)>=4){
return $in;
}else{
$in=NULL; return $in;
}
}

/*_______________-=TheSilenT.CoM=-_________________*/

function dater($secs){
global $current_time;
$s="";
if ($current_time-$secs < 0){
$secs=round($secs-$current_time,2);
}else{
$secs=round($current_time-$secs,2);
}
if($secs>= 86400*30){
$n=(int)($secs/(86400*30));$s=$n." month".($n>1?"s":"");$secs %= (86400*30);
}elseif($secs>= 86400*7){
$n=(int)($secs/(86400*7));$s=$n." week".($n>1?"s":"");$secs %= (86400*7);
}elseif($secs>= 86400){
$n=(int)($secs/86400);$s=$n." day".($n>1?"s":"");$secs %= 86400;
}elseif($secs>= 3600){
$n=(int)($secs/3600);$s .= " ".$n." hour".($n>1?"s":"");$secs %= 3600;
}elseif($secs>= 60){
$n=(int)($secs/60);$s .= " ".$n." minute".($n>1?"s":"");$secs %= 60;
}elseif($secs){
$s .= " ".$secs." second".($secs>1?"s":"");
}else{
$s='0 seconds';
}
return trim($s);
}

/*_______________-=TheSilenT.CoM=-_________________*/

$emotions_url = 'http://www.lordsoflords.com/images/emotions';
function chatit($in) {
	global $emotions,$emotions_url;
$hi=array (
'@\[img\](http:\/\/.*?)\[/img\]@si',
'@\[c=(.*?)\](.*?)\[/c\]@si',
);

$ha=array (
'<img src="\1" width="16" height="16">',
'<font color="\1">\2</font>',
);
$in=preg_replace($hi, $ha, $in);

if(preg_match("/\[.*?\]/i",$in)){
foreach($emotions as $face){
if(in_array($face,$emotions)){
$face=strtolower($face);
$in=preg_replace("'\[$face\]'i","<img src=\"$emotions_url/$face.gif\" border=\"0\">",$in);
}}}

return stripslashes($in);
}
?>