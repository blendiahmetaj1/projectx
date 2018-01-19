<?
#!/usr/local/bin/php
echo<<<EOT
<style type="text/css">
<!--
body, html, form{
margin:0;
color:$col_text;
background:$col_bg;
font-family: $font_family;
font-weight: normal;
font-size: $font_size;
}

a{text-decoration: none; color:$col_link;}
a:hover{text-decoration: underline; color:$col_hover}

body{ color:$col_text; background: $col_bg; font-family: $font_family; font-weight: normal; font-size: $font_size;}

table{border-color:$col_table;}
tr{font-family: $font_family; text-decoration: none;font-size: $font_size;}
th{color:$col_text; background-color: $col_th; font-weight: bold;}
td{text-decoration: none; font-size: $font_size;}
hr{color:$col_th;size:1;}
input{height:25; width:100%; height:100; color:$col_text; background-color:$col_form; border-color:$col_th; }
select{width:100%; color:$col_text; background-color:$col_form; border-color:$col_table;}
textarea{height:150; width:100%; color:$col_text; background-color:$col_form; border-color:$col_th;}
-->
</style>
EOT;
?>