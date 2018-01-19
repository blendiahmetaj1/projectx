<?php
#!/usr/local/bin/php

?><table cellpadding=1 cellspacing=1 border=1><tr><th>Charname</th><th>Money</th><th>Income</th><th>Settlements</th><th>Upgrades</th><th>Radius</th><th>Destroyed</th><th>Attacked</th></tr><?php
if ($lresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE `id` ORDER BY `money` DESC LIMIT 50")) {
	while ($lrow = mysqli_fetch_object ($lresult)) {

$i_income = 1+(($lrow->x0*$production)+($lrow->x1*($production*2)));
$i_explore = $cost_explore +($lrow->x0+$lrow->x1);
$i_settle = $cost_settle + ((1+$lrow->x0)*(1+$lrow->x1));
$i_upgrade = $cost_upgrade + ((1+$lrow->x0)*(1+$lrow->x1)+$i_income);
$i_attack = $cost_attack + (((1+$lrow->x0)*(1+$lrow->x1)/2)+$i_income);

print '<tr';

if(empty($bg)){
	?> bgcolor="#1234561"<?php
	$bg=1;
}else{
	$bg='';
}

print '><td><a title="Explore cost $'.number_format($i_explore).'
Settle cost $'.number_format($i_settle).'
Upgrade cost $'.number_format($i_upgrade).'
Attack cost $'.number_format($i_attack).'">'.$lrow->charname.'</a></td><td>$'.number_format($lrow->money).'</td><td>$'.number_format($i_income,2).'</td><td>'.number_format($lrow->x0).'</td><td>'.number_format($lrow->x1).'</td><td>'.number_format($lrow->x2).'</td><td>'.number_format($lrow->x4).'</td><td>'.number_format($lrow->x5).'</td></tr>';
	}
	mysqli_free_result ($lresult);
}
?></table>