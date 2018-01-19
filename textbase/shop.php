<?
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once('AdMiN/www.functions.php');
include_once("$game_header");

$items =array('weapon', 'attackspell', 'healspell','helmet', 'shield','amulet','ring', 'armor','belt', 'pants', 'hand', 'feet');
if (!empty($_POST['do'])) {
 $do=$_POST['do'];
$upgrade_cost =(97+(1+($row->$do*$row->$do)*($row->$do+$row->$do)));
if ($row->gold >= $upgrade_cost and in_array($do, $items)) {
mysql_query("update $tbl_members SET $do=$do+1,gold=gold-$upgrade_cost where id=$row->id limit 1");
$row->$do+=1;
}
}
?>
<form method=post><input type=hidden name=sid value="<?echo $sid?>">
<table cellpadding=2 cellspacing=2 border=0 width=100%><tr>
<th colspan=4>Shopping</th></tr>
<tr><td>Equipment</td><td>You have</td><td>Price</td><td>Buy</td></tr>
<?
foreach($items as $val){
$price =(97+(1+($row->$val*$row->$val)*($row->$val+$row->$val)));
 if(empty($bgcolor)){$bgcolor=" bgcolor=\"$col_th\"";}else{$bgcolor='';}
echo "<tr$bgcolor>
<td width=15% nowrap>$val</td>
<td width=35%>".number_format($row->$val)."</td>
<td width=35%>".number_format($price)."</td>
<td width=15%><input type=submit name=do value=\"$val\"></td>
</tr>";
}
?>
</td></tr></table>
</form>
<?
include_once("$game_footer");
?>