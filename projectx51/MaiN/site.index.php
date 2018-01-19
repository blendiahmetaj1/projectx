Game is like risk board game or a simplified settlers game or maybe a little bit like a chess game.<br>
The goal is to conquer the whole map I guess.<br>
Dunno check it out yourself.<br>
<br>
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
setcookie ("Username", "$row->username",time()+60*60*60);
setcookie ("Session", "$current_time",time()+60*60*60);
print '<br><a href="?">Play game!</a>';
}
}

}elseif (isset($_POST['signup'])) {
	$x = rand (550,600);
	$y = rand (550,600);
	print 'Processing Signup.';
mysqli_query ($link, "INSERT INTO `$tbl_members` VALUES ('','$username','$password','$username','','$username','$current_time','$current_time',
'50000','$x','$y',
'0',

'0','0','0','0','0','0','0','0','0','0',
'0','0','0','0','0','0','0','0','0','0',

'0','0','0','0','0','0','0','0','0','0',
'0','0','0','0','0','0','0','0','0','0',

'0','0','0','0','0','0','0','0','0','0')") or print ('This username is already in use please use another one!'.mysqli_error()).$account_exist=1;

if (empty($account_exist)) {
setcookie ("Username", "$username",time()+60*60*60);
setcookie ("Session", "$current_time",time()+60*60*60);
print '<br><a href="?">Play game!</a>';
}

}

print '<br>';
}
?>