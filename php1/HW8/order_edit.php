<?php
include_once 'models/db_connect.php';
include_once 'models/auth.php';

if (!is_admin()){
    header("Location: /"); //возвращает на станицу корневую
    die();
}

$orderId = (int) $_GET['orderId'];
$getId = (int) $_GET['id'];

$orderData = mysqli_query(getDb(),"SELECT orders_products.order_id, orders_products.product_id, orders_products.total AS quantity, products.name, products.price, (products.price*orders_products.total) AS totalPrice, SUM(orders_products.total * products.price) OVER(PARTITION BY orders.id) AS grandTotal, product_images.title AS imageName FROM orders_products
JOIN products ON products.id = orders_products.product_id
JOIN product_images ON product_images.product_id = products.id
JOIN orders ON orders.id = orders_products.order_id WHERE orders.id = '$orderId';");

if($orderData -> num_rows == 0){//если корзина пуста вывожу сообщение
    $basketEmpty = 'Козина пуста';
}else {
    $basketPrice = mysqli_fetch_assoc($orderData)['grandTotal'];
}

if ($_GET['action'] == 'delete'){//удаляю товар по нажатию кнопки
    $url = $_SERVER['REQUEST_URI']; //получаю строку страницы без GET - запроса, делаю это на тот случай, если будут повторы с ошибками
    $url = explode('?', $url);
    $url = $url[0];
    if (is_admin()){//если пользователь admin, то удаление происходит
        $result = mysqli_query(getDb(),"SELECT orders_products.product_id, orders.id FROM orders_products
        JOIN orders ON orders.id = orders_products.order_id WHERE orders.id = '$orderId' AND orders_products.product_id = '$getId';");
        if ($result -> num_rows === 0) {
            header("Location: " . $url . "?message=error&orderId=" . $orderId); //выводит в строке браузера '/?message=error'
            die();
        } else {
            $row = mysqli_fetch_assoc($result);
            mysqli_query(getDb(), "DELETE FROM orders_products WHERE product_id = {$getId} AND order_id = {$orderId};");
        }
    }else {// если пользователь не admin, то удаление не происходит
            header("Location: " . $url . "?message=error&orderId=" . $orderId); //выводит в строке браузера '/?message=error'
            die();
        }
    header("Location: " . $url . "?message=del&orderId=" . $orderId); //выводит в строке браузера '/?message=del'
    die();
}

$codes = [//массив с кодами для message
    'error' => "ошибка удаления товара",
    'del' => "товар удален",
    'empty' => "данные не заполнены",
];

$message = (isset($_GET['message'])) ? $codes[strip_tags($_GET['message'])] : "";// обрезает теги, и выводит значение message из строки браузера
include 'views/order_edit.php';

