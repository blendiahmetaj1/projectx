<table cellpadding=0 cellspacing=1 border=0 width=100%><tr><td valign=top>
<!--NAVIGATION//-->
<form method=post action="?">
<table cellpadding=0 cellspacing=1 border=0 width=100%>
<tr><th colspan=3>Navigation</th></tr>
<tr>
<td align=right><input type=submit name=move value=ne></td>
<td align=center><input type=submit name=move value=n></td>
<td align=left><input type=submit name=move value=nw></td>
</tr>
<tr>
<td align=right><input type=submit name=move value=e></td>
<td align=center><?if($row->quests >= 14){?><input type=submit name=visit value=T><?php}?></td>
<td align=left><input type=submit name=move value=w></td>
</tr>
<tr>
<td align=right><input type=submit name=move value=se></td>
<td align=center><input type=submit name=move value=s></td>
<td align=left><input type=submit name=move value=sw></td>
</tr>
</table>

<!--POTIONS//-->

<table cellpadding=0 cellspacing=1 border=0 width=100%>
<tr><th colspan=3>Potions</th></tr>
<tr><td><input type=submit name=potion value="life"></td><td><input type=submit name=potion value="mana"></td><td><input type=submit name=potion value="stamina"></td></tr></table>

<!--POTIONS//-->

<!--NAVIGATION//-->
</td><td valign=top>
<!--PLAYER//-->

<table cellpadding=0 cellspacing=1 border=0 width=100%>
<tr><th>Player</th></tr>
<tr><td align=center><input type=submit name=player value="main"></td></tr>
<tr><td align=center><input type=submit name=player value="stats"></td></tr>
<tr><td align=center><input type=submit name=player value="inventory"></td></tr>
<tr><td align=center><input type=submit name=attack value="attack"></td></tr>
<?if($freeplay >= 1) {?><tr><td align=center><input type=submit name=player value="kill"></td></tr><?php}?>
</form><form method=post action="logout.php">
<tr><td align=center><input type=submit name=logout value="logout"></td></tr>
</table>
</form>

<!--PLAYER//-->

</td><td valign=top>



<!--STATS//-->
<?php
//print ($next_level-$prev_level).' '.($next_level-$row->exp).' '.$row->exp;
$p_exp = 100-round((($next_level-$row->exp)/($next_level-$prev_level))*100,2);
$p_gold = round(($row->gold/$max_gold)*100,2);
$p_life = round(($row->life/$max_life)*100,2);
$p_mana = round(($row->mana/$max_mana)*100,2);
$p_stamina = round(($row->stamina/$max_stamina)*100,2);

?>
<table cellpadding=0 cellspacing=1 border=0 width=100%>
<tr><th>Stats</th></tr>
<tr><td bgcolor="#00FF00" nowrap><div style="height:100%;width:<?php print $p_exp;?>%;background-color:#FF0000;"><font size=-1>Level up <?php print $p_exp;?>%</div></td></tr>
<tr><td bgcolor="#00FF00" nowrap><div style="height:100%;width:<?php print $p_gold;?>%;background-color:#FF0000;"><font size=-1>Gold <?php print $p_gold;?>%</div></td></tr>
<tr><td bgcolor="#00FF00" nowrap><div style="height:100%;width:<?php print $p_life;?>%;background-color:#FF0000;"><font size=-1>Life <?php print $p_life;?>% <sup title="Life Potions"><?php print number_format($row->plife);?></sup></div></td></tr>
<tr><td bgcolor="#00FF00" nowrap><div style="height:100%;width:<?php print $p_mana;?>%;background-color:#FF0000;"><font size=-1>Mana <?php print $p_mana;?>%<sup title="Mana Potions"><?php print number_format($row->pmana);?></sup></div></td></tr>
<tr><td bgcolor="#00FF00" nowrap><div style="height:100%;width:<?php print $p_stamina;?>%;background-color:#FF0000;"><font size=-1>Stamina <?php print $p_stamina;?>%<sup title="Stamina Potions"><?php print number_format($row->pstamina);?></sup></div></td></tr>
</table>

<!--STATS//-->

</td></tr></table>
