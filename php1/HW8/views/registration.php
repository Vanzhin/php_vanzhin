<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<?php include 'menu.php'?>
<div id="main">
    <div class="post_title"><h2>Регистрация нового пользователя</h2></div>
    <div class="error">
        <?=$message?>
    </div>
    <form action="" method="post" style="display: <?= $_GET['message'] == 'reg' ? 'none' : 'inherit'; ?>;">
        <input type="text" name="login" placeholder="введите логин">
        <input type="password" name="pass" placeholder="введите пароль">
        <input type="password" name="pass_reenter" placeholder="повторите пароль">
        <input type="submit" value="зарегистрироваться" name="regSubmit">
    </form>
</div>
</body>
</html>