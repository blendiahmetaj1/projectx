<?php
#!/usr/local/bin/php

$root_url = "http://thesilent.com/warunit";

$path_images = 'images';

$admin_name = 'Admin SilenT';
$admin_email = 'admin@thesilent.com';

$title = 'warunit';
$title_info = 'Free Online Browser Text-Based Multiplayer War Game v 0.35';

$current_minute =date('i');
$current_hour =date('H');
$current_day =date('d');
$current_month =date('M');
$current_year =date('Y');
$current_date =date('d M H:i');
$current_time =time();

$ticket_tdraw =600;
$attack_time =600;

$reward_kill=250;

$play_percentage =75;

$server = 'warunit';
$paypal_email = 'paypal@thesilent.com';

$ip=$_SERVER['REMOTE_ADDR'];
$chat_timer=25;
?>