<?php
#!/usr/local/bin/php
?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th>Bank</th></tr><tr><td>For all your financial transactions, you can hold max <?php print number_format($max_gold);?> gold at the current level.<br>
<form method=post action="?visit=bank">
<?php
if(!empty($_POST['amount'])){
	$amount=round(clean_post($_POST['amount']));
if($amount < 1){$amount=0;}}else{$amount=0;}

if(!empty($_POST['action'])){$action=clean_post($_POST['action']);}else{$action='';}

//LOAN INTEREST

//LOAN INTEREST

//BANK ACCOUNT USING STASH
print 'You have '.number_format($row->stash).' gold in your bank account, and '.number_format($row->gold).' gold in your pocket.';

if (!empty($action)) {
if($action == 'Deposit' and $amount >= 1 and $row->gold >= $amount) {
	$to_update .= ", `gold`=`gold`-$amount, `stash`=`stash`+$amount";
	$to_output .= 'You have deposited <b>'.number_format($amount).'</b> gold in your bank account.<br>';
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','5','$row->charname','$current_date','Deposited ".number_format($amount)." gold.','$current_time')") or die_nice(mysqli_error().'bank deposit');
}elseif ($action == 'Withdraw' and $amount >= 1 and $row->stash >= $amount){
	if($row->gold+$amount <= $max_gold){
	$to_update .= ", `gold`=`gold`+$amount, `stash`=`stash`-$amount";
	$to_output .= 'You have withdrawn <b>'.number_format($amount).'</b> gold from your bank account.<br>';
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','5','$row->charname','$current_date','Withdrawed ".number_format($amount)." gold.','$current_time')") or die_nice(mysqli_error().'bank deposit');
	}else{
		$to_output .= 'You can\'t carry more than '.number_format($max_gold).' gold!<br>';
	}
}elseif($action == 'Deposit All' and $row->gold >= 1) {
	$to_update .= ", `gold`='0', `stash`=`stash`+'$row->gold'";
	$to_output .= 'You have deposited <b>'.number_format($row->gold).'</b> gold in your bank account.<br>';
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','5','$row->charname','$current_date','Deposited ".number_format($row->gold)." gold.','$current_time')") or die_nice(mysqli_error().'bank deposit');
}elseif ($action == 'Withdraw Max'  and $row->stash >= $max_gold){
	if($row->stash >= $max_gold and $row->gold < $max_gold) {
	$to_update .= ", `gold`='$max_gold', `stash`=`stash`-($max_gold-$row->gold)";
	$to_output .= 'You have withdrawn <b>'.number_format($amount).'</b> gold from your bank account.<br>';
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','5','$row->charname','$current_date','Withdrawed ".number_format($max_gold-$row->gold)." gold.','$current_time')") or die_nice(mysqli_error().'bank deposit');
	}else{
		$to_output .= 'Are you trying to rob the bank?<br>';
	}
}else{
	$to_output .= 'I don\'t understand you?!<br>';
}
}
?>
<table width=100% cellpadding=0 cellspacing=1 border=0>
<th colspan=4>Transactions</th></tr>
<tr><td width=5%>Gold</td><td width=45%><input type=text name=amount value="" maxlength=50></td><td width=20%><input type=submit name=action value=Deposit></td><td width=20%><input type=submit name=action value="Withdraw"></td></tr><tr><td colspan=2 width=50%><input type=submit name=action value="Deposit All"></td><td colspan=2 width=50%><input type=submit name=action value="Withdraw Max"></td></tr>
</table>

</form>
</td></tr></table>
<?php
//BANK ACCOUNT USING STASH

if(!empty($_POST['kingdoms'])){$kingdoms=round(clean_post($_POST['kingdoms']));}else{$kingdoms='';}

//KINGDOMS
if($tkresults = mysqli_query ($link, "SELECT * FROM `$tbl_kingdoms`WHERE `charname`='$row->charname' ORDER BY `x`,`y` ASC LIMIT 100")) {
if(mysqli_num_rows($tkresults) >= 1){
?>
<form method=post action="?visit=bank"><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=5>Transfer to my Kingdoms</th></tr><tr><td width=10%>Gold</td><td width=20%><input type=text name=amount value="" maxlength=50></td><td width=15% nowrap>Kingdoms</td><td width=40%><select name=kingdoms>
<?php
while ($tkrow = mysqli_fetch_object ($tkresults)) {
if ($kingdoms == $tkrow->id){
print '<option value="'.$tkrow->id.'" selected>'.ucfirst($tkrow->kingdom).' ('.$tkrow->x.'-'.$tkrow->y.')</option>';
if($row->stash >= $amount and $amount >= 1){
$to_update .= ", `stash`=`stash`-'$amount'";
mysqli_query ($link, "UPDATE `$tbl_kingdoms` SET `gold`=`gold`+'$amount' WHERE `id`='$tkrow->id' LIMIT 1") or die_nice(mysqli_error().'Bank error.');
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','5','$row->charname','$current_date','Transferred ".number_format($amount)." gold to $tkrow->kingdom kingdom.','$current_time')") or die_nice(mysqli_error().'bank deposit');
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','4','$tkrow->kingdom','$current_date','$row->sex $row->charname transferred ".number_format($amount)." gold from the bank.','$current_time')") or die_nice(mysqli_error().'bank deposit');
}
}else{
print '<option value="'.$tkrow->id.'">'.ucfirst($tkrow->kingdom).' ('.$tkrow->x.'-'.$tkrow->y.')</option>';
}
}
mysqli_free_result ($tkresults);
?>
</select></td><td width=15%><input type=submit name=transfer value="Transfer!"></td></tr></table><?php
}
}
//KINGDOMS


