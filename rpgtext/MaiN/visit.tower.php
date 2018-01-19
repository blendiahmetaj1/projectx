<?php
#!/usr/local/bin/php
$items=array('attackspell', 'healspell', 'amulet', 'ring','cape');

if (!empty($_GET['item'])) {$item=clean_post($_GET['item']);if (!in_array($item, $items)) {$item='';}} else {$item='';}
if(!empty($_GET['buy'])) {$buy = clean_post($_GET['buy']);}else{$buy='';}

?>
<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=3>Mage Tower</th></tr>
<tr><td>Fizzle my dizzle you need some mizztical shizzle then you are at the right hizzle!<br>
<?php
foreach ($items as $val) {
print '<a href="?visit=tower&item='.$val.'"><img src="'.$path_game.'/items/'.$val.'.gif" border=0"> '.$val.'\'s</a> ';
}
?>
</td></tr>
</table>

<?php
if (!empty($item)) {

//GENERATE ITEMS
mysqli_query ($link, "DELETE FROM `$tbl_inventory` WHERE (`charname`='' and `timer`<=$current_time-1000000) LIMIT 10") or die_nice(mysqli_error());
generator_shop_item();
//GENERATE ITEMS

//GET ITEMS


if($sresult = mysqli_query ($link, "SELECT * FROM `$tbl_inventory` WHERE (`charname`='' and `kind`='$item') ORDER BY `id` DESC LIMIT 5")){
if(mysqli_num_rows($sresult) >= 1) {
?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=2>Selling <?php print $item;?>'s</th></tr><?php
		$i=0;
while($itrow = mysqli_fetch_object ($sresult)) {
		if ($i == 0) { print '<tr>'; }
$itemcost=item_cost($itrow)*2;

print '<td align=center valign=top>';
if ($row->gold >= $itemcost) {print '<a href="?visit=tower&item='.$item.'&buy='.$itrow->id.'"><img src="'.$path_game.'/buttons/buy.gif" border=0 title="Buy"></a><br>';}else{print 'No Gold<br>';}
inv_prop($itrow->id);

//BUYING OR COST
if($buy == $itrow->id) {

if ($row->gold >= $itemcost) {
mysqli_query ($link, "UPDATE `$tbl_inventory` SET `charname`='$row->charname' WHERE `id`='$itrow->id' LIMIT 1") or die_nice(mysqli_error());
$to_update .= ", `gold`=`gold`-$itemcost";
$to_output .= 'Bought yourself a nice <b>'.$itrow->itemname.' '.$item.'</b> for '.number_format($itemcost).' gold.<br>';
}else{
$to_output .= 'You do not have the gold to buy this <b>'.$itrow->itemname.' '.$item.'</b> it costs '.number_format($itemcost).' gold.<br>';
}

$buy ='';
}else{
print 'Cost '.number_format($itemcost).' gold</td>';
	$i++;if ($i ==2) {print '</tr>'; $i=0;}
}
//BUYING OR COST

}
mysqli_free_result ($sresult);
?></table><?php
}else{$to_output .= 'Sorry we are out of <b>'.$item.'</b>, please come back later again.';}
}


//GET ITEMS

}
?>
<table width=100% cellpadding=0 cellspacing=1 border=0><tr><th colspan=2> </th></tr><tr><td><img src="<?php print $path_game;?>/buttons/buy.gif" border=0 title="Buy">=Buy</td></tr></table>
<?php
//NEWS PAPER LOCATION nid 9 tower
news_paper('','9','Log Book');
//NEWS PAPER LOCATION nid 9 tower

//NOOB
if($row->level <= $noob_level){
$to_output .= 'If a player sells his items it will be sold here and we also buy in normal items.';
}
//NOOB
?>