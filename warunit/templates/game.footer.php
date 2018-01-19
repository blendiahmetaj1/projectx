<?php
if (!empty($update_it)) {
mysqli_query ($link, "UPDATE `$tbl_members` SET $update_it WHERE `id`='$row->id' LIMIT 1") or die(mysqli_error());
mysqli_close($link);
}
?></td></tr></table></font></center>



<p align=right valign=bottom>
<font size=1><b>	
<a href="http://www.thesilent.com/index.php?open=privacy">Privacy</a>
<a href="http://www.thesilent.com/index.php?open=terms">Terms</a>
<a href="http://www.thesilent.com/index.php?open=rules">Rules</a>
<a href="http://www.thesilent.com/index.php?open=feedback">Feedback</a>
<br>
&copy;<?echo date("Y");?> <a href="http://thesilent.com">The silenT</a>
</b>
</font>
</p>
</body></html>