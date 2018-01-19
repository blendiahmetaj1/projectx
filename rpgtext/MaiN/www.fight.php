<?php
#!/usr/local/bin/php
/*
###_______________-=TheSilenT.CoM=-_______________###
Project name: Project name
Script name: Script name
Version: 1.00
Release date: 25-03-2002 06:06
Last Update: 04-04-2002 03:35
Email: silly@thesilent.com
Homepage: http://www.thesilent.com
Created by: TheSilent
Last modified by: TheSilent
###_______________COPYRIGHT NOTICE_______________###
*/

function monster_dies_or_revives($mid) {
global $tbl_fight,$current_time,$array_monsters, $min_x_go,$min_y_go,$max_x_go,$max_y_go,$array_strength;
if(rand(1,100) <= 50) {
$nx = rand($min_x_go,$max_x_go);
$ny = rand($min_y_go,$max_y_go);
$nmonster = rand(1,150);

$monstr=rand(0,count($array_strength)-1);
$monster_name=rand(0,count($array_monsters)-1);

$mlife=$nmonster*rand(100,((rand(1,$max_x_go)*rand(1,$max_y_go))*100));
$mmana=$monster_name*$monstr*$max_x_go;
$mstamina=$monster_name*$monstr*$max_y_go;

mysqli_query ($link, "UPDATE `$tbl_fight` SET `x`='$nx',`y`='$ny',`charname`='$nmonster',`life`='$mlife',`mana`='$mmana',`stamina`='$mstamina',`ocharname`='',`timer`='$current_time' WHERE `id`='$mid' LIMIT 1") or die_nice(mysqli_error().'monster killed error');
}else{
mysqli_query ($link, "DELETE FROM `$tbl_fight` WHERE `id`='$mid' LIMIT 10") or die_nice(mysqli_error());
}
}
/*_______________-=TheSilenT.CoM=-_________________*/

