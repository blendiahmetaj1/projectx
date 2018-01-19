<?
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once 'AdMiN/array.monsters.php';
include_once("$clean_header");
if(empty($_GET['sid'])){exit;}else{$sid=$_GET['sid'];}

foreach($gamefiles as $file){
if($file == 'br'){echo "<br>";}else{
if($file == "logout"){$target="_top";}else{$target="lol_main";}
print "<a href=\"$root_url/$file.php?sid=$sid\" target=\"$target\">".ucfirst($file)."</a> ";
}
}

if(empty($_POST['difficulty'])){
if(empty($lol['difficulty'])){$difficulty=1;}else{if($lol['difficulty'] <= 0){$difficulty=1;}else{$difficulty=$lol['difficulty'];}}
}else{
if(!empty($_POST['plus'])){if($difficulty > 100){$difficulty+=$difficulty/100;}else{$difficulty++;}}
if(!empty($_POST['min'])){if($difficulty > 100){$difficulty-=$difficulty/100;}else{$difficulty--;}}
if($difficulty <= 0){$difficulty=1;}
$difficulty=round($difficulty);
}
?>
<form action="fight.php" method=post target="lol_main"><input type=hidden name=sid value="<?echo $sid?>">
<table cellpadding=2 cellspacing="0" border=0 width=100%>
<tr><td valign=top colspan=2>
<select name="monster">
<?
$i=1;
if($difficulty>=201){
$monsterdifficulty=190;
}else{
$monsterdifficulty=$difficulty;
}
foreach($monsters_array as $value){
if($i <= $monsterdifficulty+9){
echo "<option>$i - $value - ".number_format((96+((1+$i)*(1+$i))*$i)*($difficulty))."</option>";
}else{break;}
$i++;
}
?>
</select></td></tr>
<tr><td width="10%" valign=top colspan=2><input type=submit name=action value="Fight this monster!"></td>
<input type=hidden name="difficulty" value="<? print $difficulty; ?>"></form>

<form method=post><input type=hidden name=sid value="<?echo $sid?>"></tr>
<tr><td width=50% valign=top><input type=text name="difficulty" value="<? print $difficulty; ?>"></td><td width="10%" valign=top><input type=submit name=action value="monster level"></td></tr>
<tr><td width=50% valign=top><input type=submit name="plus" value="+"></td><td width=50% valign=top><input type=submit name="min" value="-"></td></form></tr></table>

<table width=100%><tr><td width=12> </td><td>
<a href="http://www.lordsoflords.com/?otrpg" target="lol_main">Lords of Lords</a><br>
Play more RPG games like this but with more features, charms, potion, duels, chats, bigger monster, worlds and allot more at Lords of Lords.
<br>
<br>
<a href="http://www.play-flash-games.org/?otrpg" target="lol_main">Play Flash Games</a><br>
Play and search for flash games now, make a favorite list or upload your own Flash Games.
<br>
<br>
</td></tr></table>

<?
include_once("$clean_footer");
?>