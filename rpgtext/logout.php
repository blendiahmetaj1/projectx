<?php
#!/usr/local/bin/php
require_once 'MaiN/www.main.php';
require_once 'MaiN/site.header.php';
?><table>

<tr>
<td align=center valign=center>
<?php
if (!empty($_COOKIE)) {
foreach ($_COOKIE as $key=>$val){
setcookie ($key, "",$current_time-84600*360) or die_nice('Cookie removal failure!');
}
print 'All cookies have been removed, logout success!<br>';
}else{
print 'No cookies found, logout success!<br>';
}
?>Thank you for your time, we hope to see you back again soon.<br>
<br>
<b>If you like this game please tell your friends.<br>
<br>
RPGTEXT.COM
</b>
<br>
<script type="text/javascript"><!--
google_ad_client = "pub-2087744073845065";
google_alternate_color = "FFFFFF";
google_ad_width = 336;
google_ad_height = 280;
google_ad_format = "336x280_as";
google_ad_type = "text_image";
//2007-03-21: rpgtext
google_ad_channel = "4102168910";
google_color_border = "FFFFFF";
google_color_bg = "FFFFFF";
google_color_link = "0000FF";
google_color_text = "000000";
google_color_url = "000000";
//-->
</script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

</td>
</tr>

</table><?php
require_once 'MaiN/site.footer.php';
?>