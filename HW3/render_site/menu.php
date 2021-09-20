<?php
$menu = [
        "items" => [
                "main" => [
                        "link" => "#",
                        "sublinks" => [
                            "about" => "#",
                             "get in touch" => "#",
                        ],
                ],
                "about" => [
                        "link" => "#",
                ],
                "catalog" => [
                        "link" => "#",
                ],
        ]
];
?>
<nav class="menu__body">
    <ul class="menu__list">
<?php foreach ($menu[items] as $key => $value): ?>
<?php if(isset($value[sublinks])): ?>
        <li class="menu__item">
            <a href="<?=$value[link]?>" class="menu__link"><?=$key?></a>
            <ul class="menu__sub-list">
                <?php foreach ($value[sublinks] as $elkey => $elvalue): ?>
                <li class="menu__sub-item"><a href="<?=$elvalue?>" class="menu__sub-link"><?=$elkey?></a></li>
                <?php endforeach;?>
            </ul>
        </li>
    <?php else : ?>
        <li class="menu__item">
            <a href="<?=$value[link]?>" class="menu__link"><?=$key?></a>
        </li>
        <?php endif;?>
        <?php endforeach;?>
    </ul>
</nav>
<br>





