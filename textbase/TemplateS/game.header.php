<?
#!/usr/local/bin/php
if(!empty($_GET['sid']) and empty($sid)){$sid=$_GET['sid'];}
if(!empty($_POST['sid']) and empty($sid)){$sid=$_POST['sid'];}if(empty($sid)){die('666');}

header("expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once './AdMiN/www.mysql.php';
$link=mysql_connect($db_host, $db_user, $db_password) or die('10');
mysql_select_db("$db_main",$link) or die('11');

$result = mysql_query("select * from $tbl_members where sid='$sid' order by id desc limit 1") or die('12'.mysql_error());
if($result){
$row = mysql_fetch_object($result) or die('13'.mysql_error());
mysql_free_result($result) or die('14'.mysql_error());
}else{die('15');}

?><html>
<head>
<title><? echo $title; ?></title>
<?
include_once("$html_style");
?>
</head>
<body bgcolor=<?echo $col_bg;?> text=<?echo $col_text;?> rightmargin=0 leftmargin=0 topmargin=0 bottommargin=0>
<center>
<?
 //HEADER
if($sid == $row->sid){

?><table width=100% cellpadding=2 cellspacing=2 border=0><tr bgcolor=<?echo $col_th;?>><td valign=top>Level:<?echo number_format($row->level);?></td> <td valign=top>Exp:<?echo number_format($row->exp);?></td> <td valign=top>Gold:<?echo number_format($row->gold);?></td></tr></table><?

$set_fucking="timer=$current_timer";

 //LOCK FOR SECOND UNLESS PAYMENT MADE
if($row->level > 100){
$remaining=number_format($row->jail-$current_timer,2);
if($remaining<0.01){$remaining=0;}
$randval = rand(10,20);$randval/=100;
if($remaining >= 1.00 or($current_timer-$row->timer) <= $randval){
if($row->onoff <= 2){
$set_fucking.=",onoff=3";
}else{
mysql_close($link);
exit;
}
}else{
$set_fucking.=",jail=$current_timer";
}
}
 //LOCK FOR SECOND UNLESS PAYMENT MADE

mysql_query("update $tbl_members SET $set_fucking where id=$row->id limit 1") or die("".mysql_error());
}else{
include_once("$html_header");
?>Please relogin!<?
include_once("$game_footer");
exit;
}
?>