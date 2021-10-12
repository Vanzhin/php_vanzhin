<?php
include_once 'models/db_connect.php';
include_once 'models/auth.php';

$getId = (int) $_GET['id'];
$feedsData = mysqli_query(getDb(),"SELECT products.id as product_id, products.name as product_name, product_images.title as image_name, product_feedback.user_name, product_feedback.feedback, product_feedback.created_at FROM products 
JOIN product_images ON product_images.product_id = products.id 
JOIN product_feedback ON product_feedback.product_id = products.id ORDER BY product_feedback.updated_at DESC, product_feedback.created_at DESC;");
if($feedsData -> num_rows == 0){
    $feedbackMessage = 'пока отзывов нет';
}else{

}
include 'views/feedback.php';