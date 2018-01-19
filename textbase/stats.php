<?
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once 'AdMiN/array.races.php';
require_once 'AdMiN/www.battle.php';
require_once('AdMiN/www.functions.php');
include_once("$game_header");

if($row->loginfail){
?>
<center><b><font color=red>WARNING: <?echo $row->loginfail;?> login attempts failures detected!<br>We suggest to change your password when more than 5 attemps are made.</font><p>Information cleared.</b></center>
<?
mysql_query("update $tbl_members SET loginfail=0 where id=$row->id limit 1") or die("update failed 2");
}

$stats_array = array('strength', 'dexterity', 'agility', 'intelligence', 'concentration', 'contravention');
$next_level = next_level();

 //level up
if(!empty($_POST['stats'])){
$stats=$_POST['stats'];
if($row->exp >= $next_level and in_array($stats,$stats_array)){
mysql_query("update $tbl_members SET $stats=$stats+5,level=$row->level+1,life=($row->level+1)*100 where sid='$sid' limit 1") or die('20');
$row->level+=1;$row->$stats+=5;$row->life=$row->level*100;
$next_level = next_level();
}
}
 //level up

if(!in_array($row->race,array_keys($races_array))){$row->race='Human';}
$tot_stats= $row->strength+$row->dexterity+$row->agility+$row->intelligence+$row->concentration+$row->contravention;
$base_attack=($row->strength/$tot_stats)*$races_array["$row->race"][1];
$load=($row->armor+$row->helmet+$row->shield+$row->belt+$row->pants+$row->hand+$row->feet);
$base_defend=($row->agility/$tot_stats)*$races_array["$row->race"][2]+($load);
$base_magic=($row->intelligence/$tot_stats)*$races_array["$row->race"][3];

$ds[0] = $row->strength*(1+$base_attack+$row->hand+$row->weapon);
$ds[1] = $ds[0]*2.555555;
$ds[2] = $row->intelligence*(1+$row->ring+$base_magic+$row->attackspell);
$ds[3] = $ds[2]*2.555555;
$ds[4] = $row->intelligence*(1+$row->amulet+$base_magic+$row->healspell);
$ds[5] = $ds[4]*2.555555;
$ds[6] = $row->contravention*(1+$row->ring+$row->amulet+$base_magic);
$ds[7] = $ds[6]*2.555555;
$ds[8] = $row->agility*(1+$row->shield+$base_defend);
$ds[9] = $ds[8]*2.555555;
$ds[10] = $row->dexterity*(1+$base_attack+$row->feet+$row->level+$races_array["$row->race"][2]);
$ds[11] = $row->concentration*(1+$base_magic+$row->belt+$row->level+$races_array["$row->race"][3]);
$ds[12] = $ds[10]/2.5;
$ds[13] = $ds[11]/2.5;

$num=0;
foreach($ds as $val){
$ds[$num] = number_format($ds[$num]);
$num++;
}

?>
<table cellpadding=2 cellspacing=2 border=0 width=100%><tr>
<th colspan=2>Stats</th></tr>
<tr><td valign="top" align=left>Life<br>Strength<br>Dexterity<br>Agility<br>Intelligence<br>Concentration<br>Contravention</td>
<td align=right valign="top"><?echo number_format($row->life)."<br>".number_format($row->strength)."<br>".number_format($row->dexterity)."<br>".number_format($row->agility)."<br>".number_format($row->intelligence)."<br>".number_format($row->concentration)."<br>".number_format($row->contravention);?></td>
</tr></table>

<table cellpadding=2 cellspacing=2 border=0 width=100%><tr>
<th colspan=3>Natural Battlefields stats for <? echo "$row->guild $row->sex $row->charname"; ?></th></tr>
<tr>
<td valign="top"><? echo $row->race; ?> stats<br>weapon damage<br>Attack spell<br>Heal spell<br>Magic shield<br>Defence<br>Attack rating<br>Magic rating</td>
<td align=right valign="top"> Min<br><? echo "$ds[0]<br>$ds[2]<br>$ds[4]<br>$ds[6]<br>$ds[8]<br>$ds[12]<br>$ds[13]</td>
<td align=right valign=top> Max<br>$ds[1]<br>$ds[3]<br>$ds[5]<br>$ds[7]<br>$ds[9]<br>$ds[10]<br>$ds[11]</td>
</tr></table>
";

if($row->exp > $next_level){
echo "<b>Congratulations you have leveled up for reaching ".number_format($next_level)." exp</b>";
include_once('stats.inc.php');
}else{
?>
Next level <? echo number_format($next_level); ?> exp.<br>You need <? echo number_format($next_level-$row->exp); ?> exp for the next level.
<?
}
include_once("$game_footer");
?>