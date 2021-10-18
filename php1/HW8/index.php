<?php
include_once 'models/db_connect.php';
include_once 'models/auth.php';


$dataFromProducts = mysqli_query(getDb(),"SELECT products.id, products.name, products.price, product_images.title, product_likes.likes FROM products 
JOIN product_images ON product_images.product_id = products.id
JOIN product_likes ON product_likes.product_id = products.id;");

include 'views/index.php';
