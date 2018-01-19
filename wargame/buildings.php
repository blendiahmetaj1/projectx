<?php
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once($inc_functions);
require_once($inc_mysql);
require_once($inc_arrays);
require_once($html_header);

if (empty($row)) {?>It appears your session has been timed out please relogin.<?require_once($html_footer);exit;}


print '<table><tr><th colspan=7>Buildings</th></tr>
<tr><th>Name</th><th>Level</th><th>Ordered</th><th>Cost</th><th>Duration</th><th>Timer</th><th>Order</th></tr>';

$buildings_name=array_keys($buildings);

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

if (empty($tr_col)) {$tr_col = ' bgcolor="#123456"';}else{$tr_col = '';}
print '<tr'.$tr_col.'>
<td valign=top><b>'.$buildings_name[$i].'</b><br>';

if ($q == 'h') {
	$j = 0; foreach ($buildings[$buildings_name[$i]] as $val) {
		if ($val >= 1) {
			if ($j == 0) {
				print number_format($val).' '.$helping[$j].'<br>';
			}elseif ($j == 1) {
				print '+ $'.number_format($val).' '.$helping[$j].'<br>';
			}else{
				print '+ '.number_format($val).' damage to '.$helping[$j].'<br>';
			}
		}
	$j++; }

}

print '</td>
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
		print '<font size=-2>Upgrade<br>'.$buildings_name[$j].'</font>';
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

if ($row->{"b$i"} <= 0 and $row->{"pb$i"} <= 0) {break;}
}
print '</table>';



require_once($html_footer);
?>