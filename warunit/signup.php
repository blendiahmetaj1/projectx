<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/array.races.php';
require_once 'admin/www.functions.php';
include_once 'templates/template.header.php';

$sap 		= array ('+','-','*','/');
$fields=0;

function get_sap() {
global $sap;
$sapa = rand(1,9);
$sapb = $sap[array_rand ($sap, 1)];
$sapc = rand(1,9);
if ($sapa<=$sapc) {$sapa=$sapc+1;}
if ($sapb == '/') {$sapa*=2;$sapc=2;}
return array($sapa,"$sapb",$sapc);
}


function sap_me($asap,$isap) {
eregi ("(.*) (.*) (.*)", $asap, $sapi);
//print "$asap | $isap | $sapi[1] | $sapi[2] | $sapi[3] ";
if ($isap ==($sapi[1]+$sapi[3]) and $sapi[2] == '+') {
return ('OKE');
} elseif ($isap ==($sapi[1]-$sapi[3]) and $sapi[2] == '-') {
return ('OKE');
} elseif ($isap ==($sapi[1]*$sapi[3]) and $sapi[2] == '*') {
return ('OKE');
} elseif ($isap ==($sapi[1]/$sapi[3]) and $sapi[2] == '/') {
return ('OKE');
}
}

if(!empty($_POST['asap'])){$asap=clean_post($_POST['asap']);}else{$asap='';}
if(!empty($_POST['isap'])){$isap=clean_post($_POST['isap']);$fields++;}else{$isap='';}


if (!empty($_POST['email']) and !empty($_POST['password']) and !empty($_POST['repassword']) and !empty($_POST['charname']) and !empty($_POST['race']) and !empty($_POST['asap']) and !empty($_POST['isap'])) {

$saping = sap_me($asap,$isap);
if ($saping == 'OKE') {
if ($_POST['timer'] > $current_time) {

$email=$_POST['email'];
$password=clean_input($_POST['password']);
$repassword=clean_input($_POST['repassword']);
$charname=clean_input($_POST['charname']);
$race=clean_input($_POST['race']);
$sex='Private';


preg_match("/.+@.+\..+/", "$email") and $fields++;
$password and $fields++;
$charname and $fields++;

if ($fields == 3) {
 //detect same fields
$same_fields='';
if ($email == $password) {
$same_fields="$same_fields Email matches password<br>";$fields=0;
}
if ($email == strtolower($charname)) {
$same_fields="$same_fields Email matches charname<br>";$fields=0;
}
if (strtolower($charname) == $password) {
$same_fields="$same_fields charname matches password<br>";$fields=0;
}

if (!empty($same_fields)) {
print<<<EOT
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

if ($fields >= 3) {
$password=crypt($password,$email);
$sid=md5($current_time.crypt($email));
$value = "NULL,'$sid','$email','$password','1','$race','','$sex','$charname','1000000','100','200','10','10','10','10','10','5','5','5','5','5','1','1','1','1','1','0','0','0','0','0','0','$current_time'";

//mysqli_query ($link, "UPDATE `$tbl_members` SET `land`=1000,`gold`=1000000,b1=10,b2=10,b3=10,b4=10,b5=10,u1=5,u2=5,u3=5,u4=5,u5=5 WHERE id") or die(mysqli_error());

$link=mysqli_connect($db_host, $db_user, $db_password) or die('Server down please come back later.');
mysqli_select_db($db_main, $link) or die('Server down please come back later.');


mysqli_query ($link, "INSERT INTO `$tbl_members` ($fld_members) values ($value)")
 and
 $preparing="prepared"
 or
 print("Sorry the Email, Password or charname is already taken please choose another one.". mysqli_error());

mysqli_close($link);

if (isset($preparing) and !empty($preparing)) {
 if ($preparing == "prepared") {

print '<table><tr><td>
Hi <b>'.$sex.' '.$charname.'</b>,<br>
<br>
Your account has been created successfully.<br>
<br>
Good luck and above all have fun!<br>
<br>
Cheers,<br>'.$admin_name.'<br>
<br>
<br>
<a href="main.php?sid='.$sid.'">Click here to start playing!</a>
</td></tr></table>';

}else{ print("Sorry the Email, Password or charname is already taken please choose another one.");}
}else{ print("Sorry the Email, Password or charname is already taken please choose another one.");}


} else {?>Some fields are missing or incorrect, please go back with your browser try again.<?php}
} else {?>Signup timed out because you took longer than 300 seconds to signup, please try again.<?php}
} else {print "Your statement of <b>$asap = $isap</b> is not correct.";}
} else {
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
Email
<br><font size=1>maxlength is 32 chars, minimum of 4 chars
</td>
<td>
<input type=text name=email maxlength=32>
</td>
</tr>
<tr>
<td width=50%>
Password
<br><font size=1>maxlength is 16 chars, minimum of 4 chars
</td>
<td>
<input type=password name=password maxlength=16>
</td>
</tr>
<tr>
<td width=50%>
Confirm Password
<br><font size=1>maxlength is 16 chars, minimum of 4 chars
</td>
<td>
<input type=password name=repassword maxlength=16>
</td>
</tr>
<tr>
<th colspan=2>
Game Account information
</th>
</tr>

<?php
$options='';
$snapnie='';
foreach ($races_array as $key=>$val){
$options .= '<option>'.$key.'</option>';
$snapnie .= $key.'+'.$val[0].'% income, '.'+'.$val[1].'% offense, '.'+'.$val[2].'% defense<br>';
}
?>

<tr>
<td width=50%>
Race<br><font size=-2>
<?php print $snapnie;?></font>
</td>
<td>
<select name=race>
<?php print $options;?>
</select>
</td>
</tr>

<tr>
<td width=50%>
Charname
<br><font size=1>maxlength is 16 chars, minimum of 4 chars
</td>
<td>
<input type=text name=charname maxlength=16>
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
<input type=hidden name=asap value="<?php print "$sapa $sapb $sapc"; ?>">
How much is <b><?php print "$sapa$sapb$sapc"; ?></b>?
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
<input type=hidden name=timer value="<?php echo ($current_time+300); ?>">
</form>
<?php
}

include_once 'templates/template.footer.php';
?>