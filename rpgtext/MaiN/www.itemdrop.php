<?php
#!/usr/local/bin/php

$array_item_class= array('broken','damaged', 'normal', 'blind', 'magic', 'demon', 'rare', 'rainbow', 'set', 'unique');

$array_item_kind = array('weapon', 'attackspell', 'healspell', 'helmet', 'shield', 'amulet', 'ring', 'armor', 'belt', 'pant', 'hand', 'feet','cape');

/*_______________-=TheSilenT.CoM=-_________________*/

function item_cost($itrow) {
global $array_item_class;

if($itrow->class == $array_item_class[0]) {
$multiplier = 1;
}elseif($itrow->class == $array_item_class[1]) {
$multiplier = 2;
}elseif($itrow->class == $array_item_class[2]) {
$multiplier = 3;
}elseif($itrow->class == $array_item_class[3]) {
$multiplier = 4;
}elseif($itrow->class == $array_item_class[4]) {
$multiplier = 5;
}elseif($itrow->class == $array_item_class[5]) {
$multiplier = 10;
}elseif($itrow->class == $array_item_class[6]) {
$multiplier = 15;
}elseif($itrow->class == $array_item_class[7]) {
$multiplier = 30;
}elseif($itrow->class == $array_item_class[8]) {
$multiplier = 20;
}elseif($itrow->class == $array_item_class[9]) {
$multiplier = 25;
}else{$multiplier = 1;}

return ($itrow->rlevel+$itrow->damaged+$itrow->durability+$itrow->rstrength+$itrow->rintelligence+$itrow->min+$itrow->max+$itrow->a1+$itrow->a2+$itrow->a3+$itrow->a4+$itrow->a5+$itrow->a6+$itrow->a7+$itrow->a8+$itrow->a9+$itrow->multi)*($multiplier+$itrow->multi);

}
/*_______________-=TheSilenT.CoM=-_________________*/
function charm_cost($crow) {
global $current_time;
$time_left = round($crow->timer-$current_time);
if ($time_left <= 1) {$time_left=1;}

return (($crow->life+$crow->mana+$crow->stamina+$crow->strength+$crow->dexterity+$crow->agility+$crow->intelligence+$crow->concentration+$crow->contravention)*10)+$time_left;

}
/*_______________-=TheSilenT.CoM=-_________________*/

