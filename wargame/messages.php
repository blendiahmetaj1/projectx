<?php
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once($inc_functions);
require_once($inc_mysql);
require_once($inc_arrays);
require_once($html_header);

if (empty($row)) {?>It appears your session has been timed out please relogin.<?require_once($html_footer);exit;}


	//NEWS
if (!empty($_GET['del'])) {
$del=$_GET['del'];
mysqli_query ($link, "DELETE FROM $tbl_messages WHERE (id=$del and receiver='$row->charname') LIMIT 1");
}
if (!empty($_GET['adel'])) {
$adel=$_GET['adel'];
mysqli_query ($link, "DELETE FROM $tbl_messages WHERE (receiver='$row->charname') LIMIT 1000");
}
if($nresult = mysqli_query ($link, "SELECT * FROM $tbl_messages WHERE receiver='$row->charname' or receiver='' ORDER BY id DESC LIMIT 100")) {
?><table><tr><th>Messages</th></tr><?php
$i=0;while ($news = mysqli_fetch_object ($nresult)) {$i++;
print '<tr><td><a href="?del='.$news->id.'" title="Delete">Delete </a>'.$news->message.'</td></tr>';
}
mysqli_free_result ($nresult);
print '<tr><th>'.($i>=1?'<a href="?adel=1">Delete All Messages</a>':'No Messages').'</th></tr>';
?></tr></table><?php
}
	//NEWS

	//SUGGESTIONS
?>
<form method=post>
<table>
<tr><th>Suggestions Box</th></tr>
<tr><th><textarea cols=50 rows=3 name=suggest></textarea></th></tr>
<tr><th><input type=submit></th></tr>
</table>
</form>
<?php
if (!empty($_POST['suggest'])) {
$suggest=clean_post($_POST['suggest']);
mysqli_query ($link, "INSERT INTO `$tbl_messages` VALUES ('','','DhIusJokL','$row->charname : $suggest','$current_time')") or die(mysqli_error());
}

if($nresult = mysqli_query ($link, "SELECT * FROM $tbl_messages WHERE receiver='DhIusJokL' ORDER BY id DESC LIMIT 100")) {
?><table><tr><th>Suggestions</th></tr><?php
$i=0;while ($news = mysqli_fetch_object ($nresult)) {$i++;
echo '<tr><td>'.$news->message.'</td></tr>';
}
mysqli_free_result ($nresult);
?></tr></table><?php
}
	//SUGGESTIONS


print '<a href="?q=r">Reset Account</a> | <a href="?q=m">Give Me Money</a> | Beta 0.01<br>';



//RESET
if ($q == 'r') {
mysqli_query ($link, "UPDATE `$tbl_members` SET money=10000, x=5, y=5, b0=1, b1=0, b2=0, b3=0, b4=0, b5=0, b6=0, b7=0, b8=0, b9=0, b10=0, b11=0, b12=0, b13=0, b14=0, b15=0, b16=0, b17=0, b18=0, b19=0, u0=0, u1=0, u2=0, u3=0, u4=0, u5=0, u6=0, u7=0, u8=0, u9=0, u10=0, u11=0, u12=0, u13=0, u14=0, u15=0, u16=0, u17=0, u18=0, u19=0, pb0=0, pb1=0, pb2=0, pb3=0, pb4=0, pb5=0, pb6=0, pb7=0, pb8=0, pb9=0, pb10=0, pb11=0, pb12=0, pb13=0, pb14=0, pb15=0, pb16=0, pb17=0, pb18=0, pb19=0, pu0=0, pu1=0, pu2=0, pu3=0, pu4=0, pu5=0, pu6=0, pu7=0, pu8=0, pu9=0, pu10=0, pu11=0, pu12=0, pu13=0, pu14=0, pu15=0, pu16=0, pu17=0, pu18=0, pu19=0, tb0=0, tb1=0, tb2=0, tb3=0, tb4=0, tb5=0, tb6=0, tb7=0, tb8=0, tb9=0, tb10=0, tb11=0, tb12=0, tb13=0, tb14=0, tb15=0, tb16=0, tb17=0, tb18=0, tb19=0, tu0=0, tu1=0, tu2=0, tu3=0, tu4=0, tu5=0, tu6=0, tu7=0, tu8=0, tu9=0, tu10=0, tu11=0, tu12=0, tu13=0, tu14=0, tu15=0, tu16=0, tu17=0, tu18=0, tu19=0 WHERE (`id`='$row->id') LIMIT 1");
}

if ($q == 'm' and $row->money <= 100000) {
mysqli_query ($link, "UPDATE `$tbl_members` SET money=100000 WHERE (`id`='$row->id') LIMIT 1");
}elseif ($q == 'm' and $row->money >= 100000) {print 'You have enough man, dont get greedy dude!';}

require_once($html_footer);
?>