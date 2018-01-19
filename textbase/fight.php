<?
#!/usr/local/bin/php
require_once('AdMiN/www.main.php');
require_once('AdMiN/www.functions.php');
require_once 'AdMiN/array.races.php';
require_once 'AdMiN/www.battle.php';
include_once("$game_header");
if(empty($_POST['difficulty'])){$difficulty=1;}else{$difficulty=$_POST['difficulty'];if($difficulty < 1){$difficulty=1;}}
$next_level = next_level();

if($row->exp < $next_level){

if(!empty($_POST['monster']) and !empty($_POST['action'])){
$monster=$_POST['monster'];
$action=$_POST['action'];
$monster_level=preg_replace("/ - .*?$/i", "", $monster);if($monster_level <= 0){$monster_level=1;}
$monster=preg_replace("/,/i", "", $monster);

$mon=array();
for($i=0; $i <= 16; $i++){
$calcite=(100+((1+$i)*(1+$i))*$i)*($difficulty);
array_push($mon, $calcite);
}

$mnum = array("'^.*? \- '","' \- .*?$'");$mnuma = array("","");
$mon[15]=preg_replace($mnum, $mnuma, $monster); //monster name
$mnum = array("'^.*? \- '","'^.*? \- '");$mnuma = array("","");
$mon[13]=(96+((1+$monster_level)*(1+$monster_level))*$monster_level)*($difficulty); // monster exp

$mon[0]=($mon[13]+$mon[0])/15;
$mon[1]=($mon[13]+$mon[1])/5;
$mon[2]=($mon[13]+$mon[2])/15;
$mon[3]=($mon[13]+$mon[3])/3;
$mon[4]=($mon[13]+$mon[4])/15;
$mon[5]=($mon[13]+$mon[5])/4;
$mon[6]=($mon[13]+$mon[6])/15;
$mon[7]=($mon[13]+$mon[7])/6;
$mon[8]=($mon[13]+$mon[8])/15;
$mon[9]=($mon[13]+$mon[9])/7;
$mon[10]=($mon[13]+$mon[10])/25;
$mon[11]=($mon[13]+$mon[11])/25;
$mon[12]=($mon[13]+$mon[12])/5;
$mon[14]=$mon[13]/3;
$mon[17]="";
$mon[18]="";
$mon[19]="";
$mon[20]="";
$mon[21]=$mon[10]/2.5;
$mon[22]=$mon[11]/2.5;
?>
<table cellpadding=2 cellspacing=2 border=0 width=100%><tr>
<th colspan=6><? echo $row->sex.' '.$row->charname;?> vs <a name=monster><? echo $mon[15];?></a></th></tr><tr>
<?
$def=battlestats($row);
echo '<td align=right valign=top width=20%><a name=monster>Min<br>'.number_format($mon[0]).'<br>'.number_format($mon[2]).'<br>'.number_format($mon[4]).'<br>'.number_format($mon[6]).'<br>'.number_format($mon[8]).'<br>'.number_format($mon[21]).'<br>'.number_format($mon[22]).'</a></td><td align=right valign=top width=20%><a name=monster>Max<br>'.number_format($mon[1]).'<br>'.number_format($mon[3]).'<br>'.number_format($mon[5]).'<br>'.number_format($mon[7]).'<br>'.number_format($mon[9]).'<br>'.number_format($mon[10]).'<br>'.number_format($mon[11]).'</a></td></tr></table>';
?>
<table cellpadding=2 cellspacing=2 border=0 width=100%><tr><tr><th colspan=4>monster stats</th></tr><tr><td>level : <? echo number_format($monster_level); ?></td><td>life : <? echo number_format($mon[12]).'</td><td>exp : '.number_format($mon[13]).'</td><td>gold : '.number_format($mon[14]).'</td></tr></table>';

if($def[0] and $mon[0]){
$def[17]=substr($def[15], 0, 4);
$def[17]="You";
$def[18]="Your";
$def[19]="you";

$mon[17]=substr($mon[15], 0, 4);
if(preg_match("/^[AEOIU]/i",$mon[17])){
$mon[17]="She";
$mon[18]="Her";
$mon[19]="her";
}else{
$mon[17]="He";
$mon[18]="His";
$mon[19]="him";
}

$wdef=array($mon[17],$mon[18],$def[15],$def[17],$def[18],$def[19]);
$wopp=array($def[17],$def[18],$mon[15],$mon[17],$mon[18],$mon[19]);
$num=0;
$randdiv = array_rand($divs, 2);
$mon[10] =($mon[10]+$mon[21])/$divs[$randdiv[0]];
$mon[11] =($mon[11]+$mon[22])/$divs[$randdiv[1]];
$randdiv = array_rand($divs, 2);
$def[10] =($def[10]+$def[21])/$divs[$randdiv[0]];
$def[11] =($def[11]+$def[22])/$divs[$randdiv[1]];

$battles=0;
while($def[12] >=0 and $mon[12] >=0 and $battles < 5){
$battles++;echo "<b>Round $battles</b><br>";
if($def[1] > $def[3]){
if($def[12] >=0 and $mon[12] >=0){$mon[12]=weapon($def,$mon,$wopp,$divs);}else{break;}
if($def[12] >=0 and $mon[12] >=0){$def[12]=weapon($mon,$def,$wdef,$divs);}else{break;}
if($def[12] >=0 and $mon[12] >=0){$mon[12]=magic($def,$mon,$wopp,$divs);}else{break;}
if($def[12] >=0 and $mon[12] >=0){$def[12]=magic($mon,$def,$wdef,$divs);}else{break;}
if($def[12] >=0 and $mon[12] >=0){$mon[12]=heal($def,$mon,$wopp,$divs);}else{break;}
if($def[12] >=0 and $mon[12] >=0){$def[12]=heal($mon,$def,$wdef,$divs);}else{break;}
}else{
if($def[12] >=0 and $mon[12] >=0){$mon[12]=magic($def,$mon,$wopp,$divs);}else{break;}
if($def[12] >=0 and $mon[12] >=0){$def[12]=magic($mon,$def,$wdef,$divs);}else{break;}
if($def[12] >=0 and $mon[12] >=0){$mon[12]=weapon($def,$mon,$wopp,$divs);}else{break;}
if($def[12] >=0 and $mon[12] >=0){$def[12]=weapon($mon,$def,$wdef,$divs);}else{break;}
if($def[12] >=0 and $mon[12] >=0){$mon[12]=heal($def,$mon,$wopp,$divs);}else{break;}
if($def[12] >=0 and $mon[12] >=0){$def[12]=heal($mon,$def,$wdef,$divs);}else{break;}
}
}//while
}

if($mon[12] <= 0){
$mon[21]=($mon[13]/5)*(1+$def[20]);
$mon[22]=($mon[14]/5)*(1+$def[20]);
$randdiv = array_rand($divs, 2);
$mon[21] =($mon[0]+$mon[21])/$divs[$randdiv[0]];
$mon[22] =($mon[2]+$mon[22])/$divs[$randdiv[0]];
$mon[13]=round($mon[13],-1);
$mon[14]=round($mon[14],-1);
$mon[21]=round($mon[21],-1);
$mon[22]=round($mon[22],-1);
if($mon[21] >= $mon[13]){
$mon[21]=$mon[13];
}
if($mon[22] >= $mon[14]){
$mon[22]=$mon[14];
}

if($freeplay >= 1){
 $fbonus=rand(1,25);
 $mon[21]=$mon[21]*$fbonus;
 $mon[22]=$mon[22]*$fbonus;
 $fbonus="<br>Your freeplay bonus was ".number_format($fbonus*100)."%!.";
}else{
 $fbonus='';
}
if($mon[21] <= 0){$mon[21]=0;}if($mon[22] <= 0){$mon[22]=0;}
if($mon[21] > 0 or $mon[22] > 0){
$safe_exp=$row->exp+$mon[21];if($safe_exp < 0){$safe_exp=$row->exp;}
$safe_gold=$row->gold+$mon[22];if($safe_gold < 0){$safe_gold=$row->gold;}
mysql_query("update $tbl_members SET exp=$safe_exp,gold=$safe_gold where(id=$row->id and charname='$row->charname') limit 1");
 if(!empty($row->friend)){
myfriend($mon[21],$mon[22],$row->friend);
 }


}

$news = "You have slain $mon[15]. You win ".number_format($mon[21])." exp and ".number_format($mon[22])." gold. $fbonus";
}elseif($def[12] <= 0){
mysql_query("update $tbl_members SET exp=exp/1.01,gold=gold/1.01 where(id=$row->id and charname='$row->charname') limit 1");

$news = "You have been slain by $mon[15]. You lose ".number_format($row->exp/100)." exp and ".number_format($row->gold/100)." gold.";
}else{
$news = "The battle tied.";
}
print "<b>$news</b><br>";
?>
Next level <? echo number_format($next_level); ?> exp.
<?
}else{
?>
<a href="fight_control.php?sid=<? echo $sid;?>" target="lol_fcontrol">Click here to open fight controls!</a>
<?
}
}else{
echo "<b>Congratulations you have leveled up for reaching ".number_format($next_level)." exp</b>";
include_once('stats.inc.php');
}
include_once("$game_footer");
?>