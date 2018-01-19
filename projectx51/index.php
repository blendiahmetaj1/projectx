<?php
#!/usr/local/bin/php
require_once "MaiN/www.config.php";
include_once "MaiN/www.functions.php";
include_once "MaiN/site.header.php";

if (empty($row->charname)) {
include_once "MaiN/site.index.php";
} else {
?>
<table cellpadding=0 cellspacing=0 border=0 align=center width=600 height=600>
	<tr><td width=244 valign=top>


<table cellpadding=0 cellspacing=0 border=0>
<tr><td colspan=3 height=123><img src="images/m1.jpg" border=0></td></tr>
<tr><td width=23 height=313><img src="images/m2.jpg" border=0></td><td width=211 valign=top background="images/bgmap.jpg">
<!--MAP//-->
	<?include_once "MaiN/site.map.php";?>
<!--MAP//-->
</td><td width=10 height=313><img src="images/m3.jpg" border=0></td></tr>
<tr><td colspan=3 height=11><img src="images/m4.jpg" border=0></td></tr>
</table>


	</td><td width=356 valign=top>


<table cellpadding=0 cellspacing=0 border=0>
<tr><td colspan=3 height=37><img src="images/s1.jpg" border=0></td></tr>
<tr><td width=12 height=400><img src="images/s2.jpg" border=0></td><td width=321 valign=top background="images/bgmain.jpg">
<!--MAP//-->

<?php
if (isset($_GET['messages'])) {
	include_once "MaiN/site.messages.php";
}elseif (isset($_GET['ladder'])) {
	include_once "MaiN/site.ladder.php";
}elseif (isset($_GET['attack'])) {
	include_once "MaiN/site.attack.php";
}elseif (isset($_GET['help'])) {
	include_once "MaiN/site.help.php";
}else{
	include_once "MaiN/site.game.php";
}	
?>

<!--MAP//-->
</td><td width=23 height=400><img src="images/s3.jpg" border=0></td></tr>
<tr><td colspan=3 height=10><img src="images/s4.jpg" border=0></td></tr>
</table>


	</td></tr>
	<tr><td colspan=2 height=212 valign=top>


<table cellpadding=0 cellspacing=0 border=0>
<tr><td width=212 height=153><img src="images/c1.jpg" border=0></td><td width=364 height=153>

<table cellpadding=0 cellspacing=0 border=0>
<tr><td width=364 height=20><img src="images/c2.jpg" border=0></td></tr>
<tr><td height=115 valign=top background="images/bgchat.jpg">
<!--MAP//-->
<a href="game.php">Game</a>
<a href="?attack">Attack</a>
<a href="?ladder">Ladder</a>
<a href="?logout">Logout</a>
<a href="?help">Help</a><br>
<?php
print 'Hi '.$row->charname.' you have $'.number_format($row->money).' with a income of $'.number_format($my_income,2).'<br>';


if($total_costs >= 1) {
	$to_update .= ",`money`=`money`-$total_costs";
print 'You used $'.number_format($total_costs).'.<br>';
}

?>




<!--MAP//-->
</td></tr>
<tr><td width=364 height=18><img src="images/c3.jpg" border=0></td></tr>
</table>

<td width=24 width=10><img src="images/c4.jpg" border=0></td></tr>
</table>


	</td></tr>
</table>
<?php

}
?>

<a href="http://www.thesilent.com/projectx5/">BETA 0.01</a><br>
<a href="http://www.thesilent.com/projectx51/">BETA 0.02</a> more graphical interface
<?php
include_once "MaiN/site.footer.php";
?>