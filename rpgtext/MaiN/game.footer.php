<?php
#!/usr/local/bin/php
if($row->level <= $noob_level){
	if(!empty($to_see)){
$to_output .= '<font color="'.$col_buildings.'">You are seeing '.$to_see.'.</font><br>';
	}
	if(!empty($to_talk)){
$to_output .= '<font color="'.$col_talk.'">Players you can approach '.$to_talk.'.</font><br>';
	}
	if(!empty($to_fight)){
$to_output .= '<font color="'.$col_attack.'">Monsters you can approach '.$to_fight.'.</font><br>';
	}
if (!empty($to_output)) {
	//$to_output = preg_replace("/\<br\>/si","<hr size=1 height=1>",$to_output);
?><table width=100% cellpadding=0 cellspacing=1 border=0><tr><th>Actions</th><tr><td><?php
print $to_output;$to_output='';
?></td></tr></table><?php
}
}
?></td><td valign=top width=425><?php// width=425


//MONSTERS COMING
if($row->life >= 1){
if($mcresult = mysqli_query ($link, "SELECT `id`,`x`,`y` FROM `$tbl_fight` WHERE (`ocharname`='$row->charname') ORDER BY `id` DESC LIMIT $max_monsters")) {
if(mysqli_num_rows($mcresult) >= 1){
$to_output .= 'In the distance you can you clearly that you are being followed!<br>';
while ($mcrow = mysqli_fetch_object ($mcresult)) {
	$monster_update = "`timer`='$current_time'";
	if ($mcrow->x > $row->x) {
		//print 'aaa';
		$monster_update .= ",`x`=$mcrow->x-1";
	}elseif ($mcrow->x < $row->x) {
		//print 'bbb';
		$monster_update .= ",`x`=$mcrow->x+1";
	}elseif ($mcrow->y > $row->y) {
		//print 'ccc';
		$monster_update .= ",`y`=$mcrow->y-1";
	}elseif ($mcrow->y < $row->y) {
		//print 'ddd';
		$monster_update .= ",`y`=$mcrow->y+1";
	}else{
	$monster_update='';
	}
	if(!empty($monster_update)) {
		mysqli_query ($link, "UPDATE `$tbl_fight` SET $monster_update WHERE `id`='$mcrow->id' LIMIT 1") or die_nice(mysqli_error().'monsters following');
		/*if(empty($loseit)){
			$to_update .= ", `honor`=`honor`-0.001";
			$loseit=1;
		}*/
	}
}
mysqli_free_result ($mcresult);
}
}
}
//MONSTERS COMING

//REGENERATE
if($row->life >= 1){
$regen_life=0;$regen_mana=0;$regen_stamina=0;
if ($total_stats[23] >= 1) {$regen_life += rand($row->level,$row->level+$total_stats[23]);}
if ($total_stats[24] >= 1) {$regen_mana += rand($row->level,$row->level+$total_stats[24]);}
if ($total_stats[25] >= 1) {$regen_stamina = rand($row->level,$row->level+$total_stats[25]);}
if ($total_stats[48] >= 1) {$regen_life +=rand($row->level,($row->level+($row->life/100)*(100+$total_stats[48])));}
if ($total_stats[49] >= 1) {$regen_mana +=rand($row->level,($row->level+($row->mana/100)*(100+$total_stats[49])));}
if ($total_stats[50] >= 1) {$regen_stamina +=rand($row->level,($row->level+($row->stamina/100)*(100+$total_stats[50])));}
$to_regen = '';
if($regen_life >= 1 and $row->life < $max_life){
$to_regen .= number_format($regen_life).' life';
$to_update .= ", `life`=`life`+$regen_life";
}
if($regen_mana >= 1 and $row->mana < $max_mana){if(!empty($to_regen)){$to_regen .= ', ';}
$to_regen .= number_format($regen_mana).' mana';
$to_update .= ", `mana`=`mana`+$regen_mana";
}
if($regen_stamina >= 1 and $row->stamina < $max_stamina){if(!empty($to_regen)){$to_regen .= ', ';}
$to_regen .= number_format($regen_stamina).' stamina!';
$to_update .= ", `stamina`=`stamina`+$regen_stamina";
}
if (!empty($to_regen)){
	$to_output .= '<font color="'.$col_steal.'">You regenerated '.$to_regen.'.</font><br>';
}
}
//REGENERATE

