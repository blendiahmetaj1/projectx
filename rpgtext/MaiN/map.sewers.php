<?php
#!/usr/local/bin/php
if($row->x == 32 and $row->y == 32 and $row->level >= 35 and $row->location == 'streets'){
$row->x = 40;$row->y = 40;$row->location = 'sewers';
$to_update .= ", `x`='40',`y`='40', `location`='sewers'";
}

if($row->location == 'sewers'){

//MOVEMENT
$min_x_go=40;
$min_y_go=40;
$max_x_go=50;
$max_y_go=50;

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
$attribute [($min_x_go+3)."-".($max_y_go)] = 'a2';
$attribute [($max_x_go)."-".($min_y_go+3)] = 'a2';
$attribute [($max_x_go)."-".($max_y_go)] = 'a1';

$attribute [($min_x_go+5)."-".($min_y_go)] = 'a1';
$attribute [($min_x_go+3)."-".($min_y_go+1)] = 'a2';
$attribute [($min_x_go+5)."-".($min_y_go+2)] = 'a1';
$attribute [($min_x_go+2)."-".($min_y_go+3)] = 'a2';
$attribute [($min_x_go+5)."-".($min_y_go+4)] = 'a1';
$attribute [($min_x_go+1)."-".($min_y_go+5)] = 'a2';
//SPECIAL

//MAP PRINTING (show locations 0 or 1, show kingdoms 0 or 1)
map_printing(1,1);
//MAP PRINTING

		//GET SECRET
if($row->x == $min_x_go and $row->y == $min_y_go) {
$to_output .= '<a href="?xmap=streets">Exit from the '.$row->location.'.</a><br>';
}
		//GET SECRET
}else{
$to_output .= 'Can\'t do that!<br>';
include_once 'MaiN/map.game.php';
}
?>