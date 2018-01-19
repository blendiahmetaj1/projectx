	<!--FOOTER-->
<?php

if (isset($_GET['logout'])) {
setcookie ("Username", "",time()-60*60*60);
setcookie ("Session", "",time()-60*60*60);
$to_update .= ", `session`='$current_time'";
print 'Cookies removed.';
}
/*
print '<hr>';
print_r($_COOKIE);
print '<hr>';
print_r($_GET);
print '<hr>';
print_r($_POST);
print '<hr>';
print_r($row);
print '<hr>';
*/

if(!empty($to_update) and !empty($row)) {

//CHECK X0 X1
if (!preg_match("'x0'si",$to_update) and !preg_match("'x1'si",$to_update)) {
	//print 'TEST YEHA.';
if ($clresult = mysqli_query ($link, "SELECT `x0` FROM `$tbl_location` WHERE (`mid`='$row->id')  ORDER BY `id` DESC LIMIT 1000000")) {
$x0s = mysqli_num_rows($clresult);
if ($x0s >= 1 and $row->x0 <> $x0s) {
	//print 'TEST YOHA.';
	$x1s = 0;
	while ($clrow = mysqli_fetch_object ($clresult)) {
		$x1s += $clrow->x0;
	}
	mysqli_free_result ($clresult);
$to_update .= ", `x0`='$x0s', `x1`='$x1s'";
}
}
}
//CHECK X0 X1

if($total_costs >= 1) {
	$to_update .= ",`money`=`money`-$total_costs";
print 'You used $'.number_format($total_costs).', you have $'.number_format($row->money).' left.<br>';
}

mysqli_query ($link, "UPDATE `$tbl_members` SET $to_update WHERE (`id`='$row->id') LIMIT 1") or die(mysqli_error());

//print $to_update;

}
//mysqli_query ($link, "UPDATE `$tbl_members` SET x2=100, x=".rand(100,105).", y=".rand(100,105)." WHERE id LIMIT 1") or die(mysqli_error());

//for ($i=0;$i<=10;$i++){mysqli_query ($link, "INSERT INTO `$tbl_location` VALUES ('','$row->id','$current_time','".rand($row->x-25,$row->x+25)."','".rand($row->y-25,$row->y+25)."','10','0','0','0','0','0','0','0','0','0')") or print(mysqli_error().'111');}

//RESET PLAYERS
//mysqli_query ($link, "UPDATE `$tbl_members` SET `money`='50000', `x`='".rand(550,600)."', `y`='".rand(550,600)."', `x0`='0', `x1`='0', `x2`='0', `x3`='0', `x4`='0', `x5`='0', `x6`='0', `x7`='0', `x8`='0', `x9`='0', `x10`='0', `x11`='0', `x12`='0', `x13`='0', `x14`='0', `x15`='0', `x16`='0', `x17`='0', `x18`='0', `x19`='0', `x20`='0', `x21`='0', `x22`='0', `x23`='0', `x24`='0', `x25`='0', `x26`='0', `x27`='0', `x28`='0', `x29`='0', `x30`='0', `x31`='0', `x32`='0', `x33`='0', `x34`='0', `x35`='0', `x36`='0', `x37`='0', `x38`='0', `x39`='0', `x40`='0', `x41`='0', `x42`='0', `x43`='0', `x44`='0', `x45`='0', `x46`='0', `x47`='0', `x48`='0', `x49`='0', `x50`='0' WHERE `id` LIMIT 1000");
//mysqli_query ($link, "TRUNCATE TABLE `$tbl_location` ");

mysqli_close($link);

?>

<hr>
<p align=right>
<font size=-2><b>	
<a href="http://www.thesilent.com/index.php?open=privacy">Privacy</a>
<a href="http://www.thesilent.com/index.php?open=terms">Terms</a>
<a href="http://www.thesilent.com/index.php?open=rules">Rules</a>
<a href="http://www.thesilent.com/index.php?open=feedback">Feedback</a>
<br>
&copy;<?php print date("Y");?> The silenT
</b>
</font>
</p>

</center>
</body>
</html>