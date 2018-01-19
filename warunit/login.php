<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/array.races.php';
require_once "admin/www.functions.php";

$fields=0;
if(!empty($_POST['email'])){$email=$_POST['email'];$email and $fields++;}else{$email='';}
if(!empty($_POST['password'])){$password=$_POST['password'];$password and $fields++;}else{$password='';}

if($fields == 2){

$link=mysqli_connect($db_host, $db_user, $db_password, $db_main) or die('Server down please come back later.');


$password=crypt($password,$email);
$link=mysqli_connect($db_host,$db_user,$db_password);
mysqli_select_db($db_main,$link);

if($result=mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE email='$email' and password='$password' LIMIT 1")){
if($row=mysqli_fetch_object($result)){
mysqli_free_result($result);

if($row->email == $email and $row->password == $password){
$sid=md5($current_time.crypt($row->email));
mysqli_query ($link, "UPDATE `$tbl_members` SET sid='$sid' WHERE id=$row->id LIMIT 1");
$fields++;

}
}
}

mysqli_close($link);
}

if($fields==3 and !empty($sid)){

header("Location: $root_url/main.php?sid=$sid");
exit;

}else{
include_once 'templates/template.header.php';
?>

<form method=post target="_top">
<table>
<tr>
<th colspan=2>
Personal Account information
</th>
</tr>
<tr>
<td width=50%>
Email<br>
</td>
<td>
<input type=text name=email maxlength=32>
</td>
</tr>
<tr>
<td width=50%>
Password
</td>
<td>
<input type=password name=password maxlength=16>
</td>
</tr>
<tr>
<th colspan=2>
<input type=submit name=action value="Enter the battlefields!">
</th>
</tr>
</table>
</form>

<b><a href="retrieve.php" target="_top">Forgot your password?</a></b><br>
<?php
include_once 'templates/template.footer.php';
}
?>