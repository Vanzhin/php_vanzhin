<?php
//1
$n = 0;
while ($n <= 100)
{
    if (++$n % 3 === 0){
        echo $n . " ";
    }
}
echo "<br>";

//2

$n = 0;
do
{
    if ($n === 0){
        echo $n . " - ноль" . "<br>";
    } elseif($n & 1){
        echo $n . " - нечетное число" . "<br>";
    } else{
        echo $n . " - четное число" . "<br>";
    }
    $n++;
} while ($n <= 10);

echo "<br>";

//3

$region_cities = [
    "Московская область" => ["Москва", "Зеленоград", "Клин"],
    "Ленинградская область" => ["Санкт-Петербург", "Всеволожск", "Павловск", "Кронштадт"],
    "Рязанская область" => ["Рязань", "Спасск-Рязанский", "Шацк", "Сапожок"]
];

function showRegionCities(array $arr)
{
    $n = 1;
    static $len = 0;
    foreach ($arr as $key => $value){
        if(is_array($value)){
            $len = sizeof($value);
            echo $key . ": ";
            showRegionCities($value);
        } else{
            if($n < $len){
                echo $value . ", ";
                $n++;
            } else {
                echo $value . ". " . "<br />";
            }
        }
    }
}
showRegionCities($region_cities);
echo "<br>";

//4

$sentence = "ПрювеТ, мир!";
$alfabet = [
    'а' => 'a', 'б' => 'b', 'в' => 'v',
    'г' => 'g', 'д' => 'd', 'е' => 'e',
    'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
    'и' => 'i', 'й' => 'y', 'к' => 'k',
    'л' => 'l', 'м' => 'm', 'н' => 'n',
    'о' => 'o', 'п' => 'p', 'р' => 'r',
    'с' => 's', 'т' => 't', 'у' => 'u',
    'ф' => 'f', 'х' => 'h', 'ц' => 'c',
    'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
    'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
    'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
];

function translit($string)
{
    global $alfabet;
    $trPhrase = "";
    $replaceTo = $alfabet;
    for($n = 0;$n < mb_strlen($string); $n++){
        $letter = mb_substr($string, $n,1);
        $letterLower = mb_strtolower(mb_substr($string, $n,1));
        if (array_key_exists($letterLower, $replaceTo)){
            if($letter === $letterLower){
                $trPhrase .= $replaceTo[$letterLower];
            } else{
                $trPhrase .= ucfirst($replaceTo[$letterLower]);
            }
        } else {
            $trPhrase .= mb_substr($string, $n, 1);
        }
    };
    return $trPhrase;
};

echo translit ($sentence);
echo "<br>";

//5

function spaceToLowbar($string)
{
     return str_replace(" ","_", $string);
};
echo spaceToLowbar(translit($sentence));
echo "<br>";

//7

for($n = 0; $n < 10; print($n++));
echo "<br>";

//8

function getCitiesByLetter(array $arr,$letter)
{
  foreach ($arr as $elkey => $value){
      if(is_array($value)){
          foreach ($value as $key => $item){
              if(mb_strtolower(mb_substr($item, 0, 1)) !== mb_strtolower($letter)){
                  unset($arr[$elkey][$key]);
              }
          }
      }
  }
  return $arr;
};

function showCitiesLetter(array $arr, $letter)
{
    $n = 1;
    static $len = 0;
    $arr = getCitiesByLetter($arr, $letter);
    foreach ($arr as $key => $value){
        if(is_array($value)){
            $len = sizeof($value);
            echo $key . ": ";
            showCitiesLetter($value, $letter);
        } else{
            if($n < $len){
                echo $value . ", ";
                $n++;
            } else {
                echo $value . ". " . "<br />";
            }
        }
    }
}
showCitiesLetter($region_cities, "к");
echo "<br>";

//9

function urlCompilation($string)
{
    return spaceToLowbar(translit ($string));
}
echo urlCompilation("Хэллоу, Ворлд!");
echo "<br>";
