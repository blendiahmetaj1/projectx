<?php
#!/usr/local/bin/php
require_once 'MaiN/array.classes.php';

require_once 'MaiN/www.functions.php';
require_once 'MaiN/www.main.php';
require_once 'MaiN/www.mysql.php';
require_once 'MaiN/site.header.php';

//foreach($_POST as $key=>$val){echo $key.' '.$val.'<br>';}

if(!empty($_SERVER['REMOTE_ADDR'])){
$player_ip = $_SERVER['REMOTE_ADDR'];
}else{
$player_ip = 'NOIP';
}

$action='';
if (!empty($_POST['action'])) {
$action=$_POST['action'];
}
$username='';
if (!empty($_POST['username'])) {
$username=$_POST['username'];
}
$password='';
if (!empty($_POST['password'])) {
$password=$_POST['password'];
}
$charname='';
if (!empty($_POST['charname'])) {
$charname=$_POST['charname'];
}
$sex='';
if (!empty($_POST['sex'])) {
$sex=$_POST['sex'];
}
$class='';
if (!empty($_POST['class'])) {
$class=$_POST['class'];
}
$asap='';
if (!empty($_POST['asap'])) {
$asap=$_POST['asap'];
}
$isap='';
if (!empty($_POST['isap'])) {
$isap=$_POST['isap'];
}

