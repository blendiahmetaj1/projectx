<?
#!/usr/local/bin/php
$finder = array(
"'>'i","'<'i","'='i",
"'fuck'i","'script'i","'ass'i",
"'nigger'i","'retard'i",
"'asshole'i","'bastard'i",
"'penis'i","'dick'i",
);


$replacer = array(
"","","",
"","","",
"","",
"","",
);

function clean_post($in){
global $finder,$replacer;
$in=preg_replace($finder, $replacer, $in);
$in=strip_tags($in);
$in=trim($in);
$in=addslashes($in);
return $in;
}

function clean_input($in){
global $finder,$replacer;
$in=preg_replace($finder, $replacer, $in);
$in=strip_tags($in);
$in=htmlentities("$in", ENT_QUOTES);
$in=htmlspecialchars("$in", ENT_QUOTES);
$in=trim($in);
$in=addslashes($in);
if(preg_match("/^[a-z0-9]*$/i", "$in") and strlen($in) >= 4){
return $in;
}else{
$in=NULL; return $in;
}
}

function get_sap(){
global $sap;
$sapa = rand(1,9);
$sapb = $sap[array_rand($sap, 1)];
$sapc = rand(1,9);
if($sapa<=$sapc){$sapa=$sapc+1;}
if($sapb == '/'){$sapa*=2;$sapc=2;}
return array($sapa,"$sapb",$sapc);
}

function sap_me($asap,$isap){
eregi("(.*) (.*) (.*)", $asap, $sapi);
//echo "$asap | $isap | $sapi[1] | $sapi[2] | $sapi[3] ";
if($isap ==($sapi[1]+$sapi[3]) and $sapi[2] == '+'){
return('OKE');
}elseif($isap ==($sapi[1]-$sapi[3]) and $sapi[2] == '-'){
return('OKE');
}elseif($isap ==($sapi[1]*$sapi[3]) and $sapi[2] == '*'){
return('OKE');
}elseif($isap ==($sapi[1]/$sapi[3]) and $sapi[2] == '/'){
return('OKE');
}
}


function lottery_ticket(){
$strings = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9);
srand((float) microtime() * 10000000);
$rstr=array_rand($strings,20);
return($strings[$rstr[1]].$strings[$rstr[2]].$strings[$rstr[3]].$strings[$rstr[4]].$strings[$rstr[5]].$strings[$rstr[6]].$strings[$rstr[7]].$strings[$rstr[8]].$strings[$rstr[9]].$strings[$rstr[10]].$strings[$rstr[11]].$strings[$rstr[12]].$strings[$rstr[13]].$strings[$rstr[14]].$strings[$rstr[15]].$strings[$rstr[16]]);
}
?>