function generator_drop_item($monster_level) {
global $row,$array_item_kind,$tbl_inventory,$current_time,$array_attributes,$array_uniques,$array_sets,$to_output,$to_update,$col_drop,$max_inventory;

if($inresult = mysqli_query ($link, "SELECT `id` FROM `$tbl_inventory` WHERE (`charname`='$row->charname') ORDER BY `id` DESC LIMIT 50")){
if(mysqli_num_rows($inresult) < $max_inventory){

$randed_a = array_rand($array_attributes,9);
	//print $array_attributes[$randed_a[0]].' '.$array_attributes[$randed_a[2]].' '.$array_attributes[$randed_a[4]].' '.$array_attributes[$randed_a[6]].' '.$array_attributes[$randed_a[8]];

$rander_ic = rand(1,1000);
	//$rander_ic = 2; //TURN IT OFF
if($rander_ic <= 50 and $monster_level >= 150){
	$item_class = 'unique';
	$multi=rand(1,11);
	$gen_name= array_rand($array_uniques);
	$atributed = $array_uniques[$gen_name];

}elseif($rander_ic > 50 and $rander_ic <= 100 and $monster_level >= 100){
	$item_class = 'set';
	$multi=rand(1,10);
	$gen_name= array_rand($array_sets);
	$atributed = $array_sets[$gen_name];
}elseif($rander_ic > 100 and $rander_ic <= 150){
	$item_class = 'rainbow';
	$multi=rand(1,9);
	if(rand(1,100) <= 10){
	$atributed = "'".$randed_a[0]."', '".$randed_a[1]."', '".$randed_a[2]."', '".$randed_a[3]."', '".$randed_a[4]."', '".$randed_a[5]."', '0', '0', '0'";
	}else{
	$atributed = "'".$randed_a[0]."', '".$randed_a[1]."', '".$randed_a[2]."', '".$randed_a[3]."', '".$randed_a[4]."', '0', '0', '0', '0'";
	}
}elseif($rander_ic > 150 and $rander_ic <= 250){
	$item_class = 'rare';
	$multi=rand(1,8);
	if(rand(1,100) <= 10){
	$atributed = "'".$randed_a[0]."', '".$randed_a[1]."', '".$randed_a[2]."', '".$randed_a[3]."', '".$randed_a[4]."', '0', '0', '0', '0'";
	}else{
	$atributed = "'".$randed_a[0]."', '".$randed_a[1]."', '".$randed_a[2]."', '".$randed_a[3]."', '0', '0', '0', '0', '0'";
	}
}elseif($rander_ic > 250 and $rander_ic <= 350){
	$item_class = 'demon';
	$multi=rand(1,7);
	if(rand(1,100) <= 10){
	$atributed = "'".$randed_a[0]."', '".$randed_a[1]."', '".$randed_a[2]."', '".$randed_a[3]."', '0', '0', '0', '0', '0'";
	}else{
	$atributed = "'".$randed_a[0]."', '".$randed_a[1]."', '".$randed_a[2]."', '0', '0', '0', '0', '0', '0'";
	}
}elseif($rander_ic > 350 and $rander_ic <= 500){
	$item_class = 'blind';
	$multi=rand(1,6);
	if(rand(1,100) <= 10){
	$atributed = "'".$randed_a[0]."', '".$randed_a[1]."', '".$randed_a[2]."', '0', '0', '0', '0', '0', '0'";
	}else{
	$atributed = "'".$randed_a[0]."', '".$randed_a[1]."', '0', '0', '0', '0', '0', '0', '0'";
	}
}elseif($rander_ic > 500 and $rander_ic <= 650){
	$item_class = 'magic';
	$multi=rand(1,5);
	if(rand(1,100) <= 10){
	$atributed = "'".$randed_a[0]."', '".$randed_a[1]."', '0', '0', '0', '0', '0', '0', '0'";
	}else{
	$atributed = "'".rand(0,24)."', '0', '0', '0', '0', '0', '0', '0', '0'"; //o-24 +points
	}
}elseif($rander_ic > 650 and $rander_ic <= 700){
	$item_class = 'broken';
	$multi=0;
	$atributed = "'0', '0', '0', '0', '0', '0', '0', '0', '0'";
}elseif($rander_ic > 700 and $rander_ic <= 900){
	$item_class = 'normal';
	$multi=0;
	$atributed = "'0', '0', '0', '0', '0', '0', '0', '0', '0'";
}else{
	$item_class = 'damaged';
	$multi=0;
	$atributed = "'0', '0', '0', '0', '0', '0', '0', '0', '0'";
}

	//print $atributed;

if(empty($gen_name)){
$gen_name = generator_name();
}
$rander_it = array_rand($array_item_kind);
$gen_type = generator_item_type($rander_it);

$min_damage=rand(rand(1,10),rand(10,50));
$max_damage=rand(rand(50,100),rand(100,150));
if ($min_damage > $max_damage) {$max_damage=round($min_damage*rand(2.00,3.00));}

$durability = round(($min_damage+$max_damage)*5,0);
$damaged = rand(1,$durability/2);

	//must be same as generator_shop_item()
$required_level=round(($min_damage+$max_damage)/10);
$required_strength=round(($min_damage+$max_damage)/3);
$required_intelligence=round(($min_damage+$max_damage)/3);
		//print $required_level.' '.$required_strength.' '.$required_intelligence.'<br>';
if ($required_level < 1){$required_level = 0;}if($required_level > 75){$required_level = 75;}
if ($required_strength < 1){$required_strength = 0;}
if ($required_intelligence < 1){$required_intelligence = 0;}

if ($array_item_kind[$rander_it] == 'ring' or $array_item_kind[$rander_it] == 'amulet') {
	$required_strength=0;$required_intelligence=0;
	$min_damage=0;$max_damage=0;
	$durability=0;$damaged=0;
}elseif ($array_item_kind[$rander_it] == 'attackspell' or $array_item_kind[$rander_it] == 'healspell' or $array_item_kind[$rander_it] == 'cape') {
	$required_strength=0;
	$durability=0;$damaged=0;
} else {
	$required_intelligence=0;
}
	//must be same as generator_shop_item()

if ($item_class == 'unique') {
	$required_level=0;
	//$required_strength=0;$required_intelligence=0;
	$durability=0;$damaged=0;
	$itemname_final = $gen_name;
}elseif ($item_class == 'set') {
	//$required_level=0;
	//$required_strength=0;$required_intelligence=0;
	//$durability=0;$damaged=0;
	$itemname_final = $gen_name;
}else{
	$itemname_final = $gen_name.' '.$gen_type;
}

$val_item = "'', '$row->charname', '', '$itemname_final', '$item_class', '$array_item_kind[$rander_it]', '$damaged', '$durability', '$multi', '$required_level', '$required_strength', '$required_intelligence', '$min_damage', '$max_damage', $atributed, '$current_time'";
	//print $val_item;
mysqli_query ($link, "INSERT INTO `$tbl_inventory` values ($val_item)") or die_nice(mysqli_error().'Generator drop item.');
$to_output .= '<font color="'.$col_drop.'">You have found <b>'.$itemname_final.' '.$item_class.' '.$array_item_kind[$rander_it].'</b>.</font><br>';

}else{
$found_gold = rand(100,1000);
$to_update .= ", `gold`=`gold`+$found_gold";
$to_output .= '<font color="'.$col_drop.'">You found a '.number_format($found_gold).' gold.</font><br>';
}
mysqli_free_result ($inresult);
}
}

