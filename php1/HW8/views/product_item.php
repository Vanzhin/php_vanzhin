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
                    <input type="text" name="id" value="<?=$row['id']?>" style="display:none">
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
