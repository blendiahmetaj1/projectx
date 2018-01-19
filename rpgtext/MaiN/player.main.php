<?php
#!/usr/local/bin/php
?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th>Character Info</th><th>Minimap</th></tr>
<tr><td valign=top>
<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><td valign=top><font size=-1>Sex<br>Charname<br>Class<br>Level<br>Exp<br>Life<br>Mana<br>Stamina<br>Gold<br>Bank<br>Quests<br>Honor<br>Freeplay</font></td><td valign=top><font size=-1><?php print $row->sex.'<br>'.$row->charname.'<br>'.$row->class.'<br>'.number_format($row->level).'<br>'.number_format($row->exp).'<br>'.number_format($row->life).'<br>'.number_format($row->mana).'<br>'.number_format($row->stamina).'<br>'.number_format($row->gold).'<br>'.number_format($row->stash).'<br>'.number_format($row->quests).'<br>'.number_format($row->honor, 2).'<br>'.number_format($freeplay); ?><br></font></td></tr>
</table></td><td valign=top width=120 valign=top>
<?php
include_once 'MaiN/www.minimap.php';
//MAP PRINTING (show locations 0 or 1, show kingdoms 0 or 1)
minimap(1,1);
//MAP PRINTING

?></td></tr><tr><th colspan=2>Next level at <?php echo number_format($next_level); ?> exp.</th></tr></table><?php
//SUPPORT
if($row->level >= 25) {
$multier=round($row->level/250);if($multier<1){$multier=1;}

$sitems=array(
'Experience' => array(100,500000000,'exp','experience'),
'Gold' => array(50,500000000,'stash','gold'),
'Freeplay 30' => array(500,'2592000','freeplay','Freeplay for 30 days'),
'Freeplay 5' => array(100,'432000','freeplay','Freeplay for 5 days'),
'Heavenly Charm' => array(2000,'','','+100% to all stats, +1mil active'),
'Gods Charm' => array(2500,'','','+127% to all stats, +1mil active'),
);



$cobj->credits=0;if($cresult=mysqli_query( "SELECT * FROM `$tbl_credits` WHERE (`username`='$row->username' and `charname`='$row->charname') ORDER BY `id` DESC LIMIT 1")){
if($cobj=mysqli_fetch_object($cresult)){
mysqli_free_result($cresult);
if($cobj->credits >= 1 and !empty($_POST['action'])){
$action=clean_post($_POST['action']);
if(array_key_exists($action,$sitems)){

if($cobj->credits >= $sitems[$action][0]){
if(empty($sitems[$action][1]) and empty($sitems[$action][2])){
	//CHARM

if($action == 'Gods Charm'){
mysqli_query ($link, "INSERT INTO `$tbl_charms` VALUES ('','$row->charname','Gods Charm',127,127,127,127,127,127,127,127,127,$current_time+1000000)") or die_nice(__FILE__.'-'.__LINE__.'-'.__FUNCTION__.'-'.__CLASS__.'-'.__METHOD__.mysqli_error());
?>Traded some credits for a Gods Charm.<?php
}elseif($action == 'Heavenly Charm'){
mysqli_query ($link, "INSERT INTO `$tbl_charms` VALUES ('','$row->charname','Heavenly Charm',100,100,100,100,100,100,100,100,100,$current_time+1000000)") or die_nice(__FILE__.'-'.__LINE__.'-'.__FUNCTION__.'-'.__CLASS__.'-'.__METHOD__.mysqli_error());
?>Traded some credits for a Heavenly Charm.<?php
}

	//CHARM
}else{
	//OTHER
if($action == 'Freeplay 30'){
	$to_update.=", `".$sitems[$action][2]."`=$current_time+".$sitems[$action][1];
}elseif($action == 'Freeplay 5'){
	$to_update.=", `".$sitems[$action][2]."`=$current_time+".$sitems[$action][1];
}else{
	$to_update.=", `".$sitems[$action][2]."`=`".$sitems[$action][2]."`+".($sitems[$action][1]*$multier);
}

$to_output .= 'Traded '.number_format($sitems[$action][0]).' Credits for ';
$to_output .= $sitems[$action][1]>=1?number_format($sitems[$action][1]*$multier):'';
$to_output .= ' '.$action.'!<br>';
	//OTHER
}
mysqli_query ($link, "UPDATE `$tbl_credits` SET `credits`=".($cobj->credits-$sitems[$action][0])." WHERE `id`=$cobj->id LIMIT 1") or die_nice(__FILE__.'-'.__LINE__.'-'.__FUNCTION__.'-'.__CLASS__.'-'.__METHOD__.mysqli_error());
$cobj->credits-=$sitems[$action][0];
}

}}}}
?>
<table width="100%"><tr><th><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=<?php print $paypal_email;?>&undefined_quantity=1&item_name=Buy Credits for <?php print $row->sex.' '.$row->charname;?> on <?php print $server;?>&item_number=Game:rpgtext,Server:<?php print $server;?>,Charname:<?php print $row->charname;?>&amount=5.00&no_shipping=1&notify_url=<?php print $notify_url;?>" target="_blank">Buy 500 Credits for $5.00</a><br>You have <?php print number_format($cobj->credits);?> credits</th></tr>
</th></tr></table>

<form method="post" action="?player=main"><table width="100%"><tr><th colspan="4">A list of items that can be traded for your credits</th></tr><tr><td>Description / Amount</td><td>Credits</td><td>Trade</td></tr>
<?php
foreach($sitems as $key=>$val){
?><tr<?if(empty($bg)){?> bgcolor="<?php print $colth;$bg=1;?>"<?php}else{$bg='';}?>>
<td><?php print $val[1]>=1?number_format($val[1]*$multier):'';?> <?php print $val[3];?></td><td nowrap><?php print number_format($val[0]);?></td><td align="center"><?php
if(preg_match("/^Freeplay/i",$key)){

if($freeplay >= 100){print 'Enough freeplay';}elseif($freeplay <= 100 and $cobj->credits >= $val[0]){
	?><input type="submit" name="action" value="<?php print $key;?>"><?php
}else{?>Insufficient credits<?}

}elseif(preg_match("/Charm$/i",$key)){

if($hresult=mysqli_query ($link, "SELECT `id` FROM `$tbl_charms` WHERE `charname`='$row->charname' LIMIT 10")){
$openslots =mysqli_num_rows($hresult);
mysqli_free_result($hresult);
}

if($cobj->credits >= $val[0] and $openslots < $max_charms){
	?><input type="submit" name="action" value="<?php print $key;?>"><?php
	}else{
		if($cobj->credits >= $val[0]){
			?>No open Charm slots.<?php
		}else{
			?>Insufficient credits<?
		}
		}

}elseif($cobj->credits >= $val[0]){
	?><input type="submit" name="action" value="<?php print $key;?>"><?php
}else{
	?>Insufficient credits<?
}?></td></tr><?php
}
?>
</table></form>
<?php
}
//SUPPORT
//NEWS PAPER LOCATION nid 1main
news_paper($row->charname,'1','News');
//NEWS PAPER LOCATION nid 1 main
$to_output .= 'You can carry '.number_format($max_gold).' gold max.<br>';
//NOOB
if($row->level <= $noob_level){
$to_output .= 'To turn on or off the background in minimap just click on Minimap or click on any other legend items to see them only on the map and You for normal map view.';
}
//NOOB
?>