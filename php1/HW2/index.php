<?php
//1
$a = rand(-10,10);
$b = rand(-10,10);

if ($a >= 0 && $b >=0){
    echo "a = {$a} и b = {$b}: положительные<br>";
} elseif ($a < 0 && $b < 0){
    echo "a = {$a} и b = {$b}: отрицательные<br>";
} else{
    echo "a = {$a} и b = {$b}: разных знаков<br>";
}

//2
$a= rand(0,15);
$b = $a;
echo "a = {$a}<br>";
switch ($b){
    case 0:
        echo $b++;
    case 1:
        echo $b++;
    case 2:
        echo $b++;
    case 3:
        echo $b++;
    case 4:
        echo $b++;
    case 5:
        echo $b++;
    case 6:
        echo $b++;
    case 7:
        echo $b++;
    case 8:
        echo $b++;
    case 9:
        echo $b++;
    case 10:
        echo $b++;
    case 11:
        echo $b++;
    case 12:
        echo $b++;
    case 13:
        echo $b++;
    case 14:
        echo $b++;
    case 15:
        echo $b++;
    echo "<br>";
}

echo "a = {$a}<br>";
function show15($n,$count)
{  echo $n++;
   if ($n <= $count){
      show15($n,$count);
   }

}

 show15($a,15);
//3
echo "<br>";  
function add($x,$y)
{  return $x + $y;
}

function subtraction($x,$y)
{  return $x - $y;
}

function multiply($x,$y)
{  return $x * $y;
}

function division($x,$y)
{   return ($y !== 0) ? ($x / $y) :  "ошибка! на ноль делить нельзя";
}

echo add(1,2);
echo subtraction(2,4);
echo multiply(3,3);
echo division(3,2);

//4   TODO
echo "<br>";
function mathOperation($arg1, $arg2, $op)
{   switch ($op){
    case "add": case "subtraction":case "multiply": case "division":
    return $op($arg1, $arg2);
    default:  return "такой функции нет";
}
};

echo mathOperation(3,
    4,
    "division");

//6
echo "<br>";
function power($val, $pow)
{
    if ($pow>0)  {
    return $val * power($val,--$pow);
    }
    elseif($pow<0)
    {
      return 1/$val * power($val,++$pow);
    }
    return 1;
};
echo  power(6,-2);

// 7
echo "<br>";
$datetime = getdate();
$h = $datetime['hours'];
$m = $datetime['minutes'];

function letterDate($hours,$minutes)
{
    if (($hours === 0 || ($hours >= 5 && $hours <= 20))) {
        $letterH = $hours . " часов ";
    } elseif ($hours % 10 === 1) {
        $letterH = $hours . " час ";
    } elseif ($hours % 10 >= 2 && $hours % 10 <= 4) {
    $letterH = $hours . " часа ";
    
}
    if ($minutes % 10 === 0 || ($minutes % 10 >= 5 && $minutes % 10 <= 9) || ($minutes >= 11 && $minutes <=14)){
       $letTerM = $minutes . " минут ";
    } elseif ($minutes % 10 === 1){
        $letTerM = $minutes . " минута ";
    } elseif (!($minutes >= 11 && $minutes <= 14) && ($minutes % 10 >=2 && $minutes % 10 <= 4)){
      $letTerM = $minutes . " минуты ";
    }
       return $letterH . $letTerM;
};
echo letterDate(8,13);
