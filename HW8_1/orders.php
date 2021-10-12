<?php
include_once 'models/db_connect.php';
include_once 'models/auth.php';
if (!is_auth()){// если не авторизован, возвращает на главную
    header("Location: /"); //возвращает на станицу корневую
    die();
}
$ordersData = mysqli_query(getDb(),"SELECT DISTINCT SUM(orders_products.total * orders_products.price) OVER(PARTITION BY orders.id) AS orderTotal, SUM(orders_products.total * orders_products.price) OVER(PARTITION BY orders.user_id) AS grandTotal, orders.id, orders.created_at, orders.updated_at, orders.status
FROM orders_products
JOIN products ON products.id = orders_products.product_id
JOIN orders ON orders.id = orders_products.order_id 
WHERE orders.user_id = {$_SESSION['id']}
ORDER BY orders.created_at DESC;");

if($ordersData -> num_rows == 0){//если заказов нет вывожу сообщение
    $orderEmpty = 'Заказов пока нет';
}

$basketPrice = mysqli_fetch_assoc($ordersData)['grandTotal'];
$userOrderData = mysqli_query(getDb(),"SELECT orders_products.order_id, orders_products.product_id, orders_products.total AS quantity, products.name, orders_products.price, (orders_products.price*orders_products.total) AS totalPrice, product_images.title AS imageName FROM orders_products
JOIN products ON products.id = orders_products.product_id
JOIN product_images ON product_images.product_id = products.id
JOIN orders ON orders.id = orders_products.order_id WHERE orders.user_id = {$_SESSION['id']};");



include 'views/orders.php';

