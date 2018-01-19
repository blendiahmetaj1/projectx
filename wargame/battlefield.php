<?php
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once($inc_functions);
require_once($inc_mysql);
require_once($inc_arrays);
require_once($html_header);

if (empty($row)) {?>It appears your session has been timed out please relogin.<?require_once($html_footer);exit;}

	//WAR
	//MYDAMAGE	
									//troop,vehicle,airplane,building,life,army size
$my_damages = array(1,1,1,1,1,1);
							//troop,vehicle,airplane
$my_units = array(0,0,0);

for ($i=1;$i<=$maximus;$i++) {
	if ($i == 0 or $i == 1 or $i == 2 or $i == 3 or $i == 4 or $i == 5 or $i == 11 or $i == 15) {$my_units[0] += $row->{"u$i"};}
	if ($i == 6 or $i == 7 or $i == 8 or $i == 12 or $i == 14 or $i == 16 or $i == 17 or $i == 18) {$my_units[1] += $row->{"u$i"};}
	if ($i == 9 or $i == 10 or $i == 13 or $i == 19) {$my_units[2] += $row->{"u$i"};}
	if ($row->{"u$i"} >= 1) {
if (empty($tr_col)) {$tr_col = ' bgcolor="#123456"';}else{$tr_col = '';}
$damA = $row->{"u$i"}*$units[$units_name[$i]][2];
$my_damages[0] += $damA;
$damB = $row->{"u$i"}*$units[$units_name[$i]][3];
$my_damages[1] += $damB;
$damC = $row->{"u$i"}*$units[$units_name[$i]][4];
$my_damages[2] += $damC;
$damD = $row->{"u$i"}*$units[$units_name[$i]][5];
$my_damages[3] += $damD;
$damE = $row->{"u$i"}*$units[$units_name[$i]][0];
$my_damages[4] += $damE;
$my_damages[5] += $row->{"u$i"};
}
}
print '<table><tr><th>Standing Forces</th><th>Troops</th><th>Vehicles</th><th>Airplanes</th><th>Buildings</th><th>Life Points</th><th>Units</th></tr><tr><td>Total Damage</td><td>'.number_format($my_damages[0]).'</td><td>'.number_format($my_damages[1]).'</td><td>'.number_format($my_damages[2]).'</td><td>'.number_format($my_damages[3]).'</td><td>'.number_format($my_damages[4]).'</td><td>'.number_format($my_damages[5]).'</td></tr>
<tr><td>Total Units</td><td>'.number_format($my_units[0]).'</td><td>'.number_format($my_units[1]).'</td><td>'.number_format($my_units[2]).'</td></td></td></td></tr></table>';
	//MYDAMAGE

