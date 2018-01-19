<html>
<head>
<title><?php print $title;?> - DEVELOPING STADIUM</title>
<style type="text/css">
<!--
body, table, form{
background:#000000;
border :none;
color:#FFFFFF;
font-family:Verdana,Arial,Monaco;
font-size: 10pt;
margin:0;
}
a{color:#FFFFFF;}
a:hover{color:#AAA555;}

hr{color:#333333;}
input, select, textarea{color:#FFFFFF;background-color:#222222;border-color:#333333;width:100%;}
tr,th,td{border:none;margin:0;}
th{background-color:#333333;}
-->
</style>
</head>
<body><center>
<!--HEADER-->
<?php
$link=mysqli_connect($db_host, $db_user, $db_password) or die('Server down please come back later 1.');
mysqli_select_db($db_main,$link) or die('Server down please come back later 2.');

	//UPDATE GAME
mysqli_query ($link, "UPDATE `$tbl_members` SET

`money`=(`money`+
(
((`b0`*$production)+(`u0`*($production*2)))*
(('$current_time'-`timer`))
)
),`timer`='$current_time'

WHERE `id` LIMIT 1000000") or print(mysqli_error());
	//UPDATE GAME

if (!empty($_COOKIE['wgUsername']) and !empty($_COOKIE['wgSession'])) {
$cusername	= $_COOKIE['wgUsername'];
$csession		= $_COOKIE['wgSession'];

if ($result = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE (`username`='$cusername' and `session`='$csession') ORDER BY `id` DESC LIMIT 1")) {
if ($row = mysqli_fetch_object ($result)){
mysqli_free_result ($result);

$up_value = ($current_time - $row->timer);
$to_update = "timer=$current_time";

if (!empty($_GET['q'])) {$q=clean_post($_GET['q']);}else{$q='';}
print '<table><tr><th>
<table width=100%><tr><th><a href="?">General '.$row->charname.' ('.$row->x.':'.$row->y.')</a></th><th>Money:</th><th>$'.number_format($row->money).'</th></tr></table>
</th></tr><tr><th><a href="index.php">Index</a>
<a href="messages.php">Messages</a>
<a href="buildings.php">Buildings</a>
<a href="units.php">Units</a>
<a href="war.php">War</a>
<a href="battlefield.php">Battlefield</a>
<a href="index.php">Logout</a>
</th></tr></table>';
}
}
}
?>