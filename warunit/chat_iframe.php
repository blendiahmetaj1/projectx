<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.functions.php';
require_once 'admin/array.emotions.php';

$chat_timer=10;

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
<body><center><?php


if (!empty($_POST['message'])){
	$message=clean_post($_POST['message']);
mysqli_query ($link, "INSERT INTO `$tbl_board` ($fld_board) VALUES(NULL,0,'$row->clan','$row->sex','$row->charname','$row->race',".(($row->stealth+$row->b1+$row->b2+$row->b3+$row->b4+$row->b5+$row->u1+$row->u2+$row->u3+$row->u4+$row->u5+$row->s1+$row->s2+$row->s3+$row->s4+$row->s5)/1000000).",'$message','$ip','$current_time')") or die(mysqli_error());
}

if($cresult=mysqli_query ($link, "SELECT * FROM `$tbl_board` WHERE `id` ORDER BY `id` DESC LIMIT 50")){
?><table width="100%"><tr><td><?php
$i=0;

while($bobj=mysqli_fetch_object($cresult)){$i++;
print '<br>'.$bobj->sex.' '.$bobj->charname;?><font size=-2> <a href="mailto:lol_silent@hotmail.com?subject=WARUNIT CHAT REPORT <?php print $bobj->id;?>&body=reported by <?php print $row->charname;?>">[report]</a> <?php print $bobj->race.' '.number_format($bobj->level,3);?><sup><b>pu</b></sup></font> <?php print chatit($bobj->message).($current_time-$bobj->timer >= 600?' <font size=-2>('.dater($bobj->timer).')</font>':'');?><?php
}

mysqli_free_result($cresult);
?></td></tr></table><?php
}
?><form method="post" action="chat_iframe.php?sid=<?php print $sid;?>" name="fchat">
<input type="submit" name="schat" value="20" style="width:55px;height:25px;position:absolute;bottom:0px;right:0px">
</form>
<script type="text/javASCript">
<!--
var milisec=9
var seconds=<?php print $chat_timer;?>

document.fchat.schat.value='0'
function countdown(){
if (milisec<=0){
milisec=9
seconds-=1
} else
milisec-=1
document.fchat.schat.value=seconds+"."+milisec
setTimeout("countdown()",100)
}
countdown()
-->
</script>
<meta http-equiv="refresh" content="<?php print $chat_timer;?>">
<?php
if (!empty($update_it)) {
mysqli_query ($link, "UPDATE `$tbl_members` SET $update_it WHERE id='$row->id' LIMIT 1") or die(mysqli_error());
mysqli_close($link);
}
?></td></tr></table></font></center></body></html>