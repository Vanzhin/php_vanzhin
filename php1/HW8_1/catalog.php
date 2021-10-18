<?php
include_once 'models/function.php'; // подключаю функции для записи данных в бд
include_once 'models/db_connect.php';
include_once 'models/auth.php';


$dataFromProducts = mysqli_query(getDb(),"SELECT DISTINCT products.id, products.name, products.price, product_images.title, COUNT(product_likes.product_id) OVER(PARTITION BY product_likes.product_id) AS likes FROM products 
JOIN product_images ON product_images.product_id = products.id
LEFT JOIN product_likes ON product_likes.product_id = products.id ORDER BY likes DESC;");

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
    $productPrice = mysqli_fetch_assoc(mysqli_query(getDb(), "SELECT price FROM products WHERE id = '$productIdToBuy'"))['price'];

    if (isset($_SESSION['id'])){//если пользователь авторизован, то добавление идет по его id, который лежит в {$_SESSION['id']}
            $hasUserActiveOrder = mysqli_query(getDb(),"SELECT user_id, id FROM orders WHERE `status` = 'active' AND user_id = {$_SESSION['id']};");
            if($hasUserActiveOrder -> num_rows === 0){// добавляю заказ, если его еще нет
                mysqli_query(getDb(), "INSERT INTO orders (user_id, session_id) VALUES({$_SESSION['id']}, '$session');");
            }
            $row = mysqli_fetch_assoc(mysqli_query(getDb(),"SELECT user_id, id FROM orders WHERE `status` = 'active' AND user_id = {$_SESSION['id']};"));
            $isInBasket = mysqli_query(getDb(),"SELECT order_id, product_id FROM orders_products 
            JOIN orders ON orders.id = orders_products.order_id WHERE product_id = '$productIdToBuy' AND orders_products.order_id = {$row['id']};");
            if($isInBasket -> num_rows === 0){
                mysqli_query(getDb(), "INSERT INTO orders_products (product_id, total, session_id, order_id, price) VALUES('$productIdToBuy', '1', '$session', {$row['id']}, '$productPrice');");
            } else{
                mysqli_query(getDb(), "UPDATE orders_products SET total = total + 1 WHERE product_id = '$productIdToBuy' AND order_id = {$row['id']};");
            }

        } else{// если пользователь не авторизован, то добавление идет по session_id
            $isInBasket = mysqli_query(getDb(),"SELECT product_id FROM orders_products WHERE product_id = '$productIdToBuy' AND session_id = '$session';");

            if($isInBasket -> num_rows === 0){
                mysqli_query(getDb(), "INSERT INTO orders_products (product_id, total, session_id, price) VALUES('$productIdToBuy', '1', '$session', '$productPrice');");
            } else{
                mysqli_query(getDb(), "UPDATE orders_products SET total = total + 1 WHERE product_id = '$productIdToBuy' AND session_id = '$session';");
            }
        }
    header("Location: ?id={$productIdToBuy}&message=buy"); //выводит в строке браузера '/?message=ok'
    die();
    }
if ($_GET['action'] == 'addlike'){
    $id = (int) $_GET['id'];
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : "0";
    mysqli_query(getDb(), "INSERT INTO product_likes (product_id, session_id, user_id) VALUES('$id', '$session',{$user_id});");
    $row = mysqli_fetch_assoc(mysqli_query(getDb(), "SELECT COUNT(product_id) AS likes FROM product_likes WHERE product_id = '$id';"));
    $likes = $row['likes'];

//    $response = [
//            'status' => "ok",
//            'likes' => $likes,
//    ];
    $response['status'] = 'ok';
    $response['likes'] = $likes;

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    die();

}



//$imageData = getFileData(PATH_BIG);
//var_dump($imageData);
//foreach ($imageData as $key => $row){ // помещаю данные в таблицу images
//    mysqli_query($db, "INSERT INTO product_likes (product_id) VALUES ('$key' + 1);");
//}
//die();
include 'views/catalog.php';
