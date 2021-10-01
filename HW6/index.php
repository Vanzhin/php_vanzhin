<?php
include_once 'function.php'; // подключаю функции для записи данных в бд
include_once 'db_connect.php';
$dataFromProducts = mysqli_query($db,"SELECT products.id, products.name, products.price, product_images.title, product_likes.likes FROM products 
JOIN product_images ON product_images.product_id = products.id
JOIN product_likes ON product_likes.product_id = products.id;");

define("PATH_BIG", "$_SERVER[DOCUMENT_ROOT]" . '/gallery_img/big/');
define("PATH_SMALL", "$_SERVER[DOCUMENT_ROOT]" . '/gallery_img/small/');




//$imageData = getFileData(PATH_BIG);
//var_dump($imageData);
//foreach ($imageData as $key => $row){ // помещаю данные в таблицу images
//    mysqli_query($db, "INSERT INTO product_likes (product_id) VALUES ('$key' + 1);");
//}
//die();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Моя галерея</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>

</head>

<body>
<div id="main">
    <div class="post_title"><h2>Каталог</h2></div>
    <div class="gallery">
        <?php foreach($dataFromProducts as $item):?>
        <div class="gallery_item">
            <a rel="gallery" class="photo" href="product_item.php?id=<?=$item['id']?>"><img alt="<?=$item['title']?>" src="gallery_img/small/<?=$item['title']?>" width="150" height="100" /></a>
            <h3><?=$item['name']?></h3>
            <h4>Цена: <?=$item['price']?></h4>
            <span>Понравилось: <?=$item['likes']?> покупателям</span>
            <button>Купить</button>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>