<?php
include_once 'db_connect.php';
include_once 'auth.php';


$basketData = mysqli_query(getDb(),"SELECT orders_products.order_id, orders_products.product_id, orders_products.total AS quantity, products.name, products.price, (products.price*orders_products.total) AS totalPrice, product_images.title AS imageName FROM orders_products
JOIN orders ON orders.id = orders_products.order_id
JOIN products ON products.id = orders_products.product_id
JOIN product_images ON product_images.product_id = products.id WHERE orders.user_id = {$_SESSION['id']};");

if($basketData -> num_rows == 0){//если корзина пуста вывожу сообщение
    $basketEmpty = 'Козина пуста';
}else{
    $basketPrice = 0;
    while ($row = mysqli_fetch_assoc($basketData)){
        $basketPrice = $basketPrice + $row['totalPrice'];
    }
}
if (isset($basketEmpty)){//удаляю заказ, если товаров в заказе нет
    mysqli_query(getDb(), "DELETE FROM orders WHERE user_id = {$_SESSION['id']};");
}

if ($_GET['action'] == 'delete'){//удаляю товар по нажатию кнопки
    $getId = (int) $_GET['id'];
    $result = mysqli_query(getDb(),"SELECT orders_products.product_id, orders.id FROM orders_products 
    JOIN orders ON orders.id = orders_products.order_id WHERE orders.user_id = {$_SESSION['id']} AND orders_products.product_id = {$getId};");
    if ($result -> num_rows === 0) {
        header("Location: ?message=error"); //выводит в строке браузера '/?message=error'
        die();
    } else {
        $row = mysqli_fetch_assoc($result);
        mysqli_query(getDb(), "DELETE FROM orders_products WHERE product_id = {$getId} AND order_id = {$row['id']};");
        header("Location: ?message=del"); //выводит в строке браузера '/?message=del'
        die();
    }

}

$codes = [//массив с кодами для message
    'error' => "ошибка удаления товара",
    'del' => "товар удален",
];
$message = (isset($_GET['message'])) ? $codes[strip_tags($_GET['message'])] : "";// обрезает теги, и выводит значение message из строки браузера

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<?php include 'menu.php'?>
<div id="main">
    <div class="post_title"><h2>Корзина</h2></div>
    <div class="gallery_item">
        <?=isset($basketEmpty) ? $basketEmpty : $message;?>
        <?php foreach($basketData as $good):?>
            <div class="feedback-item feedback">
                <a rel="gallery" class="photo" href="product_item.php?id=<?=$good['product_id']?>"><img alt="<?=$good['imageName']?>" src="gallery_img/small/<?=$good['imageName']?>" width="50" height="50"/></a>
                <p><?=$good['name']?></p>
                <p><?=$good['quantity']?></p>
                <p><?=$good['price']?></p>
                <P><?=$good['totalPrice']?></P>
                <a href="?action=delete&id=<?=$good['product_id']?>">Удалить</a>
            </div>
        <?php endforeach; ?>
        <div><?=isset($basketEmpty) ? "" : "Итого: " . $basketPrice;?></div>
    </div>
    <div class="gallery_item">
        <a class="button" href="order.php">Оформить заказ</a>
    </div>
</div>
</body>
</html>

