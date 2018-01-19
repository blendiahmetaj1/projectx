<?php
#!/usr/local/bin/php
$equipments=array('attackspell', 'healspell', 'amulet', 'ring','cape','weapon', 'helmet', 'shield', 'armor', 'belt', 'pant', 'hand', 'feet');
$equipped = array();
if(!empty($_GET['item_idi'])){$item_idi=clean_post($_GET['item_idi']);}else{$item_idi='';}
if(!empty($_GET['item_id'])){$item_id=clean_post($_GET['item_id']);}else{$item_id='';}
if(!empty($_GET['charm_id'])){$charm_id=clean_post($_GET['charm_id']);}else{$charm_id='';}
if(!empty($_GET['action'])){$action=clean_post($_GET['action']);}else{$action='';}
if(!empty($_GET['openupe'])){$openupe=clean_post($_GET['openupe']);}else{$openupe='';}
if(!empty($_GET['openupb'])){$openupb=clean_post($_GET['openupb']);}else{$openupb='';}
if(!empty($_GET['openupc'])){$openupc=clean_post($_GET['openupc']);}else{$openupc='';}

	//action inventory
if(!empty($item_idi) and !empty($action)){
	if($iresult = mysqli_query ($link, "SELECT * FROM `$tbl_inventory` WHERE (`charname`='$row->charname' and `used`>='1' and `id`='$item_idi') ORDER BY `kind` ASC LIMIT 1")){
	if($itrow = mysqli_fetch_object ($iresult)){mysqli_free_result ($iresult);
		$item_id=$itrow->id;
		$itemcost=item_cost($itrow);
if($action == 'unuse'){
mysqli_query ($link, "UPDATE `$tbl_inventory` SET `used`='0' WHERE `id`='$itrow->id' LIMIT 1") or die_nice(mysqli_error());
$to_output .= 'Putting your <b>'.ucfirst($itrow->itemname).' '.$itrow->kind.'</b> in your back pack.<br>';
}
if($action == 'drop'){
mysqli_query ($link, "DELETE FROM `$tbl_inventory` WHERE `id`='$itrow->id' LIMIT 1") or die_nice(mysqli_error());
$to_output .= 'Dropped <b>'.ucfirst($itrow->itemname).' '.$itrow->kind.'</b>.<br>';
}
if($action == 'sell'){
mysqli_query ($link, "UPDATE `$tbl_inventory` SET `charname`='', `used`='0', `timer`='$current_time' WHERE `id`='$itrow->id' LIMIT 1") or die_nice(mysqli_error());
$to_output .= 'Sold <b>'.ucfirst($itrow->itemname).' '.$itrow->kind.'</b> for '.number_format($itemcost).' gold.<br>';
$to_update .= ", `gold`=`gold`+$itemcost";
if($itrow->kind == 'attackspell' or $itrow->kind == 'healspell' or $itrow->kind == 'amulet' or $itrow->kind == 'ring' or $itrow->kind == 'cape') {
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','9','','$current_date','$row->sex $row->charname sold a <b>$itrow->itemname $itrow->class $itrow->kind</b> to the tower.','$current_time')") or die_nice(mysqli_error().'sell charm paper');
}else{
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','8','','$current_date','$row->sex $row->charname sold a <b>$itrow->itemname $itrow->class $itrow->kind</b> to the shop.','$current_time')") or die_nice(mysqli_error().'sell charm paper');
}
}

	}
	}
}
	//action inventory
	//action backpack
