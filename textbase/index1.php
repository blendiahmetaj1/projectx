<?
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once('AdMiN/www.mysql.php');
include_once("$html_header");
?>
History server launched on 3-10-2004 15:53 for RPG starting players that want a simple game without anything attached.<br><br>
Please check <a href="http://www.lordsoflords.com">lordsoflords.com</a> for more servers.<br><br>
<?
$link=mysql_connect($db_host, $db_user, $db_password);
mysql_select_db("$db_main",$link);

mysql_query("UPDATE $tbl_members SET onoff=0 WHERE timer<=$current_timer-600 LIMIT 10000");

$result = mysql_query("select * from $tbl_members where timer>=$current_timer-600 order by exp desc limit 100");
if(!empty($result)){
while($row = mysql_fetch_object($result)){
echo "$row->guild $row->sex $row->charname, ";
}
mysql_free_result($result);
?>played in the last 10 minutes.<?
}
mysql_close($link);
include_once("$html_footer");
?>