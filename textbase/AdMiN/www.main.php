<?
#!/usr/local/bin/php
$root_url = "http://www.textbasedrpg.com";//http://www.textbasedrpg.com
$images_url = 'http://www.lordsoflords.com/images/lol';

$server = "History";
$admin_name = 'Admin SilenT';

$title = 'Text Based RPG';
$title_descrip = $title;
$title_info = $title;

$version = 1.995;
$current_timer = set_timer();
$current_date = date("d M H:i");

$html_header = './TemplateS/templates.header.php';
$html_footer = './TemplateS/templates.footer.php';
$html_style = './TemplateS/game.style.php';
$game_header = './TemplateS/game.header.php';
$game_footer = './TemplateS/game.footer.php';
$clean_header = './TemplateS/clean.header.php';
$clean_footer = './TemplateS/clean.footer.php';

$files = array( 'index', 'signup', 'login', 'ladder');

$gamefiles = array( 'stats', 'shop', 'ladder', 'logout');

$operators = array('Admin', 'Cop', 'Mod', 'Support');

$sap = array('+','-','*','/');

$col_bg ='#000000';
$col_text ='#CCCCCC';
$col_link ='#FFF888';
$col_hover ='#FFF888';
$col_table =$col_bg;
$col_th ="#012345";
$col_form ='#012345';
$font_family ='Verdana, Arial, Monaco';
$font_size ='10pt';

function set_timer(){
list($usec, $sec) = explode(" ",microtime());
return((float)$usec +(float)$sec);
}
?>