if (!empty($username) and !empty($password) and !empty($charname)) {
$fields=0;

if (empty($username)) {
	$username="";
} else {
	$username=clean_input($username);
	$username and $fields++;
}

if (empty($password)) {
	$password="";
} else {
	$password=clean_input($password);
	$password and $fields++;
}

if (empty($sex)) {
	$sex="";
} else {
	$sex=clean_input($sex);
	$sex and $fields++;
}

if (empty($charname)) {
	$charname="";
} else {
	$charname=strtolower($charname);
	$charname=ucfirst($charname);
	$charname=clean_input($charname);
	$charname and $fields++;
}

if (empty($class)) {
	$class="";
} else {
	$class=clean_input($class);
	$class=strtolower($class);
	$class and $fields++;
}

if ($fields==5) {
	//detect same fields
$same_fields="";
if ($username == $password) {
$same_fields="$same_fields Username matches Password<br>";$fields=0;
}
if ($username == strtolower($charname)) {
$same_fields="$same_fields Username matches Charname<br>";$fields=0;
}
if (strtolower($charname) == $password) {
$same_fields="$same_fields Charname matches Password<br>";$fields=0;
}

if (!empty($same_fields)) {
print '
<font color=#FF0000><b>
WARNING : '.$same_fields.'
<br>
Account signup aborted!
<br>
</b></font>
';
}
	//detect same fields
}

//echo $fields;
if ($fields >= 5) {
	//SAP
$saping = sap_me($_POST['asap'],$_POST['isap']);
if ($saping == 'OKE') {
	if ($_POST['timer'] > $current_time) {

$password=crypt($password,$username);
$value="
'',
'$username',
'$password',
'',
'$sex',
'$charname',
'$class',

'1','250','5000','100000','1',
'1000','250','250',
'5','1','1',

'25','15','10',
'25','15','10',
'0','0','0',
'5',
'".rand(1,5)."','".rand(1,5)."',
'0','','0','0','0',
'2','0','$current_time'
";

$link = mysqli_connect($db_host, $db_user, $db_password) or die_nice(mysqli_error());
mysqli_select_db($db_main, $link) or die_nice(mysqli_error());

mysqli_query ($link, "INSERT INTO $tbl_members values ($value)")
	and
	$preparing="prepared"
	or
	print("Sorry the Username, Password or Charname is already taken please choose another one.");
if (isset($preparing) and !empty($preparing)) {
	if ($preparing == "prepared") {
	print ("<table><tr><td>
	Hi <b>$sex $charname</b>,<br>
	<br>
	Your account has been created successfully.<br>
	Account details :<br>
	Username : <b>$username</b><br>
	Password : <b>**********</b><br>
	Sex : <b>$sex</b><br>
	Charname : <b>$charname</b><br>
	Class : <b>$class</b><br>
	<br>
	Good luck!.<br>
	Cheers,<br>$admin_name<br>
	$player_ip
	</td></tr></table>");

if($result = mysqli_query ($link, "SELECT * FROM $tbl_members WHERE username='$username' and charname='$charname' ORDER BY id DESC LIMIT 1")){
if(mysqli_num_rows($result) >= 1) {
if($row = mysqli_fetch_object ($result)){
mysqli_free_result ($result);
$val_item = "'', '$row->charname', '1', '$row->charname siGn', 'unique', 'cape', '10', '10', '9', '1', '0', '0', '10', '25', '0', '48', '49', '50', '58', '".rand(1,55)."', '0', '0', '0', '$current_time'";
mysqli_query ($link, "INSERT INTO $tbl_inventory values ($val_item)") or die_nice(mysqli_error().'signup drop item.');
$val_item = "'', '$row->charname', '1', '$row->charname siGn', 'unique', 'weapon', '10', '10', '9', '1', '0', '0', '10', '25', '0', '1', '2', '3', '4', '".rand(1,55)."', '5', '6', '7', '$current_time'";
mysqli_query ($link, "INSERT INTO $tbl_inventory values ($val_item)") or die_nice(mysqli_error().'signup drop item.');
$val_item = "'', '$row->charname', '1', '$row->charname siGn', 'unique', 'ring', '10', '10', '9', '1', '0', '0', '10', '25', '0', '26', '27', '28', '14', '".rand(1,55)."', '15', '16', '17', '$current_time'";
mysqli_query ($link, "INSERT INTO $tbl_inventory values ($val_item)") or die_nice(mysqli_error().'signup drop item.');
for($i=1;$i<5;$i++){
$monste_val = "'', '".($row->x-$i)."', '$row->y', '$i', '50', '".($i*3)."', '".($i*3)."','','1','$current_time'";
mysqli_query ($link, "INSERT INTO $tbl_fight values ($monste_val)") or die_nice(mysqli_error().'signup Monster generator');
}

?><h1>HAVE FUN!</1><?php
}else{die_nice(mysqli_error().'signup fetch object');}
}else{die_nice(mysqli_error().'signup fetch row');}
}else{die_nice(mysqli_error().'signup query');}
	}
}

mysqli_close ($link);
} else {
?>Signup timed out because you took longer than 300 seconds to signup, please try again.<?php
}
} else {
echo "Your statement of <b>$asap = $isap</b> is not correct.";
?><?php
}
} else {
?>
Some fields are missing or incorrect, please go back with your browser try again.
<?php
}
?><br><form method=post target="_top" action="index.php"><input type=submit name=home value="Home" style="width:150;height:50;"></form><?php
} else {
?>
<form method=post target="_top">
<input type=hidden name=signup value=1>
<input type=hidden name=timer value="<?php echo ($current_time+300); ?>">
<table>
<tr>
<th colspan=2>
Personal Account information
</th>
</tr>
<tr>
<td width=50% valign=top>
Username
</td>
<td valign=top>
<input type=text name=username maxlength=10>
</td>
</tr>
<tr>
<td width=50% valign=top>
Password</td>
<td valign=top>
<input type=password name=password maxlength=10>
</td>
</tr>
<tr>
<th colspan=2>
Game Account information
</th>
</tr>
<tr>
<td width=50% valign=top>
Sex
</td>
<td>
<select name=sex>
<option>Lord</option>
<option>Lady</option>
</select>
</td>
</tr>
<tr>
<td width=50% valign=top>
Charname

</td>
<td valign=top>
<input type=text name=charname value="" maxlength=10>
</td>
</tr>
<tr>
<td valign=top>
Class
</td><td>
<select name=class>
<?php
foreach ($array_classes as $key=>$val) {
print '<option value="'.$key.'">'.$key.'</option>';
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
<?php
list ($sapa,$sapb,$sapc) = get_sap();
?>
<input type=hidden name=asap value="<?php echo "$sapa $sapb $sapc"; ?>">
How much is <b><?php echo "$sapa$sapb$sapc"; ?></b>?
<br><font size=1>too difficult? refresh page try again
</td>
<td>
<input type=text name=isap value="">
</td>
</tr>
<tr>
<tr>
<td colspan=2 align=center>
<input type=submit name=signup value="Sign Up Now" style="width:150;height:50;">
</td>
</tr>
</table>
</form>
<font size=-2>maxlength is 10 chars, minimum of 4 chars, alpha numeric only!</font><br>
<?php
}

require_once 'MaiN/site.footer.php';
?>