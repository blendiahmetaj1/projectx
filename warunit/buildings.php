<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/array.races.php';
include_once 'templates/game.header.php';



$price=1000+($total_land/10);
if($price >= 10000){$price = 10000+(($price-10000)/10);}
$price=($price/100)*(100-($row->s1/$science_devider));

print 'You have '.number_format($row->land).' unbuild acres of land.<br>Building cost $'.number_format($price).', demolishing cost $'.number_format($price/2).' per acre.<br>You have money for '.number_format(floor($row->gold/$price)).' buildings.';

if (!empty($_POST['action'])){

$bable = array('b1','b2','b3','b4','b5');
$cost=0;$build=0;

if ($_POST['action'] == 'Build') {
while (is_array($_POST) && list($key, $val) = each($_POST)) {
if(is_numeric($val)) {
	switch ($key) {
		case in_array($key,$bable) && $row->gold >= $val*$price && $row->land >= $val && $val >= 1:
		$build += $val;$row->land -= $val;$row->$key += $val;
		$cost += $val*$price;$row->gold -= $val*$price;
		$update_it .=", $key=$key+$val";
	}
}
}
if ($build >= 1){
$update_it .=", `land`=`land`-$build, `gold`=`gold`-$cost";
echo '<br>You have build '.number_format($build).' acres land for $'.number_format($cost).'.';
}}

if ($_POST['action'] == 'Demolish') {$price/=2;
while (is_array($_POST) && list($key, $val) = each($_POST)) {
if(is_numeric($val)) {
	switch ($key) {
		case in_array($key,$bable) && $row->gold >= $val*$price && $row->$key >= $val && $val >= 1:
		$build += $val;$row->land -= $val;$row->$key -= $val;
		$cost += $val*$price;$row->gold -= $val*$price;
		$update_it .=", $key=$key-$val";
	}
}
}
if ($build >= 1){
$update_it .=", `land`=`land`+$build, `gold`=`gold`-$cost";
echo '<br>You have demolished '.number_format($build).' acres land for $'.number_format($cost).'.';
}}

}

$my_pu = (($row->stealth+$row->b1+$row->b2+$row->b3+$row->b4+$row->b5+$row->u1+$row->u2+$row->u3+$row->u4+$row->u5+$row->s1+$row->s2+$row->s3+$row->s4+$row->s5)/1000000);

?><form method=post><table border=1><tr><th>Buildings</th><th>Own</th><th>Effects</th><th>Amount</th></tr><?php
print '<tr><td valign=top>'.$races_array[$row->race][3].'</td><td valign=top>'.number_format($row->b1).'</td><td valign=top>+$'.number_format($row->b1*50).'<br>'.number_format($my_pu+((1+$row->b1)/$total_land),2).'% hack protection</td><td valign=top><input type=text name=b1></td></tr>
<tr><td valign=top>'.$races_array[$row->race][4].'</td><td valign=top>'.number_format($row->b2).'</td><td valign=top>+'.number_format($row->b2/($total_land/100),2).'% offense</td><td valign=top><input type=text name=b2></td></tr>
<tr><td valign=top>'.$races_array[$row->race][5].'</td><td valign=top>'.number_format($row->b3).'</td><td valign=top>+'.number_format($row->b3/($total_land/100),2).'% defense<br>'.number_format($my_pu+((1+$row->b3)/$total_land),2).'% airstrike protection</td><td valign=top><input type=text name=b3></td></tr>
<tr><td valign=top>'.$races_array[$row->race][6].'</td><td valign=top>'.number_format($row->b4).'</td><td valign=top>housing for '.number_format($row->b4*10).' soldiers</td><td valign=top><input type=text name=b4></td></tr>
<tr><td valign=top>'.$races_array[$row->race][7].'</td><td valign=top>'.number_format($row->b5).'</td><td valign=top>-'.number_format($row->b5/($total_land/100),2).'% loses <br>'.number_format($my_pu+((1+$row->b5)/$total_land),2).'% poisoning protection</td><td valign=top><input type=text name=b5>';
?></td></tr></table><input type=submit name=action value="Build"> <input type=submit name=action value="Demolish"><form>
<br>Unbuild land generate $1 gold per turn.<br>
<sup><b>pu</b></sup> increases defense from special attacks, you have <?php print number_format($my_pu,3);?><sup><b>pu</b></sup>.<br>
<?php
include_once 'templates/game.footer.php';
?>