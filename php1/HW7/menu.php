<?php
include_once 'db_connect.php';
//считаю количество товаров в корзине
$grandTotal = mysqli_fetch_assoc(mysqli_query(getDb(),"SELECT count(orders_products.total) AS total FROM orders_products
JOIN orders ON orders.id = orders_products.order_id WHERE orders.user_id = {$_SESSION['id']};"));
?>

<a href="index.php" class="main_menu">Главная</a>
<a href="catalog.php" class="main_menu">Каталог</a>
<a href="feedback.php" class="main_menu">Отзывы</a>
<a href="basket.php" class="main_menu">Корзина <?= ($grandTotal['total'] > 0) ? "( " . $grandTotal['total'] . " )" : "";?></a>