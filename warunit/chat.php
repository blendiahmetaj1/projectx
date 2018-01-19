<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.functions.php';
require_once 'admin/array.emotions.php';
include_once 'templates/game.header.php';


?>
<form method="post" action="chat_iframe.php?sid=<?php print $sid;?>" target="chat_iframe">
<table width="100%"><tr><td width="80%"><input type="text" name="message" size="35" maxlength="200" onFocus="document.chat.message.value='';document.chat.message.select()" style="width:100%;"></td><td width="10%"><input type="submit" name="action" value="Post" style="width:100%;"></td><td width="10%"><input type="reset" name="action" value="Clear" onmouseover="document.chat.message.value='';document.chat.message.select()" style="width:100%;"></td></tr></form></table>

<!--MAP TABLE-->
<table width="100%" height="480"><tr><td valign=top>
<iframe name="chat_iframe" src="chat_iframe.php?sid=<?php print $sid;?>" width="100%" height="100%" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="auto" style="width:100%;height:100%;"></iframe>
</td></tr></table>
 <!--MAP TABLE-->
<?php
include_once 'templates/game.footer.php';
?>