<?php
#!/usr/local/bin/php
?><table width=100%>
<tr><th colspan=2>Stats</th></tr>
<tr>

<td valign=top nowrap><font size=-1>Level<br>Exp<br>Gold<br>Life<br>Mana<br>Stamina</font></td>
<td valign=top nowrap><font size=-1><?php print number_format($row->level).'<br>'.number_format($row->exp).'<br>'.number_format($row->gold).'<br>'.number_format($row->life).'<font size=-1><sup title="Life Potions">'.number_format($row->plife).'</sup></font><br>'.number_format($row->mana).'<font size=-1><sup title="Mana Potions">'.number_format($row->pmana).'</sup></font><br>'.number_format($row->stamina).'<font size=-1><sup title="Stamina Potions">'.number_format($row->pstamina).'</sup></font>'; ?></font></td>

</tr></table>