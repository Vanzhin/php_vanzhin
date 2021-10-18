<?php
include $_SERVER['DOCUMENT_ROOT'] . '/HW4/render_site/config/config.php';
$page = 'index';
if (isset($_GET['page'])){
    $page = $_GET['page'];
}
$params = [];
switch ($page){
    case 'index':
        $params['name'] = 'Nikolay';
        break;
}

//$content = renderTemplate("about");
//$menu = renderTemplate("menu");
//$footer = renderTemplate("footer",['year' => date(Y)]);
//$params = [
//    'content' => $content,
//    'menu' => $menu,
//];

function render ($page, $params)
{
    return renderTemplate(LAYOUTS_DIR . 'main',[
        'content' => renderTemplate($page, $params),
        'menu' => renderTemplate("menu"),
        'footer' => renderTemplate("footer", ['year' => date(Y)])
        ]);
}

echo render($page, $params);

function renderTemplate($page, $params = []){
//    foreach ($params as $key => $value) {
//        $$key = $value;
//    }
    extract($params);
    ob_start();
    include TEMPLATES_DIR . $page . ".php";
    return ob_get_clean();
}