if(!empty($item_id) and !empty($action)){
	if($iresult = mysqli_query ($link, "SELECT * FROM `$tbl_inventory` WHERE (`charname`='$row->charname' and `used`<='0' and `id`='$item_id') ORDER BY `kind` ASC LIMIT 1")){
	if($utrow = mysqli_fetch_object ($iresult)){mysqli_free_result ($iresult);
		$item_idi=$utrow->id;
		$itemcost=item_cost($utrow);
if($action == 'use'){
	if(!in_array($utrow->kind,$equipped)) {
mysqli_query ($link, "UPDATE `$tbl_inventory` SET `used`='1' WHERE `id`='$utrow->id' LIMIT 1") or die_nice(mysqli_error());
$to_output .= 'You are now equipped with <b>'.ucfirst($utrow->itemname).' '.$utrow->kind.'</b>.<br>';
	}else{
$to_output .= 'Can\'t do that!';
	}
}
if($action == 'drop'){
mysqli_query ($link, "DELETE FROM `$tbl_inventory` WHERE `id`='$utrow->id' LIMIT 1") or die_nice(mysqli_error());
$to_output .= 'Dropped <b>'.ucfirst($utrow->itemname).' '.$utrow->kind.'</b>.<br>';
}
if($action == 'sell'){
mysqli_query ($link, "UPDATE `$tbl_inventory` SET `charname`='', `used`='0', `timer`='$current_time' WHERE `id`='$utrow->id' LIMIT 1") or die_nice(mysqli_error());
$to_output .= 'Sold <b>'.ucfirst($utrow->itemname).' '.$utrow->kind.'</b> for '.number_format($itemcost).' gold.<br>';
$to_update .= ", `gold`=`gold`+$itemcost";
if($utrow->kind == 'attackspell' or $utrow->kind == 'healspell' or $utrow->kind == 'amulet' or $utrow->kind == 'ring' or $utrow->kind == 'cape') {
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','9','','$current_date','$row->sex $row->charname sold a <b>$utrow->itemname $utrow->class $utrow->kind</b> to the tower.','$current_time')") or die_nice(mysqli_error().'sell charm paper');
}else{
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','8','','$current_date','$row->sex $row->charname sold a <b>$utrow->itemname $utrow->class $utrow->kind</b> to the shop.','$current_time')") or die_nice(mysqli_error().'sell charm paper');
}
}
	}
	}
}
	//action backpack

if($iresult = mysqli_query ($link, "SELECT * FROM `$tbl_inventory` WHERE (`charname`='$row->charname' and `used`>='1') ORDER BY `kind` ASC LIMIT 125")){
if(mysqli_num_rows($iresult)){
?>
<table width=100% cellpadding=0 cellspacing=1 border=0><tr><th colspan=2><a href="?player=inventory&openupe=1" title="Open all item properties.">Equipped</a><sup title="Empty Inventory slots"><?php print number_format($max_inventory-$inventory_items);?></sup></th></tr>
<?php
		$i=0;
while($itrow = mysqli_fetch_object ($iresult)) {
		if ($i == 0) { print '<tr>'; }
		print '<td valign=top nowrap><font size=-1>';

	if(!in_array($itrow->kind,$equipped)) {
	$equipped[] = $itrow->kind;
	}
$itemcost=item_cost($itrow);
print '<a href="?player=inventory&action=unuse&item_idi='.$itrow->id.(!empty($openupe)?'&openupe=1':'').'"><img src="'.$path_game.'/buttons/unuse.gif" border=0 title="Unuse item">';
print '<a href="?player=inventory&item_idi='.$itrow->id.(!empty($openupe)?'&openupe=1':'').'"><img src="'.$path_game.'/items/'.$itrow->kind.'.gif" border=0> '.ucfirst($itrow->itemname).' '.$itrow->class.' '.$itrow->kind.'</a>'.(($itrow->durability >= 1 and $itrow->damaged <= 0) ? ($itrow->durability >= 10 and $itrow->damaged <= 5) ? '<sup><font color=#FF0000>broken!</font></sup>':'1':'').'<br>';

//foreach ($itrow as $key=>$val){print $key.':'.$val.'<br>';}
//open property
if($item_idi == $itrow->id or !empty($openupe)){
print '<a href="?player=inventory&action=drop&item_idi='.$itrow->id.(!empty($openupe)?'&openupe=1':'').'""><img src="'.$path_game.'/buttons/drop.gif" border=0 title="Drop item"></a>
<a href="?player=inventory&action=sell&item_idi='.$itrow->id.(!empty($openupe)?'&openupe=1':'').'"><img src="'.$path_game.'/buttons/sell.gif" border=0 title="Sell item"></a>';
inv_prop($itrow->id);
print 'Sell value '.number_format($itemcost).' gold.<br>';

}
//open property
	print '</font></td>';
	$i++;if ($i ==2) {print '</tr>'; $i=0;}
}//while
mysqli_free_result ($iresult);
//NOT USING
$not_using='';
foreach ($equipments as $val){
		if(!in_array($val,$equipped)) {
			$not_using .= ', '.$val;
		}
}
		if(!empty($not_using)){$to_output .= 'Not using'.$not_using.'.<br>';;}
//NOT USING
?></td></tr></table><?php
}else{ $to_output .= 'You are running around in your under pants!<br>';}//num rows
}//resulting
//BACK PACK