function doit($min,$max) {
$randed = rand(1000,5000)/1000;
$randed = round($max/$randed);
	//print $min.' '.$max.' '.$randed.'A<br>';
if ($randed < $min) { $randed=$min;}
if ($randed > $max) { $randed=$max;}
	//print $min.' '.$max.' '.$randed.'B<br>';
return ($randed);
}
/*_______________-=TheSilenT.CoM=-_________________*/
function generate_monsters() {
global $row,$tbl_fight,$current_time,$array_monsters,$min_x_go,$min_y_go,$max_x_go,$max_y_go,$array_strength;

$monster_name=rand(0,count($array_monsters)-1);

$monx = rand($min_x_go,$max_x_go);
$mony = rand($min_y_go,$max_y_go);
$monstr=rand(0,count($array_strength)-1);

$mlife=$monstr*rand(100,((rand(1,$max_x_go)*rand(1,$max_y_go))*100));
$mmana=$monster_name*$monstr*$max_x_go;
$mstamina=$monster_name*$monstr*$max_y_go;

$monste_val = "'', '$monx', '$mony', '$monster_name', '$mlife', '$mmana', '$mstamina','','$monstr','$current_time'";
	//echo $val_item;
mysqli_query ($link, "INSERT INTO `$tbl_fight` values ($monste_val)") or die_nice(mysqli_error().'Monster generator');

}
/*_______________-=TheSilenT.CoM=-_________________*/
function monster_stats($mrow) {
$mon_stats = array (0,0,0,0,0,0,0,0,0,0,0,0,0,0);

$mrow->dupe <= 0 ?$mrow->dupe=0.1:'';
$mon_standard_melee = $mrow->charname+$mrow->stamina+$mrow->dupe;
$mon_standard_magic = $mrow->charname+$mrow->mana+$mrow->dupe;
$mrow->life *= $mrow->dupe;
$mrow->exp = ($mrow->charname+$mrow->life+$mrow->mana+$mrow->stamina)*$mrow->dupe;

$i=0;foreach ($mon_stats as $val) {
	if($i <= 5){$todupe=$mon_standard_melee;}else{$todupe=$mon_standard_magic;}
if (empty($minstats)) {
$mon_stats[$i]=$todupe*$mrow->dupe;$minstats=1;
} else {
$mon_stats[$i]=$todupe*$mrow->dupe*2;$minstats=0;
}
$i++;
}
	//global $tbl_fight;mysqli_query ($link, "DELETE FROM `$tbl_fight` WHERE `id` LIMIT 1000") or die_nice(mysqli_error());
	//foreach($mon_stats as $val) {print $val.'<br>test ';}print $mrow->stamina.' '.$mrow->mana;
return $mon_stats;
}
/*_______________-=TheSilenT.CoM=-_________________*/
function monster_does() {
global $row,$mrow,$battle_stats,$mon_stats,$to_update_monster,$max_life,$array_monsters,$to_update,$fight_on;
//MONSTER DON'T USE UP MANA BECAUSE THE EXP IS BASED UPON IT!

$mon_max_life = $mrow->charname*$max_life;

$fight_on .= '<font color=#888000>'.$array_monsters[$mrow->charname].' ';

if($mrow->life < $mon_max_life and rand(1,100) < 20){
	//HEALS
if ($mrow->mana >= 1) {
$healing=doit($mon_stats[12],$mon_stats[13]);

//can't heal more than monster max life
if($mrow->life+$healing >= $mon_max_life){$healing = $mon_max_life/2;}

//can't heal more than life
if($healing > $mrow->life and $healing > 1 and $mrow->life > 1){$healing = rand(10,$mrow->life/2);}

if($healing <= 1){ $healing = rand(1,$mon_max_life/2);}

$fight_on .= 'heals for '.number_format($healing).' life!';
$mrow->life +=$healing;
$to_update_monster .= ", `life`=`life`+$healing";
} else {
$fight_on .= 'calls for spiritual powers!';
}
	//HEALS
}elseif ($mon_stats[0] >= $mon_stats[6] or rand(1,100) < 25) { // or $mrow->stamina >= $mrow->mana or rand(1,10) < 3
	//ATTACKS
if ($mrow->stamina >= 1 and rand(1,100) > 5) {
$damage= doit($mon_stats[0],$mon_stats[1]);
$dar= doit($mon_stats[2],$mon_stats[3]);
$oar= doit($battle_stats[2],$battle_stats[3]);
$defence= doit($battle_stats[4],$battle_stats[5]);
$stamina= doit($mrow->charname,($mrow->charname*$mrow->charname)*5);
$damage -= $defence;
if ($dar >= $oar) {
if ($damage <= 0) {
$fight_on .= 'attack got blocked!';
} else {
		//damage can't be higher than player life to make game more enjoyable
		if($damage > $row->life and $row->life >= 10000 and $row->quests >= 16) {$damage = $row->life-1;}
$fight_on .= 'hits for '.number_format($damage).' damage.';
$row->life -= $damage;
$to_update .= ", `life`=`life`-$damage";
if ($mrow->life >= 1 and rand(1,10) <= 3) {
$mrow->life+=$mrow->charname;
$mrow->mana+=$mrow->charname;
$mrow->stamina+=$mrow->charname;
$mrow->life+=(($damage/100)*$mrow->charname);
$mrow->mana+=(($damage/100)*$mrow->charname);
$mrow->stamina+=(($damage/100)*$mrow->charname);
}
}
} else {
$fight_on .= 'misses!';
}

} else {
$fight_on .= 'takes a rest!';
}

	//ATTACKS
}elseif ($mon_stats[6] >= $mon_stats[0] or rand(1,100) < 25) { //$mrow->mana >= $mrow->stamina or rand(1,10) < 3
	//CAST
if ($mrow->mana >= 1 and rand(1,100) > 5) {
$damage= doit($mon_stats[6],$mon_stats[7]);
$dar= doit($mon_stats[8],$mon_stats[9]);
$oar= doit($battle_stats[8],$battle_stats[9]);
$defence= doit($battle_stats[10],$battle_stats[11]);
$mana= doit($mrow->charname,($mrow->charname*$mrow->charname)*5);
$damage-= $defence;
if ($dar >= $oar) {
if ($damage <= 0) {
$fight_on .= 'got contravented!';
} else {
		//damage can't be higher than player life to make game more enjoyable
		if($damage > $row->life and $row->life >= 10000 and $row->quests >= 16) {$damage = $row->life-1;}
$fight_on .= 'cast for '.number_format($damage).' damage.';
$row->life -= $damage;
$to_update .= ", `life`=`life`-$damage";
}
} else {
$fight_on .= 'fizzles!';
}

} else {
$fight_on .= 'calls for spiritual powers!';
$to_update_monster .= ", `mana`='($mrow->charname*$mrow->charname)'";
}
	//CAST
} else {
$fight_on .= 'takes a rest!';
}

$fight_on .= '</font><br>';
}
/*_______________-=TheSilenT.CoM=-_________________*/

