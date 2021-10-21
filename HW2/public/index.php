<?php
use app\models\{Products, Users, OrdersProducts, Orders};
use app\models\figure\{Triangle, Circle, Rectangle};
include "../engine/Autoload.php";

//регистрирует автозагрузчики и вызывает их, см урок php2.2
spl_autoload_register([new Autoload(), 'loadClass']);

//function loader($className)
//{
//    (new Autoload())->loadClass($className);
//    это тоже самое, что и     (new Autoload())->loadClass($className);
//    $loadClass = new Autoload();
//    $loadClass ->loadClass($className);
//}

$product = new Products();
$user = new Users();
$ordersProduct = new OrdersProducts();
$order = new Orders();
$triangle = new Triangle(2,3,4);
$circle = new Circle(3);
$rectangle = new Rectangle(2, 4);

//function foo(Model $obj){
//     return $obj->getAll();
//}
//echo foo($product);
//echo "<br>";

echo $product->getOne(1);
echo "<br>";
echo $product->getAll();
echo "<br>";
echo $user->getOne(2);
echo "<br>";
echo $user->getAll();
echo "<br>";
echo $ordersProduct->getOne(3);
echo "<br>";
echo $ordersProduct->getAll();
echo "<br>";
echo $order->getOne(4);
echo "<br>";
echo $order->getAll();

echo "<br>";
echo $triangle->getFigureName();
echo "<br> площадь равна ";
echo $triangle->getSquare();
echo "<br> периметр равен ";
echo $triangle->getPerimeter();
echo "<br>";
echo $circle->getFigureName();
echo "<br> площадь равна ";
echo $circle->getSquare();
echo "<br> периметр равен ";
echo $circle->getPerimeter();
echo "<br>";
echo $rectangle->getFigureName();
echo "<br> площадь равна ";
echo $rectangle->getSquare();
echo "<br> периметр равен ";
echo $rectangle->getPerimeter();