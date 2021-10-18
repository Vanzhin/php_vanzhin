<?php
$menu = [
        [
                "url" => "/HW4/render_site/templates/?page=about",
                 "name" =>"about",
        ],
        [
                "url" => "/HW4/render_site/templates/?page=catalog",
                "name" =>"catalog",
                "submenu" => [
                        [
                            "url" => "#",
                            "name" =>"product  1"
                        ],
                        [
                            "url" => "#",
                            "name" =>"product  2"
                        ],
                        [
                            "url" => "#",
                            "name" =>"product  3"
                        ],
                ]
        ],

];

function renderMenu(array $menu){
    $out = "<ul>";
    foreach ($menu as $value){
      $out .="<li><a href='{$value['url']}'>{$value['name']}</a>";
        if(isset($value['submenu'])){
          $out .= renderMenu($value['submenu']);
        }
        $out .= "</li>";
    }
    $out .= "</ul>";
    return $out;
}
echo renderMenu($menu);