/*_______________-=TheSilenT.CoM=-_________________*/
function generator_shop_item() {
global $row,$array_item_kind,$tbl_inventory,$current_time;

$rander_ic = rand(1,100);
if($rander_ic <= 25){
	$item_class = 'magic';
	$multi=rand(1,9);
	$item_attribute = rand(0,24); //o-24 +points
}elseif($rander_ic > 25 and $rander_ic <= 50){
	$item_class = 'damaged';
	$multi=1;
	$item_attribute =0;
}else{
	$item_class = 'normal';
	$multi=2;
	$item_attribute =0;
}

$gen_name = generator_name();
$rander_it = array_rand($array_item_kind);
$gen_type = generator_item_type($rander_it);

$min_damage=rand($row->level*1,$row->level*5);
$max_damage=rand($row->level*5,$row->level*10);
if ($min_damage > $max_damage) {$max_damage=round($min_damage*rand(2.00,3.00));}

$durability = round(($min_damage+$max_damage)*5,0);
$damaged = rand(1,$durability/2);

	//must be same as generator_drop_item()
$required_level=round(($min_damage+$max_damage)/10);
$required_strength=round(($min_damage+$max_damage)/3);
$required_intelligence=round(($min_damage+$max_damage)/3);
		//print $required_level.' '.$required_strength.' '.$required_intelligence.'<br>';
if ($required_level < 1){$required_level = 0;}if($required_level > 75){$required_level = 75;}
if ($required_strength < 1){$required_strength = 0;}
if ($required_intelligence < 1){$required_intelligence = 0;}


if ($array_item_kind[$rander_it] == 'ring' or $array_item_kind[$rander_it] == 'amulet') {
	$required_strength=0;$required_intelligence=0;
	$min_damage=0;$max_damage=0;
	$durability=0;$damaged=0;
	$multi=rand(1,9);$item_attribute = rand(0,24); //o-24 +points
}elseif ($array_item_kind[$rander_it] == 'attackspell' or $array_item_kind[$rander_it] == 'healspell' or $array_item_kind[$rander_it] == 'cape') {
	$required_strength=0;
	$durability=0;$damaged=0;
	$multi=rand(1,9);$item_attribute = rand(0,24); //o-24 +points
} else {
	$required_intelligence=0;
}
	//must be same as generator_drop_item()

//LEVEL ADAPTION FOR SHOP
if ($required_level > $row->level) {$required_level = $row->level;}
if ($required_strength > $row->strength) {$required_strength = $row->strength;}
if ($required_intelligence > $row->intelligence) {$required_intelligence = $row->intelligence;}
//LEVEL ADAPTION FOR SHOP

$val_item = "'', '', '', '$gen_name $gen_type', '$item_class', '$array_item_kind[$rander_it]', '$damaged', '$durability', '$multi', '$required_level', '$required_strength', '$required_intelligence', '$min_damage', '$max_damage', '$item_attribute', '0', '0', '0', '0', '0', '0', '0', '0', '$current_time'";
	//print $val_item;
mysqli_query ($link, "INSERT INTO `$tbl_inventory` values ($val_item)") or die_nice(mysqli_error().'Generator shop item.');

}

/*_______________-=TheSilenT.CoM=-_________________*/

