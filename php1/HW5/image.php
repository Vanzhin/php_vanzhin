<?php
$db = mysqli_connect('localhost:3306','test_user', '1234', 'vanzhin_test') or die('ошибка соединения: ' . mysqli_connect_error());
$getId = (int) $_GET['id'];
if (!empty($getId)){ // если $getId не пуст - обращаюсь к базе и извлекаю запись по $getId
    if($likesValue = mysqli_fetch_assoc(mysqli_query($db, "SELECT `likes` FROM `images` WHERE id = {$getId}"))){
        $likesValue = mysqli_fetch_assoc(mysqli_query($db, "SELECT `likes` FROM `images` WHERE id = {$getId}"));
        $likesValue['likes']++; // добавляю лайк, затем обновляю в бд
        $likesUpdated = mysqli_query($db, "UPDATE `images` SET `likes` = {$likesValue['likes']} WHERE id = {$getId}");
    }
    $image = mysqli_query($db, "SELECT * FROM `images` WHERE id = {$getId}");// извлекаю новую запись
    $imagesItem = mysqli_fetch_assoc($image);
}

if(!$imagesItem) { // если запись не найдена, вывожу сообщение
    $message = "не найдено";
} else {// если запись есть, присваиваю $message название файла
    $message = $imagesItem['title'];
}



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Изображение <?=" " . $message?></title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body>
<div id="main">
    <div class="post_title"><h2>Изображение <?=" " . $message?></h2></div>
    <div class="gallery">
        <img alt="<?=$message?>" src="gallery_img/big/<?=$message?>"/>
    </div>
    <div>
        количество просмотров: <?=$likesValue['likes']?>
    </div>
</div>
</body>
</html>
