<?php
#!/usr/local/bin/php
/*
Script name	: Functions
Version		: 3.00
Release date	: 19-12-2001 2:05
Last Update	: 03-11-07 03:00
Email		: admin@thesilent.com
Homepage	: http://www.thesilent.com
Created by	: TheSilent
Last modified by	: TheSilent
*/

/*_______________-=TheSilenT.CoM=-_________________*/

function onclick_building_kingdom() {
//ONCLICK BUILDING KINGDOM
global $row,$_POST,$is_locations,$to_update,$to_output,$is_kingdom;

for ($ix=($row->x-1);$ix<($row->x+2);$ix++){
for ($iy=($row->y-1);$iy<($row->y+2);$iy++){
	//print '<br>'.$ix.' '.$iy;
	if(!empty($_POST['visit'])){
		if(!empty($is_locations[$ix.'-'.$iy])){
			if($is_locations[$ix.'-'.$iy] == $_POST['visit']){
				$row->x=$ix;
				$row->y=$iy;
				$to_update .= ", `x`=$row->x, `y`=$row->y";
				$to_output .= 'Entering the '.$is_locations[$ix.'-'.$iy].' building.<br>';
			}
		}
	}
	if(!empty($_POST['kingdom'])){
		if(!empty($is_kingdom[$ix.'-'.$iy])){
			if($is_kingdom[$ix.'-'.$iy] == $_POST['kingdom']){
				$row->x=$ix;
				$row->y=$iy;
				$to_update .= ",`x`=$row->x, `y`=$row->y";
				$to_output .= 'Entering the '.$is_kingdom[$ix.'-'.$iy].' kingdom.<br>';
			}
		}
	}
}
}
//ONCLICK BUILDING KINGDOM
}

/*_______________-=TheSilenT.CoM=-_________________*/
function map_players($distance) {
global $row,$tbl_members,$current_time,$online_show;
$is_players = array();
//PLAYERS
if($presult = mysqli_query ($link, "SELECT `id`,`x`,`y` FROM `$tbl_members` WHERE (`x` BETWEEN ".($row->x-$distance)." AND ".($row->x+$distance).") AND (`y` BETWEEN ".($row->y-$distance)." AND ".($row->y+$distance).") AND `timer`>=($current_time-$online_show) AND `id` != '$row->id' ORDER BY `id` DESC LIMIT 100")){
if (mysqli_num_rows($presult) >= 1) {
while ($prow = mysqli_fetch_object ($presult)) {
$is_players["$prow->x-$prow->y"]=$prow->id;
}
mysqli_free_result ($presult);
}
}
return $is_players;
//PLAYERS
}
/*_______________-=TheSilenT.CoM=-_________________*/
function map_monster($distance) {
global $row,$tbl_fight;
$is_monster=array();
//MONSTERS
if($fresults = mysqli_query ($link, "SELECT `id`,`x`,`y` FROM `$tbl_fight`WHERE (`x` BETWEEN ".($row->x-$distance)." AND ".($row->x+$distance).") AND (`y` BETWEEN ".($row->y-$distance)." AND ".($row->y+$distance).") ORDER BY `id` DESC LIMIT 100")) {
if(mysqli_num_rows($fresults) >= 1){
while ($frow = mysqli_fetch_object ($fresults)) {
$is_monster["$frow->x-$frow->y"]=$frow->id;
}
mysqli_free_result ($fresults);
}
}
return $is_monster;
//MONSTERS
}
/*_______________-=TheSilenT.CoM=-_________________*/
function map_kingdoms($distance) {
global $row,$tbl_kingdoms,$is_kingdom;
//KINGDOMS
if($kresults = mysqli_query ($link, "SELECT * FROM `$tbl_kingdoms`WHERE (`x` BETWEEN ".($row->x-$distance)." AND ".($row->x+$distance).") AND (`y` BETWEEN ".($row->y-$distance)." AND ".($row->y+$distance).") ORDER BY `id` DESC LIMIT 100")) {
if(mysqli_num_rows($kresults) >= 1){
while ($krow = mysqli_fetch_object ($kresults)) {
$is_kingdom["$krow->x-$krow->y"]=$krow->kingdom;
}
mysqli_free_result ($kresults);
}
}
return $is_kingdom;
//KINGDOMS
}
/*_______________-=TheSilenT.CoM=-_________________*/

