<?php
#!/usr/local/bin/php
require_once 'MaiN/www.main.php';
require_once 'MaiN/site.header.php';

require_once 'MaiN/www.mysql.php';

$total_players=25;

$link = mysqli_connect($db_host, $db_user, $db_password) or die_nice(mysqli_error());
mysqli_select_db($db_main, $link) or die_nice(mysqli_error());


if($nresult = mysqli_query ($link, "SELECT `id` FROM `$tbl_members` WHERE `id` ORDER BY `id` DESC LIMIT 1")){
if ($nrow = mysqli_fetch_object ($nresult)){
mysqli_free_result ($nresult);
$total_players = $nrow->id;
}
}
if($total_players > 250) {
$total_players = round($total_players/25);
}else{
$total_players=25;
}

?><table><tr><th>Top <?php print number_format($total_players);?> Players</th><th>Top <?php print number_format($total_players);?> Kingdoms</th><th></th></tr><tr><td valign=top><?php

if($presults = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE `id` ORDER BY `level` DESC LIMIT $total_players")) {
while ($prow = mysqli_fetch_object ($presults)) {
print '<a href="?show='.$prow->charname.'">'.$prow->sex.' '.$prow->charname.'</a><br>';
if (!empty($_GET['show'])){
	if ($_GET['show'] == $prow->charname or $_GET['show'] == 'all'){
print '<font size=-1>';
print '<li>Level '.number_format($prow->level).'</li>';
print '<li>Class '.$prow->class.'</li>';
print '<li>Exp '.number_format($prow->exp).'</li>';
print '<li>Gold '.number_format($prow->gold).'</li>';
print '<li>Bank '.number_format($prow->stash).'</li>';
print '<li>Life '.number_format($prow->life).'</li>';
print '<li>Mana '.number_format($prow->mana).'</li>';
print '<li>Stamina '.number_format($prow->stamina).'</li>';
print '<li>Quests '.number_format($prow->quests).'</li>';
print '<li>Honor '.number_format($prow->honor).'</li>';
print '<li>Location '.(!empty($prow->location)?$prow->location:'main map').'</li>';
print '</font><br>';
	}
}
}
mysqli_free_result ($presults);
}
?></td><td valign=top><?php
if($kresults = mysqli_query ($link, "SELECT * FROM `$tbl_kingdoms` WHERE `id` ORDER BY `elites` DESC LIMIT $total_players")) {
while ($krow = mysqli_fetch_object ($kresults)) {
print '<a href="?kshow='.$krow->kingdom.'">'.$krow->kingdom.'</a><br>';
if (!empty($_GET['kshow'])){
	if ($_GET['kshow'] == $krow->kingdom){
print '<font size=-1>';
print '<li>King '.$krow->charname.'</li>';
print '<li>Guards '.number_format($krow->guards).'</li>';
print '<li>Elites '.number_format($krow->elites).'</li>';
print '<li>Treasure '.number_format($krow->gold).'</li>';
print '</font><br>';
	}
}
}
mysqli_free_result ($kresults);
}

?></td></tr></table><?php

mysqli_close($link);

require_once 'MaiN/site.footer.php';
?>