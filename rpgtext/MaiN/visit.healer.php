<?php
#!/usr/local/bin/php

$potion_price = $row->level*25;

?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th>Healer</th></tr><tr><td>My satisfaction is healing people! You will receive free full healing, mind rest for mana recovery and stamina restore from me whenever you visit me! You can carry <?php print $max_potions;?> potions with you! Price per potion is <?php print number_format($potion_price);?> gold.
<?php
if(!empty($_POST['amount'])){$amount=round(clean_post($_POST['amount']));}else{$amount=0;}
if(!empty($_POST['action'])){$action=clean_post($_POST['action']);}else{$action='';}

if($row->life <= 0) {
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','2','','$current_date','The Healer revives <b>$row->sex $row->charname</b>.','$current_time')") or die_nice(mysqli_error().'tax collection paper');
$to_output .= 'You have been revived!';
}

if($row->life < $max_life){
$to_update .= ", `life`=$max_life";
$to_output .= 'You received a free full healing of <b>'.number_format(($max_life)-$row->life).'</b> life.<br>';
$row->life = $max_life;
}else{
$to_output .= 'You don\'t need any healing! You have the maximum life for your current level.<br>';
}



if($row->mana < $max_mana){
$to_update .= ", `mana`=$max_mana";
$to_output .= 'You are at full mana now!<br>';
}
if($row->stamina < $max_stamina){
$to_update .= ", `stamina`=$max_stamina";
$to_output .= 'Stamina should not be stopping you from now on.<br>';
}


if (!empty($action) and $amount >= 1){
	$total_price = round($amount*$potion_price);
	$all_potions = $row->plife+$row->pmana+$row->pstamina+$amount;
	if($all_potions <= $max_potions){
if($row->gold >= $total_price) {
if ($action == 'Life Potion'){
	$to_update .= ", `gold`=`gold`-$total_price, `plife`=`plife`+$amount";
	$to_output .= 'You bought '.$amount.' '.strtolower($action).' for '.number_format($total_price).' gold.';
}elseif ($action == 'Mana Potion'){
	$to_update .= ", `gold`=`gold`-$total_price, `pmana`=`pmana`+$amount";
	$to_output .= 'You bought '.$amount.' '.strtolower($action).' for '.number_format($total_price).' gold.';
}elseif ($action == 'Stamina Potion'){
	$to_update .= ", `gold`=`gold`-$total_price, `pstamina`=`pstamina`+$amount";
	$to_output .= 'You bought '.$amount.' '.strtolower($action).' for '.number_format($total_price).' gold.';
}else{
	$to_output .= 'What? Sorry we don\'t have that.';
}

}else{
	$to_output .= 'You don\' have enough gold to buy those.';
}
	}else{$to_output .= 'You can\'t carry more than '.$max_potions.' potions.';}
}
?>
<form method=post action="?visit=healer">
<table width=100% cellpadding=0 cellspacing=1 border=0><tr><th colspan=5>Buy Your Potions Here for <?php print number_format($potion_price);?> gold</th></tr><tr>
<td width=10% nowrap>Amount</td>
<td width=15%><select name=amount><?for ($i=1;$i<=250;$i++){
	if($i == 10){$i *= 5;}
	if($i == 51){$i = 100;}
	if($i == 101){$i = 250;}
if ($amount == $i){
	print '<option value='.$i.' selected>'.$i.'</option>';
}else{
	print '<option value='.$i.'>'.$i.'</option>';
}

}?></select></td>
<td width=25%><input type=submit name=action value="Life Potion"></td>
<td width=25%><input type=submit name=action value="Mana Potion"></td>
<td width=25%><input type=submit name=action value="Stamina Potion"></td>
</tr></table>
</form>
</td></tr></table>
<?php
//NEWS PAPER LOCATION nid 5 bank
news_paper('','2','Revives');
//NEWS PAPER LOCATION nid 5 bank

//NOOB
if($row->level <= $noob_level){
$to_output .= 'If you are dead you must come to the healer to be revived.';
}
//NOOB
?>