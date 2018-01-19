<?php
#!/usr/local/bin/php

if(!empty($_GET['map'])){
	$map=round(clean_post($_GET['map']));
	if($map >= 2 and $map <= 6){
		$to_update .= ", `onoff`='$map'";
		$row->onoff = $map;
	}
}
//BIG MAP

//DETERMINE PLAYER POSITION
$min_x=0;$min_y=0;$max_x=5;$max_y=5;

$min_x+=$row->x-2;
$max_x+=$row->x-2;

$min_y+=$row->y-2;
$max_y+=$row->y-2;

?><table cellpadding=0 cellspacing=0 border=0 width=120 height=120><?php
for ($x=$min_x; $x<=$max_x; $x++) {
print '<tr>';
for ($y=$min_y; $y<=$max_y; $y++) {

if(empty($_COOKIE['switch'])){$bgcolor = '#202020';}else{
	//DETERMINE BGCOLOR
if($x == $max_x_go or $y == $max_y_go){
	$bgcolor = '#000000';
}else{
	$colly = $x+$y.$x.$y-$x;
	if($x >= 10 and $y >= 10) {
		$colly = $x*$y.$x.$y;
	}elseif($x >= 20 and $y >= 20) {
		$colly = $x-$y.$x+$y.$x/$y;
	}
	if(strlen($colly) < 6){
		for($i=strlen($colly);$i<6;$i++) {
			$colly .= '8';
		}
	}elseif(strlen($colly) > 6){
		$colly = substr($colly,0,6);
	}
$bgcolor='#'.$colly;
	//print $colly.'<br>';
}
	//DETERMINE BGCOLOR
}
if($row->onoff == 6 or $row->onoff == 2){
		//GET MONSTERS
if($mresult = mysqli_query ($link, "SELECT `id` charname FROM `$tbl_fight` WHERE `x`='$x' and `y`='$y' ORDER BY `id` DESC LIMIT 1")){
if (mysqli_num_rows($mresult) >= 1) {
mysqli_free_result ($mresult);
$bgcolor = '#880000';
}
}
		//GET MONSTERS
}
if($row->onoff == 4 or $row->onoff == 2){
		//PLAYERS VISIBLE
if($presult = mysqli_query ($link, "SELECT `id`,`timer` FROM `$tbl_members` WHERE `x`='$x' and `y`='$y' and `id`!='$row->id'  and `timer`>=($current_time-$online_show) and `location`='streets' ORDER BY `id` DESC LIMIT 1")){
if (mysqli_num_rows($presult) >= 1) {
if($oprow = mysqli_fetch_object ($presult)){
mysqli_free_result ($presult);
if($oprow->timer >= $current_time-1000){
$bgcolor = $col_talk;
}else{
$bgcolor = '#0000FF';
}
}
}
}
		//PLAYERS VISIBLE
}

if($row->x == $x and $row->y == $y){$bgcolor='#FFFFFF';}
print '<td width=10 height=10 bgcolor="'.$bgcolor.'"></td>';
}
print '</tr>';
}
?></table>

<table width=100% cellpadding=0 cellspacing=1 border=0><tr><td valign=center align=center>
<div style="font-size: 0px; line-height: 0%; width: 0px;border: 3px solid #FFFFFF;"> </div></td><td><font size=-2><a href="?map=2">You</a>
</font>
</td>
<td valign=center align=center>
<div style="font-size: 0px; line-height: 0%; width: 0px;border: 3px solid #880000;"> </div></td><td><font size=-2><a href="?map=6">Monsters</a>
</font>
</td></tr>
<tr><td valign=center align=center>
<div style="font-size: 0px; line-height: 0%; width: 0px;border: 3px solid #0000FF;"> </div></td><td><font size=-2><a href="?map=4">Players</a>
</font>
</td>
<td valign=center align=center>
<div style="font-size: 0px; line-height: 0%; width: 0px;border: 3px solid <?php print $col_talk;?>;"> </div></td><td><font size=-2><a href="?map=4">Online</a>
</font>
</td></tr>
</table><?php
//BIG MAP
?>