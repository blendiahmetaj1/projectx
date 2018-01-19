<?
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once('AdMiN/www.functions.php');
include_once("$html_header");

if(!empty($_POST['email']) and !empty($_POST['username'])){
$email = $_POST['email'];
$username = $_POST['username'];

require_once('AdMiN/www.mysql.php');
$link=mysql_connect($db_host, $db_user, $db_password) or die(" : Unable to connect to database");
mysql_select_db("$db_main",$link) or die( " : Unable to select database");
$result = mysql_query("select * from $tbl_members where(username='$username' and email='$email') order by id desc") or die("This email is not found in the database sorry.");
$row = mysql_fetch_object($result);
mysql_free_result($result);

$row->email=stripslashes($row->email);

if($email == $row->email and $username == $row->username){
$new_pass=lottery_ticket();
$message="
Hi $row->charname,

You have requested password for:
username :
$row->username
NEW password NEW !!!:
$new_pass

After you have logged in you can change your password :
$root_url/login.php

Cheers,
$admin_name

If you didn't request this then someone else did your account info is only send to you and is secure if this happens often better change your email.
";
$new_pass=crypt($new_pass,$row->username);
mysql_query("update $tbl_members SET password='$new_pass' where id=$row->id limit 1");

mail("$row->email", "$title new password", $message,
 "from: password@{$_SERVER['SERVER_NAME']}", "-fpassword@{$_SERVER['SERVER_NAME']}");


echo "An emails has been send to $row->email containing a new password.";
}else{
?>Sorry username or email mismatch!<?
}
mysql_close($link);

}//!empty _POST
?>
<form method=post>
<table width=80% cellpadding=2 cellspacing=2 border=0>
<tr><th colspan=2>
Request password by email
</th></tr>
<tr><td width=50%>
username<br><font size=1>
</td><td>
<input type=text name=username value="" maxlength=50>
</td></tr>
<tr><td width=50%>
email<br><font size=1>
</td><td>
<input type=text name=email value="" maxlength=50>
</td></tr>
<tr><td colspan=2>
<input type=submit name=action value="Send me the email">
</td></tr>
</table>
</from>
An email will be send to you with username and password, only if you have set an email!
<?
include_once("$html_footer");
?>