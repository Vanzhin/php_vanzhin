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

