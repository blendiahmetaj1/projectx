<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.3)">
<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.3)">
<title>Project X5 beta v0.01</title>
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
<body>
<?php
$link=mysqli_connect($db_host, $db_user, $db_password) or die('Server down please come back later 1.');
mysqli_select_db($db_main,$link) or die('Server down please come back later 2.');

	//UPDATE GAME
mysqli_query ($link, "UPDATE `$tbl_members` SET

`money`=(`money`+1+
(
((`x0`*$production)+(`x1`*($production*2)))*
(('$current_time'-`timer`))
)
),`timer`='$current_time'

WHERE (`x0` >= '1' or 'x1' >= '1') LIMIT 1000000") or print(mysqli_error());
	//UPDATE GAME

if (!empty($_COOKIE['Username']) and !empty($_COOKIE['Session'])) {
$cusername	= $_COOKIE['Username'];
$csession		= $_COOKIE['Session'];

if ($result = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE (`username`='$cusername' and `session`='$csession') ORDER BY `id` DESC LIMIT 1")) {

if ($row = mysqli_fetch_object ($result)){
mysqli_free_result ($result);

$up_value = ($current_time - $row->timer);
$to_update = "timer=$current_time";
$total_costs = 0;

if (!empty($_GET['q'])) {$q=clean_post($_GET['q']);}else{$q='';}
$my_income = 1+(($row->x0*$production)+($row->x1*($production*2)));

if ($row->x0 <= 1) {
	$row->x0=1;
}
if ($row->x1 <= 1) {
	$row->x1=1;
}

$cost_explore += ($row->x0+$row->x1);
$cost_settle += ((1+$row->x0)*(1+$row->x1));
$cost_upgrade += ((1+$row->x0)*(1+$row->x1)+$my_income);
$cost_attack += (((1+$row->x0)*(1+$row->x1)/2)+$my_income);

print '<table><tr><td>
Money $'.number_format($row->money).' Income '.number_format($my_income,2).'
<a href="?">'.$row->charname.'</a> <a href="?attack">Attack</a> <a href="?messages">Messages</a> <a href="?map">Map</a> <a href="?ladder">Ladder</a> <a href="?logout">Logout</a>
</td></tr></table><hr>';

}
}
}

?>
<!--HEADER-->