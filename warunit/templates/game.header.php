<?php
#!/usr/local/bin/php
require_once 'admin/array.races.php';
if(!empty($_GET['sid']) and empty($sid)){$sid=$_GET['sid'];}
if(!empty($_POST['sid']) and empty($sid)){$sid=$_POST['sid'];}
if(empty($sid)){$sid='';}
$link=mysqli_connect($db_host, $db_user, $db_password) or die('Server down please come back later.');
mysqli_select_db($db_main, $link) or die('Server down please come back later.');

if(!empty($sid)){

if($result=mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE sid='$sid' LIMIT 1")){
if($row=mysqli_fetch_object($result)){
mysqli_free_result($result);

$update_it="timer=$current_time";
}
}
}

header("Expires: Mon,1 Jan 2001 01:01:01 GMT");
header("Last-modified: ".gmdate("D, d M Y H:i:s") ." GMT");
header("Cache-Control: no-store,no-cache,must-revalidate");
header("Cache-Control: post-check=0,pre-check=0",false);
header("Pragma: no-cache");
?><!--warunit.com started on 5-5-2005 13:41-->
<html>
<head>
<title>Warunit - <?php print $row->sex.' '.$row->charname;?></title>
<style type="text/css"><!--
body {
	margin:0;
	color:#FFFFFF;
	background:#000000;
	font-family:Verdana,Monaco,Arial;
border:none;}
a{color:#FFFFFF;
	text-decoration:none;
	margin:1;}