function generator_name() {
$even=array('y','u','i','e','e','e','e','e','o','o','o','o','o','a','a','a','a','a');
$oven=array('q','w','r','t','y','p','s','d','f','g','h','j','k','l',' ','z','x','c','v','b','n','x','c','m','r','s','t','s','n','l','p','d','s','t','r','n');

$max_length=round(rand(3,8));
$name_generated='';$i=0;
while (strlen($name_generated) < $max_length) {
	srand((float) microtime() * 10000000);
	$aro=array_rand($oven);
	$name_generated .=$oven[$aro];
		if (strlen($name_generated) >= $max_length) {break;}
	srand((float) microtime() * 10000000);
	$are=array_rand($even);
	$name_generated .=$even[$are];
	if (strlen($name_generated) >= $max_length) {break;}
	$i++;
	if ($i > 5) {break;}
}

return $name_generated;
}
/*_______________-=TheSilenT.CoM=-_________________*/
function generator_item_type($in) {
global $array_item_kind;

if ($array_item_kind[$in] == 'amulet') {
$array_items_temp=array('stone','eye','ear','heart','tooth','chaos','king','unicorn','war','mind');
} elseif ($array_item_kind[$in] == 'armor') {
$array_items_temp=array('shirt','plate','mail','stone','bamboo','leather','wooden','demon','ornate','iron','chaos','titan');
} elseif ($array_item_kind[$in] == 'attackspell') {
$array_items_temp=array('ice','fire','ligtning','frost','summon','soul','ghost','lava','tornado','nuke','elements');
} elseif ($array_item_kind[$in] == 'belt') {
$array_items_temp=array('rope','bamboo','plated','wooden','demon','flesh','iron','chaos','lash');
} elseif ($array_item_kind[$in] == 'feet') {
$array_items_temp=array('boots','shoes','slippers','hoof','sandal','socks');
} elseif ($array_item_kind[$in] == 'hand') {
$array_items_temp=array('handshoes','gloves','gauntlets','bracers');
} elseif ($array_item_kind[$in] == 'healspell') {
$array_items_temp=array('rest','heal','relief','rebirth','life','resurrect','recover','healing');
} elseif ($array_item_kind[$in] == 'helmet') {
$array_items_temp=array('cap','horn','mask','tusk','hat');
} elseif ($array_item_kind[$in] == 'pant') {
$array_items_temp=array('jeans','trousers','pantalon','tight','silk','leather','hose',);
} elseif ($array_item_kind[$in] == 'ring') {
$array_items_temp=array('stone','ring','diamond','crystal','gold','silver','bronce','iron',);
} elseif ($array_item_kind[$in] == 'shield') {
$array_items_temp=array('buckler','stone','bamboo','wooden','demon','ornate','iron','chaos','titan');
} elseif ($array_item_kind[$in] == 'weapon') {
$array_items_temp=array('knife','sword','lance','hammer','scepter','bat','staff','pole','katana','fork','scythe','mace','axe','dirk','spear','longsword','dagger','bow','longbow','crossbow','nunjakos','scissors','sword','poleaxe','boomerang');
} elseif ($array_item_kind[$in] == 'cape') {
$array_items_temp=array('vampire','demonic','super','invisible','chaos','reflect');
}else{
die_nice('Unknown Item Found! Generator item type.');
}

srand((float) microtime() * 10000000);
$randed_it=array_rand($array_items_temp);
return $array_items_temp[$randed_it];

}

