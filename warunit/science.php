<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/array.races.php';
include_once 'templates/game.header.php';



$price=1000+($total_land/100);
$price=($price/100)*(100-($row->s3/$science_devider));

print 'Science research cost $'.number_format($price).' per point.<br>You have money to research '.number_format(floor($row->gold/$price)).' science points.';

if (!empty($_POST['action'])){

$table = array('s1','s2','s3','s4','s5');
$cost=0;$train=0;

if ($_POST['action'] == 'Research Science') {$max_science=0;
while (is_array($_POST) && list($key, $val) = each($_POST)) {
if(is_numeric($val)) {
	switch ($key) {
		case in_array($key,$table) && $row->gold >= $val*$price && $val >= 1:
		$train += $val;$row->$key += $val;
		$max_science = $row->$key;
		$cost += $val*$price;$row->gold -= $val*$price;
		if(($max_science/$science_devider) <= 50){$update_it .=", $key=$key+$val";}
	}
}
}

if(($max_science/$science_devider) <= 50){
if ($train >= 1){
$update_it .=", `gold`=`gold`-$cost";
echo '<br>You have learned '.number_format($train).' science points for $'.number_format($cost).'.';

$science = ($row->s1+$row->s2+$row->s3+$row->s4+$row->s5)/1.5;
$science_devider = ($science/100)+($total_land/100);
}
}else{?><br>You cannot obtain this high level of knowledge.<?php}

}

}
?><form method=post><table border=1><tr><th>Researh</th><th>Knowledge</th><th>Effects</th><th>Amount</th></tr><?php
print '<tr><td>Building Tools</td><td>'.number_format($row->s1).'</td><td>-'.number_format($row->s1/$science_devider,2).'% Building Cost</td><td><input type=text name=s1></td></tr>
<tr><td>Population Education</td><td>'.number_format($row->s2).'</td><td>-'.number_format($row->s2/$science_devider,2).'% Population Cost</td><td><input type=text name=s2></td></tr>
<tr><td>Research Labs</td><td>'.number_format($row->s3).'</td><td>-'.number_format($row->s3/$science_devider,2).'% Science Cost</td><td><input type=text name=s3></td></tr>
<tr><td>Battle Weapons</td><td>'.number_format($row->s4).'</td><td>+'.number_format($row->s4/$science_devider,2).'% Offense</td><td><input type=text name=s4></td></tr>
<tr><td>Land Traps</td><td>'.number_format($row->s5).'</td><td>+'.number_format($row->s5/$science_devider,2).'%  Defense</td><td><input type=text name=s5>';
?></td></tr></table><input type=submit name=action value="Research Science"><form><br>Obtaining higher level of knowledge than 50% on any effect is not possible.<?php
include_once 'templates/game.footer.php';
?>