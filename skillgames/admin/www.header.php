<html>
<head>
<title>Play Money Skill Games to win real money.</title>
<meta NAME="description" CONTENT="Moneyskillgames.com is a gaming website where you can play free and still win real money.">
<meta NAME="keywords" CONTENT="play game to win money, win cash, win money, skill games, money games, win money games, play to win money, money skill games">
<meta NAME="robots" CONTENT="INDEX,FOLLOW">
<meta NAME="revisit-after" CONTENT="1 Day">
<style type="text/css">
<!--
body {
background:#000000;
color:#FFFFFF;
font-family:Verdana,Arial,Monaco;
font-size: 10pt;
margin:0;
border :none;
}
a{
color:#FFFFFF;
}
a:hover{
color:#FFF888;
}
form {
margin:0;
border :none;
}
input {
font-family:Verdana,Arial,Monaco;
font-size: 10pt;
}
-->
</style>
</head>
<body><center>
<?php
$link=mysqli_connect($db_host, $db_user, $db_password) or die('Server down please come back later 1.');
mysqli_select_db($db_main,$link) or die('Server down please come back later 2.');

if (!empty($_COOKIE['msgUsername']) and !empty($_COOKIE['msgSession'])) {
$cusername	= $_COOKIE['msgUsername'];
$csession		= $_COOKIE['msgSession'];

if ($result = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE (`username`='$cusername' and `timer`='$csession') ORDER BY `id` DESC LIMIT 1")) {
if ($row = mysqli_fetch_object ($result)){
mysqli_free_result ($result);
}
}
}
?>
<table width=100% border=0 cellspacing=0 cellpadding=0><tr><td align=center background="images/gra.jpg">
	<table border=0 cellspacing=0 cellpadding=0><tr><td background="images/gra.jpg">
		<img src="images/msg.jpg" border=0>
	</td><td background="images/gra.jpg">
<!--LOGIN PLAY-->
<?php
if (!empty($row->username)) {
	print '<font size=-1><b>'.$row->id.' '.$row->username.'</b><br>Level : '.number_format($row->level).'<br>Experience : '.number_format($row->xp).'<br>Gold : '.number_format($row->gold).'<br>Money : $'.number_format($row->money,2).'</font>';
}else{
?>
	<form name="logon" method="POST" action="games.php">
		<table border=0 cellspacing=0 cellpadding=0>
		<tr><td><font size=-1><b>Username:</b></font></td><td><input type=text name=username maxlength=64 style="height:15;width:100px" value=""></td></tr>
		<tr><td><font size=-1><b>Password:</b></font></td><td><input type=password name=password maxlength=64 style="height:15;width:100px" value=""><input type=submit name=action value="" style="width:0;"></td></tr>
		</table>
	</form>
<font size=-2><a href="signup.php">Signup here to play!</a><br><a href="forgot.php">Forgot your password?</a></font>
<?php
}
?>
<!--LOGIN PLAY-->
	</td></tr></table>
</td></tr></table>

<table width=100% border=0 cellspacing=0 cellpadding=0><tr><td align=center bgcolor="#123456">
<b><a href="index.php">HOME</a> | <a href="games.php">GAMES</a> | <a href="winners.php">WINNERS</a> | <a href="ladder.php">LADDER</a> | <a href="logout.php">LOGOUT</a></b>
</td></tr></table>

<table width=80% border=0 cellspacing=0 cellpadding=0><tr><td>

<!--HEADER-->