//TRANSFER BELOW THIS LINE
if(!empty($_POST['alfa'])){$alfa=clean_post($_POST['alfa']);}else{$alfa='';}
if(!empty($_POST['to'])){$to=clean_post($_POST['to']);}else{$to='';}

if (!empty($to) and $amount >= 1) {
if ($row->stash >= $amount) {

if($presult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE `charname`!='$row->charname' and `charname`='$to' ORDER BY `id` ASC LIMIT 1")) {
if(mysqli_num_rows($presult) >= 1) {
if($prow = mysqli_fetch_object ($presult)){
mysqli_free_result ($presult);

mysqli_query ($link, "UPDATE `$tbl_members` SET `stash`=`stash`+'$amount' WHERE `id`='$prow->id' LIMIT 1") or die_nice(mysqli_error().'Bank error.');
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','5','$row->charname','$current_date','Transferred ".number_format($amount)." gold to $prow->sex $prow->charname bank account.','$current_time')") or die_nice(mysqli_error().'bank deposit');
mysqli_query ($link, "INSERT INTO `$tbl_paper` values ('','5','$prow->charname','$current_date','$row->sex $row->charname deposited ".number_format($amount)." gold on your bank account.','$current_time')") or die_nice(mysqli_error().'bank deposit');

$to_update .= ", `stash`=`stash`-'$amount'";
$to_output .= 'You transferred <b>'.number_format($amount).'</b> gold to <b>'.$prow->sex.' '.$prow->charname.'\'s</b> bank account.<br>';

}
}else{$to_output .= 'There is no bank account of '.$to.'.<br>';}
}
}else{$to_output .= 'You do not have the amount of '.number_format($amount).' gold in you bank account.<br>';}
}
?>
<form method=post action="?visit=bank">
<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=5>Transfer to other players</th></tr>
<?if(!empty($_POST['alfa']) and strlen($_POST['alfa']) >= 2){?>

<input type=hidden name=alfa value="<?php print $alfa;?>">

<?php
if($oresult = mysqli_query ($link, "SELECT * FROM `$tbl_members` WHERE `charname`!='$row->charname' and `charname` LIKE CONVERT (_utf8 '%$alfa%' USING latin1) COLLATE latin1_swedish_ci ORDER BY `charname` ASC LIMIT 10")) {
if(mysqli_num_rows($oresult) >= 1) {
?><tr><td width=15% nowrap>Recipient</td><td width=35%><select name=to><?php
while ($orow = mysqli_fetch_object ($oresult)) {
print '<option value="'.$orow->charname.'">'.($orow->clan ? "[$orow->clan] ":'').' '.$orow->sex.' '.$orow->charname.'</option>';
}
mysqli_free_result ($oresult);
?></select></td><td width=5% nowrap>Gold</td><td width=45%><input type=text name=amount maxlength=50></td><td width=5%><input type=submit name=transfer value=Transfer></td></tr><?php
} else {?><tr><td width=20% nowrap>Player name</td><td width=40%><input type="text" name="alfa" maxlength="25" value=""></td><td width=40%><input type="submit" name=transfer value="Search for a player."></td></tr><?php$to_output .= 'Sorry we have no bank accounts containing those names!<br>';}
}}else{?><tr><td width=20% nowrap>Player name</td><td width=40%><input type="text" name="alfa" maxlength="25" value=""></td><td width=40%><input type="submit" name=transfer value="Search for a player."></td></tr><?php}?>
</table></form>
<?php
//NEWS PAPER LOCATION nid 5 bank
news_paper($row->charname,'5','Bank Transaction');
//NEWS PAPER LOCATION nid 5 bank
//NOOB
if($row->level <= $noob_level){
$to_output .= 'Gold can be found by just walking around, killing monsters or establishing a kingdom and collect taxes.<br>';
}
//NOOB
?>