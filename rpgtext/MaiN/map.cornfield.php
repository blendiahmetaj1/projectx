<?php
#!/usr/local/bin/php
if($row->x == 7 and $row->y == 20){
$row->x = 55;$row->y = 55;$row->location = 'cornfield';
$to_update .= ", `x`='55',`y`='55', `location`='cornfield'";
}

if($row->location == 'cornfield'){

//MOVEMENT
$min_x_go=55;
$min_y_go=55;
$max_x_go=57;
$max_y_go=60;

if (!empty($_POST['move'])) {
$move=clean_post($_POST['move']);
move_it($move);
}
//MOVEMENT

//MONSTERS
if(rand(1,100) <= 10){
generator_shop_item();
map_monsters($min_x_go,$max_x_go,$min_y_go,$max_y_go,1,50);
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
$attribute [($min_x_go+1)."-".($min_y_go)] = 'a1';
$attribute [($min_x_go+1)."-".($min_y_go+1)] = 'a4';
$attribute [($min_x_go+1)."-".($min_y_go+2)] = 'a1';
$attribute [($min_x_go+1)."-".($min_y_go+3)] = 'a4';
$attribute [($min_x_go+2)."-".($min_y_go+4)] = 'a1';
$attribute [($min_x_go+2)."-".($min_y_go+5)] = 'a4';
//SPECIAL

//MAP PRINTING (show locations 0 or 1, show kingdoms 0 or 1)
map_printing(1,1);
//MAP PRINTING

		//GET SECRET
if($row->x == $min_x_go and $row->y == $min_y_go) {
$to_output .= '<a href="?xmap=game">Exit from the '.$row->location.'.</a><br>';
}
		//GET SECRET
}else{
$to_output .= 'Can\'t do that!<br>';
include_once 'MaiN/map.game.php';
}
?>