/*_______________-=TheSilenT.CoM=-_________________*/
function drop_something($monster_level) {
global $row,$total_stats,$search_location,$col_drop,$max_gold_drop;
$drop_gold = 0;

// $total_stats[51] drop gold
// $total_stats[52] drop chance

$drop_power=1+($row->honor+$total_stats[52]);
if($drop_power <= 0){$drop_power=1;}
//print 'drop power'.$drop_power;

$drop_chance=25+$total_stats[52]+$monster_level;
if($drop_chance < 5){$drop_chance=5;}
//print 'drop chance'.$drop_chance;

srand((float) microtime() * 10000000);
$rander_ic = rand(1,1000);
$rander_package = rand(1,300);

//print '<HR>TEST<HR>Drop Chance:'.$drop_chance.' Dizea:'.$rander_ic.'Dizeb:'.$rander_package;

if($rander_ic <= 150){
	if($rander_package <= $drop_chance and rand(1,10) <= 9){
		generator_drop_item($monster_level);
	}
}elseif($rander_ic > 150 and $rander_ic <= 300){
	if($rander_package <= $drop_chance and rand(1,10) <= 9){
		generator_drop_charm($monster_level);
	}
}elseif($rander_ic > 300 and $rander_ic <= 750){
	if(rand(1,10) <= 9){ //$rander_package <= $drop_chance and 
		$drop_gold = ($monster_level*500)+round((1+$monster_level)*($drop_power+$total_stats[51]));
		if($drop_gold > $max_gold_drop){
			$drop_gold=$max_gold_drop;
		}
	}
}else{
	if(!empty($search_location)){
	$to_output .= '<font color="'.$col_drop.'">You have found nothing.</font><br>';
	}
}

return $drop_gold;
}
/*_______________-=TheSilenT.CoM=-_________________*/
function generator_drop_charm($monster_level) {
global $row,$tbl_charms,$to_update,$to_output,$current_time,$col_drop,$max_charms;

if($aresult = mysqli_query ($link, "SELECT `id` FROM `$tbl_charms` WHERE (`charname`='$row->charname') ORDER BY `id` DESC LIMIT 25")){
if(mysqli_num_rows($aresult) < $max_charms){

$array_name = array ('shi','da', 'ra', 'de', 'at', 'da', 'ra', 'de', 'at', 'ma', 'ma', 'shy', 'io', 'lo', 'la', 'zi' ,'xi');

srand((float) microtime() * 10000000);

$charmname=$array_name[array_rand($array_name)].$array_name[array_rand($array_name)].$array_name[array_rand($array_name)];
//print $charmname;

$monster_level= round($monster_level/100);if($monster_level < 1){$monster_level=1;}

$cschance=rand(0,9);$pchance=rand(0,9);$tchance=rand(0,9);
$pchance += $monster_level;if($pchance > 10){$pchance=10;}
$tchance += $monster_level;if($tchance > 10){$tchance=10;}
switch ($cschance) {
case $cschance == 0 : $precharm = "0,0,".rand(1,$pchance*$tchance).",0,0,".rand(1,$pchance*$tchance);break;
case $cschance == 1 : $precharm = "0,".rand(1,$pchance*$tchance).",0,0,".rand(1,$pchance*$tchance).",0";break;
case $cschance == 2 : $precharm = rand(1,$pchance*$tchance).",0,0,".rand(1,$pchance*$tchance).",0,0";break;
case $cschance == 3 : $precharm = "0,0,0,".rand(1,$pchance).",".rand(1,$pchance).",".rand(1,$pchance);break;
case $cschance == 4 : $precharm = rand(1,$pchance).",".rand(1,$pchance).",".rand(1,$pchance).",0,0,0";break;
case $cschance == 5 : $precharm = "0,".rand(1,$pchance).",".rand(1,$pchance).",0,".rand(1,$pchance).",".rand(1,$pchance);break;
case $cschance == 6 : $precharm = rand(1,$pchance).",".rand(1,$pchance).",0,".rand(1,$pchance).",".rand(1,$pchance).",0";break;
case $cschance == 7 : $precharm = rand(1,$pchance).",".rand(1,$pchance).",".rand(1,$pchance).",".rand(1,$pchance).",".rand(1,$pchance).",".rand(1,$pchance);break;
case $cschance == 8 : $precharm = rand(1,$pchance).",0,".rand(1,$pchance).",".rand(1,$pchance).",0,".rand(1,$pchance);break;
case $cschance == 9 : $precharm = rand(1,$tchance*$cschance).",".rand(1,$tchance*$cschance).",".rand(1,$tchance*$cschance).",".rand(1,$tchance*$cschance).",".rand(1,$tchance*$cschance).",".rand(1,$tchance*$cschance);break;
}

$charm= "'','$row->charname','$charmname','".rand(1,$tchance*$cschance)."','".rand(1,$tchance*$cschance)."','".rand(1,$tchance*$cschance)."',$precharm,'($current_time+25000)'";
mysqli_query ($link, "INSERT INTO `$tbl_charms` VALUES ($charm)") or die_nice(mysqli_error().'Generator drop charm.');
$to_output .= '<font color="'.$col_drop.'">You found a <b>stats charm</b>.</font><br>';

}else{
$found_gold = rand(100,1000);
$to_update .= ", `gold`=`gold`+$found_gold";
$to_output .= '<font color="'.$col_drop.'">You found a '.number_format($found_gold).' gold.</font><br>';
}
mysqli_free_result ($aresult);
}
}
/*_______________-=TheSilenT.CoM=-_________________*/
?>