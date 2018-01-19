<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.functions.php';
require_once 'admin/www.header.php';

$game='';
if (!empty($_GET['game'])) {
$game	= clean_form($_GET['game']);
}

if (!empty($row->id)) {
if ($gresult = mysqli_query ($link, "SELECT * FROM `$tbl_scores` WHERE (`pid`='$row->id' and `times`<='8') ORDER BY `id` DESC LIMIT 10")) {
if ($grow = mysqli_fetch_object ($gresult)){
mysqli_free_result ($gresult);

if ($row->id == $grow->pid) {

if (!empty($_POST['play'])) {
$play	= clean_form($_POST['play']);

//PLAY GAME
if ($game == 1) {
$score = rand(1,6);
} elseif ($game == 2) {
$score = rand(1,13);
}
//PLAY GAME

mysqli_query ($link, "UPDATE `$tbl_scores` SET `times`=`times`+'1', `score`=`score`+'$score' WHERE `id`='$grow->id' LIMIT 1");
}

	print 'Playing game: '.$grow->gid.'<br>Play times: '.number_format($grow->times).'<br>Score: '.number_format($grow->score+$score).'<br>';
}

}else{
mysqli_query ($link, "INSERT INTO `$tbl_scores` values ('','$row->id','$game','0','0','$current_time')");
}
}
}

?>
<form method="POST">
<input type=submit name=play value="Play Game!">
</form>
<?php
require_once 'admin/www.footer.php';
?>