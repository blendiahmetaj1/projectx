<?php
#!/usr/local/bin/php
//DETERMINE PLAYER POSITION

if (!empty($_POST['action'])) {
	$action=clean_post($_POST['action']);
}else{$action ='';}

//MOVEMENT
if (!empty($_POST['xx']) and !empty($_POST['yy'])) {
	$xx=clean_post($_POST['xx']);
	$yy=clean_post($_POST['yy']);

$movement =0;
if($row->x <> $xx) {
	if($row->x > $xx) {$movement += $row->x-$xx;}elseif($row->x <= $xx) {$movement += $xx-$row->x;}
	$row->x = $xx;
	$to_update .= ", `x`='$xx'";
}
if($row->y <> $yy) {
	if($row->y > $yy) {$movement += $row->y-$yy;}elseif($row->y <= $yy) {$movement += $yy-$row->y;}
	$row->y = $yy;
	$to_update .= ", `y`='$yy'";
}
if($movement >= 1) {
	$total_costs += ($movement*$cost_explore);
}

		//SETTLE
settle($xx,$yy);
		//SETTLE
		//SETTLE UPGRADE
upgrade($xx,$yy);
		//SETTLE UPGRADE
		//ATTACK
attack($xx,$yy);
		//ATTACK
}
//MOVEMENT

?><table cellpadding=0 cellspacing=0 border=1><?php


$min_x=0;$min_y=0;$max_x=4;$max_y=4;

$min_x+=$row->x-2;
$max_x+=$row->x-2;

$min_y+=$row->y-2;
$max_y+=$row->y-2;

for ($x=$min_x; $x<=$max_x; $x++) {
	print '<tr>';
	for ($y=$min_y; $y<=$max_y; $y++) {
	$whatever='';
	print '<form method=post><input type=hidden name=xx value="'.$x.'"><input type=hidden name=yy value="'.$y.'"><td align="center" valign="center" width=75 height=75 bgcolor="'.color_me($x,$y).'">';

if ($lresult = mysqli_query ($link, "SELECT * FROM `$tbl_location` WHERE (`x`='$x' and `y`='$y') ORDER BY `id` DESC LIMIT 1")) {
	if ($lrow = mysqli_fetch_object ($lresult)) {
		print '<input type=button name="level" value="Level '.number_format($lrow->x0+1).'">';
	mysqli_free_result ($lresult);
		if ($lrow->mid == $row->id) {
			if ($row->money >= $cost_upgrade) {
				$whatever='Upgrade';
			}else{
				//NO MONEY
			}
		} else {
			if ($row->money >= $cost_attack) {
				$whatever='Attack';
			}else{
				//NO MONEY
			}
		}
	}else{
		if ($row->money >= $cost_settle) {
			$whatever='Settle';
		}else{
			//NO MONEY
		}
	}
}else{
	//NO QUERY
}

	if (!empty($whatever)) {
		print '<input type=submit name="action" value="'.$whatever.'">';
	}
	print '<input type=submit name="action" value="Explore"></td></form>';
	}
	print '</tr>';
}


?></table><?php

print 'Exploring cost $'.number_format($cost_explore).' per block.<br>
Settle and take a piece of land cost $'.number_format($cost_settle).'.<br>
Upgrading a settlement cost $'.number_format($cost_upgrade).'.<br>
Attack and destroy an enemy settlement cost $'.number_format($cost_attack).'.<br>';
?>