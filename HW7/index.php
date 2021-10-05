<?php
include_once 'db_connect.php';
include_once 'auth.php';

$dataFromProducts = mysqli_query(getDb(),"SELECT products.id, products.name, products.price, product_images.title, product_likes.likes FROM products 
JOIN product_images ON product_images.product_id = products.id
JOIN product_likes ON product_likes.product_id = products.id;");

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Магазин</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>

</head>

<body>
<?php include 'menu.php'?>
<div id="main">
    Добро пожаловать в наш магазин!
</div>
</body>
</html>
