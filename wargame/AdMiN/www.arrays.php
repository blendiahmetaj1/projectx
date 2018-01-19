<?php
#!/usr/local/bin/php

$helping = array('life points','income','troops','vehicles','airplanes','buildings',0,0,0,0,0);

$buildings = array(	//life,income,troops,vehicles,airplanes,buildings,0,0,0,0
'Headquarter' 			=> array(1000,$production,0,0,0,0,0,0,0,0),
'Scout Camp' 			=> array(500,0,0,0,0,0,0,0,0,0),
'Soldier Camp'			=> array(500,0,0,0,0,0,0,0,0,0),
'Grenadier Camp' 		=> array(500,0,0,0,0,0,0,0,0,0),
'RPG Camp' 			=> array(500,0,0,0,0,0,0,0,0,0),
'Sniper Camp' 			=> array(500,0,0,0,0,0,0,0,0,0),

'Beach Camp'			=> array(750,0,0,0,0,0,0,0,0,0),
'War Factory' 			=> array(750,0,0,0,0,0,0,0,0,0),
'Tank Compound' 		=> array(750,0,0,0,0,0,0,0,0,0),
'Heli Pad' 				=> array(750,0,0,0,0,0,0,0,0,0),
'Airfield' 				=> array(750,0,0,0,0,0,0,0,0,0),

'Guerrilla Camp' 		=> array(500,0,0,0,0,0,0,0,0,0),
'Stealth War Factory'	=> array(1000,0,0,0,0,0,0,0,0,0),
'Stealth Airfield' 		=> array(1000,0,0,0,0,0,0,0,0,0),
'Destruction Yard' 	=> array(1000,0,0,0,0,0,0,0,0,0),
'Research Center' 	=> array(1000,0,0,0,0,0,0,0,0,0),

'Airmissile Factory' 	=> array(1500,0,0,0,0,0,0,0,0,0),
'Underground Facility'	=> array(1500,0,0,0,0,0,0,0,0,0),
'Laser Factory' 		=> array(1500,0,0,0,0,0,0,0,0,0),
'Carrier Airfield' 		=> array(1500,0,0,0,0,0,0,0,0,0),
);

$units = array(		//life,income,troops,vehicles,airplanes,buildings,0,0,0,0
'Programmers' 			=> array(50,$production*2,0,0,0,0,0,0,0,0),
'Scout' 				=> array(50,0,0,0,0,0,0,0,0,0),
'Soldier' 				=> array(50,0,5,1,0,2,0,0,0,0),
'Grenadier' 			=> array(50,0,1,5,0,3,0,0,0,0),
'Rocketeer' 			=> array(50,0,1,5,5,3,0,0,0,0),
'Sniper' 				=> array(75,0,10,1,0,1,0,0,0,0),

'Buggy' 				=> array(100,0,15,5,0,3,0,0,0,0),
'Humvee' 				=> array(150,0,3,5,15,5,0,0,0,0),
'Tank' 					=> array(250,0,5,50,3,25,0,0,0,0),
'Apache' 				=> array(250,0,25,25,3,10,0,0,0,0),
'Fighter Jet' 			=> array(350,0,10,50,50,50,0,0,0,0),

'Tactical Team' 		=> array(500,0,100,100,0,100,0,0,0,0),
'Stealth Tank' 		=> array(750,0,10,100,10,100,0,0,0,0),
'Stealth Bomber' 		=> array(750,0,100,100,5,100,0,0,0,0),
'War Bulldozer' 		=> array(750,0,15,25,0,200,0,0,0,0),
'Hackers' 				=> array(500,0,1,100,100,100,0,0,0,0),

'Sam Truck' 			=> array(1000,0,0,0,250,0,0,0,0,0),
'Subterranean Tank'	=> array(1000,0,25,100,0,100,0,0,0,0),
'Laser Tank' 			=> array(2500,0,250,250,50,100,0,0,0,0),
'Airship Carrier' 		=> array(5000,0,350,350,350,350,0,0,0,0),
);

$units_name=array_keys($units);
?>