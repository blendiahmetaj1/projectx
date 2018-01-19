<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.functions.php';
require_once 'admin/array.races.php';
include_once 'templates/game.header.php';


if (!empty($_POST['action']) and !empty($_POST['player'])){
	$player=$_POST['player'];

if ($_POST['action'] == 'Infiltrate') {
$required_action = 1;
}elseif($_POST['action'] == 'Plunder') {
$required_action = 15;
}elseif($_POST['action'] == 'Learn') {
$required_action = 20;
}elseif($_POST['action'] == 'Grab land') {
$required_action = 25;
}

	if($row->stealth >= $required_action){
if ($required_action >= 1) {
$update_it .=", `stealth`=".round($row->stealth-$required_action);
}

if($aresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE charname='$player' and charname!='$row->charname' and `rank`<127 ORDER BY charname DESC LIMIT 1")){
if($arow = mysqli_fetch_object ($aresult)) {
mysqli_free_result ($aresult);
if ($arow->id == 1) {
	print 'All your men has been annihilated hahaha, you are dead!<br>
	<font color=red>Please relogin to start over!</font>';
}else{
$races_keys=array_keys($races_array);
if(!in_array($arow->race, $races_keys)) {
	$arow->race='Undead';
}

$defscience = ($arow->s1+$arow->s2+$arow->s3+$arow->s4+$arow->s5)/1.5;
$sdefcience_devider = ($defscience/100)+($total_land/100);

if ($_POST['action'] == 'Infiltrate' and !empty($_POST['u2'])){
$u2=clean_int($_POST['u2']);
if ($u2 <= $row->u2 and $row->stealth >= 1){
		//$update_it .=", `stealth`=`stealth`-1";
if ($u2/100 >= 1){$update_it .=", u2=u2-(1+$u2/100)";}
if ($u2 >= $arow->u2/10){
print 'Intel brought us this information: $'.number_format($arow->gold).', Unbuild land '.number_format($arow->land).' acres<br>';
print 'Buildings: '.number_format($arow->b1).' '.$races_array[$arow->race][3].', '.number_format($arow->b2).' '.$races_array[$arow->race][4].', '.number_format($arow->b2).' '.$races_array[$arow->race][5].', '.number_format($arow->b4).' '.$races_array[$arow->race][6].', '.number_format($arow->b5).' '.$races_array[$arow->race][7].'<br>';
print 'Population: '.number_format($arow->u1).' '.$races_array[$arow->race][8].', '.number_format($arow->u2).' '.$races_array[$arow->race][9].', '.number_format($arow->u3).' '.$races_array[$arow->race][10].', '.number_format($arow->u4).' '.$races_array[$arow->race][11].', '.number_format($arow->u5).' '.$races_array[$arow->race][12];

$tland=$arow->b1+$arow->b2+$arow->b3+$arow->b4+$arow->b5+$arow->land;
$dpower = (($arow->u4*3)+($arow->u5*5));
$dpower=($dpower/100)*(100+$races_array[$arow->race][2]+($arow->b3/($tland/100)));
$dpower=($dpower/100)*(100+($arow->s5/$sdefcience_devider));

echo '<br>Total defense power : '.number_format($dpower).'<br>';
}else{?>Mission failed!<?php$update_it .=", u2=u2-$u2";}
}


}elseif (!empty($_POST['u3']) or !empty($_POST['u5'])){
	if($_POST['action'] !== 'Infiltrate') {
$u3=clean_int($_POST['u3']);$u5=clean_int($_POST['u5']);

if ($u3 <= $row->u3 and $u5 <= $row->u5){


$apower = (($u3*3)+($u5*5));
$apower=($apower/100)*(100+$races_array[$row->race][1]+($row->b2/($total_land/100)));
$apower=($apower/100)*(100+($row->s4/$science_devider));

$tland=$arow->b1+$arow->b2+$arow->b3+$arow->b4+$arow->b5+$arow->land;
$dpower = (($arow->u4*3)+($arow->u5*5));
$dpower=($dpower/100)*(100+$races_array[$arow->race][2]+($arow->b3/($tland/100)));
$dpower=($dpower/100)*(100+($arow->s5/$sdefcience_devider));

//FACE OFF
$army_offense=$u3+$u5;
$army_defense=$arow->u4+$arow->u5;

	//KILLS ENEMY SOLDIERS
$enemy_victims = round($army_offense/20);

print 'Your send a force with '.number_format($apower).' power. <br>The defending army is fighting with '.number_format($army_defense).' soldiers with '.number_format($dpower).' power!<br>Your army has managed to kill some of their soldiers!<br>';

if ($enemy_victims >= 1) {
$killed_forces='';

if($arow->u4 >= ($enemy_victims/10)){
	//print 'AAA';
$killed_forces .="u4=u4-($enemy_victims/10)";
$enemy_victims=0;
}elseif($arow->u4 >= 1){
	//print 'FFF';
$killed_forces .="u4=0";
$enemy_victims -= $arow->u4;
}
if($arow->u5 >= $enemy_victims and $enemy_victims >= 1){
	//print 'BBB';
if (!empty($killed_forces)) {
	//print 'CCC';
	$killed_forces .=",";
}
$killed_forces .="u5=u5-$enemy_victims";
}

//print 'TEST'.$u3.' '.$u5.' '.($u4/100).' '.($u5/100);

}
	//KILLS ENEMY SOLDIERS



//FACE OFF

if($apower >= $dpower){

if($u3 >= 1){
print '<br>Some of your '.$races_array[$row->race][10].' has been killed!<br>';if($army_offense/2 < $army_defense){
$update_it .=", u3=u3-$u3/25";
$row->u3=round($row->u3-($u3/25));
}else{
	if($army_defense <= $u3){
		$update_it .=", u3=u3-$army_defense/2";
		$row->u3=round($row->u3-($army_defense/2));
	}else{
		$update_it .=", u3=u3-1";
		$row->u3=$row->u3-1;
	}
}
}

if($u5 >= 1){print '<br>Some of your '.$races_array[$row->race][12].' has been killed!<br>';if($army_offense/2 < $army_defense){
$update_it .=", u5=u5-$u5/25";
$row->u5=round($row->u5-($u5/25));
}else{if($army_defense <= $u5){
	$update_it .=", u5=u5-$army_defense/2";
	$row->u5=round($row->u5-($army_defense/2));
	}else{
		$update_it .=", u5=u5-1";
		$row->u5=$row->u5-1;
		}}}

if ($_POST['action'] == 'Grab land' and $row->stealth >= 25){
	//$update_it .=", `stealth`=`stealth`-25";

if ($tland/10 >= 1){
$update_it .=", `land`=`land`+($tland/10)";


if($tland >= 50){
mysqli_query ($link, "UPDATE `$tbl_members` SET `land`=`land`-(land/10),b1=b1-(b1/10),b2=b2-(b2/10),b3=b3-(b3/10),b4=b4-(b4/10),b5=b5-(b5/10),u4=u4-(u4/100),u5=u5-(u5/100) WHERE id=$arow->id") or die(mysqli_error());
print 'Your forces grabbed '.number_format($tland/10).' acres of land.';
mysqli_query ($link, "INSERT INTO `$tbl_news` ($fld_news) values ('','$arow->charname','$row->sex $row->charname grabbed ".number_format($tland/10)." acres of your land.','$current_time')");
}else{
	//KILLED
mysqli_query ($link, "INSERT INTO `$tbl_kills` ($fld_kills) values ('','$row->charname','$arow->sex $arow->charname','$current_time')") or die(mysqli_error());

if (preg_match("/^bot.*?/i",$arow->charname) or ($current_time-$arow->timer) >= (86400*5)){
mysqli_query ($link, "DELETE FROM `$tbl_members` WHERE `id`='$arow->id' LIMIT 1") or die(mysqli_error());
}else{
mysqli_query ($link, "UPDATE `$tbl_members` SET rank=127 WHERE `id`='$arow->id'") or die(mysqli_error());
}

mysqli_query ($link, "UPDATE `$tbl_members` SET `stealth`=`stealth`+$reward_kill WHERE `id`='$row->id' LIMIT 1") or die(mysqli_error());

print 'You have killed '.$arow->sex.' '.$arow->charname.', you have been rewarded with '.$reward_kill.' stealth points.';


	//KILLED
}


}else{?>Nothing!<?php}
}elseif($_POST['action'] == 'Plunder' and $row->stealth >= 15){
	//$update_it .=", `stealth`=`stealth`-15";

if ($arow->gold/10 >= 1){
$update_it .=", `gold`=`gold`+($arow->gold/10)";
mysqli_query ($link, "UPDATE `$tbl_members` SET `gold`=`gold`-(gold/10),u4=u4-(u4/100),u5=u5-(u5/100) WHERE id=$arow->id") or die(mysqli_error());
print 'Your forces plundered for $'.number_format($arow->gold/10);
mysqli_query ($link, "INSERT INTO `$tbl_news` ($fld_news) values ('','$arow->charname','$row->sex $row->charname plundered for $".number_format($arow->gold/10).".','$current_time')");
}else{?>Nothing!<?php}
}elseif($_POST['action'] == 'Learn' and $row->stealth >= 20){
	//$update_it .=", `stealth`=`stealth`-20";

$winning_science = $defscience/100;
if ($winning_science >= 5){

mysqli_query ($link, "UPDATE `$tbl_members` SET s1=s1-(s1/100),s2=s2-(s2/100),s3=s3-(s3/100),s4=s4-(s4/100),s5=s5-(s5/100),u4=u4-(u4/100),u5=u5-(u5/100) WHERE id=$arow->id") or die(mysqli_error());
print 'Your forces took home '.number_format($winning_science).' books of knowledge.';
mysqli_query ($link, "INSERT INTO `$tbl_news` ($fld_news) values ('','$arow->charname','$row->sex $row->charname took ".number_format($winning_science)." books of knowledge.','$current_time')");
$winning_science /= 5;
	$update_it .=", s1=s1+$winning_science, s2=s2+$winning_science, s3=s3+$winning_science, s4=s4+$winning_science, s5=s5+$winning_science";
}else{?>Nothing!<?php}

}

}else{

print '<br>Most of your men has been killed!';
if($u3 >= 1){
$update_it .=", u3=u3-$u3/10";
}
if($u5 >= 1){
$update_it .=", u5=u5-$u5/10";
}

if (!empty($killed_forces)) {
mysqli_query ($link, "UPDATE `$tbl_members` SET $killed_forces WHERE id=$arow->id") or die(mysqli_error());
}

}
}

}
}
}
}else{?>This player is in protection mode or dead!<?php}}}else{?>Not enough stealth points to do this action.<?php}}else{
	$player='';
?>So you are ready to make some enemies? Before you want to attack an opponent you need to know if you have the military power to defeat your enemy, this can be done by sending some spies and infiltrate their army. If you want to grab some of your enemies land use grab land and if you need money do a plunder attack. Sending a weak army can get all your mens killed so be sure to send enough force.
<?php}

