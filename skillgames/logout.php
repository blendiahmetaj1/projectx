<?php
#!/usr/local/bin/php
require_once 'admin/www.main.php';
require_once 'admin/www.mysql.php';
require_once 'admin/www.header.php';

setcookie ("msgUsername", "$row->username",time()-60*60*5);
setcookie ("msgSession", "$current_time",time()-60*60*5);
?>Thank you for your time.<br>Hope to see you back soon.<?php
require_once 'admin/www.footer.php';
?>