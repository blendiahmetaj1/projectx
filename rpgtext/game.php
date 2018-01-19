<?php
#!/usr/local/bin/php
require_once 'MaiN/www.main.php';
require_once 'MaiN/www.mysql.php';
require_once 'MaiN/www.functions.php';
require_once 'MaiN/www.mapping.php';

require_once 'MaiN/array.attributes.php';
require_once 'MaiN/array.classes.php';
require_once 'MaiN/array.monsters.php';
require_once 'MaiN/array.sets.php';
require_once 'MaiN/array.uniques.php';

require_once 'MaiN/www.battlestats.php';
require_once 'MaiN/www.fight.php';
require_once 'MaiN/www.itemdrop.php';
require_once 'MaiN/www.itemstats.php';
require_once 'MaiN/www.quests.php';

require_once 'MaiN/array.locations.php';

include_once 'MaiN/game.header.php';

require_once 'MaiN/www.xy.php';

if(!empty($_POST['potion'])){$potion=clean_post($_POST['potion']);}else{$potion='';}
//DRINK POTION
if ($potion == 'life' or $potion == 'mana' or $potion == 'stamina') {
	if ($potion == 'life') {
		if($row->plife >= 1){
		$to_output .= 'Drinks a life potion, feeling totally healthy again!<br>';
		$to_update .= ", `plife`=`plife`-'1', `life`='$max_life'";
		$row->life=$max_life;
		}else{$to_output .= 'Lurking on a empty bottle and nothing happens!<br>';}
	}elseif ($potion == 'mana') {
		if($row->pmana >= 1){
		$to_output .= 'Drinks a mana potion, feeling the mystical power regenerating!<br>';
		$to_update .= ", `pmana`=`pmana`-'1', `mana`='$max_mana'";
		$row->mana=$max_mana;
		}else{$to_output .= 'Lurking on a empty bottle and nothing happens!<br>';}
	}elseif ($potion == 'stamina') {
		if($row->pstamina >= 1){
		$to_output .= 'Drinks a stamina potion, you aren\'t tired anymore!<br>';
		$to_update .= ", `pstamina`=`pstamina`-'1', `stamina`='$max_stamina'";
		$row->stamina=$max_stamina;
		}else{$to_output .= 'Lurking on a empty bottle and nothing happens!<br>';}
	}else{
		$to_output .= 'Drinking nothing so you start lurking on a empty bottle!<br>';
	}
	$to_update .= ", `stamina`=`stamina`-'$use_battle'";
$potion='';
}
//DRINK POTION

if($row->level <= $noob_level){
$to_talk= '';
$to_see= '';
$to_fight='';
}
$fight_on = '';
$monsters_at_location=0;
$attribute = array();

$xmaps = array('game','streets','sewers','cornfield','desert');
$xmaps = array_merge($xmaps, array_values($array_locations));
//$to_update .= ", `quests`='1'";
//print_r($xmaps);

$xmap='game';

if(!empty($row->location)){
$xmap=$row->location;
	if (!in_array($row->location, $xmaps)) {
$xmap='game';
	}
}

if (!empty($_GET['xmap'])) {
$xmap=clean_post($_GET['xmap']);
	if (!in_array($xmap, $xmaps)) {
$xmap='game';
	}
}

include_once 'MaiN/map.'.$xmap.'.php';

if(array_key_exists("$row->x-$row->y",$array_locations)) {
$to_output .= '<a href="?xmap='.$array_locations["$row->x-$row->y"].'">Enter the '.$array_locations["$row->x-$row->y"].'.<br></a>';
}

include_once 'MaiN/game.navstats.php';
include_once 'MaiN/game.footer.php';
?>
