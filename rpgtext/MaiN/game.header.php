<?php
#!/usr/local/bin/php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?><html>
<head>
<title></title>

<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.3)">
<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.3)">

<style type="text/css">
<!--
body, table, tr, th, td, form, a, b {
	font-family:Arial,Verdana,Monaco;
	border : thin none inherit;
	border-color:#AAAAAA;
	margin:0;
}
body{
	background:<?php print $colbg;?>;
	color:<?php print $coltext;?>;
}
th{
	background:<?php print $colth;?>;
}
a{
	text-decoration: none;
	color:<?php print $collink;?>;
}
input, select, textarea {
	width:100%;
	margin:0;
}
hr {
	color:<?php print $colth;?>;
	height:1;
	size:1;
	border : none;
	margin:0;
}
-->
</style>

</head>
<body><center><?php

if (!empty($_COOKIE['username'])){
$username = clean_post($_COOKIE['username']);
}
if (!empty($_COOKIE['password'])){
$password = clean_post($_COOKIE['password']);
}
if (!empty($_POST['username'])){
$username = clean_post($_POST['username']);
}
if (!empty($_POST['password'])){
$password = clean_post($_POST['password']);
}

if(empty($username) or empty($password)){
die_nice('Please login, relogin, signup or resignup or whatever dude!');
}


$link = mysqli_connect($db_host, $db_user, $db_password) or die_nice(mysqli_error());
mysqli_select_db($db_main, $link) or die_nice(mysqli_error());

//MEMBER ROW
if($result = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE `username`='$username' ORDER BY `id` DESC LIMIT 1")){
if($row = mysqli_fetch_object ($result)){
mysqli_free_result ($result);

$cpassword=crypt($password,$username);
if($username == $row->username and $cpassword == $row->password) {


	//JAIL
if($row->jail>=$current_time){
?><hr><b>You have been jailed for violating the rules!<br> Sit back and relax your game will continue automatically in <?php print number_format($row->jail-$current_time);?> seconds!
<meta http-equiv="refresh" content="<?php print ($row->jail-$current_time)+5;?>"></b><hr></center></body></html><?php
exit;
}
	//JAIL

$to_update = "`timer`='$current_time'";

if (empty($array_classes[$row->class])){$row->class='knight';}

//$row->level=100;
$total_stats=total_stats(); // array attributes
total_skills(); // battleskill magicskill defenseskill
$total_charmed=total_charms();//charms up

$freeplay=$row->freeplay-$current_time;
if($freeplay<0){$freeplay=0;}

//MAXIMUS
$max_gold *= $row->level;

$max_life *= (1+($row->level/2))*$array_classes[$row->class][7];
$total_stats[1] >= 1 ? $max_life += $total_stats[1]:'';
$max_life = round(($max_life/100)*(100+$total_stats[26]+$total_charmed[0]));

if ($freeplay >= 1){$max_life += 100000;}

$max_mana *= (1+($row->level/2))*$array_classes[$row->class][8];
$total_stats[2] >= 1 ? $max_mana += $total_stats[2]:'';
$max_mana = round(($max_mana/100)*(100+$total_stats[27]+$total_charmed[1]));

$max_stamina *= (1+($row->level/2))*$array_classes[$row->class][9];
$total_stats[3] >= 1 ? $max_stamina += $total_stats[3]:'';
$max_stamina = round(($max_stamina/100)*(100+$total_stats[28]+$total_charmed[2]));

if($row->gold > $max_gold){
$row->gold = $max_gold;
$to_update .= ", `gold`='$row->gold'";
}
if($row->life > $max_life){
if($row->life >= 1){$row->life = $max_life;$to_update .= ", `life`='$max_life'";}
}
if($row->mana > $max_mana){
if($row->mana >= 1){$row->mana = $max_mana;$to_update .= ", `mana`='$max_mana'";}
}
if($row->stamina > $max_stamina){
if($row->stamina >= 1){$row->stamina = $max_stamina;$to_update .= ", `stamina`='$max_stamina'";}
}

if($row->honor > $max_honor){
$row->honor = $max_honor;
$to_update .= ", `honor`='$max_honor'";
}
//MAXIMUS

//USAGE
$use_battle *= $row->level;
$use_skill *= $row->level;
$max_skills = $row->level/$max_skills;
$max_exp_gain = 1+($row->level*$row->level)*$max_exp_gain;
//USAGE

if (empty($_COOKIE['username'])){
setcookie ("username", "$username",$current_time+84600*7) or die_nice('Cookie set failure!');
}if (empty($_COOKIE['password'])){
setcookie ("password", "$password",$current_time+84600*7) or die_nice('Cookie set failure!');
}
}else{die_nice('Password mismatch');}//password
}else{die_nice('Sorry error code 101<br>This account does not exist anymore or was not found.<br>Please check your spelling and try again the username and passwords are case sensitive!');}//password
}else{die_nice('Sorry error code 102');}//password
//MEMBER ROW

//DEAD MAN WALKING
if($row->life <= 0){
$to_output .= 'You are dead! Go find the nearest healer or drink a life potion.<br>';

$row->class = 'ghost';

}
//DEAD MAN WALKING

//INVENTORY ITEMS
if($iresult = mysqli_query ($link, "SELECT `id` FROM `$tbl_inventory` WHERE `charname`='$row->charname' ORDER BY `id` DESC LIMIT 50")){
if($inventory_items=mysqli_num_rows($iresult)){
mysqli_free_result ($iresult);
}
}
//INVENTORY ITEMS
//CHARMS ITEMS
if($chresult = mysqli_query ($link, "SELECT `id` FROM `$tbl_charms` WHERE `charname`='$row->charname' ORDER BY `id` DESC LIMIT 50")){
if($charms_items=mysqli_num_rows($chresult)){
mysqli_free_result ($chresult);
}
}
//CHARMS ITEMS

//LOL3 level up easy begin hard at the end
//$next_level = ($row->level*$row->level*$row->level*($row->level/10))+249;
//LOL1 level up normal
$next_level = next_level($row->level);
$prev_level = prev_level($row->level);
				// width=800
?><table cellpadding=0 cellspacing=1 border=0 align=center><tr><td valign=top width=300>