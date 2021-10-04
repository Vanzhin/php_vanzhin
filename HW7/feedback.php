<?php
include_once 'db_connect.php';
include_once 'auth.php';


$getId = (int) $_GET['id'];
$feedsData = mysqli_query(getDb(),"SELECT products.id as product_id, products.name as product_name, product_images.title as image_name, product_feedback.user_name, product_feedback.feedback, product_feedback.created_at FROM products 
JOIN product_images ON product_images.product_id = products.id 
JOIN product_feedback ON product_feedback.product_id = products.id ORDER BY product_feedback.updated_at DESC, product_feedback.created_at DESC;");
if($feedsData -> num_rows == 0){
    $feedbackMessage = 'пока отзывов нет';
}else{

}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Отзывы</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<?php include 'menu.php'?>
<div id="main">
    <div class="post_title"><h2>Отзывы о товарах</h2></div>
    <div class="gallery_item">
            <?=$feedbackMessage?>
            <?php foreach($feedsData as $feedback):?>
                <div class="feedback-item feedback">
                    <a rel="gallery" class="photo" href="product_item.php?id=<?=$feedback['product_id']?>"><img alt="<?=$feedback['product_name']?>" src="gallery_img/small/<?=$feedback['image_name']?>" width="50" height="50"/></a>
                    <p><?=$feedback['product_name']?></p>
                    <p><?=$feedback['user_name']?></p>
                    <P><?=$feedback['feedback']?></P>
                    <P><?=$feedback['created_at']?></P>
                </div>
            <?php endforeach; ?>
    </div>
</div>
</body>
</html>