function map_printing($onlocation,$onkingdom){
global $row, $to_output, $corners,$maps,$attribute,$min_x_go,$max_x_go,$min_y_go,$max_y_go, $map_url, $path_game, $tbl_fight, $tbl_members, $colbg, $max_monsters, $array_monsters,$move,$current_time,$online_show,$path_game,$monsters_at_location,$noob_level;
if($row->level <= $noob_level){
global $to_talk,$to_see,$to_fight;
}

//MAP PRINTING
//DETERMINE PLAYER POSITION
$min_x=0;$min_y=0;$max_x=2;$max_y=2;

$min_x+=$row->x-1;
$max_x+=$row->x-1;

$min_y+=$row->y-1;
$max_y+=$row->y-1;

//DETERMINE PLAYER POSITION

$is_monster=map_monster(3);

?><form method=post action="?">
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><th align=center valign=center>MAP <?php print 'X'.$row->x.' Y'.$row->y.' '.(empty($row->location)?'':$row->location);?></th></tr>
<tr><td align=center valign=center>
<table width=100% cellpadding=0 cellspacing=0 border=0 width=300 height=300>
<?php
for ($x=$min_x; $x<=$max_x; $x++) {
print '<tr>';
for ($y=$min_y; $y<=$max_y; $y++) {

if($x == $min_x_go and $y == $min_y_go and $min_x_go > 1 and $min_y_go > 1) {
$image_name = $path_game.'/maps/portal.php?bg='.$row->location.'/bg.jpg&portal=portal.gif';
}else{
$image_name = $map_url.'/'.map_it($x,$y,$corners,$maps,$attribute,$min_x_go,$max_x_go,$min_y_go,$max_y_go).'.jpg';
}

print '<td align=center valign=center width=100 height=100 background="'.$image_name.'">';

if($onlocation){
	global $is_locations, $col_buildings, $col_kingdom;
//IS LOCATION
if (in_array("$x-$y",array_keys($is_locations))) {
if(!empty($is_locations["$x-$y"])){
		print '<input type=submit name=visit value="'.$is_locations["$x-$y"].'" style="width:60;background-color:'.$col_buildings.';">';
	if($row->level <= $noob_level){
	if ($row->x == $x and $row->y == $y){
		$to_output .= '<font color="'.$col_kingdom.'">You can visit the <a href="?visit='.$is_locations["$x-$y"].'">'.$is_locations["$x-$y"].'</a>.</font><br>';
	}else{
		if(!empty($to_see)){$to_see .= ', ';}
		$to_see .= ' the '.$is_locations["$x-$y"].'\'s building';
	}
	}
}
}
//IS LOCATION
}

if($onkingdom){
	global $is_kingdom, $col_kingdom, $kingdom_level;
//IS KINGDOM
if (in_array("$x-$y",array_keys($is_kingdom))) {
if(!empty($is_kingdom["$x-$y"])){
		print '<input type=submit name=kingdom value="'.$is_kingdom["$x-$y"].'" style="width:60;background-color:'.$col_kingdom.';">';
	/*if ($row->x == $x and $row->y == $y){
		$to_output .= '<font color="'.$col_kingdom.'">You can visit the <a href="?player=kingdom&kingdom='.$is_kingdom["$x-$y"].'">'.$is_kingdom["$x-$y"].' kingdom</a>.</font><br>';
	}else{
		if(!empty($to_see)){$to_see .= ', ';}
		$to_see .= ' the '.$is_kingdom["$x-$y"].' kingdom';
	}*/
}
}else{
if ($row->x == $x and $row->y == $y and $row->level >= $kingdom_level){
	$to_output .= '<a href="?player=kingdom">Establlish a new kingdom here!</a><br>';
}
}
//IS KINGDOM
}

		//PLAYERS
print '<br>';
if ($row->x == $x and $row->y == $y){

	//print '<a title="'.$row->sex.' '.$row->charname.'" style="background:'.$colbg.';"><img src="'.$path_game.'/class/'.$row->class.'.gif" border=0></a>';
	print '<font size=-1><a title="'.$row->sex.' '.$row->charname.'" style="background:'.$colbg.';">'.$row->charname.($row->life <= 0?'<sup>DEAD</sup>':'').'</a></font>';

}
			//PLAYERS VISIBLE
if($presult = mysqli_query ($link, "SELECT `sex`,`charname`,`class`,`life`,`level` FROM `$tbl_members` WHERE `x`='$x' and `y`='$y' and `id`!='$row->id' and `timer`>=($current_time-$online_show) ORDER BY `id` DESC LIMIT 100")){
while ($prow = mysqli_fetch_object ($presult)) {
print '<a href="?talk='.$prow->charname.'" title="'.$prow->sex.' '.$prow->charname.' '.number_format($prow->level).'"><img src="'.$path_game.'/class/'.($prow->life>=1?$prow->class:'spirit').'.gif" border=0></a>';
//print '<font size=-2><a href="?talk='.$prow->charname.'" title="'.$prow->sex.' '.$prow->charname.'">'.$prow->charname.($prow->life <= 0?'<sup>DEAD</sup>':'').'</a></font> ';

if($row->level <= $noob_level){
	if(!empty($to_talk)){$to_talk .= ', ';}
	$to_talk .= '<a href="?talk='.$prow->charname.'">'.$prow->sex.' '.$prow->charname.'</a><sup>'.number_format($prow->level).'</sup>';
}

}
mysqli_free_result ($presult);
}
			//PLAYERS VISIBLE
		//PLAYERS


		//GET MONSTERS
$monsters_here=0;
if($mresult = mysqli_query ($link, "SELECT `id`,`x`,`y`,`charname` FROM `$tbl_fight` WHERE `x`='$x' and `y`='$y' ORDER BY `id` DESC LIMIT $max_monsters")){
$monsters_here = mysqli_num_rows($mresult);
if($monsters_here >= 1 and $row->life >= 1){
while ($mrow = mysqli_fetch_object ($mresult)) {
if($row->x == $mrow->x and $row->y == $mrow->y) {
	if(empty($array_monsters[$mrow->charname])){
	monster_dies_or_revives($mrow->id);
	}else{
	if($row->level <= $noob_level){
		if(!empty($to_fight)){$to_fight .= ', ';}
		$to_fight .= '<a href="?attack='.$mrow->id.'">'.$array_monsters[$mrow->charname].'</a><sup>'.$mrow->charname.'</sup>';
	}
	$monsters_at_location += $monsters_here;
	}
}
}
mysqli_free_result ($mresult);
}
}

if ($monsters_here >= 1) {
	if($row->x == $x and $row->y == $y) {
print '<br><font size=-1><a href="?attack=engage">('.$monsters_here.' monsters)</a></font>';
	}else{
print '<br><font size=-1>('.$monsters_here.' monsters)</font>';
	}
}

if (empty($monster_generated) and $monsters_here < 2 and !empty($move)) {
if(rand(1,100) <= 10){
generate_monsters();//MUST BE PLACED BEHIND max_x_go AND max_y_go
$monster_generated=1;
}elseif(rand(1,100) <= 25){
map_monsters($min_x_go,$max_x_go,$min_y_go,$max_y_go,1,$max_x_go);
}
//print 'Monster Sighted!';
}

		//GET MONSTERS
print '</td>';
} // for td
print '</tr>';
} // for tr

?></table></td></tr></table></form><?php
//MAP PRINTING
}
/*_______________-=TheSilenT.CoM=-_________________*/

