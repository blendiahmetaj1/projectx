<?php
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once($inc_functions);
require_once($inc_mysql);
require_once($inc_arrays);
require_once($html_header);

if (empty($row)) {?>It appears your session has been timed out please relogin.<?require_once($html_footer);exit;}

print '<form method=post><table><tr><th colspan=7>Units</th></tr>
<tr><th>Name</th><th>Own</th><th>Ordered</th><th>Cost</th><th>Duration</th><th>Timer</th><th>Order</th></tr>';

for ($i=0;$i<=$maximus;$i++) {
$unit_time = ((1+$i)*60)+((1+$i)*(1+$i));
$unit_cost = 100+(($i*5)*($i*5));
	//FINISHED
if ($row->{"tu$i"} >= 1) {
	if (($row->{"tu$i"}-$current_time) <= 0) {
$to_update .= ", u$i=u$i+pu$i, pu$i=0, tu$i=0";
$row->{"u$i"} += $row->{"pu$i"};
$row->{"pu$i"} = 0;
$row->{"tu$i"} = 0;
	}
}
	//FINISHED
	//ORDERING
if (!empty($_POST["pu$i"])) {
	if (is_numeric($_POST["pu$i"])) {
${"pu$i"} = $_POST["pu$i"];
if (${"pu$i"} >= 1 and ($row->{"pu$i"}+${"pu$i"}) <= $row->{"b$i"}) {
$unit_cost *= ${"pu$i"};
	if ($row->money >= $unit_cost) {
$unit_time *= ${"pu$i"};
			if (($row->{"tu$i"}-$current_time) >= 0) {
				$unit_time += ($row->{"tu$i"}-$current_time);
			}
$to_update .= ", money=money-$unit_cost, pu$i=pu$i+${"pu$i"}, tu$i=$current_time+$unit_time";
$row->money -= $unit_cost;
$row->{"pu$i"} += ${"pu$i"};
$row->{"tu$i"} = $current_time+$unit_time;
	}
}
	}
}
	//ORDERING
$unit_time = ((1+$i)*60)+((1+$i)*(1+$i));
$unit_cost = 100+(($i*5)*($i*5));

//$to_update .= ", t$q=$current_time+30+(30*$i)+(".$row->$ia."*".$row->$ia."*(1+($i*$i)))".$in_update;
if (empty($tr_col)) {$tr_col = ' bgcolor="#123456"';}else{$tr_col = '';}
print '<tr'.$tr_col.'>
<td valign=top><b>'.$units_name[$i].'</b><br>';

if ($q == 'h') {
	$j = 0; foreach ($units[$units_name[$i]] as $val) {
		if ($val >= 1) {
			if ($j == 0) {
				print $val.' '.$helping[$j].'<br>';
			}elseif ($j == 1) {
				print '+ $'.$val.' '.$helping[$j].'<br>';
			}else{
				print '+ '.$val.' damage to '.$helping[$j].'<br>';
			}
		}
	$j++; }

}

print '</td>
<td valign=top>'.$row->{"u$i"}.'</td>
<td valign=top>'.$row->{"pu$i"}.'</td>
<td valign=top>$'.number_format($unit_cost).'</td>
<td valign=top>'.number_format($unit_time).'</td>
<td valign=top>';
if ($row->{"tu$i"} >= 1) {
	print ($row->{"tu$i"}-$current_time);
	if ($refresh_timer <=0 ) {$refresh_timer = ($row->{"tu$i"}-$current_time);}
	if (($row->{"tu$i"}-$current_time) < $refresh_timer) {
		$refresh_timer = ($row->{"tu$i"}-$current_time);
	}
} else {
	print '0';
}
print '</td>
<td valign=top>';
if ($row->{"b$i"} > $row->{"pu$i"}) {
print '<input type=text name="pu'.$i.'" value="'.($row->{"b$i"}-$row->{"pu$i"}).'" size=1 maxlength=3 style="width:100%;">';
}else{
print 'NA';
}
print '</td></tr>';

if ($row->{"b$i"} <= 0 and $row->{"pb$i"} <= 0) {break;}
}

print '</td></tr><tr><th colspan=7>
<table width=100%><tr><th><input type=submit></th></tr></table>
</th></tr></table></form>';




require_once($html_footer);
?>