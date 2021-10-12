<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Админка</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<?php include 'menu.php'?>
<div id="main">
    <div class="post_title"><h2>Админка</h2></div>
    <div class="gallery_item">
        <p>Заказы магазина</p>
        <?=$message?>
        <?php foreach($ordersData as $order):?>
            <div class="feedback-item feedback">
                <p><?=$order['order_id']?></p>
                <p><?=$order['grandTotal']?></p>
                <p><?=$order['created_at']?></p>
                <P><?=$order['status']?></P>
                <P><?=$order['name']?></P>
                <P><?=$order['tel']?></P>
                <P><?=$order['comment']?></P>
            </div>
        <div>
            <a href="?action=delete&id=<?=$order['order_id']?>">Удалить</a>
            <a href="order_edit.php?orderId=<?=$order['order_id']?>">Подробнее</a>
            <form action="" method="post">
                <input type="submit" value="Изменить статус на">
                <select name="status" id="">
                    <?php foreach($enumArr as $item):?>
                    <option value="<?=$item?>" <?php if($order['status'] == $item) echo 'selected';?>><?=$item?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>

