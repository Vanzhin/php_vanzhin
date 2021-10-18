<?php
include_once 'db_connect.php';
include_once 'auth.php';
$getId = (int) $_GET['id'];
$row = [];
$buttonText = 'оставить';
$action = 'add';
$buyText = 'Купить';
$isInBasket = mysqli_query(getDb(),"SELECT product_id FROM orders_products WHERE product_id = '$getId';");
if($isInBasket ->num_rows !== 0){//если товар в корзине, на кнопке появляется надпись Добавить
    $buyText = 'Добавить';

}
if ($_POST['buy']){
    $productIdToBuy = (int) $_POST['buy'];

    $hasUserOrder = mysqli_query(getDb(),"SELECT id FROM orders WHERE user_id = {$_SESSION['id']};");

    if ($hasUserOrder -> num_rows === 0){
        mysqli_query(getDb(), "INSERT INTO orders (user_id) VALUES({$_SESSION['id']});");
    }
    $result = mysqli_query(getDb(), "SELECT id FROM orders WHERE user_id = {$_SESSION['id']}");
    $row = mysqli_fetch_assoc($result);

    $isInBasket = mysqli_query(getDb(),"SELECT product_id FROM orders_products WHERE product_id = '$productIdToBuy';");

    if($isInBasket -> num_rows === 0){
        mysqli_query(getDb(), "INSERT INTO orders_products (order_id, product_id,total) VALUES({$row['id']}, '$productIdToBuy', '1');");
    } else{
        mysqli_query(getDb(), "UPDATE orders_products SET total = total + 1 WHERE product_id = '$productIdToBuy';");
    }

    header("Location: ?id={$getId}&message=buy"); //выводит в строке браузера '/?message=ok'
    die();
}
if (!empty($getId)){ // если $getId не пуст - обращаюсь к базе и извлекаю запись по $getId
    mysqli_query(getDb(), "UPDATE product_likes SET likes = likes + 1 WHERE product_id = {$getId}");
    $itemData = mysqli_query(getDb(),"SELECT products.id, products.name, products.description, products.price, product_images.title, product_likes.likes FROM products 
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
    $feedbackData = mysqli_query(getDb(),"SELECT * FROM product_feedback WHERE product_id = {$getId} ORDER BY created_at DESC;");
    if ($feedbackData->num_rows === 0) {
        $feedbackMessage = 'отзывов пока нет';
    } else {
        $feedbackArr = [];
        while ($row = mysqli_fetch_assoc($feedbackData)) { // помещаю данные из базы в ассоциативный массив $feedbackArr
            array_push($feedbackArr, $row);
        }
    }

} else{
    $message = "Товара не найдено";
    $display = "none";

}
if ($_GET['action'] == 'add'){
$name = strip_tags(mysqli_escape_string(getDb(),$_POST['user_name']));
$feedbackText = strip_tags(mysqli_escape_string(getDb(),$_POST['user_feedback']));
if ((empty($name) || $name == "") || (empty($feedbackText) || $feedbackText == "")){
    header("Location: ?id={$getId}&message=error"); //выводит в строке браузера '/?message=ok'
    die();
}else{
    mysqli_query(getDb(), "INSERT INTO product_feedback (product_id,user_name,feedback) VALUES('$getId','$name','$feedbackText');");
    header("Location: ?id={$getId}&message=ok"); //выводит в строке браузера '/?message=ok'
    die();
    }
}
if ($_GET['action'] == 'delete'){
    $feedId = $_GET['feed'];
    $feedToDel = mysqli_query(getDb(),"SELECT * FROM product_feedback WHERE id = {$feedId};");
    if ($feedToDel->num_rows === 0) {
        header("Location: ?id={$getId}&message=error"); //выводит в строке браузера '/?message=ok'
        die();
    } else {
        mysqli_query(getDb(), "DELETE FROM product_feedback WHERE id = {$feedId};");
        header("Location: ?id={$getId}&message=del"); //выводит в строке браузера '/?message=ok'
        die();
    }

}
if ($_GET['action'] == 'edit'){
    $feedId = $_GET['feed'];
    $feedToEdit = mysqli_query(getDb(),"SELECT * FROM product_feedback WHERE id = {$feedId};");
    if ($feedToEdit->num_rows === 0) {
        header("Location: ?id={$getId}&message=error"); //выводит в строке браузера '/?message=ok'
        die();
    } else {
        $row = mysqli_fetch_assoc(mysqli_query(getDb(), "SELECT * FROM product_feedback WHERE id = {$feedId};"));
        $buttonText = 'обновить';
        $action = 'save';
    }

}
if ($_GET['action'] == 'save'){// todo не работает обновление отзыва
    $name = strip_tags(mysqli_escape_string(getDb(),$_POST['user_name']));
    $feedbackText = strip_tags(mysqli_escape_string(getDb(),$_POST['user_feedback']));
    $feedId = (int) $_POST['id'];

    if ((empty($name) || $name == "") || (empty($feedbackText) || $feedbackText == "")){
        header("Location: ?id={$getId}&message=error"); //выводит в строке браузера '/?message=ok'
        die();
    }else{
        var_dump($name, $feedbackText,$feedId);
        die();
        mysqli_query(getDb(), "UPDATE product_feedback SET user_name = '$name', feedback = '$feedbackText' WHERE id = '$feedId';");
        header("Location: ?id={$getId}&message=edit"); //выводит в строке браузера '/?message=ok'
        die();
    }
}
$codes = [//массив с кодами для message
    'ok' => "Ваш отзыв загружен",
    'error' => "ошибка загрузки отзыва",
    'del' => "отзыв удален",
    'edit' => "отзыв обновлен",
    'buy' => "товар добавлен в корзину"
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
<?php include 'menu.php'?>
<div id="main">
    <div class="post_title"><h2><?=$itemArr['name']?></h2></div>
    <div class="gallery_item" style="display:<?=$display?>">
        <img alt="<?=$itemArr['name']?>" src="gallery_img/big/<?=$itemArr['title']?>"/>
        <h3><?=$itemArr['name']?></h3>
        <h3><?=$itemArr['description']?></h3>
        <h4>Цена: <?=$itemArr['price']?></h4>
        <p>Понравилось: <?=$itemArr['likes']?> покупателям</p>
        <form action="" method="POST">
            <button type="submit" name="buy" value="<?=$itemArr['id']?>"><?=$buyText?></button>
        </form>
        <div class="feedback">
            <h2>отзывы о <?=$itemArr['name']?></h2>
            <hr>
            <?=$feedbackMessage?>
            <?php foreach($feedbackData as $feedback):?>
            <div class="feedback-item">
                <h4><?=$feedback['user_name']?></h4>
                <h5><?=$feedback['created_at']?></h5>
                <P><?=$feedback['feedback']?></P>
                <a href="?action=delete&id=<?=$getId?>&feed=<?=$feedback['id']?>">Х</a>
                <a href="?action=edit&id=<?=$getId?>&feed=<?=$feedback['id']?>">правка</a>
            </div>
            <hr>
            <?php endforeach; ?>
            <p><?=$message?></p>
            <div class="feedback-send">
                <form method="post" class="feedback-form" action="?action=<?=$action?>&id=<?=$getId?>">
                    <input type="text" name="id" value="<?=$feedback['id']?>">
                    <input type="text" name="user_name" value="<?=$row['user_name']?>">
                    <textarea name="user_feedback" rows="5" cols="33"><?=$row['feedback']?></textarea>
                    <input type="submit" value="<?=$buttonText?> отзыв">
                </form>
            </div>
        </div>
    </div>
    <a href="catalog.php">назад</a>
</div>
</body>
</html>
