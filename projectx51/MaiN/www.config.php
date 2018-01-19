<?php
#!/usr/local/bin/php
$db_host = 'localhost';
$db_main = 'projectx5';
$db_user = 'root';
$db_password = '123';

$tbl_members = 'lol_members';
$tbl_location = 'lol_location';
$tbl_messages='lol_messages';

$current_time=time();
$current_date = date('d M Y');


$production = 0.1;
$cost_explore = 1;
$cost_settle = 1000;
$cost_upgrade = 3000;
$cost_attack = 5000;
/*
x0 = settlements
x1 = upgrades
x2 = radius
x3 = attack damage
x4 = total_settlements destroyed
x5 = total_upgrades destroyed
x10 - x19 = weapons

*/
?>
