<?php
#!/usr/local/bin/php
//DETERMINE PLAYER POSITION

$upgrade_cost = 100000*(1+($my_income*100*$row->x3*$row->x3));
if (!empty($_GET['upgrade']) and $row->money >= $upgrade_cost and $row->x3 <= 100) {
$to_update .= ", `x3`=`x3`+1";
$total_costs += $upgrade_cost;
$row->money -= $upgrade_cost;
$row->x3++;
$upgrade_cost = 1000000+($my_income*100*$row->x3*$row->x3);
}

$min_x =$row->x-5;
$max_x =$row->x+5;

$min_y =$row->y-5;
$max_y =$row->y+5;

	$total_settlements = 0;
	$total_upgrades = 0;
	$total_opponents = array();
		//WEAPONS
$weapons = array ('Bullets', 'Grenades', 'Rockets', 'Tornado', 'Nuke', 'Earthquake', 'Atomic Bomb', 'Tsunami', 'Meteor Rain', 'Project X5');

?><form method=post><table cellpadding=1 cellspacing=1 border=1><tr><th colspan=7>Attack Options</th></tr>
<tr><th>Attacks</th><th>Damage</th><th>Radius</th><th>Duration</th><th>Cost</th><th>Actions</th></tr><?php

		//POSTS ACTIONS
if (!empty($_POST)) {
	foreach ($_POST as $key=>$val) {
$using = $key;
break;
	}
//print $using;
}
		//POSTS ACTIONS

for ($i=0;$i<count($weapons);$i++) {

$attack_damage = round(($row->x3)+(1+($i*$i/2)));
$attack_radius = round($i+1);
$attack_time = round((1+($i*$i/2))*600);
$attack_cost = round($cost_attack*(1+($i*$i/2)));

		//ATTACKING
if(isset($using) and $row->money >= $attack_cost) {
if ($using == "x1$i" and ($row->{"x1$i"} - $current_time) <= 1) {
			//ATTACK LOCATIONS
if ($lresult = mysqli_query ($link, "SELECT * FROM `$tbl_location` WHERE ((`x` BETWEEN '".($row->x-$attack_radius)."' AND '".($row->x+$attack_radius)."') and (`y` BETWEEN '".($row->y-$attack_radius)."' AND '".($row->y+$attack_radius)."') and (`mid`!='$row->id'))  ORDER BY `id` DESC LIMIT 100")) {
if (mysqli_num_rows($lresult) >= 1) {

	while ($lrow = mysqli_fetch_object ($lresult)) {

if ($lrow->x0 >= $attack_damage) {
	mysqli_query ($link, "UPDATE `$tbl_location` SET `x0`=`x0`-$attack_damage WHERE (`id`='$lrow->id') LIMIT 1") or print(mysqli_error().'666');
	mysqli_query ($link, "UPDATE `$tbl_members` SET `x1`=`x1`-$attack_damage WHERE (`id`='$lrow->mid') LIMIT 1") or print(mysqli_error().'555');	
	$total_upgrades += $attack_damage;
}else{
	mysqli_query ($link, "DELETE FROM `$tbl_location` WHERE (`id`='$lrow->id') LIMIT 1") or print(mysqli_error().'777');
	mysqli_query ($link, "UPDATE `$tbl_members` SET `x0`=`x0`-1 WHERE (`id`='$lrow->mid') LIMIT 1") or print(mysqli_error().'666');	
	$total_settlements++;
}

		//PLAYERS
if (!in_array($lrow->mid,$total_opponents)) {
	$total_opponents[] = $lrow->mid;
}
	//PLAYERS
	}
	mysqli_free_result ($lresult);
}
}
			//ATTACK LOCATIONS
	$total_costs += $attack_cost;
	$row->{"x1$i"} = $current_time+$attack_time;
	$to_update .= ", `$using`='".($current_time+$attack_time)."'";
}
}
		//ATTACKING

print '<tr><td>'.$weapons[$i].'</td><td align=center>'.number_format($attack_damage).'</td><td align=center>'.number_format($attack_radius).'</td><td>'.number_format($attack_time).'</td><td>$'.number_format($attack_cost).'</td><td>';
if (($row->{"x1$i"} - $current_time) >= 1) {
print 'Available in '.dater($row->{"x1$i"});
} else {
print ($row->money >= $attack_cost)?'<input type=submit name="x1'.$i.'" value="Attack">':'not enough money';
}
print '</td></tr>';
}
		//WEAPONS

		//PLAYERS LOCATED
if ($oresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE ((`x` BETWEEN '$min_x' AND '$max_x') and (`y` BETWEEN '$min_y' AND '$max_y') and (`id`!='$row->id'))  ORDER BY `money` DESC LIMIT 100")) {
if (mysqli_num_rows($oresult) >= 1) {

print '<tr><th colspan=3>Players In Range</th><th colspan=4><select name=opponent>';
	while ($orow = mysqli_fetch_object ($oresult)) {
		print '<option name="'.$orow->id.'">'.$orow->charname.'</option>';
	}
	mysqli_free_result ($oresult);
print '</select></th></tr>';


}
}
		//PLAYERS LOCATED
?></table></form><?php print ($row->x3<=100)?'You can <a href="?attack&upgrade=1">upgrade damage</a> for $'.number_format($upgrade_cost).'.<br>':'';
if ($total_settlements >= 1) {
	print ($total_settlements >= 1)?'You have destroyed '.number_format($total_settlements).' settlements<br>':'';
	$to_update .= ", `x4`=`x4`+$total_settlements";
}
if ($total_upgrades >= 1) {
	print ($total_upgrades >= 1)?'You have destroyed '.number_format($total_upgrades).' upgrades<br>':'';
	$to_update .= ", `x5`=`x5`+$total_upgrades";
}


$total_opponents = array_unique($total_opponents);
$oponents_amount = count($total_opponents);

if ($oponents_amount >= 1) {
	print 'You just attacked the lands of ';
$i=0;
foreach ($total_opponents as $val) {$i++;
	if ($i > 1) {
		print ($i <> $oponents_amount )?', ':' and ';
	}
//MESSAGES OWNER
if ($oresult = mysqli_query ($link, "SELECT `charname` FROM `$tbl_members` WHERE (`id`='$val') ORDER BY `id` DESC LIMIT 1")) {
	if ($orow = mysqli_fetch_object ($oresult)) {
	mysqli_free_result ($oresult);
	print $orow->charname;
			mysqli_query ($link, "INSERT INTO `$tbl_messages` VALUES ('','$row->charname','$orow->charname','$row->charname attacked your land.','$current_time')") or die(mysqli_error());
	}
}
//MESSAGES OWNER
}
print '<br>';

$total_money_gained = ($total_settlements+$total_upgrades)*100;
if ($total_money_gained >= 10) {
print 'You have been rewarded with $'.number_format($total_money_gained).' money.<br>';
$to_update .= ", `money`=`money`+$total_money_gained";
}

}
?>