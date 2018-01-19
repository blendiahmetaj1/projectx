<?php
#!/usr/local/bin/php
if(($row->x == 99 and $row->y == 99) and $row->level >= 25){
$row->x = 27;$row->y = 27;$row->location = 'streets';
$to_update .= ", `x`='27',`y`='27', `location`='streets'";
}elseif(($row->x == 40 and $row->y == 40) and $row->level >= 25){
$row->x = 32;$row->y = 32;$row->location = 'streets';
$to_update .= ", `x`='32',`y`='32', `location`='streets'";

}

if($row->location == 'streets'){

//MOVEMENT
$min_x_go=27;
$min_y_go=27;
$max_x_go=32;
$max_y_go=32;

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
$attribute [($min_x_go)."-".($min_y_go)] = 'a1';
$attribute [($min_x_go)."-".($max_y_go)] = 'a2';
$attribute [($max_x_go)."-".($min_y_go)] = 'a2';
$attribute [($max_x_go)."-".($max_y_go)] = 'a1';
$attribute [($min_x_go+3)."-".($min_y_go+3)] = 'a1';
//SPECIAL

//MAP PRINTING (show locations 0 or 1, show kingdoms 0 or 1)
map_printing(1,1);
//MAP PRINTING

		//GET SECRET
if($row->x == $min_x_go and $row->y == $min_y_go) {
$to_output .= '<a href="?xmap=game">Exit from the '.$row->location.'.</a><br>';
}
		//GET SECRET
if($row->x == $max_x_go and $row->y == $max_y_go) {
if (!empty($_POST['potion'])) {
if($_POST['potion'] == 'mana'){
$to_output .= '<a href="?xmap=sewers">Enter secret secret level the Sewers.</a><br>';
}
}
}
		//GET SECRET
		//GET SECRET
}else{
$to_output .= 'Can\'t do that!<br>';
include_once 'MaiN/map.game.php';
}
?>