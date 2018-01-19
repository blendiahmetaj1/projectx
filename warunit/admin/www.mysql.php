<?php
#!/usr/local/bin/php
$db_main = 'warunit';
$db_host ='localhost';
$db_user ='root';
$db_password ='123';

$tbl_board='war_board';
$tbl_credits = 'war_credits';
$tbl_messages = 'war_messages';
$tbl_paypal='war_paypal';
$tbl_kills = 'war_kills';
$tbl_members = 'war_members';
$tbl_news = 'war_news';
$tbl_updater = 'war_updater';


$table_names=array(
$tbl_board,
$tbl_credits,
$tbl_messages,
$tbl_paypal,
$tbl_kills,
$tbl_members,
$tbl_news,
$tbl_updater,
);

$fld_board='`id`,`star`,`clan`,`sex`,`charname`,`race`,`level`,`message`,`ip`,`timer`';
$fld_credits = 'id,username,charname,credits';
$fld_messages = 'id,charname,receiver,message,timer';
$fld_paypal='`id`,`server`,`amount`,`day`,`month`,`year`,`ip`';
$fld_kills = 'id,charname,killed,timer';
$fld_members = 'id, sid, email,password, rank, race, clan, sex,charname, gold, land, stealth, b1,b2,b3,b4,b5,u1,u2,u3,u4,u5,s1,s2,s3,s4,s5,sb1,sb2,sb3,tsb1,tsb2,tsb3,timer';
$fld_news = 'id,charname,content,timer';
$fld_updater = 'id,hour,minutes,updated';
?>