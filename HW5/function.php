<?php
function getFilesName($path) // находит файлы в указанной папке, возвращает массив с именами файлов
{
    $dirList = scandir($path);
    $dirList = array_splice($dirList,2);
    foreach ($dirList as $key => $item){
       if (is_dir($path . $item)){//если элемент массива папка удаляет ее название из массива
          unset($dirList[$key]);
       }
    }
    return $dirList;
}

function getFileData($pathBig, $pathSmall) // находит файлы в указанной папке, возвращает массив с данными о файле
{
    $dirList = scandir($pathBig);
    $dirList = array_splice($dirList,2);
    $dataList =[];
    foreach ($dirList as $key => $item){
        if (is_dir($pathBig . $item)){//если элемент массива папка удаляет ее название из массива
            unset($dirList[$key]);
        } else
        array_push($dataList,['id' => $key, 'title' => $item, 'big_link' => $pathBig . $item, 'small_link' => $pathSmall . $item, 'size' => filesize($pathBig . $item)]);
    }
    return $dataList;
}


