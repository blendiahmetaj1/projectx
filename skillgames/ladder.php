<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.header.php';
?><table width=100% border=0 cellspacing=0 cellpadding=0><?php
if ($gresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE `id` ORDER BY `gold` DESC LIMIT 100")) {
while ($grow = mysqli_fetch_object ($gresult)){

print '<tr><td>'.$grow->id.' '.$grow->username.'</td><td>$'.number_format($grow->gold).'</td></tr>';

}
mysqli_free_result ($gresult);
}

?></table><?php
require_once 'admin/www.footer.php';
?>