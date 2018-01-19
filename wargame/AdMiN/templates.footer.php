<?php
/*
print '<hr>';
print_r($_COOKIE);
print '<hr>';
print_r($_GET);
print '<hr>';
print_r($_POST);
print '<hr>';
print $to_update;
*/
if(!empty($to_update) and !empty($row)) {
mysqli_query ($link, "UPDATE `$tbl_members` SET $to_update WHERE (`id`='$row->id') LIMIT 1") or die(mysqli_error());
}
mysqli_close($link);

if ($refresh_timer >= 1) {
?>
<meta http-equiv=refresh content=<?php echo $refresh_timer; ?>>

<form name=fchat method=post>
<input type=submit name=schat value="<?php echo $refresh_timer; ?>" style="background:url(<?php echo $path_game; ?>/fight/clock.gif);width:100;height:25;" style="position:absolute;top:0px;left:0px">
</form>
<?php
jrefresh($refresh_timer, 'chat');

}
?>
<!--FOOTER-->
<br>BETA 0.01
<p align=right valign=bottom>
<font size=1><b>	
<a href="http://www.thesilent.com/">Home</a>
<a href="http://www.thesilent.com/index.php?open=privacy">Privacy</a>
<a href="http://www.thesilent.com/index.php?open=terms">Terms</a>
<a href="http://www.thesilent.com/index.php?open=rules">Rules</a>
<a href="http://www.thesilent.com/index.php?open=feedback">Feedback</a>
<br>
&copy;<?php print date("Y");?> <a href="http://thesilent.com">The silenT</a>
</b>
</font>
</p>
</center></body>
</html>