<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.functions.php';
require_once 'admin/array.races.php';
include_once 'templates/game.header.php';



$max_succes = 5;

$my_pu = (($row->stealth+$row->b1+$row->b2+$row->b3+$row->b4+$row->b5+$row->u1+$row->u2+$row->u3+$row->u4+$row->u5+$row->s1+$row->s2+$row->s3+$row->s4+$row->s5)/1000000);

$avt_tb1 = $current_time+($row->sb1*1000);
$avt_tb2 = $current_time+($row->sb2*1000);
$avt_tb3 = $current_time+($row->sb3*1000);

$price=10000+($total_land*10);
$price_sb1 =(1+((1+$row->sb1)*(1+$row->sb1)*(1+$row->sb1)))*$price;
$price_sb2 =(1+((1+$row->sb2)*(1+$row->sb2)*(1+$row->sb2)))*$price;
$price_sb3 =(1+((1+$row->sb3)*(1+$row->sb3)*(1+$row->sb3)))*$price;

$stealth_sb1 = 4999 + ((1+$row->sb1)*(1+$row->sb1));
$stealth_sb2 = 4999 + ((1+$row->sb2)*(1+$row->sb2));
$stealth_sb3 = 4999 + ((1+$row->sb3)*(1+$row->sb3));

if (!empty($_POST['upgrade'])) {
	if ($_POST['upgrade'] == 'Airstrike' and $row->gold >= $price_sb1 and $row->sb1 <= 25) {
	$update_it .= ", sb1=sb1+1, `gold`=`gold`-$price_sb1, tsb1=$avt_tb1";
	$row->sb1 += 1;
	$row->tsb1 = $avt_tb1;
	$price_sb1 =(1+((1+$row->sb1)*(1+$row->sb1)*(1+$row->sb1)))*$price;
	$stealth_sb1 = 4999 + ((1+$row->sb1)*(1+$row->sb1));
	print 'Upgrading!';
	}elseif ($_POST['upgrade'] == 'Poisoning' and $row->gold >= $price_sb2 and $row->sb2 <= 25) {
	$update_it .= ", sb2=sb2+1, `gold`=`gold`-$price_sb2, tsb2=$avt_tb2";
	$row->sb2 += 1;
	$row->tsb2 = $avt_tb2;
	$price_sb2 =(1+((1+$row->sb2)*(1+$row->sb2)*(1+$row->sb2)))*$price;
	$stealth_sb2 = 4999 + ((1+$row->sb2)*(1+$row->sb2));
	print 'Upgrading!';
	}elseif ($_POST['upgrade'] == 'Hack' and $row->gold >= $price_sb3 and $row->sb3 <= 35) {
	$update_it .= ", sb3=sb3+1, `gold`=`gold`-$price_sb3, tsb3=$avt_tb3";
	$row->sb3 += 1;
	$row->tsb3 = $avt_tb3;
	$price_sb3 =(1+((1+$row->sb3)*(1+$row->sb3)*(1+$row->sb3)))*$price;
	$stealth_sb3 = 4999 + ((1+$row->sb3)*(1+$row->sb3));
	print 'Upgrading!';
	}
}

