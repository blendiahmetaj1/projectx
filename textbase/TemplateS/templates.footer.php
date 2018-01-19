</td></tr></table>

<center>
<br>
<font size=-2>
<?php
$refurl = 'textbasedrpg.com';
$languas = array ("ar" => 'Arabic',"bg" => 'Bulgarian',"ca" => 'Catalan',"zh-CN" => 'Chinese (Simplified',"zh-TW" => 'Chinese (Traditional',"hr" => 'Croatian',"cs" => 'Czech',"da" => 'Danish',"nl" => 'Dutch',"en" => 'English',"tl" => 'Filipino',"fi" => 'Finnish',"fr" => 'French',"de" => 'German',"el" => 'Greek',"iw" => 'Hebrew',"hi" => 'Hindi',"id" => 'Indonesian',"it" => 'Italian',"ja" => 'Japanese',"ko" => 'Korean',"lv" => 'Latvian',"lt" => 'Lithuanian',"no" => 'Norwegian',"pl" => 'Polish',"pt" => 'Portuguese',"ro" => 'Romanian',"ru" => 'Russian',"sr" => 'Serbian',"sk" => 'Slovak',"sl" => 'Slovenian',"es" => 'Spanish',"sv" => 'Swedish',"uk" => 'Ukrainian',"vi" => 'Vietnamese',
);

foreach ($languas as $key => $val) {

print '<a href="http://translate.google.com/translate?u=http%3A%2F%2F'.$refurl.'%2F&hl=en&ie=UTF-8&sl=en&tl='.$key.'" title="'.$val.'">'.$val.'</a> | ';

}

?></font>
<br>
<font size=1>© 1999-<? echo date("Y");?> Copyright of all contents are of their respective holders. <br><a href="http://thesilent.com/?open=privacy">Privacy</a>. <a href="http://thesilent.com/?open=terms">Terms</a>. <a href="http://thesilent.com/?open=rules">Rules</a>. <a href="http://www.thesilent.com/index.php?open=feedback">Feedback</a>. <br>Lol Version <? echo $version; ?>.
Parsed in <? echo substr((set_timer()-$current_timer), 0 ,6); ?> seconds.</font>
</center>
</body>
</html>