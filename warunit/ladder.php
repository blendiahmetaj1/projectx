<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/array.races.php';
require_once 'admin/www.functions.php';
if (isset($_GET['sid'])) {
include_once 'templates/game.header.php';
}else{
include_once 'templates/template.header.php';
$link=mysqli_connect($db_host, $db_user, $db_password) or die('Server down please come back later.');
mysqli_select_db($db_main, $link) or die('Server down please come back later.');
}
?><table><?php
if(empty($_GET['charname'])){
?><tr><th>#</th><th>Player</th><th><a href="?<?php print (isset($sid))?'sid='.$sid.'&':'';?>sort=gold">Gold</a></th><th><a href="?<?php print (isset($sid))?'sid='.$sid.'&':'';?>sort=land">Land</a></th><th><a title="Power U(something)">Power</a></th><th><a href="?<?php print (isset($sid))?'sid='.$sid.'&':'';?>sort=stealth">Stealth</a></th></tr><?php

	$sorted='gold';
if (!empty($_GET['sort'])){
if ($_GET['sort'] == 'land'){
	$sorted='land';
}elseif ($_GET['sort'] == 'gold'){
	$sorted='gold';
}elseif ($_GET['sort'] == 'stealth'){
	$sorted='stealth';
}else{
	$sorted='gold';
}

}


if($lresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE (`rank` < '127' and `gold` >= '1') or (`land` >= '1') ORDER BY `$sorted` DESC LIMIT 150")){
$num=1;
while ($lrow = mysqli_fetch_object ($lresult)) {
?><tr><td><?php print $num.'</td><td><a href="?'.(!empty($sid)?'sid='.$sid.'&':'').'charname='.$lrow->charname.'">'.(($lrow->clan)?'['.$lrow->clan.']':'').$lrow->sex.' '.$lrow->charname.'</a>'.($lrow->rank == 127?'<sup><b>DEAD</b></sup>':'').' '.($lrow->race == 'Private'?'<sup><b>NEW</b></sup>':'').'</td><td>$'.number_format($lrow->gold).'</td><td>'.number_format($lrow->land+$lrow->b1+$lrow->b2+$lrow->b3+$lrow->b4+$lrow->b5).' acres</td><td>'.number_format((($lrow->stealth+$lrow->b1+$lrow->b2+$lrow->b3+$lrow->b4+$lrow->b5+$lrow->u1+$lrow->u2+$lrow->u3+$lrow->u4+$lrow->u5+$lrow->s1+$lrow->s2+$lrow->s3+$lrow->s4+$lrow->s5)/1000000),3).'<sup><b>pu</b></sup></td><td>'.$lrow->stealth.'</td></tr>';

if ($num == 50){?>
<tr><th>#</th><th>Player</th><th><a href="?sort=`gold`">Gold</a></th><th><a href="?sort=`land`">Land</a></th><th><a title="Power U(something)">Power</a></th></tr>
<?php}

$num++;
}
mysqli_free_result ($lresult);
}

}else{
$charname=clean_post($_GET['charname']);

if($lresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE `charname`='$charname' ORDER BY `id` DESC LIMIT 1")){
if($lrow = mysqli_fetch_object ($lresult)){mysqli_free_result ($lresult);
print '<tr><th>Player</th><th><a href="?sort=`gold`">Gold</a></th><th><a href="?sort=`land`">Land</a></th><th><a title="Power U(something)">Power</a></th></tr><tr><td><a href="?'.(!empty($sid)?'sid='.$sid.'&':'').'charname='.$lrow->charname.'">'.(($lrow->clan)?'['.$lrow->clan.']':'').$lrow->sex.' '.$lrow->charname.'</a>'.($lrow->rank == 127?'<sup><b>DEAD</b></sup>':'').'</td><td>$'.number_format($lrow->gold).'</td><td>'.number_format($lrow->land+$lrow->b1+$lrow->b2+$lrow->b3+$lrow->b4+$lrow->b5).' acres</td><td>'.number_format((($lrow->stealth+$lrow->b1+$lrow->b2+$lrow->b3+$lrow->b4+$lrow->b5+$lrow->u1+$lrow->u2+$lrow->u3+$lrow->u4+$lrow->u5+$lrow->s1+$lrow->s2+$lrow->s3+$lrow->s4+$lrow->s5)/1000000),3).'<sup><b>pu</b></sup></td></tr>';
print '<tr><th>Race</th><th>Buildings</th><th>Population</th><th>Cashflow</th></tr><tr><tr><td>'.$lrow->race.'</td><td>'.number_format($lrow->b1+$lrow->b2+$lrow->b3+$lrow->b4+$lrow->b5).'</td><td>'.number_format($lrow->u1+$lrow->u2+$lrow->u3+$lrow->u4+$lrow->u5).'</td><td>'.number_format(((($lrow->land)+($lrow->b1*50)+($lrow->u1*25))/100)*(100+$races_array[$lrow->race][0])).'</td></tr><tr>';
}
}


if($nresult = mysqli_query ($link, "SELECT * FROM `$tbl_kills` WHERE charname='$charname' ORDER BY id DESC LIMIT 100")){
if (mysqli_num_rows($nresult) >= 1) {
?><tr><th colspan=4>Kills made</th></tr><tr><th colspan=2>Killed</th><th colspan=2>Time</th></tr><?php
$i=0;while ($news = mysqli_fetch_object ($nresult)) {$i++;
echo '<tr><td colspan=2>'.$news->killed.'</td><td colspan=2>'.dater($news->timer).' ago</td></tr>';
}
mysqli_free_result ($nresult);

}else{?><tr><th colspan=4 align=center>This player killed nobody.</th></tr><?php}
}

}
?>
</table>
<?php
if (isset($_GET['sid'])) {
include_once 'templates/game.footer.php';
}else{
mysqli_close($link);
include_once 'templates/template.footer.php';
}
?>