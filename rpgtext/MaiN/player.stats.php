<?php
#!/usr/local/bin/php

//STATS
if (!empty($_GET['stat'])) {$stat=clean_post($_GET['stat']);} else {$stat=1;}

//levelup
if (!empty($stat) and $row->exp > $next_level and in_array($stat,$stats)) {

$to_update .= ", `level`=`level`+1, `life`='$max_life', `mana`='$max_mana', `stamina`='$max_stamina', `$stat`=`$stat`+5";
$to_output .= 'You have improved your <b>'.$stat.'</b> stats!<br>';
$row->$stat+=5;
$row->level+=1;
$row->life+=$max_life;
$row->mana+=$max_mana;
$row->stamina+=$max_stamina;

$next_level = next_level($row->level);
}
//levelup

//stats
?>
<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th>Stats</th><th>Now</th><th>Max</th></tr>
<?php
print '<tr><td>Life</td><td>'.number_format($row->life).'</td><td>'.number_format($max_life).'</td></tr>';
print '<tr><td>Mana</td><td>'.number_format($row->mana).'</td><td>'.number_format($max_mana).'</td></tr>';
print '<tr><td>Stamina</td><td>'.number_format($row->stamina).'</td><td>'.number_format($max_stamina).'</td></tr>';

?></table><table width=100% cellpadding=0 cellspacing=1 border=0><?php
$i=0;
foreach ($stats as $val) {
if($i >= 3){
	$row->$val = ($row->$val/100)*(100+$total_charmed[$i]);
	if($row->exp > $next_level and $val == 'strength'){
		?><tr><th colspan=3>Congratulations! Level Up!</th></tr><?php
	}elseif(empty($settt)){$settt=1;?><tr><th colspan=3></th></tr><?php}
print '<tr><td>';

	if ($row->exp > $next_level and $val !== 'life' and $val !== 'mana' and $val !== 'stamina') {
	print '<a href="?player=stats&stat='.$val.'"><img src="'.$path_game.'/buttons/plus.gif" border=0 title="Increase '.$val.'"></a>';
	}
print ucfirst($val).'</td><td>'.number_format($row->$val).'</td></tr>';
}

$i++;
}
?>
</table>
<?php
//stats

//battlestats
?>
<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th>Battle stats</th><th>min</th><th>max</th></tr>
<?php
$bonus_type = array('Weapon damage', 'Attack rating', 'Defense', 'Magic damage', 'Magic rating', 'Magic shield', 'Healing');

$battle_stats=battle_stats();
$nim=0;$nom=1;
foreach ($bonus_type as $val) {
echo "<tr><td>$val</td><td>".number_format($battle_stats[$nim])."</td><td>".number_format($battle_stats[$nom])."</td></tr>";
$nim+=2;$nom+=2;
}
?><tr><td>Total Power</td><td colspan=2><?php print number_format(array_sum($battle_stats)/14);?></td></table><?php
//battlestats

//STATS


//SKILLS
if ($row->level >= 5){
$have_skills = ($row->battleskill+$row->magicskill+$row->defenseskill)-($total_stats[56]+$total_stats[57]+$total_stats[58]+$total_stats[59]);

if (!empty($_GET['learn'])) {
	$learn=clean_post($_GET['learn']);
	if($have_skills < $max_skills) {
		if($learn == 'battle'){
			$to_output .= 'You have improved your battle skill!<br>';
			$to_update .= ", `battleskill`=`battleskill`+1";
			$have_skills += 1;$row->battleskill += 1;
		}elseif($learn == 'magic'){
			$to_output .= 'You have improved your magic skill!<br>';
			$to_update .= ", `magicskill`=`magicskill`+1";
			$have_skills += 1;$row->magicskill += 1;
		}elseif($learn == 'defense'){
			$to_output .= 'You have improved your defense skill!<br>';
			$to_update .= ", `defenseskill`=`defenseskill`+1";
			$have_skills += 1;$row->defenseskill += 1;
		}else{
			$to_output .= 'Whatever?';
		}
	}
}


?><table width=100% cellpadding=0 cellspacing=1 border=0><tr><th>Skills<sup title="Skills used of the total"><?php print $have_skills < $max_skills?number_format($have_skills).'/'.number_format($max_skills):number_format($max_skills);?></sup></th><th>Natural</th><th>Powered</th></tr><tr><td><?php

print ($have_skills < $max_skills)?'<a href="?player=stats&learn=battle"><img src="'.$path_game.'/buttons/plus.gif" border=0 title="Improve This Skill"></a>':'';
?>Battle Skill<br><?php
print ($have_skills < $max_skills)?'<a href="?player=stats&learn=magic"><img src="'.$path_game.'/buttons/plus.gif" border=0 title="Improve This Skill"></a>':'';
?>Magic Skill<br><?php
print ($have_skills < $max_skills)?'<a href="?player=stats&learn=defense"><img src="'.$path_game.'/buttons/plus.gif" border=0 title="Improve This Skill"></a>':'';
?>Defense Skill</td><td><?php print number_format($row->battleskill-$total_stats[56]-$total_stats[59]).'<br>'.number_format($row->magicskill-$total_stats[57]-$total_stats[59]).'<br>'.number_format($row->defenseskill-$total_stats[58]-$total_stats[59]);?></td><td><?php print number_format($row->battleskill).'<br>'.number_format($row->magicskill).'<br>'.number_format($row->defenseskill);?></td></tr></table><?php
}
//SKILLS

//BONUSSES
if(array_sum($total_stats) >= 1 or array_sum($total_charmed) >= 1){
?><table width=100% cellpadding=0 cellspacing=1 border=0><tr><?php
print (array_sum($total_stats) >= 1)?'<th>Inventory bonus</th>':'';
print (array_sum($total_charmed) >= 1)?'<th>Charms bonus</th>':'';
?></tr><tr><?php
if (array_sum($total_stats) >= 1) {?><td valign=top><font size=-1><?php
$i=0;
foreach ($array_attributes as $key=>$val) {
if($total_stats[$i] >= 1){
	print '+'.number_format($total_stats[$i]).(($i > 25 and $i <= 55)?'%':'').' '.ucfirst($val).'<br>';
}
$i++;
}
?></font></td><?php
}if(array_sum($total_charmed) >= 1){?><td valign=top><font size=-1><?php
$i=0;
foreach ($stats as $val){
if($total_charmed[$i] >= 1){
print '+'.$total_charmed[$i].'% '.$val.'<br>';
}
$i++;
}
?></font></td>
<?php}?></tr></table><?php
}
//BONUSSES

$to_output .= 'Next level is at <b>'.number_format($next_level).'</b> exp.<br>';

//NOOB HELP
if($row->level <= $noob_level){
?><table width=100% cellpadding=0 cellspacing=1 border=0><tr><th></th></tr><tr><td><img src="<?php print $path_game;?>/buttons/plus.gif" border=0>=Improve Stats or Skills<br></td></tr></table><?php
$to_output .= 'Foreach level you may choose to learn stats, strength for more weapon damage, dexterity for more attack rating, agility for more defense, intelligence for more magic damage, concentration for more more magic rating and contravention for more magic shield.<br>
Skills are gained by leveling up, battle skill for more weapon damage and more attack rating, magic skill for more magic damage and more magic rating and defense skill for more defense and more magic shield. With skill attack you hit your opponent multiple times.<br>
Natural stand for without and powered stand for with all the bonuses from the inventory and bonuses from the charms.<br>';
}
//NOOB HELP
?>