function attack_use_weapon() {
global $row,$mrow,$tbl_inventory,$battle_stats,$mon_stats,$to_update,$to_update_monster,$min_succes_chance,$max_stamina,$use_battle,$total_stats,$col_melee,$col_steal,$current_date,$current_time,$fight_on,$to_steal_life,$to_damage,$to_steal_mana,$to_steal_stamina;

$steal_life=0;$steal_mana=0;$steal_stamina=0;

$fight_on .= '<font color="'.$col_melee.'">';

if ($row->stamina >= 1) {
$row->stamina -= $use_battle;

$damage = doit($battle_stats[0],$battle_stats[1]);
$defense = doit($mon_stats[4],$mon_stats[5]);

$damage -= $defense;
$randed = rand(1,100);
if($damage <= 0){if ($randed <= ($min_succes_chance+$row->honor)){$damage=$randed;}}

$my_ar = doit($battle_stats[2],$battle_stats[3]);
$mon_ar = doit($mon_stats[2],$mon_stats[3]);

if ($my_ar >= $mon_ar or $randed <= ($min_succes_chance+$row->honor)) {
if ($damage <= 0) {
$fight_on .= 'Blocked!';
} else {

//STEALING
//if($mrow->life >= 1) {
if ($total_stats[20] >= 1) {$steal_life += rand(1,1+$total_stats[20]);}
if ($total_stats[21] >= 1) {$steal_mana += rand(1,1+$total_stats[21]);}
if ($total_stats[22] >= 1) {$steal_stamina = rand(1,1+$total_stats[22]);}
if ($total_stats[45] >= 1) {$steal_life +=rand(1,1+($damage/100)*(1+$total_stats[45]));}
if ($total_stats[46] >= 1) {$steal_mana +=rand(1,1+($damage/100)*(1+$total_stats[46]));}
if ($total_stats[47] >= 1) {$steal_stamina +=rand(1,1+($damage/100)*(1+$total_stats[47]));}

if($steal_life >= 1){
$to_steal_life += $steal_life;
}
if($steal_mana >= 1){
$to_steal_mana += $steal_mana;
}
if($steal_stamina >= 1){
$to_steal_stamina += $steal_stamina;
}
//}
//STEALING

//$fight_on .= 'Hit for '.number_format($damage).' damage.';
$to_damage += $damage;
$to_update_monster .= ", `life`=`life`-$damage";
$mrow->life -= $damage;

}
mysqli_query ($link, "UPDATE `$tbl_inventory` SET `damaged`=`damaged`-0.01 WHERE (`charname`='$row->charname' and `kind`='weapon' and `used`=1) LIMIT 1") or die_nice(mysqli_error().'Error using weapon.');
} else {
$fight_on .= 'Misses!';
}


} else {
$fight_on .= 'Out of stamina, resting.';
$row->stamina = $max_stamina;
}

$fight_on .= "</font> ";
}

/*_______________-=TheSilenT.CoM=-_________________*/

function attack_cast_spell() {
global $row,$mrow,$tbl_inventory,$battle_stats,$mon_stats,$to_update,$to_update_monster,$min_succes_chance,$max_mana,$use_battle,$col_magic,$current_date,$current_time,$fight_on,$to_damage;

$fight_on .= '<font color="'.$col_magic.'">';

mysqli_query ($link, "UPDATE `$tbl_inventory` SET `damaged`=`damaged`-0.01 WHERE (`charname`='$row->charname' and `kind`='weapon' and `used`='1') LIMIT 1") or die_nice(mysqli_error().'Error using weapon.');

if ($row->mana >= 1) {
$row->mana -= $use_battle;

$damage = doit($battle_stats[6],$battle_stats[7]);
$defense = doit($mon_stats[10],$mon_stats[11]);

$damage -= $defense;
$randed = rand(1,100);
if($damage <= 0){if ($randed <= ($min_succes_chance+$row->honor)){$damage=$randed;}}

$my_ar = doit($battle_stats[8],$battle_stats[9]);
$mon_ar = doit($mon_stats[8],$mon_stats[9]);

if ($my_ar >= $mon_ar or $randed <= ($min_succes_chance+$row->honor)) {
if ($damage <= 0) {
$fight_on .= 'Contravention!';
} else {
//$fight_on .= 'Cast for '.number_format($damage).' damage.';
$to_damage += $damage;
$to_update_monster .= ", `life`=`life`-$damage";
$mrow->life -= $damage;

}
} else {
$fight_on .= 'Spell fizzles!';
}


} else {
$fight_on .= 'Out of mana, praying for spiritual powers.';
$row->mana = $max_mana;
}

$fight_on .= "</font> ";
}
/*_______________-=TheSilenT.CoM=-_________________*/
function attack_cast_healing() {
global $row,$tbl_inventory,$battle_stats,$mon_stats,$to_update,$min_succes_chance,$max_life,$max_mana,$use_battle,$col_heal,$fight_on;
$fight_on .= '<font color="'.$col_heal.'">';

if ($row->mana >= 1) {
$randed = rand(1,100);

if($randed <= ($min_succes_chance+$row->honor)) {
$healing = doit($battle_stats[12],$battle_stats[13]);

if($row->life+$healing >= $max_life){
$fight_on .= 'Heals completely.';
}else{
$fight_on .= 'Heal for '.number_format($healing).'.';
}
$to_update .= ", `life`=`life`+$healing, `mana`=`mana`-$use_battle";
}else{
$fight_on .= 'Spell fizzles!';
$to_update .= ", `mana`=`mana`-$use_battle";
}
} else {
$fight_on .= 'Out of mana, praying for spiritual powers.';
$to_update .= ", `mana`=$max_mana";
}

$fight_on .= "</font> ";
}
/*_______________-=TheSilenT.CoM=-_________________*/

?>