function map_corners(){
global $min_x_go,$min_y_go,$max_x_go,$max_y_go;
return $corners=array(
($min_x_go-1)."-".($min_y_go-1) => 'c1',
($min_x_go-1)."-".($max_y_go+1) => 'c2',
($max_x_go+1)."-".($min_y_go-1) => 'c3',
($max_x_go+1)."-".($max_y_go+1) => 'c4',
); // can not go
}

/*_______________-=TheSilenT.CoM=-_________________*/

function map_images($map_url){

$files=array();if ($handle = opendir($map_url)) {while (false !== ($file = readdir($handle))) {if (preg_match("/.*?\.jpg$/",$file)) {$files[]=$file;}}closedir($handle);}

$maps=array();if(!empty($files)){sort($files);foreach ($files as $val){$val = preg_replace("/\.jpg$/","",$val);$maps[]=$val;}}
return $maps;
}
/*_______________-=TheSilenT.CoM=-_________________*/

function map_monsters($min_x_go,$max_x_go,$min_y_go,$max_y_go,$min_monster_level,$max_monster_level){
global $tbl_fight,$current_time,$array_strength;

$monster_name=rand($min_monster_level,$max_monster_level);

$monx = rand($min_x_go,$max_x_go);
$mony = rand($min_y_go,$max_y_go);
$monstr=rand(0,8); //$monstr=rand(0,count($array_strength)-1); too strong

$mlife=($monstr*$monstr)+rand(100,((rand(1,$max_x_go)*rand(1,$max_y_go))*100));
$mmana=$monster_name*$monstr*$max_x_go;
$mstamina=$monster_name*$monstr*$max_y_go;

$monste_val = "'', '$monx', '$mony', '$monster_name', '$mlife', '$mmana', '$mstamina','','$monstr','$current_time'";

mysqli_query ($link, "INSERT INTO `$tbl_fight` values ($monste_val)") or die_nice(mysqli_error().'Map Monster generator');
}

