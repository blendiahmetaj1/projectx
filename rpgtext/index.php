<?php
#!/usr/local/bin/php
require_once 'MaiN/www.main.php';
require_once 'MaiN/site.header.php';

?>
<table><tr><th colspan=2>A Game with multiple play style.</th></tr>
<tr><th><a href="http://thesilent.com/rpgtext" alt="rpg text" title="rpg text">RPGTEXT</a></th><th><a href="http://thesilent.com/mmorpg" alt="mmo rpg text" title="mmo rpg text">MMORPGTEXT</a></th></tr>
<tr><td><img src="b.jpg" alt="rpg text" title="rpg text" border=0></td><td><img src="a.jpg" alt="mmo rpg text" title="mmo rpg text" border=0></td></tr>
<tr><td align=center valign=top>No frames<br>No chat<br>No messages<br>More images</td><td align=center valign=top>With frames<br>With chat<br>With messages<br>Less images<br>Auto attack monsters with FP!</td></tr>
<tr><th><a href="?features">Show more game features</a></th><th><a href="?active">Show active players</a></th></tr>
</table>
<?php

if (isset($_GET['features'])) {
?>
<table><tr><th><b>RPG TEXT <sup>v1.08</sup><br>Game Features</b></th></tr><tr><td valign=top>
<b>Free Online Browser Text Based RPG World GAME!</b><br>
<br>
No waiting for a turn just play on.<br>
No limits, play forever, no ending!<br>
The map automatic grows when more players join<br>
Unlimited Establish and control Kingdoms.<br>
Siege and plunder Kingdoms.<br>
Navigation mini map!<br>
Monsters will chase you down!<br>
Monster have scars!<br>
Unlimited items including normal, magic,<br>
rare, demon, sets, unique<br>
Wearing more set item more bonus!<br>
All that and more, no downloads,<br>
browser and text based.<br>
Play wherever and whenever!<br>
Come and try this NEW beta game,<br>
Free for everybody come and try this Text Based RPG game!<br>
<br>
Game launch date 03-19-07 05:18<br>
More games at <a href="http://www.thesilent.com">thesilent.com</a><br>
</td></tr>
</table>
<?php
}

if (isset($_GET['active'])) {
require_once 'MaiN/www.mysql.php';
$link = mysqli_connect($db_host, $db_user, $db_password) or die_nice(mysqli_error());
mysqli_select_db($db_main, $link) or die_nice(mysqli_error());

if($presults = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE `timer`>=($current_time-84600) ORDER BY `level` DESC LIMIT 100")) {
?><table>
<tr><th colspan=3>Top Active Players</th></tr>
<tr><td>Charname</td><td>Level</td><td>Exp</td></tr><?php
while ($prow = mysqli_fetch_object ($presults)) {
print '<tr><td>'.$prow->sex.' '.$prow->charname.'</td><td><font size=-2>'.number_format($prow->level).'</font></td><td><font size=-2>'.number_format($prow->exp).'</font></td></tr>';
}
mysqli_free_result ($presults);
?></table></td></tr></table><?php
}
mysqli_close($link);
}


require_once 'MaiN/site.footer.php';
?>