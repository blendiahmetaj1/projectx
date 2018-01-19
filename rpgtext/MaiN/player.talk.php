<?php
#!/usr/local/bin/php
if (!empty($talk)){
if($talk !== $row->charname) {
if($tresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE `charname`='$talk' ORDER BY `id` DESC LIMIT 1")){
if($trow = mysqli_fetch_object ($tresult)){

if($trow->x > $row->x){$x_hearable = $trow->x-$row->x;}else{$x_hearable = $row->x-$trow->x;}
if($trow->y > $row->y){$y_hearable = $trow->y-$row->y;}else{$y_hearable = $row->y-$trow->y;}
	//print $x_hearable.' '.$y_hearable.'<br>';
if($x_hearable >= 0 and $y_hearable >= 0 and $x_hearable <= 10 and $y_hearable <= 10) {

mysqli_free_result ($tresult);

if(!empty($_POST['message'])){$message=clean_post($_POST['message']);}else{$message='';}
if(!empty($_POST['give'])){$give=clean_post($_POST['give']);}else{$give='';}
if(!empty($_POST['charm_id'])){$charm_id=round(clean_post($_POST['charm_id']));}else{$charm_id='';}
if(!empty($_POST['item_id'])){$item_id=round(clean_post($_POST['item_id']));}else{$item_id='';}

//print_r($_POST);

?>
<form method=post action="?talk=<?php print $trow->charname;?>">
<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=3>Talk to <?php print $trow->sex.' '.$trow->charname.' <sup>'.number_format($trow->level).'</sup>';?></th></tr>
<tr><td width=70>Message</td><td width=325><input type=text name=message value="" maxlength=255></td><td width=50><input type=submit name=action value="Say!"></td></tr>
<?php
//GIVE GOLD
if ($row->gold >= 1) {
if(!empty($_POST['amount'])){
	$amount=round(clean_post($_POST['amount']));

	if($row->gold >= $amount and $amount >= 1) {
	$to_update .= ", `gold`=`gold`-$amount";
	$to_output .= 'Giving <b>'.number_format($amount).'</b> gold to '.$trow->sex.' '.$trow->charname.'.<br>';
	$message = ' this <b>'.number_format($amount).'</b> gold is for you.';
mysqli_query ($link, "UPDATE `$tbl_members` SET `gold`=`gold`+'$amount' WHERE `id`='$trow->id' LIMIT 1") or die_nice(mysqli_error().'talk error.');

	}else{
	$to_output .= 'You don\'t have that kind of amount gold on you!<br>';
	}
}
?>
</table><table width=100% cellpadding=0 cellspacing=1 border=0><tr><th colspan=3>Give Gold</th></tr>
<tr><td width=70>Amount</td><td width=325><input type=text name=amount value="" maxlength=255></td><td width=50><input type=submit name=give value="Give"></td></tr>
<?php
}else{$to_output .= 'You are not carrying any gold with you.<br>';}
//GIVE GOLD

//GIVE POTIONS
if ($row->plife >= 1 or $row->pmana >= 1 or $row->pstamina >= 1) {

if(!empty($_POST['potions'])){
	$potions=clean_post($_POST['potions']);

if ($potions == 'life potion') {
		if($row->plife >= 1){
		$to_output .= 'Giving away a life potion.<br>';
		$to_update .= ", `plife`=`plife`-'1'";
		$message = ' this life potion is for you';
mysqli_query ($link, "UPDATE `$tbl_members` SET `plife`=`plife`+'1' WHERE `id`='$trow->id' LIMIT 1") or die_nice(mysqli_error().'talk error.');
		}else{$to_output .= 'You don\'t have it!<br>';}
}elseif ($potions == 'mana potion') {
		if($row->pmana >= 1){
		$to_output .= 'Giving away a mana potion.<br>';
		$to_update .= ", `pmana`=`pmana`-'1'";
		$message = ' this mana potion is for you';
mysqli_query ($link, "UPDATE `$tbl_members` SET `pmana`=`pmana`+'1' WHERE `id`='$trow->id' LIMIT 1") or die_nice(mysqli_error().'talk error.');
		}else{$to_output .= 'You don\'t have it!';}
}elseif ($potions == 'stamina potion') {
		if($row->pstamina >= 1){
		$to_output .= 'Giving away a stamina potion.<br>';
		$to_update .= ", `pstamina`=`pstamina`-'1'";
		$message = ' this stamina potion is for you';
mysqli_query ($link, "UPDATE `$tbl_members` SET `pstamina`=`pstamina`+'1' WHERE `id`='$trow->id' LIMIT 1") or die_nice(mysqli_error().'talk error.');
		}else{$to_output .= 'You don\'t have it!';}
}

}


?>
</table><table width=100% cellpadding=0 cellspacing=1 border=0><tr><th colspan=3>Give Potions</th></tr>
<tr><td width=30%><input type=submit name=potions value="life potion"></td><td width=35%><input type=submit name=potions value="mana potion"></td><td width=35%><input type=submit name=potions value="stamina potion"></td></tr>
<?php
}else{$to_output .= 'You are not carrying any potion with you.';}
//GIVE POTIONS



//GIVE CHARMS
if($aresult = mysqli_query ($link, "SELECT * FROM `$tbl_charms` WHERE (`charname`='$row->charname') ORDER BY `timer` DESC LIMIT 25")){
if(mysqli_num_rows($aresult) >= 1){

?>
</table><table width=100% cellpadding=0 cellspacing=1 border=0><tr><th colspan=3>Give Charm</th></tr>
<tr><td width=85%><select name=charm_id>
<?php
while($crow = mysqli_fetch_object ($aresult)) {
	$itemcost=charm_cost($crow);
	if($give == 'Give Charm' and $charm_id == $crow->id){
print '<option value="'.$crow->id.'" selected>Giving '.ucfirst($crow->name).' charm value of '.number_format($itemcost).' gold</option>';

//CHARMS ITEMS
if($tchresult = mysqli_query ($link, "SELECT `id` FROM `$tbl_charms` WHERE `charname`='$trow->charname' ORDER BY `id` DESC LIMIT 25")){
if(mysqli_num_rows($tchresult) < $max_charms){
mysqli_free_result ($tchresult);
$to_output .= 'Giving <b>'.ucfirst($crow->name).'</b> charm value of <b>'.number_format($itemcost).'</b> gold.<br>';
$message = ' this <b>'.ucfirst($crow->name).'</b> charm is for';
mysqli_query ($link, "UPDATE `$tbl_charms` SET `charname`='$trow->charname' WHERE `id`='$crow->id' LIMIT 1") or die_nice(mysqli_error().'talk rror.');

}else{$to_output .= $trow->sex.' '.$trow->charname.'\'s charm slots is full!<br>';}
}
//CHARMS ITEMS
	}else{
print '<option value="'.$crow->id.'">'.ucfirst($crow->name).' charm value of '.number_format($itemcost).' gold</option>';
	}
}
mysqli_free_result($aresult);
?>
</select></td><td width=15%><input type=submit name=give value="Give Charm"></td></tr>
<?php
}else{$to_output .= 'You are not carrying any charms with you.<br>';}
}
//GIVE CHARMS



//GIVE ITEM
if($iresult = mysqli_query ($link, "SELECT * FROM `$tbl_inventory` WHERE (`charname`='$row->charname') ORDER BY `kind` ASC LIMIT 25")){
if(mysqli_num_rows($iresult) >= 1){
?>
</table><table width=100% cellpadding=0 cellspacing=1 border=0><tr><th colspan=3>Give Item</th></tr>
<tr><td width=85%><select name=item_id>
<?php
while($itrow = mysqli_fetch_object ($iresult)) {
$itemcost=item_cost($itrow);
		if($give == 'Give Item' and $item_id == $itrow->id){
print '<option value="'.$itrow->id.'" selected>Giving '.ucfirst($itrow->itemname).' '.$itrow->class.' '.$itrow->kind.' value of '.number_format($itemcost).' gold</option>';
//INVENTORY ITEMS
if($iresult = mysqli_query ($link, "SELECT `id` FROM $tbl_inventory WHERE `charname`='$row->charname' ORDER BY `id` DESC LIMIT 50")){
if(mysqli_num_rows($iresult) < $max_inventory){
mysqli_free_result ($iresult);

$to_output .= 'Giving '.ucfirst($itrow->itemname).' '.$itrow->class.' '.$itrow->kind.' value of '.number_format($itemcost).' gold.<br>';
$message = ' this <b>'.ucfirst($itrow->itemname).' '.$itrow->class.'</b> '.$itrow->kind.' is for';
mysqli_query ($link, "UPDATE `$tbl_inventory` SET `charname`='$trow->charname',`used`='0' WHERE `id`='$itrow->id' LIMIT 1") or die_nice(mysqli_error().'talk rror.');

}else{$to_output .= $trow->sex.' '.$trow->charname.'\'s inventory slots is full!<br>';}
}
//INVENTORY ITEMS
	}else{
print '<option value="'.$itrow->id.'">'.ucfirst($itrow->itemname).' '.$itrow->class.' '.$itrow->kind.' value of '.number_format($itemcost).' gold</option>';
	}
}
mysqli_free_result($iresult);
?>
</select></td><td width=15%><input type=submit name=give value="Give Item"></td></tr>
<?php
}else{$to_output .= 'You are not carrying any items with you.<br>';}
}
//GIVE ITEM
?>
</table>
</form>



<?php
if (!empty($message)){

mysqli_query ($link, "INSERT INTO `$tbl_board` values ('','$row->charname','$trow->charname','$message','$current_time')") or die_nice(mysqli_error());
$to_output .= 'You said <b>'.$message.'</b> to <b>'.$trow->sex.' '.$trow->charname.'</b>.<br>';
}

//MESSAGES
if($aresult = mysqli_query ($link, "SELECT * FROM `$tbl_board` WHERE `receiver`='$row->charname' ORDER BY `id` DESC LIMIT 10")){
if(mysqli_num_rows($aresult) >= 1){
?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th>Communication log.</th></tr>
<tr><td><?php
while($arow = mysqli_fetch_object ($aresult)){
print '<sup>'.$arow->charname.'</sup> '.$arow->news.'<br>';
}
mysqli_free_result ($aresult);
?></td></tr></table><?php
}
}
//MESSAGES

}else{$to_output .= 'You said something but he can\'t hear you from here.!';}

}else{$to_output .= 'There\'s nobody to talk with!';}
}else{$to_output .= 'Anybody here!!';}
}else{$to_output .= 'Hi I\'m myself!';}
}else{$to_output .= 'I like to talk with myself.';}
?>