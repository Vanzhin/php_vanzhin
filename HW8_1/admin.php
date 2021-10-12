<?php
include_once 'models/db_connect.php';
include_once 'models/auth.php';
if (!is_admin()){
    //возвращает на станицу корневую
    header("Location: /");
    die();
}
if (isset($_POST['status'])){
    if (is_admin()){
        $newStatus = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_POST['status'])));
        mysqli_query(getDb(),"UPDATE orders SET `status` = '$newStatus' WHERE  id = '$row';");
        header("Location: ?message=status"); //возвращает на станицу корневую
        die();
    }else{
        header("Location: /"); //возвращает на станицу корневую
        die();
    }
}
if ($_GET['action'] == 'delete'){
    $id = $_GET['id'];
    //получаю строку страницы без GET - запроса, делаю это на тот случай, если будут повторы с ошибками
    $url = $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);
    $url = $url[0];
    if (!is_admin()){
        //возвращает на станицу корневую
        header("Location: /");
        die();
    } else{
        mysqli_query(getDb(), "DELETE FROM orders WHERE id = {$id};");
        header("Location: " . $url . "?message=del"); //возвращает на станицу, с которой пришел
        die();
    }
}

$ordersData = mysqli_query(getDb(),"SELECT DISTINCT orders_products.order_id, SUM(orders_products.total * orders_products.price) OVER(PARTITION BY orders.id) AS grandTotal, orders.created_at, orders.status, orders.name, orders.tel, orders.comment
FROM orders_products
JOIN products ON products.id = orders_products.product_id
JOIN orders ON orders.id = orders_products.order_id ORDER BY orders.created_at DESC;");
$row = mysqli_fetch_assoc($ordersData)['order_id'];// получаю order_id для статуса



// получаю все возможные значения из ENUM из статуса заказа, преобразую в массив $enumArr
$result = mysqli_fetch_assoc(mysqli_query(getDb(), "SELECT SUBSTRING(COLUMN_TYPE,5) AS enumList
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA='shop' 
    AND TABLE_NAME='orders'
    AND COLUMN_NAME='status';"));
$enum = trim($result['enumList'],"(')");
$enumArr = explode("','", $enum);

//массив с кодами для message
$codes = [
    'del' => "заказ удален",
    'status' => "статус изменен",
];
$message = (isset($_GET['message'])) ? $codes[strip_tags($_GET['message'])] : "";// обрезает теги, и выводит значение message из строки браузера

include 'views/admin.php';
