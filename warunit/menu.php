<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.functions.php';
include_once('templates/clean.header.php');
?>
<a href="main.php?sid=<?echo $sid;?>" target="war_main">Main</a><br>
<a href="buildings.php?sid=<?echo $sid;?>" target="war_main">Buildings</a><br>
<a href="population.php?sid=<?echo $sid;?>" target="war_main">Population</a><br>
<a href="war.php?sid=<?echo $sid;?>" target="war_main">War</a><br>
<a href="ladder.php?sid=<?echo $sid;?>" target="war_main">Ladder</a><br>
<?php
include_once('templates/clean.footer.php');
?>