a:hover{color:#FF0000;}
th{background:#222222;}

.menu {background:#222222;}
.nav {
		width:100%;
	background:#333333;
}
--></style>
</head>
<body><center><table width=100%><tr><td valign=top align=center class=menu width=100>

<?php
if(empty($row->sid)){$row->sid='checkthisout';}
if ($sid == $row->sid and empty($_GET['logout'])) {
?>

<a href="main.php?sid=<?echo $sid;?>" class=nav>Main</a><br>
<a href="buildings.php?sid=<?echo $sid;?>" class=nav>Buildings</a><br>
<a href="population.php?sid=<?echo $sid;?>" class=nav>Population</a><br>
<a href="science.php?sid=<?echo $sid;?>" class=nav>Science</a><br>
<br>
<a href="clans.php?sid=<?echo $sid;?>" class=nav>Clans</a><br>
<a href="war.php?sid=<?echo $sid;?>" class=nav>War</a><br>
<a href="special.php?sid=<?echo $sid;?>" class=nav>Special</a><br>
<a href="transfer.php?sid=<?echo $sid;?>" class=nav>Transfer</a><br>
<a href="chat.php?sid=<?echo $sid;?>" class=nav>Chat</a><br>
<br>
<a href="ladder.php?sid=<?echo $sid;?>" class=nav>Ladder</a><br>
<a href="support.php?sid=<?echo $sid;?>" style="color:#0000FF;" class=nav>Support</a><br>
<a href="logout.php?sid=<?echo $sid;?>&logout=1" style="color:#FFF888;" class=nav>Logout</a><br>
<a href="help.php?sid=<?echo $sid;?>" class=nav>Help</a><br>
</td><td valign=top>
<?php
 //game updater
if($upresult = mysqli_query ($link, "SELECT * FROM `$tbl_updater` WHERE id='1' LIMIT 1")){
if($uprow = mysqli_fetch_object ($upresult)){
mysqli_free_result ($upresult);

			//UPDATING GAME BY RACES
if ($current_hour <> $uprow->hour) {
//if(isset($sid)){
mysqli_query ($link, "UPDATE `$tbl_updater` SET `hour`='$current_hour'") or die(mysqli_error());
//Human, Dragon, Undead, Halfling, Reptiles

mysqli_query ($link, "UPDATE LOW_PRIORITY `$tbl_members` SET `land`=`land`+10, `gold`=`gold`+((((`land`)+(b1*50)+(u1*25))/100)*(100+".$races_array['Human'][0]."))-(u1+u2+u3+u4+(u5*3)), `stealth`=`stealth`+25 WHERE `race`='Human' and `rank`<127") or die(mysqli_error());

mysqli_query ($link, "UPDATE LOW_PRIORITY `$tbl_members` SET `land`=`land`+10, `gold`=`gold`+((((`land`)+(b1*50)+(u1*25))/100)*(100+".$races_array['Dragon'][0]."))-(u1+u2+u3+u4+(u5*3)), `stealth`=`stealth`+25 WHERE `race`='Dragon' and `rank`<127") or die(mysqli_error());

mysqli_query ($link, "UPDATE LOW_PRIORITY `$tbl_members` SET `land`=`land`+10, `gold`=`gold`+((((`land`)+(b1*50)+(u1*25))/100)*(100+".$races_array['Undead'][0]."))-(u1+u2+u3+u4+(u5*3)), `stealth`=`stealth`+25 WHERE `race`='Undead' and `rank`<127") or die(mysqli_error());

mysqli_query ($link, "UPDATE LOW_PRIORITY `$tbl_members` SET `land`=`land`+10, `gold`=`gold`+((((`land`)+(b1*50)+(u1*25))/100)*(100+".$races_array['Halfling'][0]."))-(u1+u2+u3+u4+(u5*3)), `stealth`=`stealth`+25 WHERE `race`='Halfling' and `rank`<127") or die(mysqli_error());

mysqli_query ($link, "UPDATE LOW_PRIORITY `$tbl_members` SET `land`=`land`+10, `gold`=`gold`+((((`land`)+(b1*50)+(u1*25))/100)*(100+".$races_array['Reptiles'][0]."))-(u1+u2+u3+u4+(u5*3)), `stealth`=`stealth`+25 WHERE `race`='Reptiles' and `rank`<127") or die(mysqli_error());

//FREEPLAY
mysqli_query ($link, "UPDATE LOW_PRIORITY `$tbl_members` SET `gold`=`gold`+((`land`)+(b1*50)+(u1*25))-(u1+u2+u3+u4+(u5*3)), `stealth`=`stealth`+1 WHERE `sex`!='Private' and `rank`<127") or die(mysqli_error());

// FREEPLAY

}
			//UPDATING GAME BY RACES

}else{$uprow->hour=$current_hour;
mysqli_query ($link, "INSERT INTO `$tbl_updater` ($fld_updater) values ('','$current_hour','0','')");
}
}
 //game updater

//BUGS
mysqli_query ($link, "UPDATE LOW_PRIORITY `$tbl_members` SET `stealth`=10000 WHERE `stealth`>10000 LIMIT 5000") or die(mysqli_error());
mysqli_query ($link, "UPDATE LOW_PRIORITY `$tbl_members` SET `gold`=0 WHERE `gold`<0 LIMIT 5000") or die(mysqli_error());
//BUGS

?><table width=100% cellpadding=0 cellspacing=1 border=0><tr><th><?php
print ($row->clan)?'['.$row->clan.']':'';
print $row->sex.' '.$row->charname.'</th><th>Stealth: '.number_format($row->stealth).'</th><th>Tax: 00:'.number_format(60-$current_minute).'</th><th>Gold: $'.number_format($row->gold);?></th></tr></table><?php

$total_land = $row->b1+$row->b2+$row->b3+$row->b4+$row->b5;

if($row->rank == 127){
?><b><font size=+2 color=red>Sorry you have been killed on the battlefields.<br>You are dead!<br>You have given a new chance by the war gods.</font></b><?php
mysqli_query ($link, "UPDATE LOW_PRIORITY `$tbl_members` SET `rank`=100,`land`=`land`+100 WHERE `sid`='$sid' and `rank`>=127") or die(mysqli_error());
}

$special_bonus = 0;
if ($row->sex == 'General') {
$races_array[$row->race][1]+=25;
$races_array[$row->race][2]+=25;
$special_bonus=25;
}elseif ($row->sex == 'Brigadier') {
$races_array[$row->race][1]+=20;
$races_array[$row->race][2]+=20;
$special_bonus=20;
}elseif ($row->sex == 'Colonel') {
$races_array[$row->race][1]+=15;
$races_array[$row->race][2]+=15;
$special_bonus=15;
}elseif ($row->sex == 'Major') {
$races_array[$row->race][1]+=10;
$races_array[$row->race][2]+=10;
$special_bonus=10;
}elseif ($row->sex == 'Captain') {
$races_array[$row->race][1]+=5;
$races_array[$row->race][2]+=5;
$special_bonus=5;
}elseif ($row->sex == 'Lieutenant') {
$races_array[$row->race][1]+=3;
$races_array[$row->race][2]+=3;
$special_bonus=3;
}

$science = ($row->s1+$row->s2+$row->s3+$row->s4+$row->s5)/1.5;
$science_devider = ($science/100)+($total_land/100);

}else{
header("Location: $root_url");
exit;
}
?>
<table width=100% cellpadding=0 cellspacing=1 border=0><tr><td align=center valign=top>
<?php
if (empty($sid) or $sid !== $row->sid) {
print 'Looking for something?<br>Please Signup or login to play the game!';
include_once 'templates/template.footer.php';
exit;
}

if ($row->race == 'Private') {
if (!empty($_POST['race'])) {
$races_keys=array_keys($races_array);
$race=$_POST['race'];
if(in_array($race, $races_keys)) {
	$update_it .= ",`race`='$race'";
	$row->race = $race;
	print $race;
}else{
print 'You are FUCKED!';
exit;
}
}else{
	print 'Please choose your race for a new round warunit...';
$options='';
$snapnie='';
foreach ($races_array as $key=>$val){
$options .= '<option>'.$key.'</option>';
$snapnie .= $key.'+'.$val[0].'% income, '.'+'.$val[1].'% offense, '.'+'.$val[2].'% defense<br>';
}

?><form method=post><table>
<tr>
<td width=50%>
Race<br><font size=-2>
<?php print $snapnie;?></font>
</td>
<td>
<select name=race>
<?php print $options;?>
</select>
</td>
<td><input type=submit value="Select this race"></td>
</tr>
</table></form><?php
	include_once 'templates/game.footer.php';
exit;
}
}
?><!--HEADER-->