if (!empty($_POST['action']) and !empty($_POST['player'])){
	$player=clean_post($_POST['player']);

if($row->stealth >= 1){
if($aresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE charname='$player' and charname!='$row->charname' and `rank`<127 ORDER BY charname DESC LIMIT 1")){
if($arow = mysqli_fetch_object ($aresult)) {
mysqli_free_result ($aresult);


$he_pu =  (($arow->stealth+$arow->b1+$arow->b2+$arow->b3+$arow->b4+$arow->b5+$arow->u1+$arow->u2+$arow->u3+$arow->u4+$arow->u5+$arow->s1+$arow->s2+$arow->s3+$arow->s4+$arow->s5)/1000000);

$total_land = $arow->b1+$arow->b2+$arow->b3+$arow->b4+$arow->b5;

$def_sb1 = $he_pu + ((1+$arow->b3)/$total_land);
$def_sb2 = $he_pu + ((1+$arow->b5)/$total_land);
$def_sb3 = $he_pu + ((1+$arow->b1)/$total_land);

$row->sb1 += $my_pu;
$row->sb2 += $my_pu;
$row->sb3 += $my_pu;

$row->sb1 -= $def_sb1;
if($row->sb1 < 1) {$row->sb1=0;}
$row->sb2 -= $def_sb2;
if($row->sb2 < 1) {$row->sb2=0;}
$row->sb3 -= $def_sb3;
if($row->sb3 < 1) {$row->sb3=0;}

if ($row->sb1 >= $max_succes) {$row->sb1 = $max_succes;}
if ($row->sb2 >= $max_succes) {$row->sb2 = $max_succes;}
if ($row->sb3 >= $max_succes) {$row->sb3 = $max_succes;}

//print "<b>$my_pu - $he_pu - $def_sb1 $def_sb2 $def_sb3 - $row->sb1 $row->sb3 $row->sb3</b>";
print $arow->sex.' '.$arow->charname.' '.number_format($he_pu,3). '<sup><b>pu</b></sup><br>';

			if ($my_pu/100 >= $he_pu or $he_pu/100 >= $my_pu) {
print 'You are not allowed to attack provinces less than 1% of your <sup><b>pu</b></sup> or more than 100% <sup><b>pu</b></sup>.';
			} else {//RANGE


if ($_POST['action'] == 'Airstrike' and $row->stealth >= $stealth_sb1 and ($row->tsb1-$current_time) <= 0 and $row->sb1 >= 1) {
// SB1 Airstrike

mysqli_query ($link, "UPDATE `$tbl_members` SET b1=b1-((b1/100)*$row->sb1),b2=b2-((b2/100)*$row->sb1),b3=b3-((b3/100)*$row->sb1),b4=b4-((b4/100)*$row->sb1),b5=b5-((b5/100)*$row->sb1) WHERE id=$arow->id") or die(mysqli_error());
$update_it .= ", `stealth`=`stealth`-$stealth_sb1, tsb1=$avt_tb1";
$destroyed = number_format((($arow->b1/100)*$row->sb1)+(($arow->b2/100)*$row->sb1)+(($arow->b3/100)*$row->sb1)+(($arow->b4/100)*$row->sb1)+(($arow->b5/100)*$row->sb1));
print 'Airstrike succes! Destroyed '.$destroyed.' acres of buildings!!.';
mysqli_query ($link, "INSERT INTO `$tbl_news` ($fld_news) values ('','$arow->charname','$row->sex $row->charname airstriked your lands for $destroyed acres.','$current_time')");
// SB1 Airstrike
}elseif ($_POST['action'] == 'Poisoning' and $row->stealth >= $stealth_sb2 and ($row->tsb2-$current_time) <= 0 and $row->sb2 >= 1) {
// SB2 Poisoning

mysqli_query ($link, "UPDATE `$tbl_members` SET u1=u1-((u1/100)*$row->sb2),u2=u2-((u2/100)*$row->sb2),u3=u3-((b3/100)*$row->sb2),u4=u4-((b4/100)*$row->sb2),u5=u5-((b5/100)*$row->sb2) WHERE id=$arow->id") or die(mysqli_error());
$update_it .= ", `stealth`=`stealth`-$stealth_sb2, tsb2=$avt_tb2";
$destroyed = number_format((($arow->u1/100)*$row->sb1)+(($arow->u2/100)*$row->sb1)+(($arow->u3/100)*$row->sb1)+(($arow->u4/100)*$row->sb1)+(($arow->u5/100)*$row->sb1));
print 'Poisoning succes! Killed '.$destroyed.' units!!.';
mysqli_query ($link, "INSERT INTO `$tbl_news` ($fld_news) values ('','$arow->charname','$row->sex $row->charname poisoned your lands, they killed $destroyed units.','$current_time')");
// SB2 Poisoning
}elseif ($_POST['action'] == 'Hack' and $row->stealth >= $stealth_sb3 and ($row->tsb3-$current_time) <= 0 and $row->sb3 >= 1) {
// SB3 Hack

mysqli_query ($link, "UPDATE `$tbl_members` SET `gold`=`gold`-((gold/100)*$row->sb3) WHERE id=$arow->id") or die(mysqli_error());
$update_it .= ", `stealth`=`stealth`-$stealth_sb3, tsb3=$avt_tb3";
$destroyed = number_format((($arow->gold/100)*$row->sb3));
print 'Hack succes! Destroyed $'.$destroyed.' gold.';
mysqli_query ($link, "INSERT INTO `$tbl_news` ($fld_news) values ('','$arow->charname','$row->sex $row->charname hacked your bank account for $destroyed gold.','$current_time')");
// SB4 Hack
} else {
//SB FAILED

	$action=clean_post($_POST['action']);
if ($_POST['action'] == 'Airstrike' and $row->stealth >= $stealth_sb1 and ($row->tsb1-$current_time) <= 0){
	$update_it .= ", `stealth`=`stealth`-$stealth_sb1, tsb1=$avt_tb1";
print 'Special attack failed!';
mysqli_query ($link, "INSERT INTO `$tbl_news` ($fld_news) values ('','$arow->charname','$row->sex $row->charname attempted to $action you.','$current_time')");
}elseif ($_POST['action'] == 'Poisoning' and $row->stealth >= $stealth_sb2 and ($row->tsb2-$current_time) <= 0) {
	$update_it .= ", `stealth`=`stealth`-$stealth_sb2, tsb2=$avt_tb2";
print 'Special attack failed!';
mysqli_query ($link, "INSERT INTO `$tbl_news` ($fld_news) values ('','$arow->charname','$row->sex $row->charname attempted to $action you.','$current_time')");
}elseif ($_POST['action'] == 'Hack' and $row->stealth >= $stealth_sb3 and ($row->tsb3-$current_time) <= 0){
	$update_it .= ", `stealth`=`stealth`-$stealth_sb3, tsb3=$avt_tb3";
print 'Special attack failed!';
mysqli_query ($link, "INSERT INTO `$tbl_news` ($fld_news) values ('','$arow->charname','$row->sex $row->charname attempted to $action you.','$current_time')");
}else{
print 'Not available or not enough stealth!';
}

//SB FAILED
}

			}//RANGE
}
}
}

}
?>

