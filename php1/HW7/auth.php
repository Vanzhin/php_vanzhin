<?php
session_start();
$allow = false;

function get_user(){// возвращает логин юзера
    return $_SESSION['login'];
}
function is_auth(){// проверяет авторизован ли кто-то возвращает ответ в виде true или false, если true, то сообщает кто залогинился
    if (!isset($_SESSION['login']) and isset($_COOKIE["hash"])){// если в $_SESSION есть login, то тело не выполняется
       $hash = $_COOKIE["hash"];// берем из $_COOKIE значение hash и смотрим есть ли в базе
       $result = mysqli_query(getDb(), "SELECT users.id, users.name AS login FROM users JOIN users_auth ON users_auth.user_id = users.id WHERE users_auth.hash = '$hash';");
       $row = mysqli_fetch_assoc($result);
       $user = $row['login'];// присваиваем переменной $user значение из базы
       if (!empty($user)){
           $_SESSION['login'] = $user; // присваиваем $_SESSION['login'] значение из базы
           $_SESSION['id'] = $row['id'];// присваиваем $_SESSION['id'] значение из базы
       }
    }
    return isset($_SESSION['login']);
}
function auth($login, $pass){// возвращает true с login и id пользователя, или false если пароль не верен
    $login = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($login)));
    $result = mysqli_query(getDb(), "SELECT users.id, users.name AS login, users_auth.pass_hash FROM users JOIN users_auth ON users_auth.user_id = users.id WHERE users.name = '$login';");
    $row = mysqli_fetch_assoc($result);
    if(password_verify($pass,$row['pass_hash'])){
        $_SESSION['login'] = $login;
        $_SESSION['id'] = $row['id'];
        return true;
    }
    return false;
}

if(isset($_POST['logout'])){// удаляет куки для пользователя
    setcookie("hash","", time() - 3600, '/');
    session_destroy();
    header("Location: " . $_SERVER['HTTP_REFERER']); //возвращает на станицу, с которой пришел
    die();
}
if (is_auth()){
    $allow = true;
    $login = get_user();

}
if (isset($_POST['submit'])){
    $login = strip_tags($_POST['login']);
    $pass = strip_tags($_POST['pass']);

    if (auth($login, $pass)){
        if (isset($_POST['save'])){// записывает куки, если стоит галка "запомнить"
            $hash = uniqid(rand(),true);
            $id = $_SESSION['id'];
            $session_hash = mysqli_query(getDb(), "UPDATE users_auth SET hash = '$hash' WHERE user_id = '$id';");
            setcookie("hash",$hash, time() + 3600, '/');

        }
        header("Location: " . $_SERVER['HTTP_REFERER']); //возвращает на станицу, с которой пришел
        die();
    } else{
        $is_error = (stripos($_SERVER['HTTP_REFERER'], "?log=error") ? "" : "?log=error");// если в строке браузера уже есть log=error, то нового не ставит
        header("Location: " . $_SERVER['HTTP_REFERER'] . $is_error); //возвращает на станицу, с которой пришел, и параметр log
        die();
    }
}
$codes = [//массив с кодами для $logMessage
    'error' => "Ошибка аутентификации",
];

$logMessage = (isset($_GET['log'])) ? $codes[strip_tags($_GET['log'])] : "";// обрезает теги, и выводит значение message из строки браузера

?>
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

    </form>
<?php endif; ?>
