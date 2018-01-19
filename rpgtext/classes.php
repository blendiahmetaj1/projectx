<?php
#!/usr/local/bin/php
require_once 'MaiN/www.main.php';
require_once 'MaiN/site.header.php';

require_once 'MaiN/array.classes.php';
?><table><tr><th>Class Multipliers</th><th title="weapon damage">WD</th><th title="attack rating">AR</th><th title="defense power">DP</th><th title="magic damage">MD</th><th title="magic rating">MR</th><th title="magic shield">MS</th><th title="skill bonus">SB</th><th title="life mulitplier">LM</th><th title="mana mulitplier">MM</th><th title="stamina mulitplier">SM</th></tr><?php
foreach ($array_classes as $key=>$val){
print '<tr><td>'.ucfirst($key).'</td>';
	foreach ($val as $ival){
print '<td>'.$ival.'</td>';
	}
print '</tr>';
}
?></table><?php
require_once 'MaiN/site.footer.php';
?>