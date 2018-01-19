<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.functions.php';
include_once 'templates/game.header.php';

$server = 'warunit';
$paypal_email = 'paypal@thesilent.com';

$sitems=array(
									//cost, Offense Defense
'General' 		=> array(2500,25,'% Offense & Defense'),
'Brigadier' 	=> array(2000,20,'% Offense & Defense'),
'Colonel' 		=> array(1500,15,'% Offense & Defense'),
'Major' 			=> array(1000,10,'% Offense & Defense'),
'Captain' 		=> array(500,5,'% Offense & Defense'),
'Lieutenant' => array(300,3,'% Offense & Defense'),
'Gold' => array(100,500000000,'gold'),
'Land' => array(100,5000,'land'),
);



$cobj->credits=0;
if($cresult=mysqli_query( "SELECT * FROM `$tbl_credits` WHERE (`username`='$row->id' and `charname`='$row->charname') ORDER BY `id` DESC LIMIT 1")){
if($cobj=mysqli_fetch_object($cresult)){
mysqli_free_result($cresult);
if($cobj->credits >= 1 and !empty($_POST['action'])){
	$action=$_POST['action'];
if($cobj->credits >= $sitems[$action][0]){
	$action = clean_post($_POST['action']);

if ($action == 'Gold' or $action == 'Land') {
print 'Traded '.$sitems[$action][0].' credits for '.number_format($sitems[$action][1]).' '.$action.'.';
$update_it.=", ".$sitems[$action][2]."=".$sitems[$action][2]."+".$sitems[$action][1];
}else{
if ($row->sex == 'Lieutenant'){
	$sitems[$action][0] -= 300;
}elseif ($row->sex == 'Captain'){
	$sitems[$action][0] -= 500;
}elseif ($row->sex == 'Major'){
	$sitems[$action][0] -= 1000;
}elseif ($row->sex == 'Colonel'){
	$sitems[$action][0] -= 1500;
}elseif ($row->sex == 'Brigadier'){
	$sitems[$action][0] -= 2000;
}

print 'You just became an '.$action.' for '.$sitems[$action][0].' credits.';
$update_it.=", `sex`='$action'";
$row->sex = $action;
$special_bonus = $sitems[$action][1];
}

mysqli_query ($link, "UPDATE `$tbl_credits` SET `credits`=".($cobj->credits-$sitems[$action][0])." WHERE `id`=$cobj->id LIMIT 1");

}
}
}else{print mysqli_error();}
}
if (!isset($cobj->credits)) {
	$cobj->credits=0;
}
?>
<table width="100%"><tr><th>This game is brought to you by the players that have donated real money.
</th></tr><tr><th>You have <?php print number_format($cobj->credits); ?> credits.</th></tr>
<tr><th><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=<?php print $paypal_email;?>&undefined_quantity=1&item_name=Donation for credits from <?php print $row->sex.' '.$row->charname;?> on <?php print $server;?>&item_number=Game:Warunit,Server:<?php print $server;?>,Charname:<?php print $row->charname;?>&amount=3.00&no_shipping=1&return=<?php print $root_url;?>/thanks.php&cancel_return=<?php print $root_url;?>/thanks2.php&notify_url=<?php print $notify_url;?>&lc=US" target="_blank">Donate and get creditS</a></th></tr>
</table><form method=post><table><tr><th>Rank/Item</th><th>Description</th><th>Cost</th></tr>
<?php
foreach ($sitems as $key=>$val){
if ($key !== 'Gold' and $key !== 'Land') {
if ($row->sex == 'Lieutenant'){
	$val[0] -= 300;
}elseif ($row->sex == 'Captain'){
	$val[0] -= 500;
}elseif ($row->sex == 'Major'){
	$val[0] -= 1000;
}elseif ($row->sex == 'Colonel'){
	$val[0] -= 1500;
}elseif ($row->sex == 'Brigadier'){
	$val[0] -= 2000;
}
if ($val[0] <= 0){$val[0]=0;}
}
print '<tr><td>';
if ($cobj->credits >= $val[0] and $special_bonus < $val[1]) {print '<input type=submit name=action value="'.$key.'" style="width:100%;">';
}else{print $key;}
print '</td><td>+'.number_format($val[1]).' '.$val[2].'</td><td>'.number_format($val[0]).' Credits</td></tr>';

}
?></table></form><br>You get 100 credits for each $1 dollar you donate to the game.<br>You get rank for life, extra 1 stealth points and <?php print number_format((($row->land)+($row->b1*50)+($row->u1*25))-($row->u1+$row->u2+$row->u3+$row->u4+($row->u5*3)));?> gold per tax collection.<br><?php
include_once 'templates/game.footer.php';
?>