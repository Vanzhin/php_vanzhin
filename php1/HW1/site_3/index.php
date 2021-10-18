<?php
$title = "Главная страница - страница обо мне";
$h1 = "Информация обо мне";
$year = date("Y");

$content = file_get_contents ("template.tmpl");
$replace = array("{{ title }}", "{{ h1 }}","{{ year }}");
$replaceTo = array($title,$h1,$year);
$content = str_replace($replace,$replaceTo,$content);
echo $content;