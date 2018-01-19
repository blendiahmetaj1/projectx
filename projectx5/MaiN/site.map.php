<?php
#!/usr/local/bin/php
?><table cellpadding=1 cellspacing=1 border=1><tr><td><table cellpadding=1 cellspacing=1 border=0><?php

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

		//CLUSTER SETTLE
$clusters = round(5+($radius/10));
$cluster_cost = (($cost_settle*$clusters)+$radius);
if (!empty($_GET['cluster']) and $row->money >= $cluster_cost) {
$clust_settle = 0;
$clust_upgrade = 0;

for ($i=0;$i<=$clusters;$i++){

$xed = rand($row->x-$radius,$row->x+$radius);
$yed = rand($row->y-$radius,$row->y+$radius);

if ($lresult = mysqli_query ($link, "SELECT * FROM `$tbl_location` WHERE (`x`='$xed' and `y`='$yed' and `mid`='$row->id') ORDER BY `id` DESC LIMIT 1")) {
if (mysqli_num_rows($lresult) >= 1) {
	if ($lrow = mysqli_fetch_object ($lresult)){
		mysqli_free_result ($lresult);
		mysqli_query ($link, "UPDATE `$tbl_location` SET `x0`=`x0`+1 WHERE (`id`='$lrow->id') LIMIT 1") or print(mysqli_error().'222');
		$clust_upgrade++;
	}
}else{
mysqli_query ($link, "INSERT INTO `$tbl_location` VALUES ('','$row->id','$current_time','$xed','$yed','1','0','0','0','0','0','0','0','0','0')") or print(mysqli_error().'111');
$clust_settle++;
}
}
	
}
if ($clust_settle >= 1) {
$to_update .= ", `x0`=`x0`+$clust_settle";
}
if ($clust_upgrade >= 1) {
$to_update .= ", `x1`=`x1`+$clust_upgrade";
}
$total_costs += $cluster_cost;
$row->money -= $cluster_cost;
}

//if ($row->charname == 'silent') {$to_update .=", money = money+10000000";}
		//CLUSTER SETTLE

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

for ($x=$min_x; $x<=$max_x; $x++) {
	print '<tr>';
	for ($y=$min_y; $y<=$max_y; $y++) {
	$color='#00FF00';
		if (in_array("$x-$y",$myarray)) {
			$color='#000000';
		}
		if (in_array("$x-$y",$hearray)) {
			$color='#FF0000';
		}
		if (in_array("$x-$y",$enarray)) {
			$color='#FFFFFF';
		}

if ($x == $row->x and $y == $row->y) {
	$color='#0000FF';
}
		print '<td width=5 height=5 bgcolor="'.$color.'"> </td>';
	}
	print '</tr>';
}



?></table></td></tr></table>
<?php print 'Attempt to <a href="?map&cluster='.$clusters.'">cluster settle</a> '.number_format($clusters).' settlements in a radius of '.number_format($radius).' for $'.number_format($cluster_cost).'.<br>';

if ($clust_settle >= 1) {
print 'You have established '.number_format($clust_settle).' settlements.<br>';
}
if ($clust_upgrade >= 1) {
print 'You have upgraded '.number_format($clust_upgrade).' settlements.<br>';
}

?><br>
My map radius is <?php print number_format($row->x2,2);?>.<br>
<?php print ($row->x2<=100)?'You can <a href="?map&upgrade=1">upgrade radius</a> for $'.number_format($upgrade_cost).'.<br>':'';?>
<br>
You are in the center of the map and blue of color.<br>
Your land is marked black color.<br>
<br>
Settled lands are red in color.<br>
Other players are white in color.<br>
Free lands are green in color.<br>