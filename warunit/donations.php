<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/array.races.php';
require_once 'admin/www.functions.php';
if (isset($_GET['sid'])) {
include_once 'templates/game.header.php';
}else{
include_once 'templates/template.header.php';
$link=mysqli_connect($db_host, $db_user, $db_password) or die('Server down please come back later.');
mysqli_select_db($db_main, $link) or die('Server down please come back later.');
}

if($tpresult=mysqli_query ($link, "SELECT * FROM `$tbl_paypal` WHERE `id` ORDER BY `amount` DESC LIMIT 10000")){
$numrows=mysqli_num_rows($tpresult);
if($numrows >= 1){?><table>
<tr><th colspan="3">All time hall of fame Donated Dominator's</th></tr><?php

$donators=array();
while($tpobj=mysqli_fetch_object($tpresult)){

if(!array_key_exists($tpobj->ip,$donators)){
$donators[$tpobj->ip] = $tpobj->amount;
}else{
$donators[$tpobj->ip] += $tpobj->amount;
}

}
mysqli_free_result($tpresult);

arsort($donators);
$amount=array_sum($donators);

$i=0;$topa=0;
foreach ($donators as $key=>$val){
	$i++;
	$topa += $val;
echo '<tr'; if(empty($bg)){?> bgcolor="<?php print $colth;$bg=1;?>"<?php}else{$bg='';}echo '><td>Player '.$i.'</td><td>$'.number_format($val,2).'</td><td>'.number_format(($val/$amount)*100,2).'%</tr>';
if ($i == 100) {break;}
}

echo '<tr'; if(empty($bg)){?> bgcolor="<?php print $colth;$bg=1;?>"<?php}else{$bg='';}echo '><td>The other '.number_format(count($donators)-$i).' donated players</td><td>$'.number_format($amount-$topa,2).'</td><td>'.number_format((($amount-$topa)/$amount)*100,2).'%</tr>';

?><tr><th colspan="3">A totality of <?php print number_format($numrows);?> donations where made by <?php print count($donators);?> players with a total sum of $<?php print number_format($amount,2);?>.</th></tr>
<tr><th colspan="3">The economy on this server is $<?php print number_format($amount/((date("Y")-2001)*360),2);?> average turnover per day.</th></tr>
</table><?php

}}


if (isset($_GET['sid'])) {
include_once 'templates/game.footer.php';
}else{
mysqli_close($link);
include_once 'templates/template.footer.php';
}
?>