<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.functions.php';
require_once 'admin/array.races.php';
include_once 'templates/game.header.php';

if(!empty($_POST['action'])){$action=clean_post($_POST['action']);}else{$action='';}
if(!empty($_POST['player'])){$player=clean_post($_POST['player']);}else{$player='';}
if(!empty($_POST['gold'])){$gold=round(clean_int($_POST['gold']));}else{$gold='';}
if(!empty($_POST['alfa'])){$alfa=clean_post($_POST['alfa']);}else{$alfa='';}
?>
<table width="100%"><form method="post" action="transfer.php?sid=<?php print $sid;?>"><tr><th colspan="2">Transfer</th></tr>
<?if(!empty($_POST['alfa']) and strlen($_POST['alfa']) >= 2){?>
<tr><td>Gold</td><td><input type="text" name="gold" maxlength="25" value="<?php print $gold>=1?$gold:$row->gold;?>"></td></tr>
<input type=hidden name=alfa value="<?php print $alfa;?>">
<tr><td>Player</td><td width="75%">
<select name="player">
<?php
if($presult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE `charname`!='$row->charname' and `rank`<127 and `charname` LIKE CONVERT (_utf8 '%$alfa%' USING latin1) COLLATE latin1_swedish_ci ORDER BY charname ASC LIMIT 10000")){
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
</select></td></tr><tr><td colspan="2" align=center><input type="submit" name="action" value="Transfer"><br><a href="?sid=<?php print $sid;?>">Go back to search.</a></td>
</tr>
<?php}else{?><tr><td>Player name:</td><td><input type="text" name="alfa" maxlength="25" value=""></td></tr><tr><th colspan="2"><input type="submit" name="action" value="Find Players!"></th>
</tr><?php}?>
</table></form>
Transfering or moving your gold in secret to prevent being stolen.<br>The cost of this operations are 5 stealth points and your need one <?php print $races_array[$row->race][9];?>.
<?php

if (!empty($action) and !empty($player)){
if ($gold >= 1000 and $row->u2>=1){
	if($row->stealth >= 1 and $row->gold >= $gold){
if($aresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE charname='$player' and charname!='$row->charname' and `rank`<127 ORDER BY charname DESC LIMIT 1")) {
if($arow = mysqli_fetch_object ($aresult)) {
mysqli_free_result ($aresult);

$update_it .=", `gold`=`gold`-($gold), `stealth`=`stealth`-5, u2=u2-1";
mysqli_query ($link, "UPDATE `$tbl_members` SET `gold`=`gold`+($gold) WHERE id=$arow->id") or die(mysqli_error());
mysqli_query ($link, "INSERT INTO `$tbl_news` ($fld_news) values ('','$arow->charname','$row->sex $row->charname gave you $".number_format($gold)." gold.','$current_time')");
print 'You send of your '.$races_array[$row->race][9].' with $'.number_format($gold).' gold.';
}
} else {
?><br>You can't transfer gold to dead players.<?php
}
	}
}else{
?><br>Please send more than $1.000 gold pieces.<?php
}
}

include_once 'templates/game.footer.php';
?>