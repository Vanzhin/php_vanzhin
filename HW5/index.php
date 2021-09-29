<?php
include_once('classSimpleImage.php');// подключаю файл с функцией изменения размера
include_once('function.php'); // подключаю функции для записи данных в бд

$db = mysqli_connect('localhost:3306','test_user', '1234', 'vanzhin_test') or die('ошибка соединения: ' . mysqli_connect_error());
$dataFromImages = mysqli_query($db,"SELECT * FROM `images` ORDER BY `likes` DESC");

$imageArr = [];
while ($row = mysqli_fetch_assoc($dataFromImages)){ // помещаю данные из базы в ассоциативный массив $imageArr
    array_push($imageArr, $row);
}

$pathBig = $_SERVER['DOCUMENT_ROOT'] . '/gallery_img/big/'; //путь до больших изображений
$pathSmall = $_SERVER['DOCUMENT_ROOT'] . '/gallery_img/small/'; //путь до сжатых изображений

//читаю файл для отображения загруженного изображения
$file = fopen('upload_name.html','r');
if ($file){
   $imgName = fgets($file);
    fclose($file);
} else{
    $imgName = '';
}

//$imageData = getFileData($pathBig, $pathSmall);
//foreach ($imageData as $row){ // помещаю данные в таблицу images
//    mysqli_query($db, "INSERT INTO images VALUES ('$row[id]', '$row[title]', '$row[big_link]', '$row[small_link]', '$row[size]', '0');");
//}

if (!empty($_FILES)){// если файл загружен во временную папку, то происходят дальнейшие проверки
// Проверка на размер файла
    if($_FILES["clientFile"]["size"] > 1024*5*1024)
    {
        echo ("Размер файла не больше 5 мб");
        exit;
    }
// Проверка расширения файла
    $blacklist = array(".php", ".phtml", ".php3", ".php4");
    foreach ($blacklist as $item) {
        if(preg_match("/$item\$/i", $_FILES['clientFile']['name'])) {
            echo "Загрузка php-файлов запрещена!";
            exit;
        }
    }
// Проверка расширения файла
    $imageInfo = getimagesize($_FILES['clientFile']['tmp_name']);
    if($imageInfo['mime'] != 'image/gif' && $imageInfo['mime'] != 'image/jpeg') {
        echo "Можно загружать только jpg-файлы, неверное содержание файла, не изображение.";
        exit;
    }
// записываю имя файла в upload_name.html
    $file = fopen('upload_name.html','w');
    fputs($file, $_FILES['clientFile']['name']);
    fclose($file);
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/gallery_img/big/' . $_FILES['clientFile']['name'];//путь откуда берутся файлы для изменения размера
    $saveToPath = $_SERVER['DOCUMENT_ROOT'] . '/gallery_img/small/' . $_FILES['clientFile']['name'];//путь куда помещаются измененные файлы
    $filename = $_FILES['clientFile']['name'];
    $filesize = $_FILES['clientFile']['size'];
    if(move_uploaded_file($_FILES['clientFile']['tmp_name'], $uploadPath)){// переносит из временной папки в $uploadPath
        $image = new SimpleImage();// изменяет размер картинки и переносит в $saveToPath
        $image->load($uploadPath);
        $image->resizeToWidth(250);
        $image->save($saveToPath);
        $imageMatch = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `images` WHERE title = '$filename' AND size = '$filesize'"));
        if (!$imageMatch){// если запись с таким именем и размером уже есть в бд, не заношу запись в бд
                mysqli_query($db, "INSERT INTO `images` (title, big_link, small_link, size, likes) VALUES ('$filename', '$uploadPath', '$saveToPath', '$filesize', '0')");
        }
        header('Location: /?message=ok'); //выводит в строке браузера '/?message=ok'
        die();
    } else {
        header('Location: /?message=error'); //выводит в строке браузера '/?message=error'
        die();
    }
}
$codes = [//массив с кодами для message
        'ok' => "загружен файл: " . $imgName,
        'error' => "ошибка загрузки",
];

$message = (isset($_GET['message'])) ? $codes[strip_tags($_GET['message'])] : "";// обрезает теги, и выводит значение message из строки браузера
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Моя галерея</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>

</head>

<body>
<div id="main">
    <div class="post_title"><h2>Моя галерея</h2></div>
    <div class="gallery">
        <?php foreach($imageArr as $item):?>
        <a rel="gallery" class="photo" href="image.php?id=<?=$item['id']?>"><img alt="<?=$item['title']?>" src="gallery_img/small/<?=$item['title']?>" width="150" height="100" /></a>
        <?php endforeach; ?>
    </div>
    <div>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="clientFile">
            <input type="submit" name = "отправить">
        </form>
    <?=$message?>
    </div>
</div>
</body>
</html>