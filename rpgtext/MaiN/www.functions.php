<?php
#!/usr/local/bin/php
/*
Script name	: Functions
Version		: 3.00
Release date	: 19-12-2001 2:05
Last Update	: 03-11-07 03:00
Email		: admin@thesilent.com
Homepage	: http://www.thesilent.com
Created by	: TheSilent
Last modified by	: TheSilent
*/
/*_______________-=TheSilenT.CoM=-_________________*/
$search=array("'fuck'i","'nigger'i","'vagina'i","'pussy'i","'penis'i");
$replace=array("","","","","","","","","","",);

function clean_post($in){
	global $search,$replace;
$in=preg_replace($search,$replace,$in);
$in=htmlentities($in,ENT_QUOTES);
$in=strip_tags($in);
$in=trim($in);
$in=addslashes($in);
return $in;
}

function clean_input($in){
	global $search,$replace;
$in=preg_replace($search,$replace,$in);
$in=strip_tags($in);
$in=trim($in);
$in=addslashes($in);
if(ctype_alnum($in) and strlen($in)>=4){
return $in;
}else{
$in=NULL; return $in;
}
}
/*_______________-=TheSilenT.CoM=-_________________*/
function next_level($in) { return ((($in/10)*500)+$in)*($in*$in)+449;}
/*_______________-=TheSilenT.CoM=-_________________*/
function prev_level($in) { return (((($in-1)/10)*500)+($in-1))*(($in-1)*($in-1))+449;}
/*_______________-=TheSilenT.CoM=-_________________*/
function news_paper($player,$in,$headline) {
	global $tbl_paper;
/*
NID USED
1 = main
2 = healer
3 =
4 = kingdom
5 = bank
6 = monster scars
7 = charms sell
8 = shop sell
9 = tower sell
chat uses board
*/
if($tresult = mysqli_query ($link, "SELECT * FROM `$tbl_paper` WHERE `nid`='$in' && (`charname`='$player' or `charname`='') ORDER BY `id` DESC LIMIT 25")) {
if(mysqli_num_rows($tresult) >= 1) {
?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th><?php print $headline;?></th></tr><tr><td><font size=-1><?php
while($trow = mysqli_fetch_object ($tresult)){
	if($in == 6){
print $trow->news;
	}else{
print $trow->date.' '.$trow->news.'<br>';
	}
}
mysqli_free_result ($tresult);
?></font></td></tr></table><?php
}
}
}
/*_______________-=TheSilenT.CoM=-_________________*/

$sap 		= array ('+','-','*','/');

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

/*_______________-=TheSilenT.CoM=-_________________*/
function die_nice($in) {
print '<table width=100% cellpadding=0 cellspacing=1 border=0 align=center height=100%><tr><td align=center valign=center>'.$in.'<br>Problems with login? Try logout!<br>';
if (!empty($_COOKIE)){
foreach ($_COOKIE as $key=>$val){print 'Cookies '.$key.' '.$val.'<br>';}
}
print '<form method=post action="index.php"><input type=submit value="Home" style="width:150;height:50;"></form><form method=post action="logout.php"><input type=submit value="Logout" style="width:150;height:50;"></form></td></tr></table></center></body></html>';
exit;
}
?>