<?php
include_once 'models/db_connect.php';
include_once 'models/auth.php';

if (isset($_SESSION['id'])){
    $basketData = mysqli_query(getDb(),"SELECT orders_products.order_id, orders_products.product_id, orders_products.total AS quantity, products.name, orders_products.price, (orders_products.price*orders_products.total) AS totalPrice, SUM(orders_products.total * orders_products.price) OVER(PARTITION BY orders.id) AS grandTotal, product_images.title AS imageName FROM orders_products
JOIN products ON products.id = orders_products.product_id
JOIN product_images ON product_images.product_id = products.id
JOIN orders ON orders.id = orders_products.order_id WHERE orders.status = 'active' AND orders.user_id = {$_SESSION['id']};");
} else {
    $basketData = mysqli_query(getDb(),"SELECT orders_products.order_id, orders_products.product_id, orders_products.total AS quantity, products.name, orders_products.price, (orders_products.price*orders_products.total) AS totalPrice, SUM(orders_products.total * orders_products.price) OVER(PARTITION BY orders_products.session_id) AS grandTotal, product_images.title AS imageName FROM orders_products
JOIN products ON products.id = orders_products.product_id
JOIN product_images ON product_images.product_id = products.id WHERE orders_products.session_id = '$session';");
}
if($basketData -> num_rows == 0){//если корзина пуста вывожу сообщение
    $basketEmpty = 'Козина пуста';
}else {
    $basketPrice = mysqli_fetch_assoc($basketData)['grandTotal'];
}

if ($_GET['action'] == 'order'){

    $name = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_POST['name'])));
    $tel = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_POST['tel'])));
    $comment = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_POST['comment'])));
    $url = $_SERVER['REQUEST_URI']; //получаю строку страницы без GET - запроса, делаю это на тот случай, если будут повторы с ошибками
    $url = explode('?', $url);
    $url = $url[0];

    if (empty($name) or empty($tel)){
        header("Location: " . $url . "?message=empty"); //возвращает на станицу, с которой пришел
        die();
    }
    if (isset($_SESSION['id'])){
       $sql = "UPDATE orders SET `status` = 'handling', `name` = '$name', tel = '$tel', `comment` = '$comment' WHERE `status` = 'active' AND user_id = {$_SESSION['id']};";
        mysqli_query(getDb(),$sql);

    } else{//создаю заказ с user_id = 0
        $sql = "INSERT INTO orders (user_id, session_id, `status`, `name`, tel, `comment`) VALUES('0', '$session', 'handling', '$name', '$tel', '$comment');";
        mysqli_query(getDb(), $sql);
        $result = mysqli_query(getDb(),"SELECT id FROM orders WHERE session_id = '$session'");
        $row = mysqli_fetch_assoc($result);
        mysqli_query(getDb(),"UPDATE orders_products SET order_id = {$row['id']} WHERE session_id = '$session'");
    }
    session_regenerate_id();
    $_SESSION['message'] = "Заказ оформлен";
    header("Location: " . $url); //возвращает на станицу, с которой пришел
    die();
}

if ($_GET['action'] == 'delete'){//удаляю товар по нажатию кнопки
    $getId = (int) $_GET['id'];
if (isset($_SESSION['id'])){//если пользователь авторизован, то удаление идет по его id, который лежит в {$_SESSION['id']}
    $result = mysqli_query(getDb(),"SELECT orders_products.product_id, orders.id FROM orders_products 
    JOIN orders ON orders.id = orders_products.order_id WHERE orders.user_id = {$_SESSION['id']} AND orders.status = 'active' AND orders_products.product_id = {$getId};");
    if ($result -> num_rows === 0) {
        header("Location: ?message=error"); //выводит в строке браузера '/?message=error'
        die();
    } else {
        $row = mysqli_fetch_assoc($result);
        mysqli_query(getDb(), "DELETE FROM orders_products WHERE product_id = {$getId} AND order_id = {$row['id']};");

    }

}else {// если пользователь не авторизован, то удаление идет по session_id
    $result = mysqli_query(getDb(),"SELECT orders_products.product_id  FROM orders_products WHERE session_id = '$session' AND orders_products.product_id = {$getId};");
    if ($result -> num_rows === 0) {
        header("Location: ?message=error"); //выводит в строке браузера '/?message=error'
        die();
    } else {
        $row = mysqli_fetch_assoc($result);
        mysqli_query(getDb(), "DELETE FROM orders_products WHERE product_id = {$getId} AND session_id = '$session';");
    }
}
    header("Location: ?message=del"); //выводит в строке браузера '/?message=del'
    die();
}

$codes = [//массив с кодами для message
    'error' => "ошибка удаления товара",
    'del' => "товар удален",
    'empty' => "данные не заполнены",
];

$message = (isset($_GET['message'])) ? $codes[strip_tags($_GET['message'])] : "";// обрезает теги, и выводит значение message из строки браузера
$orderMessage = $_SESSION['message'];
unset($_SESSION['message']);
include 'views/basket.php';

