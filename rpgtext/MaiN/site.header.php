<?php
#!/usr/local/bin/php
?><html>
<head>
<title>RPG TEXT online browser text based RPG game.</title>
<meta NAME="description" CONTENT="At RPG TEXT online text based RPG game there is no waiting for a turn, play forever never reset, .unlimited stats, monsters and items.">
<meta NAME="keywords" CONTENT="text based rpg, web rpg, web based rpg, role playing games, browser based rpg, massive multiplayer online, online rpg text, role playing online, role playing rpg, rpg text, rpg web, rpg web based, text based game, text rpg, web rpg games, browser rpg games">

<style type="text/css">
<!--
body, table, tr, th, td, form, a, b {
	font-family:Arial,Verdana,Monaco;
	border : thin none inherit;
	border-color:#AAAAAA;
	margin:0;
}
body{
	background:<?php print $colbg;?>;
	color:<?php print $coltext;?>;
}
th{
	background:<?php print $colth;?>;
}
a{
	text-decoration: none;
	color:<?php print $collink;?>;
}
input, select, textarea {
	width:100%;
	margin:0;
}
hr {
	color:<?php print $colth;?>;
	height:1;
	size:1;
	border : none;
	margin:0;
}
-->
</style>
</head>
<body>
<!--MAINLOGO//-->
<table cellpadding=0 cellspacing=0 border=0>
<tr><td width=250><a href="index.php"><img src="images/t1.jpg" border=0 alt="Text Based RPG menu" title="Text Based RPG navigation"></a></td><td width=350 valign=top>
	<table cellpadding=0 cellspacing=0 border=0><form method=post target="_top" action="game.php">
	<tr><td colspan=3><img src="images/t2.jpg" border=0></td></tr>
	<tr><td width=100><img src="images/t3.jpg" border=0></td><td width=100><input type=text name=username maxlength=10 value="<?php print !empty($_COOKIE['username'])?$_COOKIE['username']:'';?>" style="margin:0;border:thin none inherit;width:100;height:100%;"></td><td width=125><img src="images/t4.jpg" border=0></td></tr>
	<tr><td colspan=3><img src="images/t8.jpg" border=0></td></tr>
	</table><table cellpadding=0 cellspacing=0 border=0>
	<tr><td width=150><img src="images/t6.jpg" border=0></td><td width=100><input type=password name=password maxlength=10 value="<?php print !empty($_COOKIE['password'])?$_COOKIE['password']:'';?>" style="margin:0;border:thin none inherit;width:100%;height:100%;"><input type=submit name=action value="Login" style="width:0;height:0;"></td><td width=100><img src="images/t7.jpg" border=0></td></tr>
	<tr><td colspan=3><img src="images/t8.jpg" border=0></td></tr>
	</form></table>
</td></tr></table>
<!--MAINLOGO//-->

<table width=100% cellpadding=0 cellspacing=0 border=0><tr><td width=125 valign=top background="images/bg.jpg"><img src="images/nav.jpg" border=0 usemap="#navmap"></td><td valign=top>

<map id="navmap" name="navmap">
<area shape="rect" target="_top" coords="0,0,125,25" href="index.php" title="Home">
<area shape="rect" target="_top" coords="0,25,125,50" href="news.php" title="News">

<area shape="rect" target="_top" coords="0,75,125,100" href="signup.php" title="Signup">
<area shape="rect" target="_top" coords="0,100,125,125" href="classes.php" title="Classes">
<area shape="rect" target="_top" coords="0,125,125,150" href="ladder.php" title="Ladder">
<area shape="rect" target="_top" coords="0,150,125,175" href="screenshots.php" title="Screenshots">
<area shape="rect" target="_top" coords="0,175,125,200" href="items.php" title="Items">
</map>




