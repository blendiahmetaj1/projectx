<table cellpadding=1 cellspacing=1 border=1 width=100%><tr><th>Charname</th><th>Income</th</tr><?php
if ($lresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE `id` ORDER BY `money` DESC LIMIT 15")) {
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

print '><td><a title="Money $'.number_format($lrow->money).'
Explore cost $'.number_format($i_explore).'
Settle cost $'.number_format($i_settle).'
Upgrade cost $'.number_format($i_upgrade).'
Attack cost $'.number_format($i_attack).'
Settlements '.number_format($lrow->x0).'
Upgrades '.number_format($lrow->x1).'
Radius '.number_format($lrow->x2).'
Destroyed '.number_format($lrow->x4).'
Attacked '.number_format($lrow->x5).'">'.$lrow->charname.'
</a></td><td>$'.number_format($i_income,2).'</td></tr>';
	}
	mysqli_free_result ($lresult);
}
?></table>