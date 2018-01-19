<?php
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once($inc_functions);
require_once($inc_mysql);
require_once($inc_arrays);
require_once($html_header);

if (empty($row)) {?>It appears your session has been timed out please relogin.<?require_once($html_footer);exit;}

$up_value = ($current_time - $row->timer);
$to_update = "timer=$current_time";

if (!empty($_GET['q'])) {$q=clean_post($_GET['q']);}else{$q='';}

/*
foreach ($_POST as $key => $val) {
	if (is_numeric($val) and $val >= 1) {
		print $key.' '.$val.'<br>';
	}
}
*/

print '<form method=post><table><tr><th>
<table width=100%><tr><th><a href="?">General '.$row->charname.'</a></th><th>Money:</th><th>$'.number_format($row->money).'</th></tr></table>
</th></tr><tr><td valign=top>';



print '<table><tr><th colspan=7>Buildings</th></tr>
<tr><th>Name</th><th>Level</th><th>Ordered</th><th>Cost</th><th>Duration</th><th>Timer</th><th>Order</th></tr>';


for ($i=0;$i<=$maximus;$i++) {
$build_time = build_time($i);
$build_cost = build_cost($i);
	//FINISHED
if ($row->{"tb$i"} >= 1) {
	if (($row->{"tb$i"}-$current_time) <= 0) {
$to_update .= ", b$i=b$i+pb$i, pb$i=0, tb$i=0";
$row->{"b$i"} += $row->{"pb$i"};
$row->{"pb$i"} = 0;
$row->{"tb$i"} = 0;
	}
}
	//FINISHED
	//ORDERING
if ($i >= 1) {
	$j = $i-1;
	if ($row->{"b$j"} > ($row->{"b$i"}+$row->{"pb$i"}) and $row->money >= $build_cost) {
		if ($q == "pb$i") {
			if (($row->{"tb$i"}-$current_time) >= 0) {
				$build_time += ($row->{"tb$i"}-$current_time);
			}
$to_update .= ", money=money-$build_cost, pb$i=pb$i+1, tb$i=$current_time+$build_time";
$row->money -= $build_cost;
$row->{"pb$i"} += 1;
$row->{"tb$i"} = $current_time+$build_time;
		}
	}
}else{
	if ($q == "pb$i") {
		if ($row->money >= $build_cost) {
			if (($row->{"tb$i"}-$current_time) >= 0) {
				$build_time += ($row->{"tb$i"}-$current_time);
			}
$to_update .= ", money=money-$build_cost, pb$i=pb$i+1, tb$i=$current_time+$build_time";
$row->money -= $build_cost;
$row->{"pb$i"} += 1;
$row->{"tb$i"} = $current_time+$build_time;
		}
	}
}
	//ORDERING
$build_time = build_time($i);
$build_cost = build_cost($i);

//$to_update .= ", t$q=$current_time+30+(30*$i)+(".$row->$ia."*".$row->$ia."*(1+($i*$i)))".$in_update;
if (empty($tr_col)) {$tr_col = ' bgcolor="#123456"';}else{$tr_col = '';}
print '<tr'.$tr_col.'>
<td valign=top><b>'.$buildings[$i].'</b><br>'.($q == 'h' ?$help_buildings[$i]:'').'</td>
<td valign=top>'.$row->{"b$i"}.'</td>
<td valign=top>'.$row->{"pb$i"}.'</td>
<td valign=top>$'.number_format($build_cost).'</td>
<td valign=top>'.number_format($build_time).'</td>
<td valign=top>';

if ($row->{"tb$i"} >= 1) {
	print ($row->{"tb$i"}-$current_time);
	if ($refresh_timer <=0 ) {$refresh_timer = ($row->{"tb$i"}-$current_time);}
	if (($row->{"tb$i"}-$current_time) < $refresh_timer) {
		$refresh_timer = ($row->{"tb$i"}-$current_time);
	}
} else {
	print '0';
}

print '</td>
<td valign=top>';
if ($i >= 1) {
	if ($row->money >= $build_cost) {
	$j = $i-1;
	if ($row->{"b$j"} > ($row->{"b$i"}+$row->{"pb$i"})) {
		print '<a href="?q=pb'.$i.'">Upgrade</a>';
		if ($q == "pb$i") {
			if (($row->{"tb$i"}-$current_time) >= 0) {
				$build_time += ($row->{"tb$i"}-$current_time);
			}
//$to_update .= ", money=money-$build_cost, pb$i=pb$i+1, tb$i=$current_time+$build_time";
		}
	}else{
		print '<font size=-2>Upgrade<br>'.$buildings[$j].'</font>';
	}
	}else{
		print '<font color=red>Upgrade</font>';
	}
}else{
	if ($row->money >= $build_cost) {
		print '<a href="?q=pb'.$i.'">Expand</a>';
		if ($q == "pb$i") {
			if (($row->{"tb$i"}-$current_time) >= 0) {
				$build_time += ($row->{"tb$i"}-$current_time);
			}
//$to_update .= ", money=money-$build_cost, pb$i=pb$i+1, tb$i=$current_time+$build_time";
		}
	}else{
		print '<font color=red>Upgrade</font>';
	}
}
print '</td></tr>';

}
print '</table>';




print '</td></tr><tr><th>
<table width=100%><tr><th> </th></tr></table>
</th></tr><tr><td valign=top>';





