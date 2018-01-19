<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/array.races.php';
include_once 'templates/game.header.php';



$price=100+($total_land/25);
if($price >= 5000){$price = 5000+(($price-5000)/25);}
$price=($price/100)*(100-($row->s2/$science_devider));

$maxt=($row->b4*10)-($row->u1+$row->u2+$row->u3+$row->u4+$row->u5);
print 'You have sleeping places for '.number_format($maxt).' soldiers.<br> Training cost $'.number_format($price).' releasing cost $'.number_format($price/2).' per soldier.<br>You have money to train '.number_format(floor($row->gold/$price)).' soldiers.';

if (!empty($_POST['action'])){

$table = array('u1','u2','u3','u4','u5');
$cost=0;$train=0;

if ($_POST['action'] == 'Train') {
while (is_array($_POST) && list($key, $val) = each($_POST)) {
if(is_numeric($val)) {
	switch ($key) {
		case in_array($key,$table) && $row->gold >= $val*$price && $maxt >= $val && $val >= 1:
		$train += $val;$row->$key += $val;
		$cost += $val*$price;$row->gold -= $val*$price;
		$update_it .=", $key=$key+$val";
	}
}
}
if ($train >= 1){
$update_it .=", `gold`=`gold`-$cost";
echo '<br>You have trained '.number_format($train).' soldiers for $'.number_format($cost).'.';
}}

if ($_POST['action'] == 'Release') {$price/=2;
while (is_array($_POST) && list($key, $val) = each($_POST)) {
if(is_numeric($val)) {
	switch ($key) {
		case in_array($key,$table) && $row->gold >= $val*$price && $row->$key >= $val && $val >= 1:
		$train += $val;$row->$key -= $val;
		$cost += $val*$price;$row->gold -= $val*$price;
		$update_it .=", $key=$key-$val";
	}
}
}
if ($train >= 1){
$update_it .=", `gold`=`gold`-$cost";
echo '<br>You have released '.number_format($train).' soldiers for $'.number_format($cost).'.';
}}

}
?><form method=post><table border=1><tr><th>Population</th><th>Own</th><th>Natural Effects</th><th>Amount</th></tr><?php
print '<tr><td>'.$races_array[$row->race][8].'</td><td>'.number_format($row->u1).'</td><td>+$'.number_format($row->u1*25).'</td><td><input type=text name=u1></td></tr>
<tr><td>'.$races_array[$row->race][9].'</td><td>'.number_format($row->u2).'</td><td>Intel units</td><td><input type=text name=u2></td></tr>
<tr><td>'.$races_array[$row->race][10].'</td><td>'.number_format($row->u3).'</td><td>+'.number_format($row->u3*3).' offense</td><td><input type=text name=u3></td></tr>
<tr><td>'.$races_array[$row->race][11].'</td><td>'.number_format($row->u4).'</td><td>+'.number_format($row->u4*3).' defense</td><td><input type=text name=u4></td></tr>
<tr><td>'.$races_array[$row->race][12].'</td><td>'.number_format($row->u5).'</td><td>+'.number_format($row->u5*5).'  offense/defense</td><td><input type=text name=u5>';
?></td></tr></table><input type=submit name=action value="Train"> <input type=submit name=action value="Release"><form>
<br>All units cost $1 per turn and <?php print $races_array[$row->race][12];?> cost $3 per turn.<?php
include_once 'templates/game.footer.php';
?>