<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.functions.php';
require_once 'admin/www.header.php';

$username='';
$password='';
$passworda='';
$email='';

if (!empty($_POST)) {

	if (!empty($_POST['username'])) {
		$username=clean_form($_POST['username']);
	}
	if (!empty($_POST['password'])) {
		$password=clean_form($_POST['password']);
	}
	if (!empty($_POST['passworda'])) {
		$passworda=clean_form($_POST['passworda']);
	}
	if (!empty($_POST['email'])) {
		$email=clean_form($_POST['email']);
	}

if ($password == $passworda and !empty($username) and !empty($password) and !empty($email)){
mysqli_query ($link, "INSERT INTO `$tbl_members` values ('','$username','$password','$email','1','0','1000','0','0','$current_time')") and print('Thank you signup processed you may login and play.<br>Good luck!').$oke='1' or print('The username or email already exists.');
}else{
?>Some fields are empty or contain disallowed chars.<br><?php
}

}

if (empty($oke)) {
?>
<form name="logon" method=POST>
	<table border=0 cellspacing=0 cellpadding=0>
	<tr><td><font size=-1><b>Username:</b></font></td><td><input type=text name=username maxlength=10 style="width:200px" value="<?php print $username;?>"></td></tr>
	<tr><td><font size=-1><b>Password:</b></font></td><td><input type=password name=password maxlength=10 style="width:200px" value="<?php print $password;?>"></td></tr>
	<tr><td><font size=-1><b>Password Confirm:</b></font></td><td><input type=password name=passworda maxlength=10 style="width:200px" value="<?php print $passworda;?>"></td></tr>
	<tr><td><font size=-1><b>Email:</b></font></td><td><input type=text name=email maxlength=30 style="width:200px" value="<?php print $email;?>"></td></tr>
	<tr><td> </td><td align=center><input type=submit name=action style="width:200px" value="Signup!"></td></tr>
	</table>
</form>
Only if you agree to our Privacy, Terms and Rules.
<?php
}

require_once 'admin/www.footer.php';
?>