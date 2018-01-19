<?php
#!/usr/local/bin/php
require_once 'MaiN/www.main.php';
require_once 'MaiN/site.header.php';

require_once 'MaiN/www.mysql.php';

require_once 'MaiN/www.itemstats.php';
require_once 'MaiN/array.attributes.php';
$row->level = 1000;
$row->strength = 1000;
$row->intelligence = 1000;

?><table width=100%><tr><th>Lastest items obtained in the game.</th></tr><?php
$link = mysqli_connect($db_host, $db_user, $db_password) or die_nice(mysqli_error());
mysqli_select_db($db_main, $link) or die_nice(mysqli_error());

if($sres = mysqli_query ($link, "SELECT * FROM `$tbl_inventory` WHERE (`id` and `charname`) ORDER BY `id` DESC LIMIT 250")){
$i=1;
while($srow = mysqli_fetch_object ($sres)) {
	
	print '<tr><th><b>Player '.$srow->charname.' Found<b></th></tr><tr><td><br>';
	inv_prop($srow->id);
	print '</td></tr>';

$i++;	
}//while

mysqli_free_result ($sres);
}

mysqli_close($link);
?></table><?php
require_once 'MaiN/site.footer.php';
?>