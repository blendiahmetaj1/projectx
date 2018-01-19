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
$array_sets = array(
// nine attributes '0', '0', '0', '0', '0', '0', '0', '0', '0'

'barbaja'		=> '10,11,15,35,36,40,20,0,59',
'knighting'		=> '18,19,43,44,35,36,20,0,59',
'ninjitsi'		=> '17,18,19,40,42,43,44,0,59',
'samuraia'		=> '11,36,20,21,22,48,0,0,59',
'amazonium'	=> '17,42,45,46,47,0,0,0,59',
'androidide'	=> '19,44,19,44,19,44,0,0,59',
'paladinus'		=> '10,11,15,17,20,48,0,0,59',
'rogue spear'	=> '5,15,16,17,14,23,0,0,59',
'drangers'		=> '1,26,6,31,44,40,0,0,59',
'dracularius'	=> '7,8,32,33,14,16,39,0,59',
'necronomon'	=> '1,9,26,34,18,43,0,0,59',
'monkies'		=> '8,9,41,43,48,1,0,0,59',
'wizardius'		=> '48,43,7,32,39,49,0,0,59',
'druidonge'		=> '48,49,50,26,27,28,0,0,59',
'sorcersias'	=> '7,26,32,48,49,52,51,0,59',
'magicius'		=> '32,33,34,39,43,48,0,0,59',
'bardicus'		=> '33,37,38,48,49,12,13,0,59',
'clericassa'		=> '9,34,58,41,43,18,23,0,59',

//SET CLASS

'maki fly'		=> '1,4,5,7,8,10,26,27,0',
'bonez'			=> '1,20,21,26,27,0,0,0,0',
'shinzo'			=> '1,2,23,24,25,26,27,52,0',
'hentio'			=> '1,26,51,56,56,59,10,11,0',
'mafalo'		=> '1,26,51,56,59,0,0,0,0',

'silentio'		=> '48,49,50,51,52,0,0,0,59',
'maximus'		=> '26,27,28,32,33,34,0,0,57',
'diablo'			=> '10,11,12,13,14,15,20,21,22',
'satanos'		=> '20,21,22,36,38,11,13,51,52',
'mafioso'		=> '26,27,28,29,30,31,0,0,56',

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
);
?>