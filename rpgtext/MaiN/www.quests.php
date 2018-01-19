<?php
#!/usr/local/bin/php

if (empty($visit)){$visit='';}

/*_______________-=TheSilenT.CoM=-_________________*/
function questing() {
global $row,$array_quests,$to_update,$to_output,$col_quests,$visit,$current_time;

$to_quest = '';
	//$to_update .= ", `quests`='1'";

if(($row->quests == 0 or $row->quests == 1) and ($visit == 'bank' or $row->location == 'pond')) {

	//QUEST 1
if($row->quests == 0 and $visit == 'bank'){
	$to_quest .= 'Bring us a nice koi from the pond at the bridge and the Bank will reward you with 250,000 gold!';
}elseif($row->quests == 1 and $visit == 'bank') {
	global $tbl_paper,$current_date;
	$to_update .= ", `stash`=`stash`+250000, `quests`='2'";
	$to_quest .= 'complete! You have earned 250,000 gold!';
	mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','5','$row->charname','$current_date','Quest deposited 250,000 gold.','$current_time')") or die_nice(mysqli_error().'bank deposit');
}elseif($row->quests == 0 and $row->location == 'pond'){
	if(rand(1,100) < 5) {
		$to_update .= ", `quests`='1'";
		$to_quest .= 'You just captured a nice Koi, bring it to the bank!';
	}else{
		$to_quest .= 'Walk or Fight around to capture a koi here!';
	}
}elseif($row->quests == 1 and $row->location == 'pond'){
	$to_quest .= 'You have the koi, now bring it back to the bank!';
}
	//QUEST 1

}elseif(($row->quests == 2 or $row->quests == 3) and ($visit == 'healer' or $row->location == 'cornfield')) {

	//QUEST 2
if($row->quests == 2 and $visit == 'healer'){
	$to_quest .= 'Get me the alienated corn and I will make the Unique Healspell of Regeneration for you!';
}elseif($row->quests == 3 and $visit == 'healer') {
	global $tbl_inventory;
	$val_item = "'', '$row->charname', '', 'regeneration', 'unique', 'healspell', '0', '0', '".rand(1,9)."', '5', '0', '5', '100', '250','23','24','25','48','49','50','0','0','58', '$current_time'";
	mysqli_query ($link, "INSERT INTO `$tbl_inventory` values ($val_item)") or die_nice(mysqli_error().'Quest Generator drop item.');
	$to_update .= ", `quests`='4'";
	$to_quest .= 'complete! Unique Healspell of Regeneration is now in your inventory!';
}elseif($row->quests == 2 and $row->location == 'cornfield'){
	if(rand(1,300) < 5) {
		$to_update .= ", `quests`='3'";
		$to_quest .= 'You have got enough now!';
	}else{
		$to_quest .= 'Walk or Fight around to get the alienated corn!';
	}
}elseif($row->quests == 3 and $row->location == 'cornfield'){
	$to_quest .= 'You have got enough now, give it to the healer!';
}
	//QUEST 2

}elseif(($row->quests == 4 or $row->quests == 5) and ($visit == 'charmer' or $row->location == 'desert')) {

	//QUEST 3
	global $tbl_charms,$array_monsters;
	$quest_monster = 55;
if($row->quests == 4 and $visit == 'charmer'){
	$to_quest .= 'Go to the desert and kill '.$array_monsters[$quest_monster].' monster and bring me the head for the Da Quartz charm!';
}elseif($row->quests == 5 and $visit == 'charmer') {
	$charm= "'','$row->charname','Quartz','25','25','25','25','25','25','25','25','25','$current_time+25000'";
	mysqli_query ($link, "INSERT INTO `$tbl_charms` VALUES ($charm)") or die_nice(mysqli_error().'Quest Generator drop charm.');
	$to_update .= ", `quests`='6'";
	$to_quest .= 'complete! You have received the Da Quartz charm!';
}elseif($row->quests == 4 and $row->location == 'desert'){
	global $fight_on;
	if(preg_match("/You have slain \<b\>$array_monsters[$quest_monster]\<\/b\>/si",$fight_on)) {
		$to_quest .= 'You have got the '.$array_monsters[$quest_monster].' head, give it to the charmer!';
		$to_update .= ", `quests`='5'";
	}else{
		$to_quest .= 'You need to kill <b>'.$array_monsters[$quest_monster].'</b> and take the head!';
	}
}elseif($row->quests == 5 and $row->location == 'desert'){
	$to_quest .= 'You have got the <b>'.$array_monsters[$quest_monster].'</b> head, give it to the charmer!';
}
	//QUEST 3

}elseif(($row->quests == 6 or $row->quests == 7) and ($visit == 'tower' or $row->location == 'pond')) {

	//QUEST 4
	global $array_monsters;
	$quest_monster = 73;
if($row->quests == 6 and $visit == 'tower'){
	$to_quest .= 'Go to the pond and kill the '.$array_monsters[$quest_monster].' monster and I will reward you with a Set Ring of Regeneration!';
}elseif($row->quests == 7 and $visit == 'tower') {
	global $tbl_inventory;
	$val_item = "'', '$row->charname', '', 'regeneration', 'set', 'ring', '0', '0', '".rand(1,9)."', '10', '0', '10', '100', '250','23','24','25','48','49','50','0','0','58', '$current_time'";
	mysqli_query ($link, "INSERT INTO `$tbl_inventory` values ($val_item)") or die_nice(mysqli_error().'Quest Generator drop item.');
	$to_update .= ", `quests`='8'";
	$to_quest .= 'complete! Set Ring of Regeneration is now in your inventory!';
}elseif($row->quests == 6 and $row->location == 'pond'){
	global $fight_on;
	if(preg_match("/You have slain \<b\>$array_monsters[$quest_monster]\<\/b\>/si",$fight_on)) {
		$to_quest .= 'You have slain '.$array_monsters[$quest_monster].', go to the tower keeper!';
		$to_update .= ", `quests`='7'";
	}else{
		$to_quest .= 'You need to kill <b>'.$array_monsters[$quest_monster].'</b>!';
	}
}elseif($row->quests == 7 and $row->location == 'pond'){
	$to_quest .= 'You have slain a <b>'.$array_monsters[$quest_monster].'</b>, go to the tower!';
}
	//QUEST 4

}elseif(($row->quests == 8 or $row->quests == 9) and ($visit == 'shop' or $row->location == 'cornfield')) {

	//QUEST 5
	global $array_monsters;
	$quest_monster = 100;
if($row->quests == 8 and $visit == 'shop'){
	$to_quest .= 'Go to the cornfield and kill the '.$array_monsters[$quest_monster].' monster and I will reward you with a Set belt of Regeneration!';
}elseif($row->quests == 9 and $visit == 'shop') {
	global $tbl_inventory;
	$val_item = "'', '$row->charname', '', 'regeneration', 'set', 'belt', '0', '0', '".rand(1,9)."', '15', '0', '15', '100', '250','1','2','3','4','5','6','7','8','9', '$current_time'";
	mysqli_query ($link, "INSERT INTO `$tbl_inventory` values ($val_item)") or die_nice(mysqli_error().'Quest Generator drop item.');
	$to_update .= ", `quests`='10'";
	$to_quest .= 'complete! Set Belt of Regeneration is now in your inventory!';
}elseif($row->quests == 8 and $row->location == 'cornfield'){
	global $fight_on;
	if(preg_match("/You have slain \<b\>$array_monsters[$quest_monster]\<\/b\>/si",$fight_on)) {
		$to_quest .= 'You have slain '.$array_monsters[$quest_monster].', go to the shop keeper!';
		$to_update .= ", `quests`='9'";
	}else{
		$to_quest .= 'You need to kill <b>'.$array_monsters[$quest_monster].'</b>!';
	}
}elseif($row->quests == 9 and $row->location == 'cornfield'){
	$to_quest .= 'You have slain a <b>'.$array_monsters[$quest_monster].'</b>, go to the shop!';
}
	//QUEST 5

}elseif(($row->quests == 10 or $row->quests == 11) and ($visit == 'smith' or $row->location == 'bones')) {

	//QUEST 6
	global $array_monsters;
	$quest_monster = 200;
if($row->quests == 10 and $visit == 'smith'){
	$to_quest .= 'Go to the bones and kill the '.$array_monsters[$quest_monster].' monster and I will reward you with a Set feet of Regeneration!';
}elseif($row->quests == 11 and $visit == 'smith') {
	global $tbl_inventory;
	$val_item = "'', '$row->charname', '', 'regeneration', 'set', 'feet', '0', '0', '".rand(1,9)."', '15', '0', '15', '100', '250','26','27','28','29','30','31','32','33','34', '$current_time'";
	mysqli_query ($link, "INSERT INTO `$tbl_inventory` values ($val_item)") or die_nice(mysqli_error().'Quest Generator drop item.');
	$to_update .= ", `quests`='12'";
	$to_quest .= 'complete! Set feet of Regeneration is now in your inventory!';
}elseif($row->quests == 10 and $row->location == 'bones'){
	global $fight_on;
	if(preg_match("/You have slain \<b\>$array_monsters[$quest_monster]\<\/b\>/si",$fight_on)) {
		$to_quest .= 'You have slain '.$array_monsters[$quest_monster].', go to the iron smith!';
		$to_update .= ", `quests`='11'";
	}else{
		$to_quest .= 'You need to kill <b>'.$array_monsters[$quest_monster].'</b>!';
	}
}elseif($row->quests == 11 and $row->location == 'bones'){
	$to_quest .= 'You have slain a <b>'.$array_monsters[$quest_monster].'</b>, go to the irion smith!';
}
	//QUEST 6

}elseif(($row->quests == 12 or $row->quests == 13) and ($visit == 'teleport' or $row->location == 'bones')) {

	//QUEST 7
	global $array_monsters;
	$quest_monster = 199;
if($row->quests == 12 and $visit == 'teleport'){
	$to_quest .= 'Go to the bones and kill the '.$array_monsters[$quest_monster].' monster and I will learn you the Teleportation Skill!';
}elseif($row->quests == 13 and $visit == 'teleport') {
	$to_update .= ", `quests`='14'";
	$to_quest .= 'complete!';
}elseif($row->quests == 12 and $row->location == 'bones'){
	global $fight_on;
	if(preg_match("/You have slain \<b\>$array_monsters[$quest_monster]\<\/b\>/si",$fight_on)) {
		$to_quest .= 'You have slain '.$array_monsters[$quest_monster].', go to the teleporter!';
		$to_update .= ", `quests`='13'";
	}else{
		$to_quest .= 'You need to kill <b>'.$array_monsters[$quest_monster].'</b>!';
	}
}elseif($row->quests == 13 and $row->location == 'bones'){
	$to_quest .= 'You have slain a <b>'.$array_monsters[$quest_monster].'</b>, go to the teleporter!';
}
	//QUEST 7

}elseif(($row->quests == 14 or $row->quests == 15) and ($visit == 'healer' or $row->location == 'pond')) {

	//QUEST 8
	global $array_monsters;
	$quest_monster = 10;
if($row->quests == 14 and $visit == 'healer'){
	$to_quest .= 'Go to the pond and kill the '.$array_monsters[$quest_monster].' monster and I will learn you the Survival Skill!';
}elseif($row->quests == 15 and $visit == 'healer') {
	$to_update .= ", `quests`='16'";
	$to_quest .= 'complete!';
}elseif($row->quests == 14 and $row->location == 'pond'){
	global $fight_on;
	if(preg_match("/You have slain \<b\>$array_monsters[$quest_monster]\<\/b\>/si",$fight_on)) {
		$to_quest .= 'You have slain '.$array_monsters[$quest_monster].', go to the healer!';
		$to_update .= ", `quests`='15'";
	}else{
		$to_quest .= 'You need to kill <b>'.$array_monsters[$quest_monster].'</b>!';
	}
}elseif($row->quests == 15 and $row->location == 'pond'){
	$to_quest .= 'You have slain a <b>'.$array_monsters[$quest_monster].'</b>, go to the healer!';
}
	//QUEST 8
}elseif(($row->quests == 16 or $row->quests == 17) and ($visit == 'bank' or $row->location == 'cornfield')) {

	//QUEST 9
	global $array_monsters;
	$quest_monster = 10;
if($row->quests == 16 and $visit == 'bank'){
	$to_quest .= 'Go to the cornfield and kill the '.$array_monsters[$quest_monster].' monster and I will learn you the Free Run and Hide Skill!';
}elseif($row->quests == 17 and $visit == 'bank') {
	$to_update .= ", `quests`='18'";
	$to_quest .= 'complete!';
}elseif($row->quests == 16 and $row->location == 'cornfield'){
	global $fight_on;
	if(preg_match("/You have slain \<b\>$array_monsters[$quest_monster]\<\/b\>/si",$fight_on)) {
		$to_quest .= 'You have slain '.$array_monsters[$quest_monster].', go to the bank!';
		$to_update .= ", `quests`='17'";
	}else{
		$to_quest .= 'You need to kill <b>'.$array_monsters[$quest_monster].'</b>!';
	}
}elseif($row->quests == 17 and $row->location == 'cornfield'){
	$to_quest .= 'You have slain a <b>'.$array_monsters[$quest_monster].'</b>, go to the bank!';
}
	//QUEST 9
}elseif(($row->quests == 18 or $row->quests == 19) and ($visit == 'tower' or $row->location == 'pond')) {

	//QUEST 10
	global $array_monsters;
	$quest_monster = 50;
if($row->quests == 18 and $visit == 'tower'){
	$to_quest .= 'Go to the pond and kill the '.$array_monsters[$quest_monster].' monster and I will learn you the Monster Identify Skill!';
}elseif($row->quests == 19 and $visit == 'tower') {
	$to_update .= ", `quests`='20'";
	$to_quest .= 'complete!';
}elseif($row->quests == 18 and $row->location == 'pond'){
	global $fight_on;
	if(preg_match("/You have slain \<b\>$array_monsters[$quest_monster]\<\/b\>/si",$fight_on)) {
		$to_quest .= 'You have slain '.$array_monsters[$quest_monster].', go to the tower!';
		$to_update .= ", `quests`='19'";
	}else{
		$to_quest .= 'You need to kill <b>'.$array_monsters[$quest_monster].'</b>!';
	}
}elseif($row->quests == 19 and $row->location == 'pond'){
	$to_quest .= 'You have slain a <b>'.$array_monsters[$quest_monster].'</b>, go to the tower!';
}
	//QUEST 10
}elseif(($row->quests == 20 or $row->quests == 21) and ($visit == 'bank' or $row->location == 'pond')) {

	//QUEST 11
	global $array_monsters;
	$quest_monster = 198;
if($row->quests == 20 and $visit == 'bank'){
	$to_quest .= 'Go to the pond and kill the '.$array_monsters[$quest_monster].' monster and I will reward you with 250.000.000!';
}elseif($row->quests == 21 and $visit == 'bank') {
	$to_update .= ", `quests`='22'";
	$to_quest .= 'complete!';
	
	global $tbl_paper,$current_date;
	$to_update .= ", `stash`=`stash`+250000000, `quests`='2'";
	$to_quest .= 'complete! You have earned 250,000,000 gold!';
	mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','5','$row->charname','$current_date','Quest deposited 250,000,000 gold.','$current_time')") or die_nice(mysqli_error().'bank deposit');

}elseif($row->quests == 20 and $row->location == 'pond'){
	global $fight_on;
	if(preg_match("/You have slain \<b\>$array_monsters[$quest_monster]\<\/b\>/si",$fight_on)) {
		$to_quest .= 'You have slain '.$array_monsters[$quest_monster].', go to the bank!';
		$to_update .= ", `quests`='21'";
	}else{
		$to_quest .= 'You need to kill <b>'.$array_monsters[$quest_monster].'</b>!';
	}
}elseif($row->quests == 21 and $row->location == 'pond'){
	$to_quest .= 'You have slain a <b>'.$array_monsters[$quest_monster].'</b>, go to the bank!';
}
	//QUEST 11
}

if (!empty($to_quest)){$to_output .= '<br><font color="'.$col_quests.'">Quest '.$to_quest.'</font><br>';}

}

/*_______________-=TheSilenT.CoM=-_________________*/

?>