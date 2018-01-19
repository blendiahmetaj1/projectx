<?php
#!/usr/local/bin/php
?>
<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th>Teleport Service</th></tr><tr><td>
A location full of monsters can get you killed when teleporting in the middle of it!<br>
<?php
if(!empty($_POST['teleported'])){$teleported=round(clean_post($_POST['teleported']));}else{$teleported='';}

//print_r($_POST);
?>
<table width=100% cellpadding=0 cellspacing=1 border=0>
<tr><th colspan=3>Reachable Kingdoms</th></tr>
<?php

//MY KINGDOMS
if($tkresults = mysqli_query ($link, "SELECT * FROM `$tbl_kingdoms`WHERE (`x` BETWEEN ".($row->x-15)." AND ".($row->x+15).") AND (`y` BETWEEN ".($row->y-15)." AND ".($row->y+15).") AND (`charname`='$row->charname') ORDER BY `kingdom` ASC LIMIT 100")) {
if(mysqli_num_rows($tkresults) >= 1){
?>
<form method=post action="?visit=teleport"><tr><td width=15% nowrap>My Kingdoms</td><td width=80%><select name=teleported>
<?php
while ($tkrow = mysqli_fetch_object ($tkresults)) {
if($tkrow->x.' '.$tkrow->y !== $row->x.' '.$row->y) {
if ($teleported == $tkrow->id){
print '<option value="'.$tkrow->id.'" selected>'.ucfirst($tkrow->kingdom).' ('.$tkrow->x.'-'.$tkrow->y.')</option>';
$to_update .= ", `x`='$tkrow->x', `y`='$tkrow->y'";
$to_output .= '<b>Teleporting to <b>'.$tkrow->kingdom.'</b> ('.$tkrow->x.'-'.$tkrow->y.') kingdom, please wait a moment!</b><br><meta http-equiv="refresh" content="3;URL=?player=kingdom">';
}else{
print '<option value="'.$tkrow->id.'">'.ucfirst($tkrow->kingdom).' ('.$tkrow->x.'-'.$tkrow->y.')</option>';
}
}
}
mysqli_free_result ($tkresults);
?>
</select>
</td><td width=5%><input type=submit name=action value="Go!"></td></tr></form>
<?php
}
}
//MY KINGDOMS

//KINGDOMS
if($tkresults = mysqli_query ($link, "SELECT * FROM `$tbl_kingdoms`WHERE (`x` BETWEEN ".($row->x-15)." AND ".($row->x+15).") AND (`y` BETWEEN ".($row->y-15)." AND ".($row->y+15).") AND (`charname`!='$row->charname') ORDER BY `x`,`y` ASC LIMIT 100")) {
if(mysqli_num_rows($tkresults) >= 1){
?>
<form method=post action="?visit=teleport"><tr><td width=15% nowrap>Kingdoms</td><td width=80%><select name=teleported>
<?php
while ($tkrow = mysqli_fetch_object ($tkresults)) {
if($tkrow->x.' '.$tkrow->y !== $row->x.' '.$row->y) {
if ($teleported == $tkrow->id){
print '<option value="'.$tkrow->id.'" selected>'.ucfirst($tkrow->kingdom).' ('.$tkrow->x.'-'.$tkrow->y.')</option>';
$to_update .= ", `x`='$tkrow->x', `y`='$tkrow->y'";
$to_output .= '<b>Teleporting to <b>'.$tkrow->kingdom.'</b> ('.$tkrow->x.'-'.$tkrow->y.') kingdom, please wait a moment!</b><br><meta http-equiv="refresh" content="3;URL=?player=kingdom">';
}else{
print '<option value="'.$tkrow->id.'">'.ucfirst($tkrow->kingdom).' ('.$tkrow->x.'-'.$tkrow->y.')</option>';
}
}
}
mysqli_free_result ($tkresults);
?>
</select>
</td><td width=5%><input type=submit name=action value="Go!"></td></tr></form>
<?php
}
}
//KINGDOMS
?>
</table>


</td></tr></table>
<?php
//NOOB
if($row->level <= $noob_level){
$to_output .='This teleport service is free however the teleport machine can\'t bring you too far.';
}
//NOOB

?>