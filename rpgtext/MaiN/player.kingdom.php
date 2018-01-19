<?php
#!/usr/local/bin/php
?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th>Kingdoms</th></tr><tr><td><form method=post action="?player=kingdom">
<?php
//KINGDOMS
if($dresults = mysqli_query ($link, "SELECT * FROM `$tbl_kingdoms` WHERE `x`='$row->x' and `y`='$row->y' ORDER BY `id` DESC LIMIT 1")) {
if(mysqli_num_rows($dresults) >= 1){
if ($krow = mysqli_fetch_object ($dresults)) {
	mysqli_free_result ($dresults);
	$cost_guard = ((1+$krow->guards)+(1+$krow->guards))*125;
	$cost_elite = ((1+$krow->elites)+(1+$krow->elites))*500;

if ($row->kid !== $krow->id) {$to_update .= ", `kid`='$krow->id'";}

print 'Welcome to the <b>'.$krow->kingdom.'</b> kingdom of <b>'.$krow->charname.'</b> our protection price is <b>'.number_format($krow->tax).'%</b> gold of your kills! We have <b>'.number_format($krow->guards).'</b> guards guarding our kingdom and <b>'.number_format($krow->elites).'</b> elites to help in your quest. This kingdom has <b>'.number_format($krow->gold).'</b> gold, deploying a guard cost <b>'.number_format($cost_guard).'</b> gold and a elite cost <b>'.number_format($cost_elite).'</b> gold.';

if($row->charname == $krow->charname) {
	//KINGDOM OWNER
	//TAXING
if(!empty($_POST['tax'])) {
	$tax=clean_post($_POST['tax']);
	if($krow->tax <> $tax and $tax >= 1 and $tax <= 75){
mysqli_query ($link, "UPDATE `$tbl_kingdoms` SET `tax`='$tax' WHERE `id`='$krow->id' LIMIT 1") or die_nice(mysqli_error().'kingdom tax');
$krow->tax = $tax;
$to_output .= 'Chang tax collection to '.$tax.'%.<br>';
	}
}
	//TAXING
	//DEPLOYING
if(!empty($_POST['soldiers'])) {$soldiers=round(clean_post($_POST['soldiers']));}else{$soldiers=0;}
if(!empty($_POST['imperial']) and $soldiers >= 1) {

	$imperial=clean_post($_POST['imperial']);
	if($imperial == 'Deploy Guards' and $krow->gold >= $cost_guard){

if ($soldiers > 1) {$fuck_guards=0;
	for($i=0;$i<$soldiers;$i++){
		$guarda_calc = ((1+($krow->guards+$i))+(1+($krow->guards+$i)))*125;
		if($krow->gold-$guarda_calc >= $guarda_calc) {$fuck_guards++;
			$cost_guard += $guarda_calc;
			$krow->gold -= $guarda_calc;
		}else{break;}
	}
$soldiers=$fuck_guards;
}

mysqli_query ($link, "UPDATE `$tbl_kingdoms` SET `guards`=`guards`+'$soldiers', `gold`=`gold`-$cost_guard WHERE `id`='$krow->id' LIMIT 1") or die_nice(mysqli_error().'kingdom deploy');
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','4','$krow->kingdom','$current_date','$row->sex $row->charname deploys a <b>$soldiers guards</b> costing ".number_format($cost_guard)." gold.','$current_time')") or die_nice(mysqli_error().'deploy paper');
	}elseif($imperial == 'Deploy Elites' and $krow->gold >= $cost_elite){

if ($soldiers > 1) {$fuck_elites = 0;
	for($i=0;$i<$soldiers;$i++){
		$elita_calc = ((1+($krow->elites+$i))+(1+($krow->elites+$i))*(1+(($krow->elites+$i)/5)))*500;
		if($krow->gold-$elita_calc >= $elita_calc) {$fuck_elites++;
			$cost_elite += $elita_calc;
			$krow->gold -= $elita_calc;
			//print $i.' '.$soldiers.' '.$krow->gold.' '.$elita_calc.' '.$cost_elite.' <br>';
		}else{break;}
	}
$soldiers=$fuck_elites;
}

mysqli_query ($link, "UPDATE `$tbl_kingdoms` SET `elites`=`elites`+'$soldiers', `gold`=`gold`-$cost_elite WHERE `id`='$krow->id' LIMIT 1") or die_nice(mysqli_error().'kingdom deploy');
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','4','$krow->kingdom','$current_date','$row->sex $row->charname deploys new <b>$soldiers elites</b> costing ".number_format($cost_elite)." gold.','$current_time')") or die_nice(mysqli_error().'deploy paper');
	}else{
$to_output .= 'The Kingdom is out of gold.<br>';
	}


}
	//DEPLOYING
?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=3>Imperial Forces</th></tr>
<tr><td width=40%><input type=submit name=imperial value="Deploy Guards"></td><td width=20%><select name=soldiers><?php
for ($i=1;$i<=1000;$i++){
	if($i == 10){$i *= 5;}
	if($i == 51){$i = 100;}
	if($i == 101){$i = 250;}
	if($i == 251){$i = 500;}
	if($i == 501){$i = 1000;}
if ($soldiers == $i){
print '<option value="'.$i.'" selected>'.$i.'</option>';
}else{
print '<option value="'.$i.'">'.$i.'</option>';
}
}
?></select></td><td width=40%><input type=submit name=imperial value="Deploy Elites"></td></tr>
</table>

<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=2>TAX</th></tr>
<tr>
<td width=50%><select name=tax><?php
for($i=1;$i<=75;$i++){
	if($i == $krow->tax) {$selected= ' selected';} else {$selected= '';}
	print '<option value="'.$i.'"'.$selected.'>'.$i.'%</option>';
}
?></select></td>
<td width=50%><input type=submit name=kd value="Change TAX collection!"></td>
</tr>
</table><?php

//treasure
		if(!empty($_POST['treasure'])){
		$treasure = round(clean_post($_POST['treasure']));
	if ($krow->gold >= $treasure and $treasure >= 1 and $krow->gold >= 1) {
		if($row->gold + $treasure <= $max_gold) {
$to_update .= ", `gold`=`gold`+$treasure";
mysqli_query ($link, "UPDATE `$tbl_kingdoms` SET `gold`=`gold`-'$treasure' WHERE `id`='$krow->id' LIMIT 1") or die_nice(mysqli_error().'kingdom donate');
$to_output .= 'You took '.number_format($treasure).' gold from the treasure chamber!<br>';
mysqli_query ($link, "INSERT INTO $tbl_paper values ('','4','$krow->kingdom','$current_date','$row->sex $row->charname took ".number_format($treasure)." gold from the treasure chamber.','$current_time')") or die_nice(mysqli_error().'tax collection paper');
		}else{
			$to_output .= 'You can\'t carry that much gold!!<br>';
			}
	}else{
		$to_output .= 'The Kingdom doesn\'t have that kind of amount gold!<br>';
		}
		}

?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=3>Take Gold From The Kingdom</th></tr>
<tr><td width=30% nowrap>Gold Amount</td><td width=30%><input type=text name=treasure maxlength=10></td><td width=40%><input type=submit name=take value="Take Gold!"></td>
</tr></table><?php
//treasure
	//KINGDOM OWNER
}else{
	//KINGDOM VISITORS

$to_output .= 'Welcome to the kingdom <b>'.$krow->kingdom.'</b> of <b>'.$krow->charname.'</b>.<br>';


//SIEGE KINGDOM
	if(!empty($_POST['siege']) and $row->life >= 1 and $row->honor >= 1){
		$kdrow->charname =$krow->guards+$krow->elites;
		$kdrow->dupe =$krow->guards;
		$kdrow->life =$kdrow->charname;
		$kdrow->mana =$kdrow->charname;
		$kdrow->stamina =$kdrow->charname;
		$k_stats = monster_stats($kdrow);
		$battle_stats=battle_stats();
		$kd_power=array_sum($k_stats);
		$my_power=array_sum($battle_stats);
		//print '<pre>';print_r($krow);print_r($kdrow);print($kd_power).' - '.($my_power);print'</pre>';
		if($my_power >= $kd_power){
			//print '<hr>'.rand(1,100).' <= 3 and '.$my_power/rand(1,10).' >= '.$kd_power/rand(1,10).'<hr>';
			if(rand(1,100) <= (5+$row->honor) and $my_power/rand(1,10) >= $kd_power/rand(1,10)){
mysqli_query ($link, "UPDATE `$tbl_kingdoms` SET `charname`='$row->charname' WHERE `id`='$krow->id' LIMIT 1") or die_nice(mysqli_error().'kingdom donate');
mysqli_query ($link, "INSERT INTO $tbl_paper values ('','4','$krow->kingdom','$current_date','$row->sex $row->charname has sieged this kingdom.','$current_time')") or die_nice(mysqli_error().'siege kd');
$to_output .= 'After a fierce battle against '.number_format($krow->guards).' guards and '.number_format($krow->elites).' elites, you are the new king here!<br>';
			}else{
mysqli_query ($link, "INSERT INTO $tbl_paper values ('','4','$krow->kingdom','$current_date','$row->sex $row->charname is sieging this kingdom.','$current_time')") or die_nice(mysqli_error().'siege kd');
$to_output .= 'After a fierce battle against '.number_format($krow->guards).' guards and '.number_format($krow->elites).' elites, you have lost your life honorable.<br>';
$to_update .= ", `life`='0', `honor`=`honor`-0.1";
			}
		}else{
$to_output .= 'You are no match for the kingdom forces of '.number_format($krow->guards).' guards and '.number_format($krow->elites).' elites, you have lost you life and honor.<br>';
$to_update .= ", `life`='0', `honor`=`honor`-0.5";
		}
	} elseif($row->honor < 1){
$to_output .= 'You have no honor to siege this kingdom.<br>';
	}
?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=3>Siege this Kingdom!</th></tr>
<tr><td colspan=3><input type=submit name=siege value="Siege this kingdom!"></td></tr>
<tr><td><input type=submit name=potion value="life"></td><td><input type=submit name=potion value="mana"></td><td><input type=submit name=potion value="stamina"></td></tr></table><?php


//print '<pre>';print_r($krow);print'</pre>';

//SIEGE KINGDOM
	//KINGDOM VISITORS
}
	//DONATIONS
		if(!empty($_POST['amount'])){
		$amount = round(clean_post($_POST['amount']));
	if ($row->gold >= $amount and $amount >= 1) {
$to_update .= ", `gold`=`gold`-$amount";
mysqli_query ($link, "UPDATE `$tbl_kingdoms` SET `gold`=`gold`+'$amount' WHERE `id`='$krow->id' LIMIT 1") or die_nice(mysqli_error().'kingdom donate');
$to_output .= 'Thank you for donating!<br>';
mysqli_query ($link, "INSERT INTO $tbl_paper values ('','4','$krow->kingdom','$current_date','$row->sex $row->charname donate\'s ".number_format($amount)." gold.','$current_time')") or die_nice(mysqli_error().'tax collection paper');
	}else{
		$to_output .= 'You don\'t have that kind of amount gold on you!<br>';
		}
		}
//ALL GOLD
if(!empty($_POST['donate_all']) and $row->gold >= 1){
$to_update .= ", `gold`='0'";
mysqli_query ($link, "UPDATE `$tbl_kingdoms` SET `gold`=`gold`+'$row->gold' WHERE `id`='$krow->id' LIMIT 1") or die_nice(mysqli_error().'kingdom donate');
$to_output .= 'Thank you for donating!<br>';
mysqli_query ($link, "INSERT INTO $tbl_paper values ('','4','$krow->kingdom','$current_date','$row->sex $row->charname donate\'s ".number_format($row->gold)." gold.','$current_time')") or die_nice(mysqli_error().'tax collection paper');
}
//ALL GOLD

?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=4>Kingdom Donations Here!</th></tr>
<tr><td width=15% nowrap>Gold Amount</td><td width=25%><input type=text name=amount maxlength=10></td><td width=30%><input type=submit name=donate value="Donate Gold!"></td><td width=30%><input type=submit name=donate_all value="Donate All Gold!"></td>
</tr></table><?php

	//DONATIONS

}//fetch object

}else{//numrows

	//NO KINGDOM
if($row->level >= $kingdom_level){
	$kingdom_price = 1000000+$max_gold;
?>
Having kingdom you must help to protect your visitors against monsters and other players. You will be reward by your visitor that come fight here. The price to build a new kingdom is <?php print number_format($kingdom_price);?> gold. Are you ready to rule the kingdom?
<?php

	if ($row->stash >= $kingdom_price) {
		if(!empty($_POST['kingdom_name']) and !empty($_POST['establish'])) {
			$kingdom_name = clean_input($_POST['kingdom_name']);
			$establish = clean_post($_POST['establish']);
	if(!in_array($kingdom_name,$is_kingdom)) {
		if(!empty($kingdom_name)){
//EXIST CHECK
if($ekresults = mysqli_query ($link, "SELECT * FROM `$tbl_kingdoms` WHERE `kingdom`='$kingdom_name' ORDER BY `id` DESC LIMIT 1")) {
if(mysqli_num_rows($ekresults) >= 1){
if ($ekrow = mysqli_fetch_object ($ekresults)) {
	mysqli_free_result ($ekresults);
}
}
}
//EXIST CHECK
if(empty($ekrow->kingdom)) {
if(empty($row->location)){$row->location = 'X'.$row->x.' Y'.$row->y;}else{$row->location = 'the '.$row->location;}
mysqli_query ($link, "INSERT INTO $tbl_paper values ('','1','','$current_date','Kingdom established at <b>".$row->location."</b> for <b>".number_format($kingdom_price)."</b> gold.','$current_time')") or die_nice(mysqli_error().'tax collection paper');
mysqli_query ($link, "INSERT INTO $tbl_kingdoms values ('','$row->x','$row->y','$row->charname','$kingdom_name','0','0','50','1500','$current_time')") or die_nice(mysqli_error().'kd dupe');
$to_update .= ", `stash`=`stash`-'$kingdom_price'";
$to_output .= 'A new Kingdom has been established at <b>'.$row->location.'</b> on your name.<br>';
}else{
	$to_output .= 'The name <b>'.$ekrow->kingdom.'</b> is already taken by <b>'.$ekrow->charname.'</b>, please choose another one.<br>';
}
		}else{
$to_output .= 'Please use only alpha numeric only, maxlength is 10 chars and minimum of 4 chars!<br>';
		}
	}else{
		$to_output .= '<b>This name is taken please choose another name.</b><br>';
	}
		}else{
?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=3>Your kingdom?</th></tr>
<tr><td width=30% nowrap>Kingdom Name</td><td width=30%><input type=text name=kingdom_name maxlength=10></td><td width=40%><input type=submit name=establish value="Establish a Kingdom!"></td>
</tr></table><?php
		}
	}else{
$to_output .= 'You need money in your bank account to buy properties here.';
	}

}else{
$to_output .= 'You must be at least level '.$kingdom_level.' to establish a kingdom.';
}
	//NO KINGDOM

}//numrows
}//mysql select
//KINGDOMS
?></form></td></tr></table><?php
//NEWS PAPER LOCATION nid 4 kingdom
if (!empty($krow->kingdom)){
news_paper($krow->kingdom,'4','Kingdom Log');
}
//NEWS PAPER LOCATION nid 4 kingdom

//NOOB
if($row->level <= $noob_level){
$to_output .= 'Kingdoms will help you with fighting monsters by sending their elite troop\'s and protect you with their guards from dieing when going offline and all players in this kingdom also joins the fight to help you!.';
}
//NOOB
?>