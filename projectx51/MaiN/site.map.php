<?php
#!/usr/local/bin/php
?><table cellpadding=0 cellspacing=0 border=0><tr><td><table cellpadding=0 cellspacing=1 border=0><?php

$upgrade_cost = 1000+($my_income*100*$row->x2);
if (!empty($_GET['upgrade']) and $row->money >= $upgrade_cost and $row->x2 <= 100) {
$to_update .= ", `x2`=`x2`+1";
$total_costs += $upgrade_cost;
$row->money -= $upgrade_cost;
$row->x2++;
$upgrade_cost = 1000+($my_income*100*$row->x2);
}

if (($row->x2/2) <= 10) {
	$radius = 10;
}else{
	$radius = round($row->x2/2);
}

$min_x=0;$min_y=0;$max_x=$radius;$max_y=$radius;

$min_x+= round($row->x-($radius/2));
$max_x+=round($row->x-($radius/2));

$min_y+=round($row->y-($radius/2));
$max_y+=round($row->y-($radius/2));

$myarray = array();
if ($lresult = mysqli_query ($link, "SELECT `x`,`y` FROM `$tbl_location` WHERE ((`x` BETWEEN '$min_x' AND '$max_x') and (`y` BETWEEN '$min_y' AND '$max_y') and (`mid`='$row->id'))  ORDER BY `id` DESC LIMIT 10000")) {
	while ($lrow = mysqli_fetch_object ($lresult)) {
	$myarray[] = "$lrow->x-$lrow->y";
	}
	mysqli_free_result ($lresult);
}

$hearray = array();
if ($lresult = mysqli_query ($link, "SELECT `x`,`y` FROM `$tbl_location` WHERE ((`x` BETWEEN '$min_x' AND '$max_x') and (`y` BETWEEN '$min_y' AND '$max_y') and (`mid`!='$row->id'))  ORDER BY `id` DESC LIMIT 10000")) {
	while ($lrow = mysqli_fetch_object ($lresult)) {
	$hearray[] = "$lrow->x-$lrow->y";
	}
	mysqli_free_result ($lresult);
}

$enarray = array();
if ($eresult = mysqli_query ($link, "SELECT `x`,`y` FROM `$tbl_members` WHERE ((`x` BETWEEN '$min_x' AND '$max_x') and (`y` BETWEEN '$min_y' AND '$max_y') and (`id`!='$row->id'))  ORDER BY `id` DESC LIMIT 10000")) {
	while ($erow = mysqli_fetch_object ($eresult)) {
	$enarray[] = "$erow->x-$erow->y";
	}
	mysqli_free_result ($eresult);
}

$title='';
$image=' ';
for ($x=$min_x; $x<=$max_x; $x++) {
	print '<tr>';
	for ($y=$min_y; $y<=$max_y; $y++) {
	$color='#00FF00';
	$title='Free land!';
		if (in_array("$x-$y",$myarray)) {
			$color='#000000';
			$title='My land!';
		}
		if (in_array("$x-$y",$hearray)) {
			$color='#FF0000';
			$title='Enemy land!';
		}
		if (in_array("$x-$y",$enarray)) {
			$color='#FFFFFF';
			$title='Enemy is here!';
			$image='<img src="images/enemy.gif" width="5 " height="5">';
		}

if ($x == $row->x and $y == $row->y) {
	$color='#0000FF';
	$title='You are here!';
}
		print '<td width=5 height=5 bgcolor="'.$color.'" title="'.$title.'">'.$image.'</td>';
	$title='';
	$image=' ';
	}
	print '</tr>';
}
?></table></td></tr></table>