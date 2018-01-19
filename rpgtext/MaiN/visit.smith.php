<?php
#!/usr/local/bin/php
?>
<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th>Iron Smith</th></tr><tr><td>I can repair most damaged items or charms for a small price.<br></td></tr>
<?php
if (!empty($_GET['repair'])) {$repair=clean_post($_GET['repair']);} else {$repair='';}
if (!empty($_GET['show'])) {$show=clean_post($_GET['show']);} else {$show='';}

//ITEMS
if($itresult = mysqli_query ($link, "SELECT * FROM `$tbl_inventory` WHERE (`charname`='$row->charname' and `damaged`<`durability` and `durability`>='1') ORDER BY `id` ASC LIMIT 10")) {
if(mysqli_num_rows($itresult) >= 1) {
	?><tr><th>Damaged Items</th></tr><tr><td><?php
$repair_all=0;
$repaired_cost=0;
while($itrow = mysqli_fetch_object ($itresult)) {

$itcost=item_cost($itrow);
$repaircost=($itcost/$itrow->durability)/5;
$repaircost=($repaircost*($itrow->durability-$itrow->damaged));
if ($repaircost <= 1){$repaircost=3;}

$repair_all += $repaircost;

print '<a href="?visit=smith&repair='.$itrow->id.'"><img src="'.$path_game.'/buttons/repair.gif" border=0 title="Repair this item"></a> <a href="?visit=smith&show='.$itrow->id.'" title="Ask for repair cost."><img src="'.$path_game.'/items/'.$itrow->kind.'.gif" border=0> '.ucfirst($itrow->itemname).' '.$itrow->class.' '.$itrow->kind.'</a><br>';

if ($show == $itrow->id) {
inv_prop($itrow->id);
echo 'Repair cost '.number_format($repaircost).'<br>New price '.number_format($itcost).'<br>';
}

//REPAIR ALL
if ($repair == 'all' or $repair == $itrow->id){
	if($row->gold >= $repaircost){
mysqli_query ($link, "UPDATE `$tbl_inventory` SET `damaged`='$itrow->durability' WHERE `id`='$itrow->id'") or die_nice(mysqli_error());
$repaired_cost += $repaircost;
$row->gold -= $repaircost;
	}else{$to_output .= 'You do not have enough gold to let me complete the repairing!<br>';}
		if ($repair !== 'all'){$repair='';}
}
//REPAIR ALL

}
mysqli_free_result ($itresult);

if ($repaired_cost >= 1){
$to_update .= ", `gold`=`gold`-$repaired_cost";
$to_output .= 'Repaired your gear for '.number_format($repaired_cost).' gold.<br>';
}else{
print '<a href="?visit=smith&repair=all"><img src="'.$path_game.'/buttons/repair.gif" border=0 title="Click here to repair"> repair all items for '.number_format($repair_all).' gold.</a>';
}
	?></td></tr><?php
}else{
$to_output .= 'You have no items that needs to be repaired.<br>';
}
}
//ITEMS



if(!empty($_GET['action'])){$action=clean_post($_GET['action']);}else{$action='';}
if(!empty($_GET['charm_id'])){$charm_id=clean_post($_GET['charm_id']);}else{$charm_id='';}

//CHARMS
if($aresult = mysqli_query ($link, "SELECT * FROM `$tbl_charms` WHERE `charname`='$row->charname' and `timer`<='$current_time' ORDER BY `timer` DESC LIMIT 25")){
if(mysqli_num_rows($aresult) >= 1){
	?><tr><th>Rechargeable Charms</th></tr><tr><td><?php
$recharge_all_cost = 0;
$recharged_cost = 0;
while($crow = mysqli_fetch_object ($aresult)) {
$itemcost=charm_cost($crow);
$recharge_cost = 50000+($itemcost*5);
$recharge_all_cost += $recharge_cost;
print '<a href="?visit=smith&action=recharge&charm_id='.$crow->id.'"><img src="'.$path_game.'/buttons/repair.gif" border=0 title="Repair this item"></a> <a href="?visit=smith&charm_id='.$crow->id.'"><img src="'.$path_game.'/items/charm.gif" border=0>'.ucfirst($crow->name).' charm</a><br>';

if($charm_id == 'all' or $charm_id == $crow->id){
foreach ($stats as $val){
if($crow->$val >= 1){
print '+'.$crow->$val.'% '.$val.'<br>';
}
}
echo 'Recharge cost '.number_format($recharge_cost).'<br>Charm price '.number_format($itemcost).'<br>';

if($action == 'recharge'){
	if($row->gold >= $recharge_cost){
mysqli_query ($link, "UPDATE `$tbl_charms` SET timer='".($current_time+50000)."' WHERE `id`='$crow->id' LIMIT 1") or die_nice(mysqli_error());
$recharged_cost += $recharge_cost;
$row->gold -= $recharge_cost;
	}else{$to_output .= 'Not enough gold to complete recharge.<br>';$charm_id='';}
		if ($charm_id !== 'all'){$charm_id='';}
}

}

}//while
mysqli_free_result ($aresult);

if ($recharged_cost >= 1){
$to_update .= ", `gold`=`gold`-$recharged_cost";
$to_output .= 'Recharged your charms for '.number_format($recharged_cost).' gold.<br>';
}else{
print '<a href="?visit=smith&action=recharge&charm_id=all"><img src="'.$path_game.'/buttons/repair.gif" border=0 title="Click here to repair"> recharge all charms for '.number_format($recharge_all_cost).' gold.</a>';
}
	?></td></tr><?php
}else{
$to_output .= 'You have no charms that needs to be recharged.<br>';
}
}

?>
</table>
<?php
//NOOB
if($row->level <= $noob_level){
$to_output .= 'You gear will get damaged in battle only. For repair cost per item or per charm click on the name to request for the single price';
}//NOOB
?>