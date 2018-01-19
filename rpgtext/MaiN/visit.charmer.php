<?php
#!/usr/local/bin/php
$item = 'charm';
if(!empty($_GET['buy'])) {$buy = clean_post($_GET['buy']);}else{$buy='';}

?>
<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=3>Charmer</th></tr>
<tr><td>Need some extra power? I'll see if I can find something for you!<br>
</td></tr>
</table>

<?php
if (!empty($item)) {


if($sresult = mysqli_query ($link, "SELECT * FROM `$tbl_charms` WHERE (`charname`='') ORDER BY `id` DESC LIMIT 2")){
if(mysqli_num_rows($sresult) >= 1) {
?><table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=2>Selling <?php print $item;?>'s</th></tr><tr><?php
while($crow = mysqli_fetch_object ($sresult)) {
$itemcost=charm_cost($crow)*2;

print '<td align=center valign=top>';
if ($row->gold >= $itemcost) {print '<a href="?visit=charmer&item='.$item.'&buy='.$crow->id.'"><img src="'.$path_game.'/buttons/buy.gif" border=0 title="Buy"></a><br>';}else{print 'No Gold<br>';}

foreach ($stats as $val){
if($crow->$val >= 1){
print '+'.$crow->$val.'% '.$val.'<br>';
}
}


//BUYING OR COST
if($buy == $crow->id) {

if($aresult = mysqli_query ($link, "SELECT `id` FROM `$tbl_charms` WHERE (`charname`='$row->charname') ORDER BY `id` DESC LIMIT 25")){
if(mysqli_num_rows($aresult) < $max_charms){

if ($row->gold >= $itemcost) {
mysqli_query ($link, "UPDATE `$tbl_charms` SET `charname`='$row->charname' WHERE `id`='$crow->id' LIMIT 1") or die_nice(mysqli_error());
$to_update .= ", `gold`=`gold`-$itemcost";
$to_output .= 'Bought yourself a nice <b>'.$crow->name.' '.$item.'</b> for '.number_format($itemcost).' gold.<br>';
}else{
$to_output .= 'You do not have the gold to buy this <b>'.$crow->itemname.' '.$item.'</b> it costs '.number_format($itemcost).' gold.<br>';
}

}else{
$to_output .= 'Your charm slots are full.<br>';
}
mysqli_free_result ($aresult);
}

$buy ='';
}else{
print 'Cost '.number_format($itemcost).' gold</td>';
}
//BUYING OR COST

}
mysqli_free_result ($sresult);
?></tr></table><?php
}else{$to_output .= 'Sorry we are out of <b>'.$item.'</b>, please come back later again.<br>';}
}


//GET ITEMS

}
?>
<table width=100% cellpadding=0 cellspacing=1 border=0><tr><th colspan=2> </th></tr><tr><td><img src="<?php print $path_game;?>/buttons/buy.gif" border=0 title="Buy">=Buy</td></tr></table>
<?php
//NEWS PAPER LOCATION nid 7 charmer
news_paper('','7','Log Book');
//NEWS PAPER LOCATION nid 7 charmer

//NOOB
if($row->level <= $noob_level){
$to_output .= 'If a player sells charms it will be sold here.';
}
//NOOB
?>