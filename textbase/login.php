<?
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once('AdMiN/www.mysql.php');
require_once('AdMiN/www.functions.php');

if(!empty($_POST['action'])){

if(empty($_POST['username']) or empty($_POST['password'])){
include_once("$html_header");
?>Login failed make sure that your username and password are case correct!.<br><?
login_form();
include_once("$html_footer");
exit;
}else{
$username=$_POST['username'];
$password=$_POST['password'];
 //start login process and connect to mysql

$link=mysql_connect($db_host, $db_user, $db_password) or print("Unable to connect to database");
mysql_select_db("$db_main",$link) or print( "Unable to select database");
$query = "select * from $tbl_members where(username='$username') order by id desc";
$result = mysql_query($query) or die("Query failed");
$row = mysql_fetch_object($result) or die("Query failed 1");
mysql_free_result($result);

$password=crypt($password,$row->username);
if($row->password == $password and $username == $row->username){
$sid=lottery_ticket();
mysql_query("update $tbl_members SET sid='$sid', onoff=1, timer=$current_timer where id=$row->id limit 1") or die("update failed 1".mysql_error());
mysql_close($link);
}else{
mysql_query("update $tbl_members SET loginfail=loginfail+1 where id=$row->id limit 1") or die("update failed 2");
mysql_close($link);

include_once("$html_header");
?>Login failed make sure that your username and password are case correct!..<br><?
login_form();
include_once("$html_footer");
exit;
}

?>
<html><head><title><? echo $title; ?> Default</title></head>
<frameset cols="*,200" border=0 bordercolor="#000000" framespacing=0 frameborder=0 noborder>
<frame name="lol_main" src="<? echo $root_url; ?>/stats.php?sid=<?echo $sid;?>" scrolling=auto noborder>
<frame name="lol_side" src="<? echo $root_url; ?>/menu.php?sid=<?echo $sid;?>" scrolling=no noborder>
</frameset>
<noframes>
<BODY>
This site uses frames. Please get a browser that supports frames.
</BODY>
</noframes>
</html>
<?

}

}else{
include_once("$html_header");
login_form();
?>
<b><a href="retrieve.php">Forget your password?</a></b><br>

<?
include_once("$html_footer");
}

function login_form(){
global $lol;
?>
<form method=post enctype="application/x-www-form-urlencoded" target="_top">
<table border=0 cellpadding=2 cellspacing=2 width="50%">
<tr>
<th colspan=2>Account Information</th>
</tr>
<tr>
<td width="50%">username</td><td width="50%"><input type=text size=25 name="username" maxlength=10></td>
</tr>
<tr>
<td>password</td><td><input type=password size=25 name="password" maxlength=50> </td>
</tr>
<tr>
<th colspan=2> <input type=submit value="Enter Lol!" Submit name=action></th>
</tr>
</table>
</form>
<?
}
?>