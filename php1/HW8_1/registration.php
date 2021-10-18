<?php
include_once 'models/db_connect.php';
include_once 'models/auth.php';

if (isset($_SESSION['id'])){
    header("Location: /");
    die();
}
if (isset($_POST['regSubmit'])){

    $login = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_POST['login'])));
    $pass = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_POST['pass'])));
    $passReenter = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_POST['pass_reenter'])));
    $url = $_SERVER['REQUEST_URI']; //получаю строку страницы без GET - запроса, делаю это на тот случай, если будут повторы с ошибками
    $url = explode('?', $url);
    $url = $url[0];
    if (empty($login) or empty($pass) or empty($passReenter)){
        header("Location: " . $url . "?message=null"); //возвращает на станицу, с которой пришел
        die();
    }
    if($pass !== $passReenter){
        header("Location: " . $url . "?message=pass"); //возвращает на станицу, с которой пришел
        die();
    }
    $result = mysqli_query(getDb(), "SELECT users.id FROM users WHERE users.name = '$login';");
    if ($result -> num_rows === 0){
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
        $result = mysqli_query(getDb(), "INSERT INTO users (name, pass_hash) VALUES ('$login', '$pass_hash');");
        if (mysqli_connect_errno()){
            header("Location: " . $url . "?message=error"); //возвращает на станицу, с которой пришел
            die();
        } else{
            header("Location: " . $url . "?message=reg"); //возвращает на станицу, с которой пришел
            die();
        }

    }else{
        header("Location: " . $url . "?message=same"); //возвращает на станицу, с которой пришел
        die();
    }

}
$codes = [//массив с кодами для $message
    'pass' => "Введенные пароли не совпадают",
    'null' => "Какое-то из полей осталось пустым, пожалуйста повторите ввод",
    'reg' => "Вы зарегистрированы",
    'error' => "Ошибка подключения к БД",
    'same' => "Пользователь с таким именем уже существует"

];

$message = (isset($_GET['message'])) ? $codes[strip_tags($_GET['message'])] : "";// обрезает теги, и выводит значение message из строки браузера
include 'views/registration.php';
