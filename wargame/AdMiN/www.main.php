<?php
#!/usr/local/bin/php

$title='WAR GAME';

$current_time=time();
$current_date = date('d M Y');

$html_header='AdMiN/templates.header.php';
$html_footer='AdMiN/templates.footer.php';

$inc_functions = 'AdMiN/www.functions.php';
$inc_mysql = 'AdMiN/www.mysql.php';
$inc_arrays = 'AdMiN/www.arrays.php';

$maximus = 19; //max 19
$resource_production = 1;
$production = 1;
$refresh_timer = 0;
$attack_time=100;
?>