if(!empty($_POST['player']) or !empty($_GET['player'])){
if(!empty($_GET['player'])){$player=clean_post($_GET['player']);}
if(!empty($_POST['player'])){$player=clean_post($_POST['player']);}


if (in_array($player,$action_players)){
	$player = preg_replace("/ /si","_",$player);
include_once 'MaiN/player.'.$player.'.php';
}else{
	$to_output .= 'What\'s a <b>'.$player.'</b>?<br>';
	include_once 'MaiN/player.main.php';
}
	//print $player;
}elseif(!empty($_GET['visit']) or !empty($_POST['visit'])){
if(!empty($_GET['visit'])){$visit=clean_post($_GET['visit']);}
if(!empty($_POST['visit'])){$visit=clean_post($_POST['visit']);}
					if(($visit == 'T' or $visit == 'teleport') and ($row->quests >= 14)){
						include_once 'MaiN/visit.teleport.php';
					}else{
if (in_array($visit,$action_visit)){
	$visit = preg_replace("/ /si","_",$visit);

	//print $visit.' '.$x.' '.$y.' '.$row->x.' '.$row->y.'<br>';	print '<pre>';print_r($is_locations);print_r($_GET);print_r($_POST);print '</pre>';
	//print $is_locations[$row->x.'-'.$row->y];
if(array_key_exists($row->x.'-'.$row->y, $is_locations) and $visit == $is_locations[$row->x.'-'.$row->y]) {
	include_once 'MaiN/visit.'.$visit.'.php';

}else{
	$to_output .= 'Huh where is that <b>'.$visit.'</b>?<br>';
	include_once 'MaiN/player.main.php';
}

}else{
	$to_output .= 'What do you mean by <b>'.$visit.'</b>?<br>';
	include_once 'MaiN/player.main.php';
}
					}


}else{
if(!empty($_GET['talk']) or !empty($_POST['talk'])){
if(!empty($_GET['talk'])){$talk=clean_post($_GET['talk']);}
if(!empty($_POST['talk'])){$talk=clean_post($_POST['talk']);}

	include_once 'MaiN/player.talk.php';
}elseif(!empty($_GET['attack']) or !empty($_POST['attack'])){
if(!empty($_GET['attack'])){$attack=clean_post($_GET['attack']);}
if(!empty($_POST['attack'])){$attack=clean_post($_POST['attack']);}

	include_once 'MaiN/player.attack.php';
}elseif(!empty($_GET['kingdom']) or !empty($_POST['kingdom'])){
	include_once 'MaiN/player.kingdom.php';
}else{
	if($monsters_at_location >= 1){//!empty($to_fight)
	include_once 'MaiN/player.attack.php';
	}else{
	include_once 'MaiN/player.main.php';
	}
}
}


//questing
questing();
//questing

if(!empty($link)){

//CHAT CHECK
if($caresult = mysqli_query ($link, "SELECT * FROM `$tbl_board` WHERE `receiver`='$row->charname' and `timer`>=($current_time-500) ORDER BY `id` DESC LIMIT 10")){
if(mysqli_num_rows($caresult) >= 1){
	$to_chat='';$talk_uniques = array();
while($carow = mysqli_fetch_object ($caresult)){
		//print $carow->timer.' > '.($current_time-500).' ---- '.($current_time-$carow->timer).'<br>';
if(!in_array($carow->charname,$talk_uniques)){
	$talk_uniques[] = $carow->charname;
if(!empty($to_chat)){$to_chat .= ', ';}
	$to_chat .= '<a href="?talk='.$carow->charname.'">'.$carow->charname.'</a>';
}
}
mysqli_free_result ($caresult);
}
}

	if(!empty($to_chat)){
	$to_output .= '<br>'.$to_chat.' is talking to you.<br>';
	}
//CHAT CHECK

	//OUT OF MAP
if($row->x < $min_x_go or $row->x > $max_x_go) {
	$to_update .= ", `x`='$max_x_go'";
}
if($row->y < $min_y_go or $row->y > $max_y_go) {
	$to_update .= ", `y`='$max_y_go'";
}
	//OUT OF MAP
if (!empty($to_update)) {

if(($current_time-$row->timer) < 0.3){
	if($row->jail>=$current_time-1){
		if($row->jail-$current_time < 50){
		$to_update .= ", `jail`=`jail`+'10'";
		}
	}else{
		$to_update .= ", `jail`='$current_time'";
	}
	$to_output .= '<hr><b>Be careful you will get jailed if you are flooding the server!</b><hr>';

//print '<hr>Flood protection activated.<hr>';
}else{
	//$to_update .= ", `jail`='0'";
}

mysqli_query ($link, "UPDATE `$tbl_members` SET $to_update WHERE `id`='$row->id' LIMIT 1") or die_nice(mysqli_error().'game footer update'.$to_update);

//if($row->id == 1){print '<hr>'.$to_update.'<hr>';}
//print '<hr color=red>'.$to_update.'<hr color=red>';

}


//DELETES INACTIVES AND OLD
mysqli_query ($link, "DELETE FROM `$tbl_fight` WHERE (`life`<='0' or `timer`<=$current_time-1000) LIMIT 10") or die_nice(mysqli_error().'deleteion inactive monsters');
mysqli_query ($link, "DELETE FROM `$tbl_paper` WHERE (`timer`<=$current_time-32300) LIMIT 10") or die_nice(mysqli_error().'deleteion inactive paper');
//DELETES INACTIVES AND OLD

mysqli_close($link);
}



//foreach ($row as $key=>$val){print $key.':'.$val.'<br>';}

if(empty($player)){$player='';}

if (!empty($to_output) or !empty($to_output2)) {
	$to_output = preg_replace("/\<br\>/si","<hr size=1>",$to_output);
?><table width=100% cellpadding=0 cellspacing=1 border=0><tr><th>Information</th><tr><td><font size=-1><?php
print (!empty($to_output)?$to_output.'<br>':'');

print (next_level($row->level)-$row->exp >= 1? 'Require '.number_format(next_level($row->level)-$row->exp).' exp to level up.<br>':'<b><a href="?player=stats">Congratulations! You have leveled up</a>!</b><br>');$to_output='';

print ((!empty($to_output2) and $player == 'inventory') ? $to_output2:'');

?></font></td></tr></table><?php
}

?></td></tr></table>
<font size=-2>© <?php echo date("Y");?> <a href="http://www.thesilent.com">theSilent.com</a>. <a href="http://thesilent.com/?open=privacy">Privacy</a>. <a href="http://thesilent.com/?open=terms">Terms</a>. <a href="http://thesilent.com/?open=rules">Rules</a>. <a href="http://www.thesilent.com/index.php?open=feedback">Feedback</a>.</font>
</center>
</body></html>