if($wresult = mysqli_query ($link, "SELECT * FROM $tbl_war WHERE charname='$row->charname' ORDER BY timer DESC LIMIT 100")) {
?><table><tr><th>War Forces</th></tr><tr><th>Outgoing Forces</th></tr><?php
while ($wrow = mysqli_fetch_object ($wresult)) {
if (empty($tr_col)) {$tr_col = ' bgcolor="#123456"';}else{$tr_col = '';}

if (($wrow->timer-$current_time) <= 1) {
	?><tr><td><?php


if ($oresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE (`charname`='$wrow->opponent') ORDER BY `id` DESC LIMIT 1")) {
	if (mysqli_num_rows($oresult) >= 1) {
		if ($orow = mysqli_fetch_object ($oresult)) {
			mysqli_free_result ($oresult);

									//troop,vehicle,airplane,building,life,army size
$he_damages = array(1,1,1,1,1,1);
							//troop,vehicle,airplane
$he_units = array(0,0,0);
$percentage_damages = array(1,1,1,1,1,1);

for ($i=1;$i<=$maximus;$i++) {
	if ($i == 0 or $i == 1 or $i == 2 or $i == 3 or $i == 4 or $i == 5 or $i == 11 or $i == 15) {$he_units[0] += $wrow->{"u$i"};}
	if ($i == 6 or $i == 7 or $i == 8 or $i == 12 or $i == 14 or $i == 16 or $i == 17 or $i == 18) {$he_units[1] += $wrow->{"u$i"};}
	if ($i == 9 or $i == 10 or $i == 13 or $i == 19) {$he_units[2] += $wrow->{"u$i"};}
	if ($wrow->{"u$i"} >= 1) {
$damA = $wrow->{"u$i"}*$units[$units_name[$i]][2];
$he_damages[0] += $damA;
$damB = $wrow->{"u$i"}*$units[$units_name[$i]][3];
$he_damages[1] += $damB;
$damC = $wrow->{"u$i"}*$units[$units_name[$i]][4];
$he_damages[2] += $damC;
$damD = $wrow->{"u$i"}*$units[$units_name[$i]][5];
$he_damages[3] += $damD;
$damE = $wrow->{"u$i"}*$units[$units_name[$i]][0];
$he_damages[4] += $damE;
$he_damages[5] += $wrow->{"u$i"};
}
}
$percentage_damages[0] += ($he_damages[0]/$my_damages[0])*100;
$percentage_damages[1] += ($he_damages[1]/$my_damages[1])*100;
$percentage_damages[2] += ($he_damages[2]/$my_damages[2])*100;
$percentage_damages[3] += ($he_damages[3]/$my_damages[3])*100;
$percentage_damages[4] += ($he_damages[4]/$my_damages[4])*100;
$percentage_damages[5] += ($he_damages[5]/$my_damages[5])*100;

print '<table><tr><th>Incoming Damage</th><th>Troops</th><th>Vehicles</th><th>Airplanes</th><th>Buildings</th><th>Life Points</th><th>Units</th></tr><tr><td>'.$wrow->opponent.'</td><td>'.number_format($he_damages[0]).'</td><td>'.number_format($he_damages[1]).'</td><td>'.number_format($he_damages[2]).'</td><td>'.number_format($he_damages[3]).'</td><td>'.number_format($he_damages[4]).'</td><td>'.number_format($he_damages[5]).'</td></tr><tr><td></td><td>'.number_format($percentage_damages[0],2).'%</td><td>'.number_format($percentage_damages[1],2).'%</td><td>'.number_format($percentage_damages[2],2).'%</td><td>'.number_format($percentage_damages[3],2).'%</td><td>'.number_format($percentage_damages[4],2).'%</td><td>'.number_format($percentage_damages[5],2).'%</td><tr></tr>
<tr><td>Total Units</td><td>'.number_format($he_units[0]).'</td><td>'.number_format($he_units[1]).'</td><td>'.number_format($he_units[2]).'</td></td></td></td></tr></table>';
		/*for ($i=1;$i<=$maximus;$i++) {
			if ($wrow->{"u$i"} >= 1) {
print number_format($wrow->{"u$i"}).' '.$units_name[$i].'<br>';
			}
		}*/
	//BATTLE
$multiplier=2;
if ($row->x > $orow->x) {$multiplier += ($row->x-$orow->x);} elseif ($row->x < $orow->x) {$multiplier += ($orow->x-$row->x);}else{$multiplier=2;}
if ($row->y > $orow->y) {$multiplier += ($row->y-$orow->y);} elseif ($row->y < $orow->y) {$multiplier += ($orow->y-$row->y);}else{$multiplier=2;}

$attack_time *= ($multiplier/2);

mysqli_query ($link, "DELETE FROM $tbl_war WHERE `id`='$wrow->id' LIMIT 1");
if ($percentage_damages[4] <= 100 and $percentage_damages[5] <= 100) {
	print 'VICTORY!';
mysqli_query ($link, "INSERT INTO `$tbl_messages` VALUES ('','','$orow->charname','DEFEATED!','$current_time')") or die(mysqli_error());
}elseif ($percentage_damages[4] > 100 and $percentage_damages[5] > 100) {
	print 'DEFEATED!';
	$to_update .= ', gold=0';

mysqli_query ($link, "UPDATE `$tbl_members` SET gold=gold+$row->gold WHERE (`id`='$orow->id') LIMIT 1") or die(mysqli_error());
mysqli_query ($link, "INSERT INTO `$tbl_messages` VALUES ('','','$orow->charname','VICTORY! You gained $".number_format($row->gold)."!','$current_time')") or die(mysqli_error());

}else{
	print 'DRAW!';
}
	//BATTLE
		}
	}
}
	?></td></tr><?php
}else{

print '<tr><td><a href="?q='.$wrow->id.'">Arriving '.$wrow->opponent.'</a> <font size=-2>('.$wrow->x.':'.$wrow->y.') in '.number_format($wrow->timer-$current_time).'<br>';
	if ($q == $wrow->id) {
		for ($i=1;$i<=$maximus;$i++) {
			if ($wrow->{"u$i"} >= 1) {
print number_format($wrow->{"u$i"}).' '.$units_name[$i].'<br>';
			}
		}
	}

}
print '</font><td></tr>';

}
mysqli_free_result ($wresult);
?></tr></table><?php
}
	//WAR

require_once($html_footer);
?>