//BACK PACK
if($iresult = mysqli_query ($link, "SELECT * FROM `$tbl_inventory` WHERE (`charname`='$row->charname' and `used`<='0') ORDER BY `kind` ASC LIMIT 25")){
if(mysqli_num_rows($iresult)){

?><table width=100% cellpadding=0 cellspacing=1 border=0><tr><th colspan=2><a href="?player=inventory&openupb=1" title="Open all item properties.">Back Pack</a><sup title="Empty Inventory slots"><?php print number_format($max_inventory-$inventory_items);?></sup></th></tr><?php
		$i=0;
while($utrow = mysqli_fetch_object ($iresult)) {
		if ($i == 0) { print '<tr>'; }
		print '<td valign=top nowrap><font size=-1>';
$itemcost=item_cost($utrow);

if ($utrow->rlevel <= $row->level and $utrow->rstrength <= $row->strength and $utrow->rintelligence <= $row->intelligence) {
	if(!in_array($utrow->kind,$equipped)) {
print '<a href="?player=inventory&action=use&item_id='.$utrow->id.(!empty($openupb)?'&openupb=1':'').'"><img src="'.$path_game.'/buttons/use.gif" border=0 title="Use item"></a>';
	}
}

print '<a href="?player=inventory&item_id='.$utrow->id.(!empty($openupb)?'&openupb=1':'').'"><img src="'.$path_game.'/items/'.$utrow->kind.'.gif" border=0> '.ucfirst($utrow->itemname).' '.$utrow->class.' '.$utrow->kind.'</a>'.(($utrow->durability >= 1 and $utrow->damaged <= 0) ?'<sup><font color=#FF0000>broken!</font></sup>':'').'<br>';

//open property
if($item_id == $utrow->id or !empty($openupb)){
print '<a href="?player=inventory&action=drop&item_id='.$utrow->id.(!empty($openupb)?'&openupb=1':'').'""><img src="'.$path_game.'/buttons/drop.gif" border=0 title="Drop item"></a><a href="?player=inventory&action=sell&item_id='.$utrow->id.(!empty($openupb)?'&openupb=1':'').'"><img src="'.$path_game.'/buttons/sell.gif" border=0 title="Sell item"></a>';
inv_prop($utrow->id);
print 'Sell value '.number_format($itemcost).' gold.<br>';

}
//open property
	print '</font></td>';
	$i++;if ($i ==2) {print '</tr>'; $i=0;}
}//while
mysqli_free_result ($iresult);
?></table><?php
}else{ $to_output .= 'Your back pack is empty!<br>';}//num rows
}//resulting
//BACK PACK



