<?php if($allow): ?>
    <div class="hello">Добро пожаловать, <?=$login?>&nbsp;
        <form class="bye" method="post">
            <button type="submit" name="logout">Выйти</button>
        </form>
    </div>
<?php else: ?>
    <div class="error">
        <?=$logMessage?>
    </div>
    <form action="" method="post">
        <input type="text" name="login">
        <input type="password" name="pass">
        <label class="text" for="save"> Запомнить меня</label><input id="save" type="checkbox" name="save">
        <input type="submit" value="вход" name="submit">
        <a href="registration.php" style="display: <?= strpos($_SERVER['REQUEST_URI'], 'registration') ? 'none' : 'inline-block'; ?>" class="button">Зарегистрироваться</a>
    </form>
<?php endif; ?>

<a href="index.php" class="main_menu">Главная</a>
<a href="catalog.php" class="main_menu">Каталог</a>
<a href="feedback.php" class="main_menu">Отзывы</a>
<a href="basket.php" class="main_menu">Корзина <?= ($grandTotal['total'] > 0) ? "( " . $grandTotal['total'] . " )" : "";?></a>
<?php if(is_admin()): ?>
<a href="admin.php" class="main_menu">Админка</a>
<?php endif; ?>
<?php if(is_auth() && !is_admin()): ?>
    <a href="orders.php" class="main_menu">Мои заказы <?= ($ordersCount['orders'] > 0) ? "( " . $ordersCount['orders'] . " )" : "";?></a>
<?php endif; ?>
