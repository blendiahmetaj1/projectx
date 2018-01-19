<?
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once('AdMiN/www.mysql.php');
require_once('AdMiN/www.functions.php');
if(!empty($_GET['sid']) and empty($sid)){$sid=$_GET['sid'];}
if(!empty($_POST['sid']) and empty($sid)){$sid=$_POST['sid'];}if(empty($sid)){die('666');}

$link=mysql_connect($db_host, $db_user, $db_password) or die('10');
mysql_select_db("$db_main",$link) or die('11');

$result = mysql_query("select * from $tbl_members where sid='$sid' order by id desc limit 1") or die('12'.mysql_error());
if($result){
$row = mysql_fetch_object($result) or die('13'.mysql_error());
mysql_free_result($result) or die('14'.mysql_error());
if($row->sid == $sid){
$sid=lottery_ticket();
mysql_query("update $tbl_members SET sid='$sid', onoff=0 where id=$row->id limit 1");
foreach($table_names as $tnames){
mysql_query("OPTIMIZE TABLE $tnames");
}
}
}else{die('15');}
mysql_close($link);

include_once("$html_header");
?>
Thanks for playing <? echo $title; ?>. Hope to see you back again. You have been logged out successfully.<br><br>
You have been logged out and cookies has been cleaned.
<?
include_once("$html_footer");
?>