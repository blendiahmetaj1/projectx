<?
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once('AdMiN/www.mysql.php');
require_once('AdMiN/www.functions.php');
require_once 'AdMiN/array.races.php';
include_once("$html_header");

if(empty($_GET['sort'])){$sort="level";}else{
if($_GET['sort'] == 'level' or $_GET['sort'] == 'onoff' or $_GET['sort'] == 'exp' or $_GET['sort'] == 'gold' or $_GET['sort'] == 'race' or $_GET['sort'] == 'stash'){$sort=$_GET['sort'];}else{$sort="exp";}}

if(empty($_GET['where'])){$where='id';}else{
$races_array_keys=array_keys($races_array);if(in_array($_GET['where'],$races_array_keys)){$where="race='".$_GET['where']."'";}else{$where='id';}}

$link=mysql_connect($db_host, $db_user, $db_password);
mysql_select_db("$db_main",$link);

?>

<table width=100% cellpadding=2 cellspacing=2 border=0>
<tr>
<th colspan=7>Top 100 players sorted by <?echo $sort; ?>.</th>
</tr>
<tr>
<td align=center><a name=a>No</a></td><td><a href="?sort=onoff">Charname</a></td><td align=right><a href="?sort=level">Level</a></td><td align=right><a href="?sort=exp">Exp</a></td><td align=right><a href="?sort=gold">Gold</a></td><td align=right><a href="?sort=stash">Stash</a></td><td align=right><a href="?sort=race">Race</a></td><td></td>
</tr>
<?
$where.=" and sex!='Admin' and sex!='Cop' and sex!='Mod' and sex!='Support'";
$result=mysql_query("select * from $tbl_members where $where order by $sort desc limit 100");
if($result){
$num=1;
while($row = mysql_fetch_object($result)){
 if($row->timer>=$current_timer-1000){$colored="<font color=\"#FFF123\">";}else{$colored="";}
 if(empty($bgcolor)){$bgcolor=" bgcolor=\"$col_th\"";}else{$bgcolor='';}
 if(($row->freeplay-$current_timer) > 1){$star="<img src=\"$emotions_url/star.gif\">";}else{$star='';}
echo"<tr$bgcolor><td align=center>$num</td><td><a href=\"members.php?info=$row->charname\">$star$colored$row->sex $row->charname</a></td><td align=right>".number_format($row->level)."</td><td align=right>".number_format($row->exp)."</td><td align=right>".number_format($row->gold)."</td><td align=right>".number_format($row->stash)."</td><td align=right><a href=\"?sort=$sort&where=$row->race\">".ucfirst($row->race)."</a></td>";
$num++;
}
mysql_free_result($result);
}
mysql_close($link);
?>
</table>
<?
include_once("$html_footer");
?>