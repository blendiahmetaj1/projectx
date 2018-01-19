<?php
#!/usr/local/bin/php
require_once "MaiN/www.config.php";
include_once "MaiN/www.functions.php";
include_once "MaiN/site.header.php";

if (empty($row->charname)) {
include_once "MaiN/site.index.php";
} else {

if (isset($_GET['messages'])) {
	include_once "MaiN/site.messages.php";
}elseif (isset($_GET['map'])) {
	include_once "MaiN/site.map.php";
}elseif (isset($_GET['ladder'])) {
	include_once "MaiN/site.ladder.php";
}elseif (isset($_GET['attack'])) {
	include_once "MaiN/site.attack.php";
}else{
	include_once "MaiN/site.game.php";
}
}
?>

<a href="http://www.thesilent.com/projectx5/">BETA 0.01</a><br>
<a href="http://www.thesilent.com/projectx51/">BETA 0.02</a> more graphical interface
<?php
include_once "MaiN/site.footer.php";
?>