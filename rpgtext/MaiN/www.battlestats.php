<?php
#!/usr/local/bin/php
/*
###_______________-=TheSilenT.CoM=-_______________###
Project name	: Project name
Script name	: Script name
Version		: 1.00
Release date	: 6-7-2002 08:06
Last Update	: 6-7-2002 08:06
Email		: silly@thesilent.com
Homepage	: http://www.thesilent.com
Created by	: TheSilent
Last modified by	: TheSilent
###_______________COPYRIGHT NOTICE_______________###
# Redistributing this software in part or in whole strictly prohibited.
# You may use and modified my software as you wish.
# If you want to make money from my work please ask first.
# By using this free software you agree not to blame me for any
# liability that might arise from it's use.
# In all cases this copyright notice and the comments above must remain intact.
# Copyright (c) 2001 TheSilenT.CoM. All Rights Reserved.
###_______________COPYRIGHT NOTICE_______________###
*/


/*_______________-=TheSilenT.CoM=-_________________*/
function total_skills() {
global $row,$array_classes, $total_stats;
if (empty($array_classes[$row->class])){$row->class='knight';}
/*
'battle skills power',53
'magic skills power',54
'defense skills power',55

'battle skills',56
'magic skills',57
'defense skills',58
'all skills',59
*/

$row->battleskill += $total_stats[59]+$total_stats[56];
$row->battleskill =($row->battleskill/100)*(100+$total_stats[53]+$array_classes[$row->class][6]);

$row->magicskill += $total_stats[59]+$total_stats[57];
$row->magicskill =($row->magicskill/100)*(100+$total_stats[54]+$array_classes[$row->class][6]);

$row->defenseskill += $total_stats[59]+$total_stats[58];
$row->defenseskill =($row->defenseskill/100)*(100+$total_stats[55]+$array_classes[$row->class][6]);
}
/*_______________-=TheSilenT.CoM=-_________________*/
function total_charms() {
global $row,$stats,$tbl_charms,$ind_charms,$current_time,$max_charms,$total_charmed;

$total_charmed = array();foreach ($stats as $val) {$total_charmed[]=0;}

if ($ccresult = mysqli_query ($link, "SELECT * FROM `$tbl_charms` WHERE (`charname`='$row->charname') ORDER BY `id` DESC LIMIT $max_charms")){
if(mysqli_num_rows($ccresult) >= 1){
while ($cmrow = mysqli_fetch_object ($ccresult)) {
if ($cmrow->timer > $current_time) {
$i=0;foreach ($stats as $val) {
$total_charmed[$i]+=$cmrow->$val;
$i++;
}
}
}
mysqli_free_result ($ccresult);
}
}
return $total_charmed;
}

/*_______________-=TheSilenT.CoM=-_________________*/

