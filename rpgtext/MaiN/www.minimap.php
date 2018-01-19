<?php
#!/usr/local/bin/php
function minimap($onlocation,$onkingdom){

global $row, $_GET,$tbl_fight,$tbl_members,$col_kingdom,$col_buildings,$col_talk,$to_update,$current_time,$online_show,$min_x_go,$max_x_go,$min_y_go,$max_y_go,$colth;
//MINIMAP
//BIG MAP

if(!empty($_GET['map'])){
	$map=round(clean_post($_GET['map']));
	if($map >= 2 and $map <= 6){
		$to_update .= ", `onoff`='$map'";
		$row->onoff = $map;
	}
}

//DETERMINE PLAYER POSITION
$min_x=0;$min_y=0;$max_x=10;$max_y=10;

$min_x+=$row->x-5;
$max_x+=$row->x-5;

$min_y+=$row->y-5;
$max_y+=$row->y-5;

$is_monster=map_monster(6);
$is_players=map_players(6);
$is_kingdom = map_kingdoms(6);

?><table cellpadding=0 cellspacing=0 border=0 width=120 height=120><?php
for ($x=$min_x; $x<=$max_x; $x++) {
print '<tr>';
for ($y=$min_y; $y<=$max_y; $y++) {$building_type = ' ';
	//print $x.' '.$y;
$bgcolor = '#202020';

if($row->onoff == 6 or $row->onoff == 2){
		//GET MONSTERS
if(!empty($is_monster["$x-$y"])){
	$bgcolor = '#880000';
}
		//GET MONSTERS
}
if($row->onoff == 4 or $row->onoff == 2){
		//PLAYERS VISIBLE
if(!empty($is_players["$x-$y"])){
	$bgcolor = $col_talk;
}
		//PLAYERS VISIBLE

}

if($onkingdom){
	global $is_kingdom;
if($row->onoff == 5 or $row->onoff == 2){
		//KINGDOMS
if(!empty($is_kingdom["$x-$y"])){
	$bgcolor = $col_kingdom;
}
		//KINGDOMS
}
}

if($onlocation){
	global $is_locations;
if($row->onoff == 3 or $row->onoff == 2){
		//GET BUILDINGS
if(!empty($is_locations["$x-$y"])){
	$bgcolor = $col_buildings;
	$building_type='<font size=-2 title='.$is_locations["$x-$y"].'>'.ucfirst(substr($is_locations["$x-$y"],0,1)).'</font>';
}
		//GET BUILDINGS
}
}

if($row->x == $x and $row->y == $y){$bgcolor='#FFFFFF';}

if($x == $min_x_go-1 or $x == $max_x_go+1 or $y == $min_y_go-1 or $y == $max_y_go+1) {
$bgcolor= $colth;
}
print '<td width=10 height=10 bgcolor="'.$bgcolor.'">'.$building_type.'</td>';
}
print '</tr>';
}
?></table>

<table width=100% cellpadding=0 cellspacing=1 border=0><tr><td valign=center align=center>
<div style="font-size: 0px; line-height: 0%; width: 0px;border: 3px solid #FFFFFF;"> </div></td><td><font size=-2><a href="?player=main&map=2">You</a>
</font>
</td>
<td valign=center align=center>
<div style="font-size: 0px; line-height: 0%; width: 0px;border: 3px solid #880000;"> </div></td><td><font size=-2><a href="?player=main&map=6">Monsters</a>
</font>
</td></tr>
<tr><td valign=center align=center>
<div style="font-size: 0px; line-height: 0%; width: 0px;border: 3px solid <?php print $col_talk;?>;"> </div></td><td><font size=-2><a href="?player=main&map=4">Players</a>
</font>
</td>
<td valign=center align=center>
<div style="font-size: 0px; line-height: 0%; width: 0px;border: 3px solid <?php print $col_buildings;?>;"> </div></td><td><font size=-2><a href="?player=main&map=3">Buildings</a>
</font>
</td></tr>
<tr><td valign=center align=center>
	</td>
	<td><font size=-2> </font>
</td>
<td valign=center align=center>
<div style="font-size: 0px; line-height: 0%; width: 0px;border: 3px solid <?php print $col_kingdom;?>;"> </div></td><td><font size=-2><a href="?player=main&map=5">Kingdoms</a>
</font>
</td></tr></table><?php
//BIG MAP
//MINIMAP
}
?>