<?php
include_once 'function.php'; // подключаю функции для записи данных в бд
include_once 'db_connect.php';
include_once 'auth.php';

$dataFromProducts = mysqli_query(getDb(),"SELECT products.id, products.name, products.price, product_images.title, product_likes.likes FROM products 
JOIN product_images ON product_images.product_id = products.id
JOIN product_likes ON product_likes.product_id = products.id;");

define("PATH_BIG", "$_SERVER[DOCUMENT_ROOT]" . '/gallery_img/big/');
define("PATH_SMALL", "$_SERVER[DOCUMENT_ROOT]" . '/gallery_img/small/');
//todo
$buyText = 'Купить';
//$isInBasket = mysqli_query($db,"SELECT product_id FROM orders_products;");
//$basket = [];
//$row = mysqli_fetch_row($isInBasket);
//var_dump($row);
//echo 123;
//die();
//if($isInBasket -> num_rows != 0){//если товар в корзине, на кнопке появляется надпись Добавить
//
//    $buyText = 'Добавить';
//
//}
if ($_POST['buy']){
    $productIdToBuy = (int) $_POST['buy'];
    if (isset($_SESSION['id'])){
        $hasUserOrder = mysqli_query(getDb(),"SELECT id FROM orders WHERE user_id = {$_SESSION['id']};");

        if ($hasUserOrder -> num_rows === 0){
            mysqli_query(getDb(), "INSERT INTO orders (user_id) VALUES({$_SESSION['id']});");
        }
        $result = mysqli_query(getDb(), "SELECT id FROM orders WHERE user_id = {$_SESSION['id']}");
        $row = mysqli_fetch_assoc($result);

        $isInBasket = mysqli_query(getDb(),"SELECT product_id FROM orders_products WHERE product_id = '$productIdToBuy';");

        if($isInBasket -> num_rows === 0){
            mysqli_query(getDb(), "INSERT INTO orders_products (order_id, product_id,total) VALUES({$row['id']}, '$productIdToBuy', '1');");
        } else{
            mysqli_query(getDb(), "UPDATE orders_products SET total = total + 1 WHERE product_id = '$productIdToBuy';");
        }

        header("Location: ?id={$productIdToBuy}&message=buy"); //выводит в строке браузера '/?message=ok'
        die();
    }else{

    }

}



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
    <title>Каталог</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>

</head>

<body>
<?php include 'menu.php'?>
<div id="main">
    <div class="post_title"><h2>Каталог</h2></div>
    <div class="gallery">
        <?php foreach($dataFromProducts as $item):?>
        <div class="gallery_item">
            <a rel="gallery" class="photo" href="product_item.php?id=<?=$item['id']?>"><img alt="<?=$item['title']?>" src="gallery_img/small/<?=$item['title']?>" width="150" height="100" /></a>
            <h3><?=$item['name']?></h3>
            <h4>Цена: <?=$item['price']?></h4>
            <span>Понравилось: <?=$item['likes']?> покупателям</span>
            <form action="" method="POST">
                <button type="submit" name="buy" value="<?=$item['id']?>"><?=$buyText?></button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>