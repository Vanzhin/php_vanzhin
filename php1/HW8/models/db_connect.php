<?php
session_start();
$session = session_id();

function getDb(){
    static $db = '';
    if(isset($db)){
        $db = mysqli_connect('localhost:3306','test_user', '1234', 'shop') or die('ошибка соединения: ' . mysqli_connect_error());
    }
    return $db;
}
if (isset($_SESSION['id'])){
    $grandTotal = mysqli_fetch_assoc(mysqli_query(getDb(),"SELECT SUM(orders_products.total) AS total FROM orders_products
JOIN orders ON orders.id = orders_products.order_id WHERE orders.user_id = {$_SESSION['id']} AND orders.status = 'active';"));
} else{
    $grandTotal = mysqli_fetch_assoc(mysqli_query(getDb(),"SELECT SUM(orders_products.total) AS total FROM orders_products
    WHERE session_id = '$session';"));
}