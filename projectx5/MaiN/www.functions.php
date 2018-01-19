<?php
#!/usr/local/bin/php

/*_______________-=TheSilenT.CoM=-_________________*/

function clean_post($in){
$in=htmlentities("$in",ENT_QUOTES);
$in=strip_tags($in);
$in=trim($in);
$in=addslashes($in);
return $in;
}

/*_______________-=TheSilenT.CoM=-_________________*/

function color_me($x,$y) {
$color="#$x$y";
while (strlen($color) < 7) {
$color .= "8";
}
return $color;
}

/*_______________-=TheSilenT.CoM=-_________________*/

function settle ($xx,$yy) {
global $row,$cost_settle,$action,$tbl_location,$total_cost,$to_update,$total_costs,$current_time;
		//SETTLE
		if ($row->money >= $cost_settle and $action == 'Settle' and !empty($xx) and !empty($yy)) {
			mysqli_query ($link, "INSERT INTO `$tbl_location` VALUES ('','$row->id','$current_time','$xx','$yy','0','0','0','0','0','0','0','0','0','0')") or print(mysqli_error().'111');
			$total_costs += $cost_settle;
			$row->money -=$cost_settle;
			$to_update .= ", `x0` = `x0`+1";
		}
		//SETTLE
}

/*_______________-=TheSilenT.CoM=-_________________*/

function upgrade($xx,$yy) {
global $row,$cost_upgrade,$action,$tbl_location,$total_cost,$to_update,$total_costs,$current_time;
		//SETTLE UPGRADE
		if ($row->money >= $cost_upgrade and $action == 'Upgrade' and !empty($xx) and !empty($yy)) {
if ($lresult = mysqli_query ($link, "SELECT * FROM `$tbl_location` WHERE (`x`='$xx' and `y`='$yy') ORDER BY `id` DESC LIMIT 1")) {
	if ($lrow = mysqli_fetch_object ($lresult)) {
	mysqli_free_result ($lresult);
		if ($lrow->mid == $row->id and $row->x == $lrow->x and $row->y == $lrow->y and $lrow->x0 <= 999) {
			mysqli_query ($link, "UPDATE `$tbl_location` SET `x0`=`x0`+1 WHERE (`id`='$lrow->id') LIMIT 1") or print(mysqli_error().'222');
			$total_costs += $cost_upgrade;
			$row->money -=$cost_upgrade;
			$to_update .= ", `x1` = `x1`+1";
		}
	}
}
		}
		//SETTLE UPGRADE
}

/*_______________-=TheSilenT.CoM=-_________________*/

function attack($xx,$yy) {
global $row,$cost_attack,$action,$tbl_location,$tbl_members,$tbl_messages,$total_cost,$to_update,$total_costs,$current_time;
		//ATTACK
		if ($row->money >= $cost_attack and $action == 'Attack' and !empty($xx) and !empty($yy)) {
if ($lresult = mysqli_query ($link, "SELECT * FROM `$tbl_location` WHERE (`x`='$xx' and `y`='$yy') ORDER BY `id` DESC LIMIT 1")) {
	if ($lrow = mysqli_fetch_object ($lresult)) {
	mysqli_free_result ($lresult);
		if ($lrow->mid !== $row->id and $row->x == $lrow->x and $row->y == $lrow->y) {
			if ($lrow->x0 <= 1) {
				mysqli_query ($link, "DELETE FROM `$tbl_location` WHERE (`id`='$lrow->id') LIMIT 1") or print(mysqli_error().'333');
				
				mysqli_query ($link, "UPDATE `$tbl_members` SET `x0`=`x0`-1 WHERE (`id`='$lrow->mid') LIMIT 1") or print(mysqli_error().'555');	
				$to_update .= ", `x4`=`x4`+1";
			}else{
				mysqli_query ($link, "UPDATE `$tbl_location` SET `x0`=`x0`-1 WHERE (`id`='$lrow->id') LIMIT 1") or print(mysqli_error().'444');
				mysqli_query ($link, "UPDATE `$tbl_members` SET `x1`=`x1`-1 WHERE (`id`='$lrow->mid') LIMIT 1") or print(mysqli_error().'666');			
				$to_update .= ", `x5`=`x5`+1";
			}
//MESSAGES OWNER
if ($oresult = mysqli_query ($link, "SELECT `charname` FROM `$tbl_members` WHERE (`id`='$lrow->mid') ORDER BY `id` DESC LIMIT 1")) {
	if ($orow = mysqli_fetch_object ($oresult)) {
	mysqli_free_result ($oresult);
			mysqli_query ($link, "INSERT INTO `$tbl_messages` VALUES ('','$row->charname','$orow->charname','$row->charname attacked your land.','$current_time')") or die(mysqli_error());
	}
}
//MESSAGES OWNER
			$total_costs += $cost_attack;
			$row->money -=$cost_attack;
		}
	}
}
		}
		//ATTACK
}


/*_______________-=TheSilenT.CoM=-_________________*/

function dater($secs){
global $current_time;
$s='';
if ($current_time-$secs < 0){
$secs=round($secs-$current_time,2);
}else{
$secs=round($current_time-$secs,2);
}

if($secs>= 3600){
$n=(int)($secs/3600);$s .= (strlen($n)<=1?"0":"").$n;$secs %= 3600;
}else{$s .='00';}
$s .=':';
if($secs>= 60){
$n=(int)($secs/60);$s .= (strlen($n)<=1?"0":"").$n;$secs %= 60;
}else{$s .='00';}
$s .=':';
if($secs>=1){
$s .= (strlen($secs)<=1?"0":"").$secs;
}else{
$s.='00';
}
return trim($s);
}

/*_______________-=TheSilenT.CoM=-_________________*/

?>