/*_______________-=TheSilenT.CoM=-_________________*/

function map_it($x,$y,$corners,$maps,$attribute,$min_x_go,$max_x_go,$min_y_go,$max_y_go) {
	//IMAGE MAPPING make function
if (array_key_exists("$x-$y",$corners)) {//CORNERS
return $corners["$x-$y"];
}elseif (in_array("$x-$y",$maps)) {
return "$x-$y";
}elseif (array_key_exists("$x-$y",$attribute)) {
return $attribute["$x-$y"];
}elseif ($x == $min_x_go-1) {//TOP
return 'ct';
}elseif ($x == $max_x_go+1) {//BOTTOM
return 'cb';
}elseif ($y == $min_y_go-1) {//LEFT
return 'cl';
}elseif ($y == $max_y_go+1) {//RIGHT
return 'cr';
}else{
return 'bg';
}
	//IMAGE MAPPING make function
}

/*_______________-=TheSilenT.CoM=-_________________*/
function move_it($move){
global $row,$to_update,$to_output,$min_x_go,$max_x_go,$min_y_go,$max_y_go;
if (!empty($move)) {
	$xmen=$row->x;
	$ymen=$row->y;
	$walking='';
if ($move=="n") {$row->x--;$walking = 'north';}
if ($move=="e") {$row->y--;$walking = 'east';}
if ($move=="w") {$row->y++;$walking = 'west';}
if ($move=="s") {$row->x++;$walking = 'south';}

if ($move=="ne") {$row->x--;$row->y--;$walking = 'north east';}
if ($move=="se") {$row->x++;$row->y--;$walking = 'south east';}
if ($move=="nw") {$row->x--;$row->y++;$walking = 'north west';}
if ($move=="sw") {$row->x++;$row->y++;$walking = 'south west';}

if ($row->x >= $min_x_go and $row->y >= $min_y_go and $row->x <= $max_x_go and $row->y <= $max_y_go){
	$to_update .= ", `x`='$row->x', `y`='$row->y'";
	$to_output .= 'Traveling to '.$walking.'.<br>';
}else{
	$row->x=$xmen;
	$row->y=$ymen;
	$walking='';
	$to_output .= 'You can not got there.<br>';
}

}
}
/*_______________-=TheSilenT.CoM=-_________________*/

?>