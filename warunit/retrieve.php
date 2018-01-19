<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/array.races.php';
require_once 'admin/www.functions.php';
include_once 'templates/template.header.php';

if (!empty($_POST['email'])) {
$email=$_POST['email'];
$link=mysqli_connect($db_host, $db_user, $db_password) or die('Server down please come back later.');
mysqli_select_db($db_main, $link) or die('Server down please come back later.');

if($result = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE email='$email' ORDER BY id desc")){
while ($row = mysqli_fetch_object ($result)) {
$row->email=stripslashes($row->email);
if ($email == $row->email and $email == $row->email) {
$new_pass=md5(rand(11111,99999));
//print $new_pass;
$message="
Hi $row->sex $row->charname,

You have requested a new password for:
email :
$row->email
NEW password NEW !!!:
$new_pass

After you have logged in you can change your password.

Cheers,
$admin_name

If you didn't request this then someone else did your account info is only send to you and is secure if this happens often better change your email.
";
$new_pass=crypt($new_pass,$row->email);
mysqli_query ($link, "UPDATE `$tbl_members` SET password='$new_pass' WHERE id='$row->id' LIMIT 1");

mail("$email", "$title password retrieval!", $message,"From: password@{$_SERVER['SERVER_NAME']}", "-fpassword@{$_SERVER['SERVER_NAME']}");
}
}
mysqli_free_result ($result);
?>A new password has sent!<?php
}
mysqli_close($link);
}
?>
<table><form method=post>
<tr><th colspan=2>
Request password by email
</th></tr>
<tr><td width=50%>
Email<br><font size=1>
</td><td>
<input type=text name=email value="" maxlength=50>
</td></tr>
<tr><th colspan=2>
<input type=submit name=action value="Request a new password!">
</th></tr></from>
</table>
<?php
include_once 'templates/template.footer.php';
?>