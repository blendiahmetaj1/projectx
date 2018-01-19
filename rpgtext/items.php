<?php
#!/usr/local/bin/php
require_once 'MaiN/www.main.php';
require_once 'MaiN/site.header.php';

require_once 'MaiN/array.attributes.php';
require_once 'MaiN/array.sets.php';
require_once 'MaiN/array.uniques.php';


?>
<table><tr><td valign=top>

<table><tr><th>Unique Items</th></tr><?php
foreach ($array_uniques as $key=>$val){
print '<tr><td><b>'.ucfirst($key).'</b><br><font size=-1>';
$val = explode(',',$val);
	foreach ($val as $ival){
print $ival>=1?'+'.$array_attributes[$ival].'<br>':'';
	}
print '</font></td></tr>';
}
?></table>

</td><td valign=top>

<table><tr><th>Set Items</th></tr><?php
foreach ($array_sets as $key=>$val){
print '<tr><td><b>'.ucfirst($key).'</b><br><font size=-1>';
$val = explode(',',$val);
	foreach ($val as $ival){
print $ival>=1?'+'.$array_attributes[$ival].'<br>':'';
	}
print '</font></td></tr>';
}
?></table>


</td></tr></table>
<?php
require_once 'MaiN/site.footer.php';
?>