//CHARMS
if($aresult = mysqli_query ($link, "SELECT * FROM `$tbl_charms` WHERE (`charname`='$row->charname') ORDER BY `timer` DESC LIMIT 25")){
if($inventory_charms=mysqli_num_rows($aresult)){

?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=2><a href="?player=inventory&openupc=1" title="Open all charm properties.">Charms</a><sup title="Empty Charm Slots."><?php print number_format($max_charms-$inventory_charms);?></sup></th></tr><tr><td>
<?php
foreach ($stats as $val){
$tcrow->$val = 0;
}

		$i=0;
while($crow = mysqli_fetch_object ($aresult)) {
		if ($i == 0) { print '<tr>'; }
		print '<td valign=top nowrap><font size=-1>';
$itemcost=charm_cost($crow);
$recharge_cost = 5000+($itemcost*3);
print '<a href="?player=inventory&charm_id='.$crow->id.(!empty($openupc)?'&openupc=1':'').'"><img src="'.$path_game.'/items/charm.gif" border=0>'.ucfirst($crow->name).' charm</a>';

//activity
if ($crow->timer <= $current_time){
print ' <sup><font color=#FF0000>Inactive!</font></sup><br>';
//<a href="?player=inventory&action=recharge&charm_id='.$crow->id.(!empty($openupc)?'&openupc=1':'').'"">Recharge for '.number_format($recharge_cost).'</a>
}else{
print '<br><sup>Active for '.number_format($crow->timer-$current_time).' seconds</sup><br>';;
}
//activity

//open property
if($charm_id == $crow->id or !empty($openupc)){

print '<a href="?player=inventory&action=drop&charm_id='.$crow->id.(!empty($openupc)?'&openupc=1':'').'""><img src="'.$path_game.'/buttons/drop.gif" border=0 title="Drop item"></a>
<a href="?player=inventory&action=sell&charm_id='.$crow->id.(!empty($openupc)?'&openupc=1':'').'""><img src="'.$path_game.'/buttons/sell.gif" border=0 title="Sell item"></a><br>Sell value '.number_format($itemcost).' gold.<br>';

foreach ($stats as $val){
if($crow->$val >= 1){
print '+'.$crow->$val.'% '.$val.'<br>';
}
}
	//action
if($charm_id == $crow->id){
if($action == 'drop'){print 'Done!<br>';
mysqli_query ($link, "DELETE FROM `$tbl_charms` WHERE `id`='$crow->id' LIMIT 1") or die_nice(mysqli_error());
$to_output .= 'Dropped <b>'.ucfirst($crow->name).' '.$crow->id.'</b>.<br>';
}elseif($action == 'sell'){print 'Done!<br>';
mysqli_query ($link, "UPDATE `$tbl_charms` SET `charname`='' WHERE `id`='$crow->id' LIMIT 1") or die_nice(mysqli_error());
$to_update .= ", `gold`=`gold`+$itemcost";
$to_output .= 'Sold <b>'.ucfirst($crow->name).'</b> for <b>'.number_format($itemcost).'</b> gold.<br>';

mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','7','','$current_date','$row->sex $row->charname sold <b>".$crow->name." charm</b> to the charmer.','$current_time')") or die_nice(mysqli_error().'sell charm paper');

/*}elseif($action == 'recharge'){print 'Done!<br>';
if($row->gold >= $recharge_cost){
mysqli_query ($link, "UPDATE `$tbl_charms` SET timer='".($current_time+5000)."' WHERE `id`='$crow->id' LIMIT 1") or die_nice(mysqli_error());
$to_update .= ", `gold`=`gold`-$recharge_cost";
$to_output .= 'Recharged for <b>'.ucfirst($crow->name).'</b> for <b>'.number_format($recharge_cost).'</b> gold.<br>';
}else{$to_output .= 'Not enough gold to complete recharge.<br>';}
*/
}
$charm_id='';
}
	//action
}
//open property
	print '</font></td>';
	$i++;if ($i ==2) {print '</tr>'; $i=0;}
}//while
mysqli_free_result ($aresult);
?></td></tr></table><?php
}else{ $to_output .= 'Your don\'t have any charms!<br>';}//num rows
}//resulting
//CHARMS

?>
<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th></th></tr>
<tr><td>
<img src="<?php print $path_game;?>/buttons/use.gif" border=0>=Use Item
<img src="<?php print $path_game;?>/buttons/unuse.gif" border=0>=Unuse Item
<img src="<?php print $path_game;?>/buttons/drop.gif" border=0>=Drop Item
<img src="<?php print $path_game;?>/buttons/sell.gif" border=0>=Sell Item
</td></tr></table>
<?php
$to_output .= 'You have <b>'.number_format($max_charms-$inventory_charms).'</b> empty charm slots and <b>'.number_format($max_inventory-$inventory_items).'</b> empty inventory slots.<br>';


//NOOB
if($row->level <= $noob_level){

$to_output .= 'To find charms or items you can walk around, buying from the shops or kill monsters to get better items. When the charms or inventory slots are full you are not able to pick up charms or any other item!<br>
To repair any inactive charms or items go to the smith. One item of each kind may be used at once!<br>';

if(!empty($over_equipped)){

}

if ($max_inventory-$inventory_items < 0){
$to_output .= 'You are carrying too much items this will hurt your stats in battle.<br>';
}

}
//NOOB
?>