<?php
include_once 'models/db_connect.php';
include_once 'models/auth.php';

$getId = (int) $_GET['id'];
$row = [];
$buttonText = 'оставить';
$action = 'add';
$buyText = 'Купить';
$isInBasket = mysqli_query(getDb(),"SELECT product_id FROM orders_products WHERE product_id = '$getId';");
if($isInBasket ->num_rows !== 0){//если товар в корзине, на кнопке появляется надпись Добавить
    $buyText = 'Добавить';

}
if ($_POST['buy']){
    $productIdToBuy = (int) $_POST['buy'];
        if (isset($_SESSION['id'])){//если пользователь авторизован, то добавление идет по его id, который лежит в {$_SESSION['id']}
            $hasUserActiveOrder = mysqli_query(getDb(),"SELECT user_id, id FROM orders WHERE `status` = 'active' AND user_id = {$_SESSION['id']};");
            if($hasUserActiveOrder -> num_rows === 0){
                mysqli_query(getDb(), "INSERT INTO orders (user_id, session_id) VALUES({$_SESSION['id']}, '$session');");
            }
            $row = mysqli_fetch_assoc(mysqli_query(getDb(),"SELECT user_id, id FROM orders WHERE `status` = 'active' AND user_id = {$_SESSION['id']};"));
            $isInBasket = mysqli_query(getDb(),"SELECT order_id, product_id FROM orders_products 
            JOIN orders ON orders.id = orders_products.order_id WHERE product_id = '$productIdToBuy' AND orders_products.order_id = {$row['id']};");
            if($isInBasket -> num_rows === 0){
                mysqli_query(getDb(), "INSERT INTO orders_products (product_id, total, session_id, order_id) VALUES('$productIdToBuy', '1', '$session', {$row['id']});");
            } else{
                mysqli_query(getDb(), "UPDATE orders_products SET total = total + 1 WHERE product_id = '$productIdToBuy' AND order_id = {$row['id']};");
            }

        } else{// если пользователь не авторизован, то добавление идет по session_id
            $isInBasket = mysqli_query(getDb(),"SELECT product_id FROM orders_products WHERE product_id = '$productIdToBuy' AND session_id = '$session';");

            if($isInBasket -> num_rows === 0){
                mysqli_query(getDb(), "INSERT INTO orders_products (product_id, total, session_id) VALUES('$productIdToBuy', '1', '$session');");
            } else{
                mysqli_query(getDb(), "UPDATE orders_products SET total = total + 1 WHERE product_id = '$productIdToBuy' AND session_id = '$session';");
            }
        }
    header("Location: ?id={$productIdToBuy}&message=buy"); //выводит в строке браузера '/?message=ok'
    die();
}

if (!empty($getId)){ // если $getId не пуст - обращаюсь к базе и извлекаю запись по $getId
    $itemData = mysqli_query(getDb(),"SELECT DISTINCT products.id, products.name, products.description, products.price, product_images.title, COUNT(product_likes.product_id) OVER(PARTITION BY product_likes.product_id) AS likes FROM products 
JOIN product_images ON product_images.product_id = products.id
JOIN product_likes ON product_likes.product_id = products.id WHERE id = {$getId};");
    $response = ($itemData -> num_rows);
} else{
    $response = 0;
}
if($response === 1){
    $itemArr = mysqli_fetch_assoc($itemData);
    $message = $itemArr['name'];
    $display = "inherit";
    $feedbackData = mysqli_query(getDb(),"SELECT * FROM product_feedback WHERE product_id = {$getId} ORDER BY created_at DESC;");
    if ($feedbackData->num_rows === 0) {
        $feedbackMessage = 'отзывов пока нет';
    } else {
        $feedbackArr = [];
        while ($row = mysqli_fetch_assoc($feedbackData)) { // помещаю данные из базы в ассоциативный массив $feedbackArr
            array_push($feedbackArr, $row);
        }
    }

} else{
    $message = "Товара не найдено";
    $display = "none";

}
if ($_GET['action'] == 'add'){
$name = strip_tags(mysqli_escape_string(getDb(),$_POST['user_name']));
$feedbackText = strip_tags(mysqli_escape_string(getDb(),$_POST['user_feedback']));
if ((empty($name) || $name == "") || (empty($feedbackText) || $feedbackText == "")){
    header("Location: ?id={$getId}&message=error"); //выводит в строке браузера '/?message=ok'
    die();
}else{
    mysqli_query(getDb(), "INSERT INTO product_feedback (product_id,user_name,feedback) VALUES('$getId','$name','$feedbackText');");
    header("Location: ?id={$getId}&message=ok"); //выводит в строке браузера '/?message=ok'
    die();
    }
}
if ($_GET['action'] == 'delete'){
    $feedId = $_GET['feed'];
    $feedToDel = mysqli_query(getDb(),"SELECT * FROM product_feedback WHERE id = {$feedId};");
    if ($feedToDel->num_rows === 0) {
        header("Location: ?id={$getId}&message=error"); //выводит в строке браузера '/?message=ok'
        die();
    } else {
        mysqli_query(getDb(), "DELETE FROM product_feedback WHERE id = {$feedId};");
        header("Location: ?id={$getId}&message=del"); //выводит в строке браузера '/?message=ok'
        die();
    }

}
if ($_GET['action'] == 'edit'){
    $feedId = $_GET['feed'];
    $feedToEdit = mysqli_query(getDb(),"SELECT * FROM product_feedback WHERE id = {$feedId};");
    if ($feedToEdit->num_rows === 0) {
        header("Location: ?id={$getId}&message=error"); //выводит в строке браузера '/?message=ok'
        die();
    } else {
        $row = mysqli_fetch_assoc(mysqli_query(getDb(), "SELECT * FROM product_feedback WHERE id = {$feedId};"));
        $buttonText = 'обновить';
        $action = 'save';
    }

}
if ($_GET['action'] == 'save'){// todo не работает обновление отзыва
    $name = strip_tags(mysqli_escape_string(getDb(),$_POST['user_name']));
    $feedbackText = strip_tags(mysqli_escape_string(getDb(),$_POST['user_feedback']));
    $feedId = (int) $_POST['id'];
    if ((empty($name) || $name == "") || (empty($feedbackText) || $feedbackText == "")){
        header("Location: ?id={$getId}&message=error"); //выводит в строке браузера '/?message=ok'
        die();
    }else{
        mysqli_query(getDb(), "UPDATE product_feedback SET user_name = '$name', feedback = '$feedbackText' WHERE id = '$feedId';");
        header("Location: ?id={$getId}&message=edit"); //выводит в строке браузера '/?message=ok'
        die();
    }
}
$codes = [//массив с кодами для message
    'ok' => "Ваш отзыв загружен",
    'error' => "ошибка загрузки отзыва",
    'del' => "отзыв удален",
    'edit' => "отзыв обновлен",
    'buy' => "товар добавлен в корзину"
];

$message = (isset($_GET['message'])) ? $codes[strip_tags($_GET['message'])] : "";// обрезает теги, и выводит значение message из строки браузера
//include 'views/product_item.php';

include "views/product_item.php";