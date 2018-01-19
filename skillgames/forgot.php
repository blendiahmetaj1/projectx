<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.functions.php';
require_once 'admin/www.header.php';


if (!empty($_POST['email']) and !empty($_POST['username'])) {
$email		= clean_form($_POST['email']);
$username	= clean_form($_POST['username']);

if ($result = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE (`username`='$username' and email='$email') ORDER BY `id` DESC LIMIT 1")) {
if ($row = mysqli_fetch_object ($result)){
mysqli_free_result ($result);

$row->email=stripslashes($row->email);

if ($email == $row->email and $username == $row->username) {
$new_pass=rand(100,999).substr($current_time,-5);
$message="
Hi $row->username,

You have requested password for:
Username :
$row->username
NEW Password NEW !!!:
$new_pass

After you have logged in you can change your password.

Cheers,
moneyskillgames.com

If you didn't request this then someone else did your account info is only send to you and is secure.";

mysqli_query ($link, "UPDATE `$tbl_members` SET `password`='$new_pass' WHERE `id`='$row->id' LIMIT 1");

mail("$row->email", "New password requested", $message,
     "From: password@moneyskillgames.com", "-fpassword@moneyskillgames.com");

print "An emails has been send to $row->email containing a new password.";
} else {
?>Sorry username or email mismatch!<?php
}

}
}

} //!empty _POST
?>
<form name="logon" method=POST>
	<table border=0 cellspacing=0 cellpadding=0>
	<tr><td><font size=-1><b>Username:</b></font></td><td><input type=text name=username maxlength=10 style="width:200px" value="<?php print $username;?>"></td></tr>
	<tr><td><font size=-1><b>Email:</b></font></td><td><input type=text name=email maxlength=30 style="width:200px" value="<?php print $email;?>"></td></tr>
	<tr><td> </td><td align=center><input type=submit name=action style="width:200px" value="Send a me a new password!"></td></tr>
	</table>
</form>
An email will be send to you with username and password, only if you have set an email!
<?php
require_once 'admin/www.footer.php';
?>