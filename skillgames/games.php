<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.functions.php';
require_once 'admin/www.header.php';

if (!empty($_POST['password']) and !empty($_POST['username'])) {
$password		= clean_form($_POST['password']);
$username		= clean_form($_POST['username']);

if ($result = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE (`username`='$username' and `password`='$password') ORDER BY `id` DESC")) {
if ($row = mysqli_fetch_object ($result)){
mysqli_free_result ($result);

mysqli_query ($link, "UPDATE `$tbl_members` SET `timer`='$current_time' WHERE `id`='$row->id' LIMIT 1");

setcookie ("msgUsername", "$row->username",time()+60*60*5);
setcookie ("msgSession", "$current_time",time()+60*60*5);

}
}
}
?>
<table width=100% border=0 cellspacing=0 cellpadding=0>
<tr><th>Text Based Games</th></tr>

<tr><dl><dt><a href="play.php?game=1">8 Dices</a></dt><dd>
<font size=-1>
Rol the dice 8 time and see who hit the highest total.<br>
Win chance 50%<br>
No skills required
</font>
</dd></dl></tr>

<tr><dl><dt><a href="play.php?game=2">8 Cards</a></dt><dd>
<font size=-1>
Pull 8 cards and see who hit the highest total.<br>
Win chance 50%<br>
No skills required
</font>
</dd></dl></tr>

</table>
<?php
require_once 'admin/www.footer.php';
?>