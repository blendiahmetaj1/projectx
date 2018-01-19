<?
#!/usr/local/bin/php
function next_level(){
global $row;
$next_level =((($row->level/10)*500)+$row->level)*($row->level*$row->level)+449;
return $next_level;
}

function battlestats($row){
global $races_array;
if(!in_array($row->race,array_keys($races_array))){$row->race='human';}

$tot_stats= $row->strength+$row->dexterity+$row->agility+$row->intelligence+$row->concentration+$row->contravention; if($tot_stats <= 0){$tot_stats=100;}
$base_attack=($row->strength/$tot_stats)*$races_array["$row->race"][1];
$load=($row->armor+$row->helmet+$row->shield+$row->belt+$row->pants+$row->hand+$row->feet);
$base_defend=($row->agility/$tot_stats)*$races_array["$row->race"][2]+($load);
$base_magic=($row->intelligence/$tot_stats)*$races_array["$row->race"][3];
$os[0] = $row->strength*(1+$base_attack+$row->hand+$row->weapon);
$os[1] = $os[0]*2.555555;
$os[2] = $row->intelligence*(1+$row->ring+$base_magic+$row->attackspell);
$os[3] = $os[2]*2.555555;
$os[4] = $row->intelligence*(1+$row->amulet+$base_magic+$row->healspell);
$os[5] = $os[4]*2.555555;
$os[6] = $row->contravention*(1+$row->ring+$row->amulet+$base_magic);
$os[7] = $os[6]*2.555555;
$os[8] = $row->agility*(1+$row->shield+$base_defend);
$os[9] = $os[8]*2.555555;
$os[10] = $row->dexterity*(1+$base_attack+$row->feet+$row->level+$races_array["$row->race"][2]);
$os[11] = $row->concentration*(1+$base_magic+$row->belt+$row->level+$races_array["$row->race"][3]);
$os[12] = $row->life;
$os[13] = $row->exp;
$os[14] = $row->gold;
$os[15] = $row->charname;
$os[16] = $row->life;
$os[17] = "";
$os[18] = "";
$os[19] = "";
$os[20] =(1+($row->agility/$tot_stats))*$races_array["$row->race"][4];
$os[21] = $os[10]/2.5;
$os[22] = $os[11]/2.5;
$os[23] = $row->level;
$opp =$os;
$i=0;
foreach($os as $val){
if (is_numeric($os[$i])) {
$os[$i] = number_format($os[$i]);
}
$i++;
}

echo<<<EOT
<td valign="top" width=20%> <br>Weapon damage<br>Attack spell<br>Heal spell<br>Magic Shield<br>Defence<br>Attack Rating<br>Magic Rating </td>
<td valign="top" align=right width=20%> Min<br>$os[0]<br>$os[2]<br>$os[4]<br>$os[6]<br>$os[8] <br>$os[21]<br>$os[22]</td>
<td valign="top" align=right width=20%> Max<br>$os[1]<br>$os[3]<br>$os[5]<br>$os[7]<br>$os[9] <br>$os[10]<br>$os[11]</td>
EOT;

return $opp;
}
//battlestats

$divs = array(1.5, 1.6, 1.7, 1.8, 1.9,2.0, 2.1, 2.2, 2.3, 2.4,2.5, 2.6, 2.7, 2.8, 2.9,3.0, 3.1, 3.2, 3.3, 3.4,3.5);

//weapon
function weapon($def,$opp,$wll,$divs){
print "<font color=\"#FF0000\">";
$randdiv = array_rand($divs, 2);
$def_ar =($def[10]+$def[21])/$divs[$randdiv[0]];
$opp_ar =($opp[10]+$opp[21])/$divs[$randdiv[1]];

if($def_ar < $def[21]){$def_ar=$def[21];}elseif($def_ar > $def[10]){$def_ar=$def[10];}
if($opp_ar < $opp[21]){$opp_ar=$opp[21];}elseif($opp_ar > $opp[10]){$opp_ar=$opp[10];}

if($def_ar >= $opp_ar){
$def_damage =($def[0]+$def[1])/$divs[$randdiv[0]];
$opp_defense =($opp[8]+$opp[9])/$divs[$randdiv[1]];

 $def_damage-=$opp_defense;
 if($def_damage <= 0){
 print "$wll[1] strike got blocked!";
 }else{
 $opp[12]-=$def_damage;
 $def_damage = number_format($def_damage);
 $opp_defense = number_format($opp_defense);
print "$wll[0] hit $wll[5] for $def_damage! <font size=-1>$wll[3] blocked for $opp_defense.</font>";
 }
}else{
 print "$wll[0] missed! ";
}
print "</font><br>";
return $opp[12];
}
//weapon

//magic
function magic($def,$opp,$wll,$divs){
print "<font color=\"#8888FF\">";
$randdiv = array_rand($divs, 2);
$def_mr =($def[11]+$def[22])/$divs[$randdiv[0]];
$opp_mr =($opp[11]+$opp[22])/$divs[$randdiv[1]];

if($def_mr < $def[22]){$def_mr=$def[22];}elseif($def_mr > $def[11]){$def_mr=$def[11];}
if($opp_mr < $opp[22]){$opp_mr=$opp[22];}elseif($opp_mr > $opp[11]){$opp_mr=$opp[11];}

if($def_mr >= $opp_mr){
$randdiv = array_rand($divs, 2);
$def_spell =($def[2]+$def[3])/$divs[$randdiv[0]];
$m_shield =($opp[6]+$opp[7])/$divs[$randdiv[1]];

 $def_spell-=$m_shield;
 if($def_spell <= 0){
 print "$wll[1] spell got blocked! ";
 }else{
 $opp[12]-=$def_spell;
 $def_spell = number_format($def_spell);
 $m_shield = number_format($m_shield);
print "$wll[0] cast for $def_spell!<font size=-1>$wll[4] magic shield took $m_shield.</font>";
 }
}else{
 print "$wll[1] spell fizzles!";
}
print "</font><br>";
return $opp[12];
}
//magic

//heal
function heal($def,$opp,$wll,$divs){
print "<font color=\"#88FF88\">";
$randdiv = array_rand($divs, 2);
$def_mr =($def[11]+$def[22])/$divs[$randdiv[0]];
$opp_mr =($opp[11]+$opp[22])/$divs[$randdiv[1]];

if($def_mr < $def[22]){$def_mr=$def[22];}elseif($def_mr > $def[11]){$def_mr=$def[11];}
if($opp_mr < $opp[22]){$opp_mr=$opp[22];}elseif($opp_mr > $opp[11]){$opp_mr=$opp[11];}

if($def_mr >= $opp_mr){
$randdiv = array_rand($divs, 2);
$def_heal=($def[4]+$def[5])/$divs[$randdiv[0]];
$contraven=($opp[6]+$opp[7])/$divs[$randdiv[1]];
 $def_heal-=$contraven;
if($def_heal<= 0){
 print "$wll[1] heal spell got contravented! ";
 }else{
 $def[12]+= $def_heal;
 $def_heal = number_format($def_heal);
 $contraven = number_format($contraven);
 if($def[12] <= $def[16]){
print "$wll[0] heal for $def_heal!<font size=-1>$wll[3] contravented for $contraven.</font>";
 }else{
 print "$wll[0] heal totally!"; $def[12] = $def[16];
 }
 }
}else{
 print "$wll[1] heal spell fizzles!";
}
print "</font><br>";
return $opp[12];
}
//heal

?>