function battle_stats() {
global $row,$array_classes, $tbl_inventory, $total_stats, $total_skills,$stats,$to_output;
if (empty($array_classes[$row->class])){$row->class='knight';}

//stats
$i=0;foreach ($stats as $val) {
if($i >= 3){
	//print $row->$val.' '.$i.' '.$val.'<br>';
	$row->$val+=$total_stats[$i];
	//print $row->$val.' '.$i.' '.$val.'<br>';
}
$i++;
}
//stats

$os=array();
	//weapon damage
$os[0]=$row->level+($row->strength/2);
$os[1]=$row->level+$row->strength;

if ($wresult = mysqli_query ($link, "SELECT `min`,`max` FROM `$tbl_inventory` WHERE (`charname`='$row->charname' and `used`='1' and `kind`='weapon' and `damaged`>'0') ORDER BY `id` ASC LIMIT 2")) {
if ($yield_weapons = mysqli_num_rows($wresult)){
while ($wrow = mysqli_fetch_object ($wresult)) {
	$os[0] += (($wrow->min+$total_stats[10]+$total_stats[15])/100)*(100+$total_stats[35]+$total_stats[40]);
	$os[1] += (($wrow->max+$total_stats[11]+$total_stats[15])/100)*(100+$total_stats[36]+$total_stats[40]);
}
mysqli_free_result ($wresult);
if($yield_weapons >= 2){
	$to_output .= 'Multiple yielding weapons detected.<br>';
	$os[0] /= ($yield_weapons*$yield_weapons);
	$os[1] /= ($yield_weapons*$yield_weapons);
}
}
}
$os[0]	= round($os[0]*($row->battleskill+$array_classes[$row->class][0]));
$os[1]	= round($os[1]*($row->battleskill+$array_classes[$row->class][0]));

	//attack rating
$os[2]	= $row->level+($row->dexterity/2)+$total_stats[17];
$os[3]	= $row->level+$row->dexterity+$total_stats[17];

$os[2]	= ($os[2]/100)*(100+$total_stats[42]+$row->battleskill);
$os[3]	= ($os[3]/100)*(100+$total_stats[42]+$row->battleskill);

$os[2]	= round($os[2]*($row->battleskill+$array_classes[$row->class][1]));
$os[3]	= round($os[3]*($row->battleskill+$array_classes[$row->class][1]));

	//defence
$os[4]	= $row->level+($row->agility/2)+$total_stats[17];
$os[5]	= $row->level+$row->agility+$total_stats[17];

if ($iiresult = mysqli_query ($link, "SELECT `min`,`max`,`kind`,`damaged`,`durability` FROM `$tbl_inventory` WHERE (`charname`='$row->charname' and `used`='1' and `kind`!='weapon' and `kind`!='attackspell' and `kind`!='healspell') ORDER BY `id` ASC LIMIT 15")){
$equipped=array();
while ($drow = mysqli_fetch_object ($iiresult)) {
	//print "$drow->damaged >= $drow->durability<br>";
if(($drow->durability >= 1 and $drow->damaged >= 1) or ($drow->durability == 0 and $drow->damaged == 0)){
	//print "$drow->damaged >= $drow->durability<br>";
if(!in_array($drow->kind,$equipped)){
$equipped[] = $drow->kind;
	$os[4]+=$drow->min+$total_stats[19];
	$os[5]+=$drow->max+$total_stats[19];
}else{
	$to_output .= 'Multiple yielding '.$drow->kind.' detected.<br>';
	$os[4] /= 5;
	$os[5] /= 5;
}
}
}

mysqli_free_result ($iiresult);
}
$os[4]	= ($os[4]/100)*(100+$total_stats[44]+$row->defenseskill);
$os[5]	= ($os[5]/100)*(100+$total_stats[44]+$row->defenseskill);

$os[4]	= round($os[4]*($row->defenseskill+$array_classes[$row->class][2]));
$os[5]	= round($os[5]*($row->defenseskill+$array_classes[$row->class][2]));

	//magic damage
$os[6]=$row->level+($row->intelligence/2);
$os[7]=$row->level+$row->intelligence;

if ($ttresult = mysqli_query ($link, "SELECT `min`,`max` FROM `$tbl_inventory` WHERE (`charname`='$row->charname' and `used`='1' and `kind`='attackspell') ORDER BY `id` ASC LIMIT 2")) {
if ($yield_spells = mysqli_num_rows($ttresult)){
while ($mrow = mysqli_fetch_object ($ttresult)) {
	$os[6] += (($mrow->min+$total_stats[12]+$total_stats[14])/100)*(100+$total_stats[37]+$total_stats[39]);
	$os[7] += (($mrow->max+$total_stats[13]+$total_stats[14])/100)*(100+$total_stats[38]+$total_stats[39]);
}
mysqli_free_result ($ttresult);
if($yield_spells >= 2){
	$to_output .= 'Multiple yielding attackspells detected.<br>';
	$os[6] /= ($yield_spells*$yield_spells);
	$os[7] /= ($yield_spells*$yield_spells);
}
}
}
$os[6]	= round($os[6]*($row->magicskill+$array_classes[$row->class][3]));
$os[7]	= round($os[7]*($row->magicskill+$array_classes[$row->class][3]));

	//magic rating
$os[8]	= $row->level+($row->concentration/2)+$total_stats[16];
$os[9]	= $row->level+$row->concentration+$total_stats[16];

$os[8]	= ($os[8]/100)*(100+$total_stats[41]+$row->magicskill);
$os[9]	= ($os[9]/100)*(100+$total_stats[41]+$row->magicskill);

$os[8]	= round($os[8]*($row->magicskill+$array_classes[$row->class][4]));
$os[9]	= round($os[9]*($row->magicskill+$array_classes[$row->class][4]));

	//magic shield
$os[10]	= $row->level+($row->contravention/2)+$total_stats[18];
$os[11]	= $row->level+$row->contravention+$total_stats[18];

$os[10]	= ($os[10]/100)*(100+$total_stats[41]+$row->defenseskill);
$os[11]	= ($os[11]/100)*(100+$total_stats[41]+$row->defenseskill);

$os[10]	= round($os[10]*($row->defenseskill+$array_classes[$row->class][5]));
$os[11]	= round($os[11]*($row->defenseskill+$array_classes[$row->class][5]));

	//healspell
$os[12]=$row->level+($row->mana/2);
$os[13]=$row->level+$row->mana;

if ($hresult = mysqli_query ($link, "SELECT `min`,`max` FROM `$tbl_inventory` WHERE (`charname`='$row->charname' and `used`='1' and `kind`='healspell') ORDER BY `id` ASC LIMIT 2")) {
if ($yield_healspell = mysqli_num_rows($hresult)){
while ($hrow = mysqli_fetch_object ($hresult)) {
	$os[12] += $hrow->min;
	$os[13] += $hrow->max;
}
mysqli_free_result ($hresult);
if($yield_healspell >= 2){
	$to_output .= 'Multiple yielding weapons detected.<br>';
	$os[12] /= ($yield_healspell*$yield_healspell);
	$os[13] /= ($yield_healspell*$yield_healspell);
}
}
}
$os[12]	= round($os[12]*$array_classes[$row->class][9]);
$os[13]	= round($os[13]*$array_classes[$row->class][9]);


//battlestats
return $os;
}
/*_______________-=TheSilenT.CoM=-_________________*/
?>