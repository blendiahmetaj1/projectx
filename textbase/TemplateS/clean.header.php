<?
#!/usr/local/bin/php
if(!empty($_GET['sid']) and empty($sid)){$sid=$_GET['sid'];}
if(!empty($_POST['sid']) and empty($sid)){$sid=$_POST['sid'];}if(empty($sid)){die('666');}
?>
<html>
<head>
<?
include_once("$html_style");
?>
<title><? echo "$title $title_descrip"; ?></title>
</head>
<body bgcolor=<?echo $col_bg;?> text=<?echo $col_text;?> rightmargin=0 leftmargin=0 topmargin=0 bottommargin=0>
<center>