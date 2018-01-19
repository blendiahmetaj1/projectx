<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/array.races.php';
if (isset($_GET['sid'])) {
include_once 'templates/game.header.php';
}else{
include_once 'templates/template.header.php';
$link=mysqli_connect($db_host, $db_user, $db_password) or die('Server down please come back later.');
mysqli_select_db($db_main, $link) or die('Server down please come back later.');
}
print $title_info;

//mysqli_query ($link, "UPDATE `$tbl_members` SET `race`='Private',`sex`='Private',`gold`=1000000,`land`=100, stealth=200,b1=10,b2=10,b3=10,b4=10,b5=10,u1=5,u2=5,u3=5,u4=5,u5=5,s1=1,s2=1,s3=1,s4=1,s5=1,sb1=0,sb2=0,sb3=0,tsb1=0,tsb2=0,tsb3=0 WHERE id") or die(mysqli_error());
?>

<table><tr><th colspan=2>Active players of the past 12 hours</th></tr><tr><td valign=top><font size=-1>
<?php
if($lresult = mysqli_query ($link, "SELECT * FROM $tbl_members WHERE timer>=$current_time-42300 ORDER BY timer DESC LIMIT 1000")){
while ($lrow = mysqli_fetch_object ($lresult)) {
print ($lrow->clan)?'['.$lrow->clan.']':'';
print $lrow->sex.' '.$lrow->charname.', ';
}
mysqli_free_result ($lresult);
}


if($tresult = mysqli_query ($link, "SELECT id FROM $tbl_members WHERE id")){
print number_format(mysqli_num_rows($tresult)).' players signed up, ';
mysqli_free_result ($tresult);
}


if($nresult = mysqli_query ($link, "SELECT * FROM $tbl_members WHERE id ORDER BY id desc LIMIT 1")){
$nrow = mysqli_fetch_object ($nresult);
mysqli_free_result ($nresult);
print ($nrow->clan)?'['.$nrow->clan.']':'';
print $nrow->sex.' '.$nrow->charname.'  is the newest player.';
}


?>
</font></td></tr></table>

<br>
<br>
Every hour you get some acres of land and some stealth points, you decide what is going to happen to the other players, hehe!<br>
<br>
<br>
Things that a player can do in this game are: buildings, population control, science research, war, special attacks, transfer gold and more to come.
<br>
<br>
If you like this game please tell your friends.<br>
<a href="http://www.warunit.com">http://www.warunit.com</a><br>
And don't forget to bookmark :o)...
</b><br>
<?php
if (isset($_GET['sid'])) {
include_once 'templates/game.footer.php';
}else{
mysqli_close($link);
include_once 'templates/template.footer.php';
}
?>