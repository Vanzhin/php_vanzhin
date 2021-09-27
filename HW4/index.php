<?php

$path = $_SERVER['DOCUMENT_ROOT'] . '/HW4/gallery_img/big';
function getFilesName($path)
{
    return array_splice(scandir($path),2);
}

$galleryFiles = getFilesName($path);

if (!empty($_FILES)){
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/HW4/gallery_img/big/' . $_FILES['clientFile']['name'];
    $saveToPath = $_SERVER['DOCUMENT_ROOT'] . '/HW4/gallery_img/small/' . $_FILES['clientFile']['name'];
    //Проверка на размер файла
    if($_FILES["clientFile"]["size"] > 1024*5*1024)
    {
        echo ("Размер файла не больше 5 мб");
        exit;
    }
//Проверка расширения файла
    $blacklist = array(".php", ".phtml", ".php3", ".php4");
    foreach ($blacklist as $item) {
        if(preg_match("/$item\$/i", $_FILES['clientFile']['name'])) {
            echo "Загрузка php-файлов запрещена!";
            exit;
        }
    }
    $imageinfo = getimagesize($_FILES['clientFile']['tmp_name']);
    if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg') {
        echo "Можно загружать только jpg-файлы, неверное содержание файла, не изображение.";
        exit;
    }

    if(move_uploaded_file($_FILES['clientFile']['tmp_name'],$uploadPath)){

        include_once('classSimpleImage.php');
        $image = new SimpleImage();
        $image->load($uploadPath);
        $image->resizeToWidth(250);
        $image->save($saveToPath);
        header('Location: /HW4/?message=ok');
        die();
    } else {
        header('Location: /HW4/?message=error');
        die();
    }
}
$codes = [
        'ok' => "файл загружен",
        'error' => "ошибка загрузки",
];

$messageCode = strip_tags($_GET['message']);
$message = $codes[$messageCode];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Моя галерея</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script type="text/javascript" src="./scripts/jquery-1.4.3.min.js"></script>
    <script type="text/javascript" src="./scripts/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="./scripts/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="./scripts/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
        $(document).ready(function(){
            $("a.photo").fancybox({
                transitionIn: 'elastic',
                transitionOut: 'elastic',
                speedIn: 500,
                speedOut: 500,
                hideOnOverlayClick: false,
                titlePosition: 'over'
            });	}); </script>

</head>

<body>
<div id="main">
    <div class="post_title"><h2>Моя галерея</h2></div>
    <div class="gallery">
        <?php foreach($galleryFiles as $file):?>
        <a rel="gallery" class="photo" href="gallery_img/big/<?=$file?>"><img src="gallery_img/small/<?=$file?>" width="150" height="100" /></a>
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