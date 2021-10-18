<?php
include_once 'db_connect.php';

$getId = (int) $_GET['id'];
if (!empty($getId)){ // если $getId не пуст - обращаюсь к базе и извлекаю запись по $getId
    mysqli_query($db, "UPDATE product_likes SET likes = likes + 1 WHERE product_id = {$getId}");
    $itemData = mysqli_query($db,"SELECT products.id, products.name, products.description, products.price, product_images.title, product_likes.likes FROM products 
JOIN product_images ON product_images.product_id = products.id
JOIN product_likes ON product_likes.product_id = products.id WHERE id = {$getId};");
    $response = ($itemData -> num_rows);
} else{
    $response = 0;

}
if($response === 1){
    $itemArr = mysqli_fetch_assoc($itemData);
    $message = $itemArr['name'];
    $display = "inherit";
    $feedbackData = mysqli_query($db,"SELECT * FROM product_feedback WHERE product_id = {$getId};");
    $feedbackArr = [];
    while ($row = mysqli_fetch_assoc($feedbackArr)) { // помещаю данные из базы в ассоциативный массив $feedbackArr
        array_push($feedbackArr, $row);
    }
} else{
    $message = "Товара не найдено";
    $display = "none";

}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$name = strip_tags(mysqli_escape_string($db,$_POST['user_name']));
$feedbackText = strip_tags(mysqli_escape_string($db,$_POST['user_feedback']));
if ((empty($name) || $name == "") || (empty($feedbackText) || $feedbackText == "")){
    header("Location: /product_item.php?id={$getId}&message=error"); //выводит в строке браузера '/?message=ok'
    die();
}else{
    mysqli_query($db, "INSERT INTO product_feedback (product_id,user_name,feedback) VALUES('$getId','$name','$feedbackText');");
    header("Location: /product_item.php?id={$getId}&message=ok"); //выводит в строке браузера '/?message=ok'
    die();
    }
}
$codes = [//массив с кодами для message
    'ok' => "Ваш отзыв загружен",
    'error' => "ошибка загрузки отзыва",
];

$message = (isset($_GET['message'])) ? $codes[strip_tags($_GET['message'])] : "";// обрезает теги, и выводит значение message из строки браузера

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$itemArr['name']?></title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div id="main">
    <div class="post_title"><h2><?=$itemArr['name']?></h2></div>
    <div class="gallery_item" style="display:<?=$display?>">
        <img alt="<?=$itemArr['name']?>" src="gallery_img/big/<?=$itemArr['title']?>"/>
        <h3><?=$itemArr['name']?></h3>
        <h3><?=$itemArr['description']?></h3>
        <h4>Цена: <?=$itemArr['price']?></h4>
        <p>Понравилось: <?=$itemArr['likes']?> покупателям</p>
        <button name="cart" value="buy">Купить</button>
        <div class="feedback">
            <h2>отзывы о <?=$itemArr['name']?></h2>
            <hr>
            <?php foreach($feedbackData as $feedback):?>
            <div class="feedback-item">
                <h4><?=$feedback['user_name']?></h4>
                <h5><?=$feedback['created_at']?></h5>
                <P><?=$feedback['feedback']?></P>
            </div>
            <hr>
            <?php endforeach; ?>
            <p><?=$message?></p>
            <div class="feedback-send">
                <form method="post" class="feedback-form">
                    <input type="text" name="user_name" value="">
                    <textarea name="user_feedback" rows="5" cols="33" value=""></textarea>
                    <input type="submit" value="оставить отзыв">
                </form>
            </div>
        </div>
    </div>
    <a href="index.php">назад</a>



</div>
</body>
</html>
