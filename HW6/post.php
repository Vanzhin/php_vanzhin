<?php
include_once 'function.php';

$data = json_decode(file_get_contents('php://input'));//возвращает из формата json посланные данные
$arg1 = $data->arg1;
$arg2 = $data->arg2;
$operation = $data->operation;

$response = [
    'arg1' => $data->arg1,
    'arg2' => $data->arg2,
    'result' => $operation($arg1, $arg2),
];

header("Content-type: application/json");
echo json_encode($response);//отправляет в формате json ответ

