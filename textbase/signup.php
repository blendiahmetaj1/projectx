<?
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once 'AdMiN/array.races.php';
require_once "AdMiN/www.functions.php";
include_once("$html_header");

if(!empty($_POST['action']) and !empty($_POST['timer']) and !empty($_POST['username']) and !empty($_POST['password']) and !empty($_POST['charname']) and !empty($_POST['sex']) and !empty($_POST['asap']) and isset($_POST['isap'])){

$fields=0;

if(empty($_POST['username'])){
 $username="";
}else{
 $username=clean_input($_POST['username']);
 $username and $fields++;
}

if(empty($_POST['password'])){
 $password="";
}else{
 $password=clean_input($_POST['password']);
 $password and $fields++;
}

if(empty($_POST['email'])){
 $email="";
}else{
 $email=$_POST['email'];
 $email and $fields++;
}

if(empty($_POST['sex'])){
 $sex="";
}else{
 $sex=clean_input($_POST['sex']);
 $sex and $fields++;
}

if(empty($_POST['charname'])){
 $charname="";
}else{
 $charname=strtolower($_POST['charname']);
 $charname=ucfirst($charname);
 $charname=clean_input($charname);
 $charname and $fields++;
}

if(empty($_POST['race'])){
 $race="";
}else{
 $race=$_POST['race'];
 $races_key=array_keys($races_array);
 if(in_array($race,$races_key)){ $fields++; }
}
if($fields==6){
 //detect same fields
$same_fields="";
if($username == $password){
$same_fields="$same_fields username matches password<br>";$fields=0;
}
if($username == strtolower($charname)){
$same_fields="$same_fields username matches charname<br>";$fields=0;
}
if(strtolower($charname) == $password){
$same_fields="$same_fields charname matches password<br>";$fields=0;
}

if(!empty($same_fields)){
echo<<<EOT
<font color=#FF0000><b>
WARNING : $same_fields
<br>
Account signup aborted!
<br>
</b></font>
EOT;
}
 //detect same fields
}
if($fields >= 6){
 //SAP
$saping = sap_me($_POST['asap'],$_POST['isap']);
if($saping == 'OKE'){
 if($_POST['timer'] > $current_timer){
require_once "./AdMiN/www.mysql.php";
$link=mysql_connect($db_host, $db_user, $db_password);
mysql_select_db("$db_main",$link);

 //CHECKING FOR A friend
if(empty($_POST['friend'])){
$friend='';
}else{
$query = "select * from $tbl_members where(charname='".$_POST['friend']."') order by id desc limit 1";
$result = mysql_query($query) or die("Query failed 33");
if(!empty($result)){
$prow = mysql_fetch_object($result);
mysql_free_result($result);
 $my_ip=$_SERVER['REMOTE_ADDR'];
 $prow->ip=preg_replace("/(\d+)\.(\d+)\.(\d+)\.(\d+)/i","\${1}\${2}\${3}",$prow->ip);
 $my_ip=preg_replace("/(\d+)\.(\d+)\.(\d+)\.(\d+)/i","\${1}\${2}\${3}",$my_ip);
 if($prow->ip !== $my_ip){
 $friend=$prow->charname;
 }else{
 $friend='';
 }
 //echo $my_ip == $prow->ip == $my_ip == $friend == ".$_POST['friend'];
}else{
$friend='';
}
}
 //CHECKING FOR A friend

$password=crypt($password,$username);
$sid=lottery_ticket();
$value = "
'','$sid','$username','$password','$email','','$sex','$charname','$race',
1,50,250,100,25,15,10,25,15,10,
1,1,1,1,1,1,1,1,1,1,1,1,
0,
0,
0,
0,
1000,
0,0,
$current_timer,
0,0,
'$friend',
'$my_ip'
";

mysql_query("INSERT INTO $tbl_members($fld_members) values($value)")
 and
 $preparing="prepared"
 or
 print("Sorry your chosen username '$username' or charname '$charname' is already taken please choose another one.".mysql_error());
if(isset($preparing) and !empty($preparing)){
 if($preparing == "prepared"){
$history="'', '$charname', '0', '0', '0', '0', '0'";
mysql_query("INSERT INTO $tbl_history($fld_history) values($history)");
 print("<table><tr><td>
 Hi <b>$sex $charname</b>,<br>
 <br>
 Your account has been created successfully.<br>
 ATTENTION : Your account details could have changed a little.<br>
 Account details :<br>
 username : <b>$username</b><br>
 password : <b>**********</b><br>
 sex : <b>$sex</b><br>
 charname : <b>$charname</b><br>
 race : <b>$race</b><br>
 <br>
 If you forget your username or password fast, then you can give up an email address for username and password retrieval in the game.<br>
 After you have logged in go to preferences to add and change your site and account details.<br>
 <br>
 Good luck!.<br>
 Cheers,<br>$admin_name<br>
 $my_ip
 </td></tr></table>");
 }
}
mysql_close($link);
}else{
?>Signup timerd out because you took longer than 300 seconds to signup, please try again.<?
}
}else{
echo "Your statement of <b>$asap = $isap</b> is not correct.";
}
}else{
?>Some fields are missing or incorrect, please go back with your browser try again.<?echo $fields;
}
}else{
?>
<b>You must use only letters and numbers with a minimum of four characters.</b>
<form method=post target="_top">
<input type=hidden name=timer value="<? echo($current_timer+300); ?>">
<? if(!empty($_GET['friend'])){ ?><input type=hidden name=friend value="<? echo $_GET['friend']; ?>"><?}?>
<table cellpadding=2 cellspacing=2 border=0>
<tr>
<th colspan=2>
Personal Account Information
</th>
</tr>
<tr>
<td width=50%>
username
<br><font size=1>maxlength is 10 chars, minimum of 4 chars
</td>
<td>
<input type=text name=username maxlength=10>
</td>
</tr>
<tr>
<td width=50%>
password
<br><font size=1>maxlength is 10 chars, minimum of 4 chars
</td>
<td>
<input type=password name=password maxlength=10>
</td>
</tr>
<tr>
<td width=50%>
email
<br><font size=1>maxlength is 50 chars, minimum of 1 chars
</td>
<td>
<input type=text name=email maxlength=50>
</td>
</tr>
<tr>
<th colspan=2>
Game Account Information
</th>
</tr>
<tr>
<td width=50%>
sex
</td>
<td>
<select name=sex>
<option>Lord</option>
<option>Lady</option>
</select>
</td>
</tr>
<tr>
<td width=50%>
charname
<br><font size=1>maxlength is 10 chars, minimum of 4 chars
</td>
<td>
<input type=text name=charname value="" maxlength=10>
</td>
</tr>
<tr>
<td valign=top>
race
<br><font size=1>select a race
</td><td>
<select name=race>
<?
$i=0;
foreach($races_array as $key=>$val){
if($key == 'Human'){
echo "<option selected>".ucfirst($key)."</option>";
}else{
echo "<option>".ucfirst($key)."</option>";
}
}
?>
</select>
</td>
</tr>
<tr>
<th colspan=2>
Simple Automatism Protection
</th>
</tr>
<tr>
<td width=50%>
<?
list($sapa,$sapb,$sapc) = get_sap();
?>
<input type=hidden name=asap value="<? echo "$sapa $sapb $sapc"; ?>">
How much is <b><? echo "$sapa$sapb$sapc"; ?></b>?
<br><font size=1>too difficult? refresh page try again
</td>
<td>
<input type=text name=isap value="">
</td>
</tr>
<tr>
<th colspan=2 align=center>
<input type=submit name=action value="Signup now">
</th>
</tr>
</table>
</form>
<?
}
include_once("$html_footer");
?>
