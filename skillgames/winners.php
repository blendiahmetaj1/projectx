<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.header.php';
?><table width=100% border=0 cellspacing=0 cellpadding=0><?php
if ($gresult = mysqli_query ($link, "SELECT * FROM `$tbl_win` WHERE `id` ORDER BY `id` DESC LIMIT 100")) {
while ($grow = mysqli_fetch_object ($gresult)){

print '<tr><td>Game ID: '.$grow->gid.'</td><td>Player ID: '.$grow->pid.'</td><td>Score: '.$grow->score.'</td></tr>';

}
mysqli_free_result ($gresult);
}


if ($gresult = mysqli_query ($link, "SELECT * FROM `$tbl_scores` WHERE (`pid`='$row->id' and `times`>='8') ORDER BY `id` DESC LIMIT 10")) {
while ($grow = mysqli_fetch_object ($gresult)){

if ($hresult = mysqli_query ($link, "SELECT * FROM `$tbl_scores` WHERE (`pid`!='$row->pid' and `gid`='$grow->gid' and `times`>='8') ORDER BY `id` DESC LIMIT 10")) {
if ($hrow = mysqli_fetch_object ($hresult)){
mysqli_free_result ($hresult);

if ($grow->score > $hrow->score) {
mysqli_query ($link, "UPDATE `$tbl_members` SET `gold`=`gold`+'50' WHERE (`id`='$grow->pid') LIMIT 1");
mysqli_query ($link, "UPDATE `$tbl_members` SET `gold`=`gold`-'50' WHERE (`id`='$hrow->pid') LIMIT 1");
mysqli_query ($link, "INSERT INTO `$tbl_win` values ('','$grow->pid','$grow->id','$grow->score','$current_time')");
mysqli_query ($link, "DELETE FROM `$tbl_scores` WHERE `id`='$grow->id' LIMIT 1");
mysqli_query ($link, "DELETE FROM `$tbl_scores` WHERE `id`='$hrow->id' LIMIT 1");
} elseif ($grow->score < $hrow->score) {
mysqli_query ($link, "UPDATE `$tbl_members` SET `gold`=`gold`+'50' WHERE (`id`='$hrow->pid') LIMIT 1");
mysqli_query ($link, "UPDATE `$tbl_members` SET `gold`=`gold`-'50' WHERE (`id`='$grow->pid') LIMIT 1");
mysqli_query ($link, "INSERT INTO `$tbl_win` values ('','$hrow->pid','$hrow->id','$hrow->score','$current_time')");
mysqli_query ($link, "DELETE FROM `$tbl_scores` WHERE `id`='$grow->id' LIMIT 1");
mysqli_query ($link, "DELETE FROM `$tbl_scores` WHERE `id`='$hrow->id' LIMIT 1");
}

}
}

}
mysqli_free_result ($gresult);
}


?></table><?php
require_once 'admin/www.footer.php';
?>