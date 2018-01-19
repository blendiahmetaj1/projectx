<?php
#!/usr/local/bin/php

function clean_form($in){
	$in=htmlentities($in,ENT_QUOTES);
	$in=strip_tags($in);
	$in=trim($in);
	$in=addslashes($in);
	return $in;
}
?>