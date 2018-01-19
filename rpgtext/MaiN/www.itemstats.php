<?php
#!/usr/local/bin/php

/*_______________-=TheSilenT.CoM=-_________________*/
function total_stats() {
global $row,$array_attributes,$tbl_inventory,$to_output,$to_output2;

$ts=array();
$sets_equiped = array();
$kind_equiped = array();

foreach ($array_attributes as $val){
	//print $val.'<br>'; //prints whole attributes list with values 0-60
$ts[]=0;
}

if($iresult = mysqli_query ($link, "SELECT * FROM `$tbl_inventory` WHERE (`charname`='$row->charname' and `used`='1' and `rlevel`<='$row->level') ORDER BY `kind` ASC LIMIT 50")){
if(mysqli_num_rows($iresult) >= 1){
while($itrow = mysqli_fetch_object ($iresult)) {
if(!array_key_exists($itrow->kind, $kind_equiped)){$kind_equiped[$itrow->kind] = 1;
			//SETS
if ($itrow->class == 'set') {
		if(array_key_exists($itrow->itemname, $sets_equiped)){
		$sets_equiped[$itrow->itemname] += 1;
		}else{
		$sets_equiped[$itrow->itemname] = 1;
		}
}
			//SETS

if(($itrow->durability >= 1 and $itrow->damaged >= 1) or ($itrow->durability == 0 and $itrow->damaged == 0)){
for ($i=1;$i<=9;$i++){
$a = 'a'.$i;
$itrow->$a >=1 ? $ts[$itrow->$a]+=calstats($itrow->$a, $itrow->multi):'';
			//print $itrow->itemname.' '.$i.' '.$itrow->$a.'<br>';
}
	}else{
$to_output .= '<b>'.$itrow->itemname.' '.$itrow->class.' '.$itrow->kind.'</b> is broken!<br>';
	}
}else{$kind_equiped[$itrow->kind] += 1;

for ($i=1;$i<=9;$i++){
$a = 'a'.$i;
$itrow->$a >=1 ? $ts[$itrow->$a] -=calstats($itrow->$a, $itrow->multi):'';
			//print $i.' '.$itrow->$a.'<br>';
}

}
}
mysqli_free_result ($iresult);
	//multi yield
	//print '<pre>';print_r($kind_equiped);print '</pre>';
	foreach ($kind_equiped as $key=>$val){
		if($val >= 2){
			$to_output2 .= ', '.$val.' '.$key;
		}
	}
	if(!empty($to_output2)){
		$to_output2 = '<b>Multiple yielding'.$to_output2.'.</b><br>';
		$to_output .= 'You are over equipped! Carrying any equipment more then allowed can cause you to lose power.<br>';
	}
	//multi yield
	//SETS
	//print '<pre>';print_r($sets_equiped);print '</pre>';
	if (count($sets_equiped) >= 1){
		$to_output2 .= '<font color="#12ee12"><b>Set Bonus</b><br>';
	foreach ($sets_equiped as $key=>$val) {
		$to_output2 .= '<br>Using <b>'.$val.'</b> items from <b>'.$key.'</b> set.<br>';
		$ts[$val] += $val;
		if($val >= 1){
			$ts[1] += 10000*$val;
			$to_output2 .= '+'.number_format(10000*$val).' life<br>';
			}
		if($val >= 2){
			$ts[2] += 10000*$val;
			$ts[3] += 10000*$val;
			$to_output2 .= '+'.number_format(10000*$val).' mana & stamina<br>';
			}
		if($val >= 3){
			$ts[26] += 5*$val;
			$to_output2 .= '+'.number_format(5*$val).'% life<br>';
			}
		if($val >= 4){
			$ts[26] += 5*$val;
			$ts[27] += 5*$val;
			$to_output2 .= '+'.number_format(5*$val).'% mana & stamina<br>';
			}
		if($val >= 5){
			$ts[14] += 5*$val;
			$ts[15] += 5*$val;
			$to_output2 .= '+'.number_format(5*$val).' magic damage & weapon damage<br>';
			}
		if($val >= 6){
			$ts[39] += 2*$val;
			$ts[40] += 2*$val;
			$to_output2 .= '+'.number_format(2*$val).'% magic damage & weapon damage<br>';
			}
		if($val >= 7){
			$ts[41] += 2*$val;
			$ts[42] += 2*$val;
			$to_output2 .= '+'.number_format(2*$val).'% magic rating & attack rating<br>';
			}
		if($val >= 8){
			$ts[51] += 2*$val;
			$ts[52] += 2*$val;
			$to_output2 .= '+'.number_format(2*$val).'% extra gold and drop chance<br>';
			}
		if($val >= 9){
			$ts[56] += 5;
			$ts[57] += 5;
			$ts[58] += 5;
			$to_output2 .= '+5 to battle, magic and defense skills.<br>';
			}
		if($val >= 10){
			$ts[25] += 25;
			$to_output2 .= '+25% to regenerate stamina.<br>';
			}
		if($val >= 11){
			$ts[24] += 25;
			$to_output2 .= '+25% to regenerate mana.<br>';
			}
		if($val >= 12){
			$ts[23] += 25;
			$to_output2 .= '+25% to regenerate life.<br>';
			}
		if($val >= 13){
			$ts[59] += 25;
			$to_output2 .= '+25 to all skills.<br>';
			}
	}
		$to_output2 .= '</font>';
	}
			//SETS
}
}

$i=0;
foreach ($ts as $val) {
		//echo "$i=$val $array_attributes[$i]<br>";	//prints whole attributes list with values 0-60
if (isset($row->$array_attributes[$i])) {
if ($i <= 25) {	//attributes points

	if($row->$array_attributes[$i] >= 1){$row->$array_attributes[$i]+=$val;}

} else {		//attributes percentages

	if($row->$array_attributes[$i] >= 1){$row->$array_attributes[$i]=($row->$array_attributes[$i]/100)*(100+$val);}

}
}
$i++;
if ($i>=60) {break;}
}

return $ts;
}
/*_______________-=TheSilenT.CoM=-_________________*/
function calstats ($in, $multi) {
//print $in.' '.$multi.'<br>';

if ($in < 26) {
	$multi += substr(($in*$multi*$multi*$multi), 0, 3);
	//print 'aaa';
} elseif ($in >= 26 and $in < 56) {
	$multi += substr(($multi*$multi*$multi), 0, 2);
	//print 'aaa';
} else {
	$multi += substr(($multi*$multi), 0, 1);
	//print 'bbb';
}

//print $multi.'<br>';

return $multi;
}
/*_______________-=TheSilenT.CoM=-_________________*/
function inv_prop($iid) {
global $row,$array_attributes,$tbl_inventory;

if($iresult = mysqli_query ($link, "SELECT * FROM `$tbl_inventory` WHERE `id`='$iid' ORDER BY `id` DESC LIMIT 1")){
if($itrow = mysqli_fetch_object ($iresult)){
mysqli_free_result ($iresult);
if ($itrow->class == 'magic') {
$color='#cccfff';
} elseif ($itrow->class == 'set') {
$color='#12ee12';
} elseif ($itrow->class == 'rare') {
$color='#fff123';
} elseif ($itrow->class == 'unique') {
$color='#fffccc';
} elseif ($itrow->class == 'demon') {
$color='#ee1212';
} elseif ($itrow->class == 'normal') {
$color='#ffffff';
} elseif ($itrow->class == 'blind') {
$color='#cccccc';
} elseif ($itrow->class == 'damaged') {
$color='#aaaaaa';
} elseif ($itrow->class == 'rainbow') {
$color='#'.rand(10,99).rand(10,99).rand(10,99);
} else {
$color='#cccccc';
}

echo '<b><font color="'.$color.'">'.ucfirst($itrow->itemname).'</b><br>'.ucfirst($itrow->class).' '.$itrow->kind.'<br>';

if ($itrow->min >= 1 and $itrow->max >= 1) {
if ($itrow->kind == 'weapon' or $itrow->kind == 'attackspell') {
print 'Damage';
} elseif ($itrow->kind == 'healspell') {
print 'Heals';
} else {
print 'Defense';
}
print ' '.$itrow->min.' min - '.$itrow->max.' max<br>';
}

//print '<b>Requirements'.$itrow->rlevel.' '.$itrow->rstrength.' '.$itrow->rintelligence.'<br>Durability '.$itrow->damaged.' '.$itrow->durability.'</b><br>';

print ($itrow->rlevel) ? ($row->level < $itrow->rlevel) ? '<u>Required level '.number_format($itrow->rlevel).'</u><br>':'Required level '.number_format($itrow->rlevel).'<br>':'';
	//print "$row->strength < $itrow->rstrength";
print ($itrow->rstrength) ? ($row->strength < $itrow->rstrength) ? '<u>Required strength '.number_format($itrow->rstrength).'</u><br>':'Required strength '.number_format($itrow->rstrength).'<br>':'';
print ($itrow->rintelligence) ? ($row->intelligence < $itrow->rintelligence) ? '<u>Required intelligence '.number_format($itrow->rintelligence).'</u><br>':'Required intelligence '.number_format($itrow->rintelligence).'<br>':'';

print ($itrow->durability) ? ($itrow->damaged <= 5) ? '<u>Durability '.number_format($itrow->damaged).' of '.number_format($itrow->durability).'</u><br>':'Durability '.number_format($itrow->damaged).' of '.number_format($itrow->durability).'<br>':'';


for ($i=1;$i<=9;$i++){
$a = 'a'.$i;
	//print $a.' '.$itrow->$a.'<br>';
print ($itrow->$a >=1) ? ($itrow->$a > 26 and $itrow->$a < 56) ? '+'.calstats($itrow->$a, $itrow->multi).'% '.$array_attributes[$itrow->$a].'<br>':'+'.calstats($itrow->$a, $itrow->multi).' '.$array_attributes[$itrow->$a].'<br>':'';
}

print '</font>';
}
}

}

/*_______________-=TheSilenT.CoM=-_________________*/
?>