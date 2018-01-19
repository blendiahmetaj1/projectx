<?php
#!/usr/local/bin/php
if($row->x == 110 and $row->y == 110 and $row->location == 'bones'){
$row->x = 120;$row->y = 120;$row->location = 'demonic';
$to_update .= ", `x`='120',`y`='120', `location`='demonic'";
}

if($row->location == 'demonic'){

//MOVEMENT
$min_x_go=120;
$min_y_go=120;
$max_x_go=125;
$max_y_go=135;

if (!empty($_POST['move'])) {
$move=clean_post($_POST['move']);
move_it($move);
}
//MOVEMENT

//MONSTERS
if(rand(1,100) <= 10){
generator_shop_item();
map_monsters($min_x_go,$max_x_go,$min_y_go,$max_y_go,150,200);
}
//MONSTERS

//KINGDOMS
$is_kingdom = map_kingdoms(3);
//KINGDOMS

//ONCLICK BUILDING KINGDOM
onclick_building_kingdom();
//ONCLICK BUILDING KINGDOM

//MAPPING
$map_url='images/maps/'.$row->location;
$corners=map_corners();
$maps=map_images($map_url);
//MAPPING

//SPECIAL
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a1';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a2';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a3';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a4';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a5';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a6';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a1';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a2';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a3';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a4';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a5';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a6';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a1';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a2';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a3';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a4';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a5';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a6';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a1';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a2';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a3';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a4';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a5';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a6';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a1';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a2';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a3';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a4';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a5';
$attribute [rand($min_x_go,$max_x_go-1)."-".rand($min_y_go,$max_y_go-1)] = 'a6';

//SPECIAL

//MAP PRINTING (show locations 0 or 1, show kingdoms 0 or 1)
map_printing(1,1);
//MAP PRINTING

		//GET SECRET
if($row->x == $min_x_go and $row->y == $min_y_go) {
$to_output .= '<a href="?xmap=bones">Exit from the '.$row->location.'.</a><br>';
}
		//GET SECRET
}else{
	print 'aaaaaaaaaaaaaaaa';
$to_output .= 'Can\'t do that!<br>';
include_once 'MaiN/map.game.php';
}
?>