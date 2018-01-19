<?php
#!/usr/local/bin/php
/*
Script name	: Lol3 Player Classes II
Version		: 2.50
Release date	: 20-2-2001 0:54
Last Update	: 6-17-2002 03:13
Email		: silly@thesilent.com
Homepage	: http://www.thesilent.com
Created by	: Daniel Lee
Last modified by	: TheSilent
*/
$array_uniques = array(
// nine attributes '0', '0', '0', '0', '0', '0', '0', '0', '0'

'noobioso'			=> '1,2,3,4,5,6,7,58,59',
'rockon'			=> '1,2,3,4,7,8,9,58,59',
'fateless'			=> '48,49,50,51,52,59,0,0,0',
'mystizle'			=> '7,8,14,16,18,32,33,48,54',

'elphantos'			=> '1,4,5,7,8,10,26,27,0',
'murderioso'		=> '10,11,12,13,14,15,16,17,59',
'senseious'			=> '51,52,53,54,55,56,57,58,59',
'vampirous'		=> '51,52,45,46,47,48,49,0,0',
'muscleness'		=> '4,5,29,30,36,40,43,53,0',

'lifelicious'			=> '1,20,23,26,45,48,0,0,59',
'manalicious'		=> '2,21,24,27,46,49,0,0,59',
'stamilicious'		=> '3,22,25,28,47,50,0,0,59',
'battlelicous'		=> '4,5,6,10,11,35,36,56,59',
'magicous'		=> '7,8,9,12,13,37,38,57,59',

'regeneration'		=> '23,24,25,48,49,50,0,0,58',
'skillerz'		=> '56,57,58,59,56,57,58,59,59',

);
/*
'murderious'		=> '0,0,0,0,0,0,0,0,0',
'murderious'		=> '0,0,0,0,0,0,0,0,0',
'murderious'		=> '0,0,0,0,0,0,0,0,0',
'murderious'		=> '0,0,0,0,0,0,0,0,0',
'murderious'		=> '0,0,0,0,0,0,0,0,0',
0=0-------10=0 minimum damage--------20=0 life steal--------30=0 dexterity
1=1 life-------11=0 maximum damage--------21=0 mana steal--------31=0 agility
2=2 mana-------12=0 minimum spell--------22=22 stamina steal--------32=0 intelligence
3=0 stamina-------13=0 maximum spell--------23=0 regenerate life--------33=0 concentration
4=0 strength-------14=0 magic damage--------24=0 regenerate mana--------34=0 contravention
5=0 dexterity-------15=0 attack damage--------25=0 regenerate stamina--------35=0 minimum damage
6=0 agility-------16=0 magic rating--------26=0 life--------36=0 maximum damage
7=0 intelligence-------17=85 attack rating--------27=0 mana--------37=0 minimum spell
8=0 concentration-------18=0 magic shield--------28=0 stamina--------38=0 maximum spell
9=0 contravention-------19=0 defense--------29=0 strength--------39=0 magic damage
10=0 minimum damage-------20=0 life steal--------30=0 dexterity--------40=0 attack damage
11=0 maximum damage-------21=0 mana steal--------31=0 agility--------41=0 magic rating
12=0 minimum spell-------22=22 stamina steal--------32=0 intelligence--------42=0 attack rating
13=0 maximum spell-------23=0 regenerate life--------33=0 concentration--------43=0 magic shield
14=0 magic damage-------24=0 regenerate mana--------34=0 contravention--------44=0 defense
15=0 attack damage-------25=0 regenerate stamina--------35=0 minimum damage--------45=0 life steal
16=0 magic rating-------26=0 life--------36=0 maximum damage--------46=0 mana steal
17=85 attack rating-------27=0 mana--------37=0 minimum spell--------47=0 stamina steal
18=0 magic shield-------28=0 stamina--------38=0 maximum spell--------48=0 regenerate life
19=0 defense-------29=0 strength--------39=0 magic damage--------49=0 regenerate mana
20=0 life steal-------30=0 dexterity--------40=0 attack damage--------50=0 regenerate stamina
21=0 mana steal-------31=0 agility--------41=0 magic rating--------51=0 extra gold
22=22 stamina steal-------32=0 intelligence--------42=0 attack rating--------52=0 drop chance
23=0 regenerate life-------33=0 concentration--------43=0 magic shield--------53=0 battle skills power
24=0 regenerate mana-------34=0 contravention--------44=0 defense--------54=0 magic skills power
25=0 regenerate stamina-------35=0 minimum damage--------45=0 life steal--------55=0 defense skills power
26=0 life-------36=0 maximum damage--------46=0 mana steal--------56=0 battle skills
27=0 mana-------37=0 minimum spell--------47=0 stamina steal--------57=0 magic skills
28=0 stamina-------38=0 maximum spell--------48=0 regenerate life--------58=0 defense skills
29=0 strength-------39=0 magic damage--------49=0 regenerate mana--------59=0 all skill

$arrrrr = array(
'0=0',
'1=1 life',
'2=2 mana',
'3=0 stamina',
'4=0 strength',
'5=0 dexterity',
'6=0 agility',
'7=0 intelligence',
'8=0 concentration',
'9=0 contravention',
'10=0 minimum damage',
'11=0 maximum damage',
'12=0 minimum spell',
'13=0 maximum spell',
'14=0 magic damage',
'15=0 attack damage',
'16=0 magic rating',
'17=85 attack rating',
'18=0 magic shield',
'19=0 defense',
'20=0 life steal',
'21=0 mana steal',
'22=22 stamina steal',
'23=0 regenerate life',
'24=0 regenerate mana',
'25=0 regenerate stamina',
'26=0 life',
'27=0 mana',
'28=0 stamina',
'29=0 strength',
'30=0 dexterity',
'31=0 agility',
'32=0 intelligence',
'33=0 concentration',
'34=0 contravention',
'35=0 minimum damage',
'36=0 maximum damage',
'37=0 minimum spell',
'38=0 maximum spell',
'39=0 magic damage',
'40=0 attack damage',
'41=0 magic rating',
'42=0 attack rating',
'43=0 magic shield',
'44=0 defense',
'45=0 life steal',
'46=0 mana steal',
'47=0 stamina steal',
'48=0 regenerate life',
'49=0 regenerate mana',
'50=0 regenerate stamina',
'51=0 extra gold',
'52=0 drop chance',
'53=0 battle skills power',
'54=0 magic skills power',
'55=0 defense skills power',
'56=0 battle skills',
'57=0 magic skills',
'58=0 defense skills',
'59=0 all skill');

$i=9;$ii=19;$iii=29;
foreach ($arrrrr as $val){$i++;$ii++;$iii++;
print $val.'-------'.$arrrrr[$i].'--------'.$arrrrr[$ii].'--------'.$arrrrr[$iii].' <br>';
}
*/
?>