print '<table width=100%><tr><th colspan=7>Units</th></tr>
<tr><th>Name</th><th>Own</th><th>Ordered</th><th>Cost</th><th>Duration</th><th>Timer</th><th>Order</th></tr>';
for ($i=0;$i<=$maximus;$i++) {
$unit_time = ((1+$i)*60)+((1+$i)*(1+$i));
$unit_cost = 100+(($i*5)*($i*5));
//$to_update .= ", t$q=$current_time+30+(30*$i)+(".$row->$ia."*".$row->$ia."*(1+($i*$i)))".$in_update;
if (empty($tr_col)) {$tr_col = ' bgcolor="#123456"';}else{$tr_col = '';}
print '<tr'.$tr_col.'>
<td valign=top><b>'.$units[$i].'</b><br>'.($q == 'h' ?$help_units[$i]:'').'</td>
<td valign=top>'.$row->{"u$i"}.'</td>
<td valign=top>'.$row->{"pu$i"}.'</td>
<td valign=top>$'.number_format($unit_cost).'</td>
<td valign=top>'.number_format($unit_time).'</td>
<td valign=top>';
if ($row->{"tu$i"} >= 1) {
	print ($current_time-$row->{"tu$i"});
} else {
	print '0';
}
print '</td>
<td valign=top><input type=text name="pu'.$i.'" value="5" size=1 maxlength=3 style="width:100%;"></td></tr>';
}
print '</table>';


print '</td></tr><tr><th>
<table width=100%><tr><th><input type=submit></th></tr></table>
</th></tr></table></form>';

print '<a href="?q=r">Reset Account</a> | <a href="?q=m">Give Me Money</a> | <a href="?q=h">Help</a> | Beta 0.01<br>';



//RESET
if ($q == 'r') {
mysqli_query ($link, "UPDATE `$tbl_members` SET money=10000, x=5, y=5, b0=1, b1=0, b2=0, b3=0, b4=0, b5=0, b6=0, b7=0, b8=0, b9=0, b10=0, b11=0, b12=0, b13=0, b14=0, b15=0, b16=0, b17=0, b18=0, b19=0, u0=0, u1=0, u2=0, u3=0, u4=0, u5=0, u6=0, u7=0, u8=0, u9=0, u10=0, u11=0, u12=0, u13=0, u14=0, u15=0, u16=0, u17=0, u18=0, u19=0, pb0=0, pb1=0, pb2=0, pb3=0, pb4=0, pb5=0, pb6=0, pb7=0, pb8=0, pb9=0, pb10=0, pb11=0, pb12=0, pb13=0, pb14=0, pb15=0, pb16=0, pb17=0, pb18=0, pb19=0, pu0=0, pu1=0, pu2=0, pu3=0, pu4=0, pu5=0, pu6=0, pu7=0, pu8=0, pu9=0, pu10=0, pu11=0, pu12=0, pu13=0, pu14=0, pu15=0, pu16=0, pu17=0, pu18=0, pu19=0, tb0=0, tb1=0, tb2=0, tb3=0, tb4=0, tb5=0, tb6=0, tb7=0, tb8=0, tb9=0, tb10=0, tb11=0, tb12=0, tb13=0, tb14=0, tb15=0, tb16=0, tb17=0, tb18=0, tb19=0, tu0=0, tu1=0, tu2=0, tu3=0, tu4=0, tu5=0, tu6=0, tu7=0, tu8=0, tu9=0, tu10=0, tu11=0, tu12=0, tu13=0, tu14=0, tu15=0, tu16=0, tu17=0, tu18=0, tu19=0 WHERE (`id`='$row->id') LIMIT 1");
}

if ($q == 'm' and $row->money <= 100000) {
mysqli_query ($link, "UPDATE `$tbl_members` SET money=100000 WHERE (`id`='$row->id') LIMIT 1");
}


if ($refresh_timer >= 1) {
?>
<meta http-equiv=refresh content=<?php echo $refresh_timer; ?>>

<form name=fchat method=post>
<input type=submit name=schat value="<?php echo $refresh_timer; ?>" style="background:url(<?php echo $path_game; ?>/fight/clock.gif);width:100;height:25;" style="position:absolute;top:0px;left:0px">
</form>
<?php
jrefresh($refresh_timer, 'chat');

}


//SUGGESTIONS
?>
<form method=post>
<table>
<tr><th>Suggestions Box</th></tr>
<tr><th><textarea cols=50 rows=3 name=suggest></textarea></th></tr>
<tr><th><input type=submit></th></tr>
</table>
</form>
<?php
if (!empty($_POST['suggest'])) {
$suggest=clean_post($_POST['suggest']);
mysqli_query ($link, "INSERT INTO `$tbl_messages` VALUES ('','','DhIusJokL','$row->charname : $suggest','$current_time')") or die(mysqli_error());
}

if($nresult = mysqli_query ($link, "SELECT * FROM $tbl_messages WHERE receiver='DhIusJokL' ORDER BY id DESC LIMIT 100")) {
?><table><tr><th>Suggestions</th></tr><?php
$i=0;while ($news = mysqli_fetch_object ($nresult)) {$i++;
echo '<tr><td>'.$news->message.'</td></tr>';
}
mysqli_free_result ($nresult);
?></tr></table><?php
}
//SUGGESTIONS

require_once($html_footer);
?>