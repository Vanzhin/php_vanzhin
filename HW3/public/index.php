<?php
use app\models\{Product, User, OrdersProduct, Order,ProductFeedback, ProductImage, ProductLike};
use app\engine\{Autoload, Db};
include "../engine/Autoload.php";
include '../config/config.php';
//регистрирует автозагрузчики и вызывает их, см урок php2.2
spl_autoload_register([new Autoload(), 'loadClass']);

$feed = new ProductFeedback();
$feedFromDB = $feed->getOne(112);
$feedFromDB->__set('user_name', 'sarah');
$feedFromDB->update();
