<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/array.races.php';
require_once 'admin/www.functions.php';
include_once 'templates/game.header.php';

if (empty($sid) or $sid !== $row->sid) {
print 'Looking for something?<br>Please Signup or login to play the game!';

include_once 'templates/template.footer.php';
exit;
}

$income=((($row->land)+($row->b1*50)+($row->u1*25))/100)*(100+$races_array[$row->race][0]);
$cost=$row->u1+$row->u2+$row->u3+$row->u4+($row->u5*3);

$apower = (($row->u3*3)+($row->u5*5));
$apower=($apower/100)*(100+$races_array[$row->race][1]+($row->b2/($total_land/100)));
$apower=($apower/100)*(100+($row->s4/$science_devider));

$dpower = (($row->u4*3)+($row->u5*5));
$dpower=($dpower/100)*(100+$races_array[$row->race][2]+($row->b3/($total_land/100)));
$dpower=($dpower/100)*(100+($row->s5/$science_devider));

?><table border=1><tr><th colspan=2>Intel</th><th colspan=2>Resources</th></tr><tr><?php
print '<td valign=top>Rank<br>Race<br>Clan<br>Stealth<br>Tax collect<br>Offense power<br>Defense power</td><td valign=top align=right>'.$row->rank.'<br>'.$row->race.'<br>';
print ($row->clan)?'['.$row->clan.']':'';
print '<br>'.number_format($row->stealth).'<br>'.number_format(60-$current_minute).' minutes<br>'.number_format($apower).'<br>'.number_format($dpower).'</td><td valign=top>Money<br>Total Income<br>Cost<br>Cashflow<br>Unbuild land<br>Constructions<br>Total Land</td><td valign=top align=right>$'.number_format($row->gold).'<br>$'.number_format($income).'<br>$'.number_format($cost).'<br>$'.number_format($income-$cost).'<br>'.number_format($row->land).' acres<br>'.number_format($total_land).' acres<br>'.number_format($row->land+$total_land).' acres</tr></table>';

print '<table border=1><tr><th colspan=2>Buildings</th><th colspan=2>Population</th></tr><tr><td valign=top>'.$races_array[$row->race][3].'<br>'.$races_array[$row->race][4].'<br>'.$races_array[$row->race][5].'<br>'.$races_array[$row->race][6].'<br>'.$races_array[$row->race][7].'</td><td align=right valign=top>'.number_format($row->b1).'<br>'.number_format($row->b2).'<br>'.number_format($row->b3).'<br>'.number_format($row->b4).'<br>'.number_format($row->b5).'</td><td valign=top>'.$races_array[$row->race][8].'<br>'.$races_array[$row->race][9].'<br>'.$races_array[$row->race][10].'<br>'.$races_array[$row->race][11].'<br>'.$races_array[$row->race][12].'</td><td align=right valign=top>'.number_format($row->u1).'<br>'.number_format($row->u2).'<br>'.number_format($row->u3).'<br>'.number_format($row->u4).'<br>'.number_format($row->u5).'</td><tr><td>Total</td><td align=right>'.number_format($row->b1+$row->b2+$row->b3+$row->b4+$row->b5).'</td><td>Total</td><td align=right>'.number_format($row->u1+$row->u2+$row->u3+$row->u4+$row->u5).'</td></tr></table>';

if ($row->sex !== 'Private'){
	print 'You will receive 1 extra stealth points and '.number_format((($row->land)+($row->b1*50)+($row->u1*25))-($row->u1+$row->u2+$row->u3+$row->u4+($row->u5*3))).' extra gold per turn.';
}

if (!empty($_GET['del'])) {
$del=$_GET['del'];
mysqli_query ($link, "DELETE FROM `$tbl_news` WHERE (id=$del and charname='$row->charname') LIMIT 1");
}
if (!empty($_GET['adel'])) {
$adel=$_GET['adel'];
mysqli_query ($link, "DELETE FROM `$tbl_news` WHERE (charname='$row->charname') LIMIT 1000");
}
if($nresult = mysqli_query ($link, "SELECT * FROM `$tbl_news` WHERE charname='$row->charname' or charname='' ORDER BY id DESC LIMIT 100")){
?><table><tr><th>History</th></tr><tr><td><dl><?php
$i=0;while ($news = mysqli_fetch_object ($nresult)) {$i++;
echo '<dt><a href="?sid='.$sid.'&del='.$news->id.'" title="Delete">X</a> '.dater($news->timer).' ago</dt><dd>'.$news->content.'<hr size=1><dd>';
}
mysqli_free_result ($nresult);
print $i>=1?'<a href="?sid='.$sid.'&adel=1">Delete All</a>':'No news';
?></dl></td></tr></table><?php
}else{?>No news<?}

include_once 'templates/game.footer.php';
?>