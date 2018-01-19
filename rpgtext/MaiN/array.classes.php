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
$array_classes = array(
/*
classname	=>array(
					0 weapon damage, 1 attack rating, 2 defense power,
					3 magic damage, 4 magic rating, 5 magic shield, 6 skill bonus%,
					7% life mulitplier, 8% mana mulitplier, 9% stamina mulitplier,
					,)
*/

//MELEE RACES
'barbarian'	=> array(5,5,3, 1,1,3, 10, 5,2,3),
'knight'		=> array(5,3,5, 1,1,3, 10, 5,2,3),
'ninja'		=> array(3,5,5, 1,1,3, 10, 5,2,3),

'samurai'	=> array(5,3,2, 3,2,3, 10, 3,2,5),
'amazon'	=> array(3,5,2, 3,3,2, 10, 3,2,5),
'android'	=> array(3,2,5, 2,3,3, 10, 3,2,5),

'paladin'	=> array(5,3,2, 5,1,2, 10, 5,3,2),
'rogue'		=> array(3,5,2, 1,5,2, 10, 5,3,2),
'ranger'	=> array(3,2,5, 2,1,5, 10, 5,3,2),


//MYSTIC RACES
'dracu'		=> array(1,1,1, 5,5,3, 10, 5,2,3),
'necro'		=> array(1,1,1, 5,3,5, 10, 5,2,3),
'monk'		=> array(1,1,1, 3,5,5, 10, 5,2,3),

'wizard'	=> array(3,2,3, 5,3,2, 10, 3,2,5),
'druid'		=> array(3,3,2, 3,5,2, 10, 3,2,5),
'sorcerer'	=> array(2,3,3, 3,2,5, 10, 3,2,5),

'mage'		=> array(5,1,2, 5,3,3, 10, 5,3,2),
'bard'		=> array(1,5,2, 3,5,2, 10, 5,3,2),
'cleric'		=> array(2,1,5, 3,2,5, 10, 5,3,2),


//'ghost'	=> array(1,1,1,1,1,1,5,2,2,2),
//'spirit'	=> array(1,1,1,1,1,1,5,2,2,2),

);
?>