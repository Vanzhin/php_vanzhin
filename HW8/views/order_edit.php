<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Изменение заказа</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<?php include 'menu.php'?>
<div id="main">
    <div class="post_title"><h2>Заказ id <?=$orderId?></h2></div>
    <div class="gallery_item">
        <?=isset($basketEmpty) ? $basketEmpty : $message;?>
        <p><?=$orderMessage;?></p>
        <?php foreach($orderData as $good):?>
            <div class="feedback-item feedback">
                <a rel="gallery" class="photo" href="product_item.php?id=<?=$good['product_id']?>"><img alt="<?=$good['imageName']?>" src="gallery_img/small/<?=$good['imageName']?>" width="50" height="50"/></a>
                <p><?=$good['name']?></p>
                <p><?=$good['quantity']?></p>
                <p><?=$good['price']?></p>
                <P><?=$good['totalPrice']?></P>
                <a href="?action=delete&id=<?=$good['product_id']?>&orderId=<?=$good['order_id']?>">Удалить</a>
            </div>
        <?php endforeach; ?>
        <div><?=isset($basketEmpty) ? "" : "Итого: " . $basketPrice;?></div>
    </div>
</div>
</body>
</html>

