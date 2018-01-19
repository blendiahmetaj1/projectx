<?php
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
print '<tr><td><a href="?messages&del='.$news->id.'" title="Delete">Delete </a>'.$news->message.'</td></tr>';
}
mysqli_free_result ($nresult);
print '<tr><th>'.($i>=1?'<a href="?messages&adel=1">Delete All Messages</a>':'No Messages').'</th></tr>';
?></tr></table><?php
}
	//NEWS

	//SUGGESTIONS
?>
<form method=post>
<table>
<tr><th>Suggestions Box</th></tr>
<tr><th><textarea cols=35 rows=3 name=suggest></textarea></th></tr>
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
	?>