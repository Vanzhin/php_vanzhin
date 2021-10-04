<?php
function getDb(){
    static $db = '';
    if(isset($db)){
        $db = mysqli_connect('localhost:3306','test_user', '1234', 'shop') or die('ошибка соединения: ' . mysqli_connect_error());
    }
    return $db;
}