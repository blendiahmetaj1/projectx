<?php
#!/usr/local/bin/php
if(($row->x == 27 and $row->y == 27) or ($row->x == 40 and $row->y == 40)){
$row->x = $max_x_go;$row->y = $max_y_go;$row->location = '';
$to_update .= ", `x`='25',`y`='25', `location`=''";
}elseif($row->x == 50 and $row->y == 50){
$row->x = 11;$row->y = 10;$row->location = '';
$to_update .= ", `x`='11',`y`='10', `location`=''";
}elseif($row->x == 55 and $row->y == 55){
$row->x = 7;$row->y = 20;$row->location = '';
$to_update .= ", `x`='7',`y`='20', `location`=''";
}elseif($row->x == 75 and $row->y == 75){
$row->x = 20;$row->y = 10;$row->location = '';
$to_update .= ", `x`='20',`y`='10', `location`=''";
}elseif($row->x == 100 and $row->y == 100){
$row->x = 20;$row->y = 20;$row->location = '';
$to_update .= ", `x`='20',`y`='20', `location`=''";
}elseif($row->x == 120 and $row->y == 120){
$row->x = 20;$row->y = 20;$row->location = '';
$to_update .= ", `x`='20',`y`='20', `location`=''";
}


//MOVEMENT


if (!empty($_POST['move'])) {
$move=clean_post($_POST['move']);
move_it($move);
}
//MOVEMENT

//MONSTERS
if(rand(1,100) <= 10){
generator_shop_item();
map_monsters(1,10,1,10,1,10);
}
//MONSTERS

//BUGGED
if($row->x >= $max_x_go){
	$row->x=$max_x_go;
	$to_update .= ", `x`='$max_x_go',`location`=''";
}
if($row->y >= $max_y_go){
	$row->y=$max_y_go;
	$to_update .= ", `y`='$max_y_go',`location`=''";
}
//BUGGED

//KINGDOMS
$is_kingdom = map_kingdoms(3);
//KINGDOMS

//ONCLICK BUILDING KINGDOM
onclick_building_kingdom();
//ONCLICK BUILDING KINGDOM

//MAPPING
$map_url= $path_game.'/maps/default';
$corners=map_corners();
$maps=map_images($map_url);
//MAPPING

//SPECIAL
$attribute [($min_x_go)."-".($min_y_go)] = 'a6';
$attribute [($min_x_go)."-".($max_y_go)] = 'a6';
$attribute [($max_x_go)."-".($min_y_go)] = 'a6';
$attribute [($max_x_go)."-".($max_y_go)] = 'a6';


$attribute [($max_x_go-1)."-".($max_y_go-1)] = 'a5';
$attribute [($max_x_go-1)."-".($max_y_go-2)] = 'a5';
$attribute [($max_x_go-1)."-".($max_y_go-3)] = 'a5';
$attribute [($max_x_go-3)."-".($max_y_go-1)] = 'a5';
$attribute [($max_x_go-3)."-".($max_y_go-2)] = 'a5';
$attribute [($max_x_go-3)."-".($max_y_go-3)] = 'a5';
$attribute [($max_x_go-1)."-".($max_y_go-1)] = 'a5';
$attribute [($max_x_go-2)."-".($max_y_go-2)] = 'a3';
$attribute [($max_x_go-3)."-".($max_y_go-3)] = 'a5';

$attribute [($min_x_go+5)."-".($min_y_go)] = 'a4';
$attribute [($min_x_go+5)."-".($min_y_go+1)] = 'a4';
$attribute [($min_x_go+5)."-".($min_y_go+2)] = 'a4';
$attribute [($min_x_go+5)."-".($min_y_go+3)] = 'a4';
$attribute [($min_x_go+5)."-".($min_y_go+4)] = 'a4';
$attribute [($min_x_go+5)."-".($min_y_go+5)] = 'a4';

$attribute [($min_x_go)."-".($min_y_go+6)] = 'a4';
$attribute [($min_x_go+1)."-".($min_y_go+6)] = 'a4';
$attribute [($min_x_go+2)."-".($min_y_go+6)] = 'a4';
$attribute [($min_x_go+3)."-".($min_y_go+6)] = 'a4';
$attribute [($min_x_go+4)."-".($min_y_go+6)] = 'a4';
$attribute [($min_x_go+5)."-".($min_y_go+6)] = 'a6';
$attribute [($min_x_go+4)."-".($min_y_go+5)] = 'a6';

$attribute [($min_x_go+3)."-".($min_y_go+2)] = 'a5';
$attribute [($min_x_go+1)."-".($min_y_go+2)] = 'a5';
$attribute [($min_x_go+2)."-".($min_y_go+1)] = 'a6';

$attribute [($min_x_go+3)."-".($min_y_go+4)] = 'a5';
$attribute [($min_x_go+1)."-".($min_y_go+4)] = 'a5';
$attribute [($min_x_go+2)."-".($min_y_go+3)] = 'a6';


$attribute['10-9'] = 'a1';
$attribute['10-11'] = 'a3';
$attribute['11-9'] = 'a2';
$attribute['11-11'] = 'a2';
$attribute['12-9'] = 'a3';
$attribute['12-11'] = 'a1';
//SPECIAL

		//GET SECRET
if($row->x == $max_x_go and $row->y == $max_y_go) {
if (!empty($_POST['potion'])) {
if($_POST['potion'] == 'life'){
$to_output .= '<a href="?xmap=streets">Enter secret level the StreetS.</a><br>';
}
}
}
		//GET SECRET

//MAP PRINTING (show locations 0 or 1, show kingdoms 0 or 1)
map_printing(1,1);
//MAP PRINTING
?>
