<?php
function renderTemplate($page, $content="", $menu=""){
    ob_start();
    include $page . ".php";
    return ob_get_clean();
}

$content = renderTemplate("about");
$menu = renderTemplate("menu");
echo renderTemplate("layout",$content,$menu);




