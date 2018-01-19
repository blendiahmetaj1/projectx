<?
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once('AdMiN/www.mysql.php');
require_once('AdMiN/www.functions.php');
require_once 'AdMiN/array.races.php';
include_once("$html_header");

if(!empty($_GET['info']) and empty($info)){$info=clean_post($_GET['info']);}
if(!empty($_POST['info']) and empty($info)){$info=clean_post($_POST['info']);}

$link=mysql_connect($db_host,$db_user,$db_password);
mysql_select_db($db_main);

if($iresult=mysql_query("SELECT * FROM `$tbl_members` WHERE `Charname`='$info' LIMIT 1")){
if($iobj=mysql_fetch_object($iresult)){
mysql_free_result($iresult);

?><table width="100%">
<tr><th colspan="2">Player information and statisticS</th></tr>
<tr><td>
Race<br>
Sex<br>
Charname<hr>
Level<br>
Life<br>
Xp<br>
Gold<br>
<hr>
Strength<br>
Dexterity<br>
Agility<br>
Intelligence<br>
Concentration<br>
Contravention<br>
<hr>
Weapon<br>
Attackspell<br>
Healspell<br>
Helmet<br>
Shield<br>
Amulet<br>
Ring<br>
Armor<br>
Belt<br>
Pants<br>
Hand<br>
Feet<br>
</td><td>
<?

print $iobj->race.'<br>'.$iobj->sex.'<br>'.$iobj->charname.'<hr>'.number_format($iobj->level).'<br>'.number_format($iobj->life).'<br>'.number_format($iobj->exp).'<br>'.number_format($iobj->gold).'<hr>'.number_format($iobj->strength).'<br>'.number_format($iobj->dexterity).'<br>'.number_format($iobj->agility).'<br>'.number_format($iobj->intelligence).'<br>'.number_format($iobj->concentration).'<br>'.number_format($iobj->contravention).'<br><hr>'.number_format($iobj->weapon).'<br>'.number_format($iobj->attackspell).'<br>'.number_format($iobj->healspell).'<br>'.number_format($iobj->helmet).'<br>'.number_format($iobj->shield).'<br>'.number_format($iobj->amulet).'<br>'.number_format($iobj->ring).'<br>'.number_format($iobj->armor).'<br>'.number_format($iobj->belt).'<br>'.number_format($iobj->pants).'<br>'.number_format($iobj->hand).'<br>'.number_format($iobj->feet).'<br>';
?></td><tr><td colspan="2">
<?
if($iobj->strength>$iobj->intelligence ){
?>More muscles than brains and slams into combat.<?
}elseif($iobj->str<$iobj->intel){
?>Very intelelligent and chooses the mystical power in combat.<?
}else{
?>Fights with hand and magic.<?
}
?> <?
if($iobj->dexterity >$iobj->concentration ){
?>Aims very well with a melee weapon.<?
}elseif($iobj->Dexterity<$iobj->Concentration){
?>Spells are not fizzling here.<?
}else{
?>Cool minded aimer.<?
}
?> <?
if($iobj->agility>$iobj->contravention ){
?>Defense is stronger than his magic shield.<?
}elseif($iobj->Agility<$iobj->Contravention){
?>Magic shield is stronger than his defense.<?
}else{
?>Defending agains a weapon or spell should be no problem.<?
}
?> <?
if($iobj->weapon>$iobj->attackspell){
?>Prefers using a weapon in combat.<?
}elseif($iobj->Weapon<$iobj->Attackspell){
?>Prefers using a spell in combat.<?
}else{
?>Uses whatever is at hand.<?
}

?>
</td></tr></table><?

}else{?>Can't find player.<?}}

include_once("$html_footer");
?>