if (!empty($u2)) {
	if ($u2 > $row->u2) {
	$u2 = $row->u2;
	}
}else{
//$u2 = $row->u2;
}
if (!empty($u3)) {
	if ($u3 > $row->u3) {
	$u3 = $row->u3;
	}
}else{
//$u3 = $row->u3;
}
if (!empty($u5)) {
	if ($u5 > $row->u5) {
	$u5 = $row->u5;
	}
}else{
//$u5 = $row->u5;
}
?>
<form method=post><table border=1><tr><th>Military</th><th>Own</th><th>Effects</th><th>Amount</th></tr><?php
print '<tr><td>'.$races_array[$row->race][9].'</td><td>'.number_format($row->u2).'</td><td>Intel units</td><td><input type=text name=u2 value="'.(!empty($u2)?$u2:'').'"></td></tr>
<tr><td>'.$races_array[$row->race][10].'</td><td>'.number_format($row->u3).'</td><td>+'.number_format($row->u3*3).' offense</td><td><input type=text name=u3 value="'.(!empty($u3)?$u3:'').'"></td></tr>
<tr><td>'.$races_array[$row->race][12].'</td><td>'.number_format($row->u5).'</td><td>+'.number_format($row->u5*5).'  offense/defense</td><td><input type=text name=u5 value="'.(!empty($u5)?$u5:'').'">';?>
</td></tr></table>

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

<input type=submit name=action value="Infiltrate">
<input type=submit name=action value="Grab land">
<input type=submit name=action value="Learn">
<input type=submit name=action value="Plunder">
<br><a href="?sid=<?php print $sid;?>">Go back to search.</a>
<?php}else{?>Player name:<input type="text" name="alfa" maxlength="25" value=""><input type="submit" name="action" value="Find Players!"><?php}?>

</form><br><br>
Infiltrate cost 1 stealth points.<br>
Plunder cost 15 stealth points.<br>
Learn cost 20 stealth points.<br>
Grab land cost 25 stealth points.<br><br>
When the tax is collected every player gets new stealth action points.
<?php
include_once 'templates/game.footer.php';
?>