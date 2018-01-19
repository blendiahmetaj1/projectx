<?php
#!/usr/local/bin/php

$min_x_go = 1;
$min_y_go = 1;

if($nresult = mysqli_query ($link, "SELECT `id` FROM `$tbl_members` WHERE `id` ORDER BY `id` DESC LIMIT 100000")){
if($total_players=mysqli_num_rows($nresult)){
mysqli_free_result ($nresult);
	//print $total_players;	$total_players = 100;
//EXTRA LOCATIONS SHOP ETC
if($total_players/10 >= 1) {

for ($i=0;$i<=$total_players/10;$i++){
	$i += 20-count($action_visit);
	//print $i.' ';
	foreach ($action_visit as $val) {
		$i++;
		if (preg_match("/\.5$/",($i/2))){
			$is_locations[($i-2).'-'.($i-1)]=$val;
		}else{
			$is_locations[($i+1).'-'.$i]=$val;
		}

	}

}
}
//EXTRA LOCATIONS SHOP ETC
}
}

$max_x_go = round($total_players/10);
$max_y_go = round($total_players/10);
if ($max_x_go <= 25){
$max_x_go=25;
}
if ($max_y_go <= 25){
$max_y_go=25;
}

?>