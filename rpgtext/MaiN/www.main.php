<?php
#!/usr/local/bin/php

$path_game = 'images';
$admin_name = 'Admin SilenT';

$server='rpgtext';
$paypal_email = 'paypal@thesilent.com';
$notify_url='http://www.thesilent.com/paypal/index.php';

//row->onoff 1 =login logout? 2-6 mini onoff
//row->kid = kingdom id, 10.000.000 = in a building or in a kingdom

//using in attack,stats,battlestats,www.battlestats
$stats = array ('life', 'mana', 'stamina', 'strength', 'dexterity', 'agility', 'intelligence', 'concentration', 'contravention');

//monster strength
$array_strength = array('almost dead','wounded','weak','tired','normal','strong','powerful','extra powerful','insane','frenzy','master','boss','super boss','mega boss', 'ultra boss', 'uber boss', 'ultimate boss', 'extinction boss');

//using in footer
$action_players = array('main','stats','inventory','kingdom','kill','talk');


$current_date =date('dm H:i');
$current_time = round(array_sum(explode(" ", microtime())), 2);

//print $current_date.' '.$current_time;

//STATIC
$max_inventory =25;
$max_charms =10;
$max_monsters = 25;
$max_potions=250;
$max_honor=75;
$max_exp_gain = 25;
$min_succes_chance =5;
$kingdom_level=3;
$max_rounds=50;
$max_gold_drop=250000;
$noob_level = 1000;
$online_show = 1000;
//STATIC

//LEVEL DEPENDENT
$max_gold = 50000;
$max_skills =3;
$max_life = 250;
$max_mana=25;
$max_stamina=25;
$use_battle = 3;
$use_skill= 15;
//LEVEL DEPENDENT


$is_kingdom=array();

$to_output = '';
$to_output2 = '';

//COLORS
$colbg = '#000000';
$coltext = '#FFFFFF';
$collink = '#FFF888';
$colth = '#123456';
$fontfamily = 'Arial, Verdana, Monaco';

$col_buildings = '#228888';
$col_talk = '#00FF00';
$col_attack = '#880000';
$col_kingdom = '#188818';

$col_melee = '#FF000';
$col_magic = '#8888FF';
$col_heal = '#88FF88';

$col_drop = '#888FFF';
$col_steal = '#FF0000';
$col_regen = '#00FF00';

$col_quests = '#88FFFF';
//COLORS
?>