<form method=post><table border=1><tr><th>Special</th><th>Time</th><th>Effects on target</th><th>Upgrade Cost</th><th>Upgrade</th></tr><?php
print '<tr><td>Airstrike</td><td>'.(($row->tsb1-$current_time) <= 0?'Available':number_format(($row->tsb1-$current_time)/60).' minutes').'</td><td>Destroys '.number_format($my_pu+$row->sb1).'% buildings</td><td>$'.number_format($price_sb1).'</td><td>'.($row->sb1 < 25?'<input type=submit name=upgrade value="Airstrike" style="width=100%">':'MAX').'</td></tr>
<tr><td>Poisoning</td><td>'.(($row->tsb2-$current_time) <= 0?'Available':number_format(($row->tsb2-$current_time)/60).' minutes').'</td><td>Kills '.number_format($my_pu+$row->sb2).'% population</td><td>$'.number_format($price_sb2).'</td><td>'.($row->sb2 < 25?'<input type=submit name=upgrade value="Poisoning" style="width=100%">':'MAX').'</td></tr>
<tr><td>Hack</td><td>'.(($row->tsb3-$current_time) <= 0?'Available':number_format(($row->tsb3-$current_time)/60).' minutes').'</td><td>Destroys '.number_format($my_pu+$row->sb3).'% gold</td><td>$'.number_format($price_sb3).'</td><td>'.($row->sb3 < 35?'<input type=submit name=upgrade value="Hack" style="width=100%">':'MAX').'</td></tr>';?>
</table>
<?php
if(!empty($_POST['alfa'])){$alfa=clean_post($_POST['alfa']);}else{$alfa='';}

if(!empty($_POST['alfa']) and strlen($_POST['alfa']) >= 2){
?>
<input type=hidden name=alfa value="<?php print $alfa;?>">
<select name=player>
<?php
if($presult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE charname!='$row->charname' and `rank`<127 and `charname` LIKE CONVERT (_utf8 '%$alfa%' USING latin1) COLLATE latin1_swedish_ci ORDER BY charname ASC LIMIT 10000")){
while ($prow = mysqli_fetch_object ($presult)) {
if($player == $prow->charname){
echo '<option value="'.$prow->charname.'" selected>'.$prow->charname.' '.$prow->sex.'</option>';
}else{
echo '<option value="'.$prow->charname.'">'.$prow->charname.' '.$prow->sex.'</option>';
}
}
mysqli_free_result ($presult);
}
?>
</select>
<input type=submit name=action value="Airstrike">
<input type=submit name=action value="Poisoning">
<input type=submit name=action value="Hack">

<br><a href="?sid=<?php print $sid;?>">Go back to search.</a>
<?php}else{?>Player name:<input type="text" name="alfa" maxlength="25" value=""><input type="submit" name="action" value="Find Players!"><?php}?>

</form><br><br>
Airstrike cost <?php print number_format($stealth_sb1);?> stealth points.<br>
Poisoning cost <?php print number_format($stealth_sb2);?> stealth points.<br>
Hack cost <?php print number_format($stealth_sb3);?> stealth points.<br>
When the tax is collected every player gets new stealth action points.<br>
The maximum succes on the target is maxed at <?php print $max_succes;?>%.<br>
<sup><b>pu</b></sup> increases special attacks power, you have <?php print number_format($my_pu,3);?><sup><b>pu</b></sup><br>
You are not allowed to attack provinces less than 1% of your <sup><b>pu</b></sup> or more than 100% <sup><b>pu</b></sup>.<br>
<?php
include_once 'templates/game.footer.php';
?>