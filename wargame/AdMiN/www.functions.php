<?php
#!/usr/local/bin/php

function clean_post($in){
$in=htmlentities("$in",ENT_QUOTES);
$in=strip_tags($in);
$in=trim($in);
$in=addslashes($in);
return $in;
}


function build_time($i) {
	global $row;
	return (100+((1+$row->{"pb$i"})*(100*$row->{"b$i"}+$i+($i*$i*$i))));
}


function build_cost($i) {
	global $row;
	return (100+((1+$row->{"pb$i"})*(100+(30*(1+$i))*((1+$row->{"b$i"})*(1+$row->{"b$i"})*(1+($i*$i))))));
	//return floor(($row->{"b$i"}+50)*pow(1.5, $row->{"b$i"}-1));
}



function jrefresh($secs,$name) {
echo<<<EOT
<script>
<!--
var milisec=9
var seconds=$secs
document.f$name.s$name.value='0'

function countdown() {
if (milisec<=0){
milisec=9
seconds-=1
} else
milisec-=1
document.f$name.s$name.value=seconds+"."+milisec
setTimeout("countdown()",100)
}

countdown()
//-->
</script>
EOT;
}
?>