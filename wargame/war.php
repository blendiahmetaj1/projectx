<?php
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once($inc_functions);
require_once($inc_mysql);
require_once($inc_arrays);
require_once($html_header);

if (empty($row)) {?>It appears your session has been timed out please relogin.<?require_once($html_footer);exit;}

print '<form method=post><table><tr><th colspan=7>War</th></tr><tr><th>Damage Versus</th><th>Troops</th><th>Vehicles</th><th>Airplanes</th><th>Buildings</th><th>Life Points</th><th>Own</th><th>Send</th></tr>';

//print_r ($_POST);

	//SEND FORCES
if (!empty($_POST) and !empty($_POST['player']) and !empty($_POST['x']) and !empty($_POST['y'])) {
	$inserto='';
	$player = clean_post($_POST['player']);
	$x = clean_post($_POST['x']);
	$y = clean_post($_POST['y']);
	$total_units=0;
if ($oresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE (`x`='$x' and `y`='$y' and `id`!='$row->id' and `charname`='$player') ORDER BY `id` DESC LIMIT 1")) {
if (mysqli_num_rows($oresult) >= 1) {
	if ($orow = mysqli_fetch_object ($oresult)) {
mysqli_free_result ($oresult);
	for ($i=0;$i<=$maximus;$i++) {
		if (!empty($_POST["u$i"])) {
			if (is_numeric($_POST["u$i"]) and $row->{"u$i"} >= $_POST["u$i"] and $_POST["u$i"] >= 1) {
				$ameretto = clean_post($_POST["u$i"]);
				$inserto .= ", '$ameretto'";
				$to_update .= ", `u$i`=`u$i`-'$ameretto'";
				$row->{"u$i"} -= $ameretto;
				$total_units += $ameretto;
				//print 'AAA';
			} else {
				$inserto .= ", '0'";
				//print 'BBB';
			}
		}else{
			$inserto .= ", '0'";
			//print 'CCC';

		}
		//print "u$i ";
	}
$multiplier=2;
if ($row->x > $x) {$multiplier += ($row->x-$x);} elseif ($row->x < $x) {$multiplier += ($x-$row->x);}else{$multiplier=2;}
if ($row->y > $y) {$multiplier += ($row->y-$y);} elseif ($row->y < $y) {$multiplier += ($y-$row->y);}else{$multiplier=2;}

$attack_time *= ($multiplier/2);
if ($total_units >= 1) {
mysqli_query ($link, "INSERT INTO `$tbl_war` VALUES ('','$row->charname','$orow->charname','".($current_time+$attack_time)."','0','$x','$y'$inserto)") or die(mysqli_error());

print 'Forces has been deployed.';
}
	}
}
}
	//SEND FORCES


//mysqli_query ($link, "INSERT INTO `$tbl_messages` VALUES ('','','$row->charname','$orow->charname a a a a a','$current_time')") or die(mysqli_error());
}

$damages = array(1,1,1,1,1,1);

for ($i=1;$i<=$maximus;$i++) {
	if ($row->{"u$i"} >= 1) {
if (empty($tr_col)) {$tr_col = ' bgcolor="#123456"';}else{$tr_col = '';}
$damA = $row->{"u$i"}*$units[$units_name[$i]][2];
$damages[0] += $damA;
$damB = $row->{"u$i"}*$units[$units_name[$i]][3];
$damages[1] += $damB;
$damC = $row->{"u$i"}*$units[$units_name[$i]][4];
$damages[2] += $damC;
$damD = $row->{"u$i"}*$units[$units_name[$i]][5];
$damages[3] += $damD;
$damE = $row->{"u$i"}*$units[$units_name[$i]][0];
$damages[4] += $damE;
$damages[5] += $row->{"u$i"};

print '<tr'.$tr_col.'><td valign=top><b>'.$units_name[$i].'</b></td>
<td valign=top>'.number_format($damA).'</td>
<td valign=top>'.number_format($damB).'</td>
<td valign=top>'.number_format($damC).'</td>
<td valign=top>'.number_format($damD).'</td>
<td valign=top>'.number_format($damE).'</td>
<td valign=top>'.number_format($row->{"u$i"}).'</td>
<td valign=top>';
if ($row->{"u$i"} >= 1) {
	print '<input type=text name="u'.$i.'" value="0" size=1 maxlength=5 style="width:100%;">';
}else{
	//print '<input type=hidden name="u'.$i.'" value=0>';
}
print '</td></tr>';

if ($row->{"b$i"} <= 0 and $row->{"pb$i"} <= 0) {break;}
	}else{
		//print '<input type=hidden name="u'.$i.'" value=0>';
	}
}

print '</td></tr><tr><th>Totals</th><th>'.number_format($damages[0]).'</th><th>'.number_format($damages[1]).'</th><th>'.number_format($damages[2]).'</th><th>'.number_format($damages[3]).'</th><th>'.number_format($damages[4]).'</th><th>'.number_format($damages[5]).'</th><th> </th></tr><tr><th colspan=7>
<table width=100%><tr>';

$players = 0;
if (!empty($_POST['u1']) and !empty($_POST['x']) and !empty($_POST['y'])) {
		if ($_POST['u1'] >= 1) {
			$x = clean_post($_POST['x']);
			$y = clean_post($_POST['y']);
if ($dresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE (`x`='$x' and `y`='$y' and `id`!='$row->id') ORDER BY `id` DESC LIMIT 10")) {
	$players = mysqli_num_rows($dresult);
	if ($players >= 1) {
		print '<th width=50%><select name=player>';
		while ($drow = mysqli_fetch_object ($dresult)) {
print '<option value="'.$drow->charname.'">'.$drow->charname.'</option>';
		}
		mysqli_free_result ($dresult);
		print '</select><input type=hidden name=x value="'.$x.'"><input type=hidden name=y value="'.$y.'"></th>';
	}
}
		}
}

if (empty($_POST['u1']) or $players <= 0) {
print '<th><input type=text name=x value="'.$row->x.'" size=1 maxlength=3 style="height:100%;width:100%;"></th><th>:</th><th><input type=text name=y value="'.$row->y.'" size=1 maxlength=3 style="height:100%;width:100%;"></th>';
}

print '<th><input type=submit></th></tr></table>
</th></tr></table></form>';
?>To scout send one scouts :o).<br>
To spy send more scouts ;o)<br>
To attack send forces :o).<br><?php
require_once($html_footer);
?>