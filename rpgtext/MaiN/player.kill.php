<?php
#!/usr/local/bin/php
$distance = 1;
$max_killing = 3;

?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th>Killing Spree</th></tr><tr><td>A group of monsters working together will make them stronger as they have the benefit of more men power. To attack a group of monsters you must have at least 5 battle skills and magic skills. Attack up to <?php print $max_killing; ?> monsters on the map!<br>
<?php
if ($freeplay >= 1 and $row->level >= 100 and $row->battleskill >= 5 and $row->magicskill >= 5 and $row->life >= 1) {





	//MONSTERS LIST
if($mlresult = mysqli_query ($link, "SELECT * FROM `$tbl_fight` WHERE (`x` BETWEEN ".($row->x-$distance)." AND ".($row->x+$distance).") AND (`y` BETWEEN ".($row->y-$distance)." AND ".($row->y+$distance).") ORDER BY `id` ASC LIMIT $max_killing")) {
	$monsters_here = mysqli_num_rows($mlresult);
	if($monsters_here >= 1){



//PLAYER STATS
if(empty($total_stats)){$total_stats=total_stats();}
if(empty($total_charmed)){$total_charmed=total_charms();}
$i=0;
foreach ($stats as $val) {
if($i >= 3){
	$row->$val = ($row->$val/100)*(100+$total_charmed[$i]);
}
}
$battle_stats=battle_stats();

//print $battle_stats[0].' '.$battle_stats[6];
//PLAYER STATS



		while ($mrow = mysqli_fetch_object ($mlresult)) {

//FIGHT ON

$mrow->dupe *= 2;
$mrow->dupe *= $monsters_here;

$mon_stats = monster_stats($mrow);
//$mon_exp =(96+((1+$mrow->charname)*(1+$mrow->charname))*$mrow->charname)*(1+$mrow->dupe); //lol1 exp
$mon_exp = (($mrow->charname*$mrow->charname)+$mrow->mana+$mrow->stamina)*(1+$mrow->dupe);
$mon_exp -= $row->level;
if ($mon_exp <= 1) {$mon_exp = 10;}
if($mon_exp > $max_exp_gain){$mon_exp = $max_exp_gain+$mrow->charname+$mrow->dupe;}

if (empty($array_strength[$mrow->dupe])) {
$monster_class = 'unknown uber powerfull';
}else {
$monster_class = $array_strength[$mrow->dupe];
}

$fight_on .= 'Approaching <b>'.$array_monsters[$mrow->charname].'</b>, an <b>'.$monster_class.'</b> level <b>'.$mrow->charname.'</b> monster with <b>'.number_format($mrow->life).'</b> life.<br>';

	$to_update_monster ="`timer`='$current_time', `ocharname`='$row->charname'";
$fight_on .= 'Estimated power of the monster <b>'.number_format(array_sum($mon_stats)/14).'</b>, your total power is <b>'.number_format(array_sum($battle_stats)/14).'</b>.<br>'; // and '.number_format($mon_exp).' experience.<br>';

$to_damage = 0;
$to_steal_life = 0;
$to_steal_mana = 0;
$to_steal_stamina = 0;
$col_me='';

if ($battle_stats[0] >= $battle_stats[6]) {	//MELEE ATTACK SKILL
	$action = 'use battle skill';
	$i=0;
	while ($i < $max_rounds and $i<1+$row->battleskill and $mrow->life > 0 and $row->life > 0){
	//for ($i=0;$i<=1+$row->battleskill;$i++){if($i >= $max_rounds){break;}
	attack_use_weapon();
	$i++;
}
	$col_me = $col_melee;
	$fight_on .= 'Strikes '.$i.' times.';
	$to_update .= ", `stamina`='$row->stamina'";
} else { 	//MYSTIC ATTACK SKILL
	$action = 'cast magic skill';
	$i=0;
	while ($i < $max_rounds and $i<1+$row->magicskill and $mrow->life > 0 and $row->life > 0){
	//for ($i=0;$i<=1+$row->magicskill;$i++){if($i >= $max_rounds){break;}
	attack_cast_spell();
	$i++;
}
	$col_me = $col_magic;
	$fight_on .= 'Casted '.$i.' times.';
	$to_update .= ", `mana`='$row->mana'";
}

if($to_damage>1){

	$fight_on .= '<font color="'.$col_me.'">You '.$action.' for '.number_format($to_damage).' damage.</font>';
	mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','6','$mrow->id','$current_date','$row->sex $row->charname ".$action." ".number_format($to_damage)." damage.','$current_time')") or die_nice(mysqli_error().'deploy paper');

	//STEAL
	$to_steal = '';
	if($to_steal_life>=1){$to_update .= ", `life`=`life`+$to_steal_life";$to_steal .= 'Stealing '.number_format($to_steal_life).' life.';}
	if($to_steal_mana>=1){$to_update .= ", `mana`=`mana`+$to_steal_mana";$to_steal .= 'Stealing '.number_format($to_steal_mana).' mana.';}
	if($to_steal_stamina>=1){$to_update .= ", `stamina`=`stamina`+$to_steal_stamina";$to_steal .= 'Stealing '.number_format($to_steal_stamina).' stamina.';}
	if(!empty($to_steal)){$fight_on .= '<font color="'.$col_steal.'">'.$to_steal.'</font><br>';}
	//STEAL
}

monster_does();

	//WIN OR lOSS
if ($mrow->life < 0 and $row->life > 0) {
	$fight_on .= 'You have slain <b>'.$array_monsters[$mrow->charname].'</b>, you gain <b>'.number_format($mon_exp).'</b> experience!<br>';
		if ($freeplay >= 1){
		$mon_exp *= 2;
		}
		$to_update .= ", `exp`=`exp`+$mon_exp";
if($mrow->charname*$mrow->dupe >= $row->level) {
	//print 'aaaaaaaaaaaaaaaaaaaaaa';
	$to_update .= ", `honor`=`honor`+0.01";
}
monster_dies_or_revives($mrow->id);
	$drop_gold = drop_something($mrow->charname);


	//$drop_gold = 10000;
	//DROP GOLD AND TAX COLLECTIONS
if($drop_gold >= 1){
	$fight_on .= '<font color="'.$col_drop.'">Found <b>'.number_format($drop_gold).'</b> gold';
if(!empty($krow->tax) and !empty($krow->charname)){
if ($krow->tax >= 1 and $krow->tax <= 75){
	$drop_gold /= 100;
	$tax_gold = round($drop_gold*$krow->tax);
	$drop_gold = round($drop_gold*(100-$krow->tax));
	$fight_on .= ' kingdom tax <b>'.number_format($tax_gold).'</b> gold';
mysqli_query ($link, "UPDATE `$tbl_kingdoms` SET `gold`=`gold`+'$tax_gold' WHERE `id`='$krow->id' LIMIT 1") or die_nice(mysqli_error().'tax collection');
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','5','$krow->charname','$current_date','Tax collected by <b>$krow->kingdom</b> kingdom from $row->sex $row->charname <b>".number_format($tax_gold)."</b> gold.','$current_time')") or die_nice(mysqli_error().'tax collection paper');
}
}
	if ($freeplay >= 1){
	$drop_gold *= 2;
	}
	$to_update .= ", `gold`=`gold`+$drop_gold";
	$fight_on .= ' .</font><br>';
}
	//DROP GOLD AND TAX COLLECTIONS

}elseif ($mrow->life > 0 and $row->life < 0) {

	$fight_on .= 'You have been slain by <b>'.$array_monsters[$mrow->charname].'</b>';
	$to_update .= ", `life`=0";
	if($row->exp > $prev_level) {
	if($row->exp-$mon_exp < $prev_level){
		$to_update .= ", `exp`='$prev_level'";
	}else{
		$to_update .= ", `exp`=`exp`-$mon_exp";
	}
	$fight_on .= ', you lost <b>'.number_format($mon_exp).'</b> experience';
	}
	if($row->gold >= 1){
	$to_update .= ", `gold`=`gold`-".$row->gold/50;
	$fight_on .= ', you lost <b>'.number_format($row->gold/50).'</b> gold';
	}
	$fight_on .= '!<br>';
}elseif ($mrow->life < 0 and $row->life < 0) {
	$fight_on .= 'You are both dead! Nobody lost!<br>';
}elseif ($mrow->life > 0 and $row->life > 0) {
	$fight_on .= 'Keep on trying!<br>';
}else{
	$fight_on .= 'Don\'t know what happend here?<br>';
}

$fight_on .= 'You have '.number_format($row->life).' life, '.number_format($row->mana).' mana and '.number_format($row->stamina).' stamina left.<br>';

	//WIN OR lOSS
	
mysqli_query ($link, "UPDATE `$tbl_fight` SET $to_update_monster WHERE `id`='$mrow->id' LIMIT 1") or die_nice(mysqli_error().'monsters timer');



$fight_on .= '<hr>';
		}
		mysqli_free_result ($mlresult);
	}
}
	//MONSTERS LIST

if(!empty($fight_on)){
?><table width=100% cellpadding=0 cellspacing=1 border=0><tr><th>Fight Analysis</th><tr><td><font size=-1><?php
print $fight_on;//$fight_on='';
?></font></td></tr></table><?php
}


} else {
	if ($row->life <= 0) {
		print 'You are dead.';
	} else {
		print '<br><br>This feature is only available for Freeplay players and you must have reached level 100.';
	}
}
?>
</td></tr></table>