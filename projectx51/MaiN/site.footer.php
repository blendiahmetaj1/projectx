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

mysqli_query ($link, "UPDATE `$tbl_members` SET $to_update WHERE (`id`='$row->id') LIMIT 1") or die(mysqli_error());

//print $to_update;

}
//mysqli_query ($link, "UPDATE `$tbl_members` SET x2=100, x=".rand(100,105).", y=".rand(100,105)." WHERE id LIMIT 1") or die(mysqli_error());

//for ($i=0;$i<=1000;$i++){mysqli_query ($link, "INSERT INTO `$tbl_location` VALUES ('','".rand(1,6)."','$current_time','".rand($row->x-25,$row->x+25)."','".rand($row->y-25,$row->y+25)."','10','0','0','0','0','0','0','0','0','0')") or print(mysqli_error().'111');}

mysqli_close($link);

?>
<br>

<font size=-2><b>
<a href="http://www.thesilent.com/index.php?open=privacy">Privacy</a>
<a href="http://www.thesilent.com/index.php?open=terms">Terms</a>
<a href="http://www.thesilent.com/index.php?open=rules">Rules</a>
<a href="http://www.thesilent.com/index.php?open=feedback">Feedback</a>
<br>
&copy;<?php print date("Y");?> The silenT
</b>
</font>


</center>
</body>
</html>