<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/array.races.php';
require_once "admin/www.functions.php";
include_once 'templates/template.header.php';
?>
Thank you for your time to play the game.<br><br>
Hope to see you back again.<br><br>
<?php

?>
<br><br><table border=1 align=center><tr><td><center>
This game is working now.<br>
But do you want to help improve this game or do you have any ideas for this game?<br>
<b>Your help is needed to improve this game!<br>
<a href="http://thesilent.com/forums/forums.php">Enter the development forums and help.</a></b>
</center></td></tr></table><br><br>
<b>
If you like this game please tell your friends.<br>
<a href="http://www.warunit.com">http://www.warunit.com</a><br>
And don't forget to bookmark :o)...
</b><br><br>

<?php

if (!empty($sid) and $sid == $row->sid) {
$sid=md5($current_time.crypt($row->email));
$update_it .=", sid='$sid'";
}
include_once 'templates/template.footer.php';
?>