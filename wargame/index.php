<?php
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once($inc_functions);
require_once($inc_mysql);
require_once($html_header);
?>
<form method=post>
<table cellpadding=0 cellspacing=0 border=1 width=600>
<tr><td colspan=3 width=600 height=89><img src="t.jpg"></td></tr>
<tr><td width=44 valign=top><img src="l.jpg"></td><td width=522 valign=top align=center>


To signup fill in username and password click signup.<br>
To login fill in username and password click login.<br>

<form method=post action="?">
<table><tr><th colspan=2>Login or Signup</th></tr><tr><td width=100>Username:</td><td width=100>
<input type=text name=username value="" maxlength=10>
</td></tr><tr><td width=100>Password:</td><td width=100>
<input type=password name=password value="" maxlength=10>
<tr><td width=100>
<input type=submit name="login" value="Login" maxlength=10>
</td><td width=100>
<input type=submit name="signup" value="Signup" maxlength=10>
</td></tr></table>
</form>


<?php
if (!empty($_POST['username']) and !empty($_POST['password'])) {
	$username=clean_post($_POST['username']);
	$password=clean_post($_POST['password']);
print '<br>';

if (isset($_POST['login'])) {
	print 'Processing Login.';

if ($result = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE (`username`='$username' and `password`='$password') ORDER BY `id` DESC LIMIT 1")) {
if ($row = mysqli_fetch_object ($result)){
mysqli_free_result ($result);
mysqli_query ($link, "UPDATE `$tbl_members` SET `session`='$current_time' WHERE `id`='$row->id' LIMIT 1");
setcookie ("wgUsername", "$row->username",time()+60*60*60);
setcookie ("wgSession", "$current_time",time()+60*60*60);
print '<br><a href="messages.php">Play game!</a>';
}
}

}elseif (isset($_POST['signup'])) {
	print 'Processing Signup.';
	$x=rand(1,100);
	$y=rand(1,100);
mysqli_query ($link, "INSERT INTO `$tbl_members` VALUES ('','$username','$password','$username','','$username','$current_time','$current_time',
'10000','$x','$y',
'1','0','0','0','0','0','0','0','0','0',
'0','0','0','0','0','0','0','0','0','0',

'0','0','0','0','0','0','0','0','0','0',
'0','0','0','0','0','0','0','0','0','0',

'0','0','0','0','0','0','0','0','0','0',
'0','0','0','0','0','0','0','0','0','0',

'0','0','0','0','0','0','0','0','0','0',
'0','0','0','0','0','0','0','0','0','0',

'0','0','0','0','0','0','0','0','0','0',
'0','0','0','0','0','0','0','0','0','0',

'0','0','0','0','0','0','0','0','0','0',
'0','0','0','0','0','0','0','0','0','0')") or print ('This username is already in use please use another one!'.mysqli_error()).$account_exist=1;

if (empty($account_exist)) {
setcookie ("wgUsername", "$username",time()+60*60*5);
setcookie ("wgSession", "$current_time",time()+60*60*5);
print '<br><a href="messages.php">Play game!</a>';
}

}

print '<br>';
}
?></td><td width=44 valign=top><img src="r.jpg"></td></tr></table>
<?php
require_once($html_footer);
?>