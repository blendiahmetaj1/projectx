<?php
#!/usr/local/bin/php
require_once 'MaiN/www.main.php';
require_once 'MaiN/site.header.php';
require_once 'MaiN/array.attributes.php';
?>
<table width=450><tr><td><b>News and workarounds</b><br>
<table width=100%>

<tr><dl><dt>2-18-2008 03:45:17</dt><dd>
Upcoming improvements, news and changes will be posted on <a href="http://www.thesilent.com">thesilent.com</a>
</dd></dl></tr>

<tr><dl><dt>13-1-2008 19:56</dt><dd>
RPG Text:
New Killing Spree kills up to 3 monsters in a single click any visible monster on the map.<br>
Only available to Freeplay players that are level 100 or above.<br>
To attack a group of monsters you must have at least 5 battle skills and magic skills.<br>
Monsters in a group are much stronger than they appear to be.<br>
New Screenshots of the killing spree.
</dd></dl></tr>

<tr><dl><dt>11-1-2008 17:51</dt><dd>
Fixed some bugs thanks to <a href="ladder.php?show=Hanzaemon">Lord Hanzaemon</a>.<br>
Added <a href="stuff.php">Latest item Drops.</a>.
</dd></dl></tr>

<tr><dl><dt>04-04-07 03:10</dt><dd>
Paypal activated, freeplay will give players double exp and gold win on win and extra 100.000 max life!!!</dd></dl></tr>

<tr><dl><dt>
2-4-2007 18:17</dt><dd>
Running away from monsters won't cause you to lose honor anymore.<br>
More bonus from set items.</dd></dl></tr><tr><dl><dt>
04-01-07 23:59</dt><dd>
Quests 10 reward with Monster Identify Skill.</dd></dl></tr><tr><dl><dt>
1-4-2007 18:25</dt><dd>
Tuned here and there made the monsters easier they where too difficult.</dd></dl></tr><tr><dl><dt>
30-3-2007 23:53</dt><dd>
Added quests 7 the teleport skill, you can use teleport anywhere on any map when quest completed.<br>
Added quest 8 the survival skill, if you have 10.000 life or more left and quests complete you always have 1 life remaining!<br>
Added quest 9 the honor skill, free run or hide action it won't cause you to lose honor!<br>
<b>Honor is important for succes rate, sieging kingdoms and drop chance and gold drops multipliers.</b><br>
Made monsters a little bit easier had made it too hard to beat them, maybe still too hard going to make easier again in a few days.</dd></dl></tr><tr><dl><dt>
3-27-2007 22:12</dt><dd>
Kingdom siege implemented, more guards for more defence in a kd. If a char is stronger than the kd forces there is a 3% success chance.</dd></dl></tr><tr><dl><dt>
03-26-07 03:59</dt><dd>
Quest is back up a little bit changes here and there.<br>
New quest for some cool items.<br>
The layout changes after level 100 and basic information disappears.</dd></dl></tr><tr><dl><dt>
03-24-07 04:52</dt><dd>
Changes made, Exit a mini is shown by a swirl at the beginning of the portal,<br>
Minimap showing borders now, kd can be established everywhere, better map system, <br>
to open secret levels when drinking a life or a mana potion on the right spot,<br>
set items can be dropped by level 100 and unique items can only be dropped by level 150 and up,<br>
monster level decides how much gold is dropped and not the player level,<br>
here and there allot more changes, just check it out.</dd></dl></tr><tr><dl><dt>
03-23-07 04:23</dt><dd>
Redone the maps, email me maps if you have some, <a href="?examples=1">examples</a>.<br>
<?php
if(!empty($_GET['examples'])){
?><br>Maps will be splitter with a script into tiles of 100x100<br><img src="images/maps/default.jpg"><br><img src="images/maps/pond.jpg"><br><img src="images/maps/streets.jpg"><br><?php
}
?></dd></dl></tr><tr><dl><dt>
03-22-07 05:13</dt><dd>
First 2 quest installed great rewards.</dd></dl></tr><tr><dl><dt>
03-22-07 03:21</dt><dd>
Quick ladder update</dd></dl></tr><tr><dl><dt>
03-22-07 02:52</dt><dd>
Added some secret maps and other secrets to the game</dd></dl></tr><tr><dl><dt>
03-22-07 01:33</dt><dd>
News accounts get 3 Unique powerful items instead of one to start the game!</dd></dl></tr><tr><dl><dt>
3/21/2007 8:45PM</dt><dd>
Modified the dropping factors, more items will be dropped by monsters and items stats are boosted!</dd></dl></tr><tr><dl><dt>
03-21-07 04:32</dt><dd>
Bug causing no extra defense when Agility was added has been found and fixed.</dd></dl></tr><tr><dl><dt>
03-21-07 03:28</dt><dd>
Automatic into battle mode when entering a location with monsters.<br>
If the monster is kill it won't show up on the select list anymore.</dd></dl></tr>

</table>
</td></tr></table><?php
require_once 'MaiN/site.footer.php';
?>