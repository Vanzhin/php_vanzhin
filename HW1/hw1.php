<?php
class Tabouret
{
    public $title;
    public $comfort;
    public $material;
    public $wear;

    public function __construct($title = null, $comfort = null, $material = null, $wear = null)
    {
        $this->title = $title;
        $this->comfort = $comfort;
        $this->material = $material;
        $this->wear = $wear;

    }
    public function view()
    {
        echo "<br>Название: {$this->title}, уровень комфорта: {$this->comfort}, основной материал: {$this->material}, уровень износа: {$this->wear}<br>";
    }


}

class Chair extends Tabouret
{
    public $backMaterial;
    public function __construct($title = null, $comfort = null, $material = null, $wear = 0, $backMaterial = null)
    {
        parent::__construct($title, $comfort, $material, $wear);
        $this->backMaterial = $backMaterial;
    }

    public function view()
    {
        parent::view();
        echo "Материал спинки и сидения: {$this->backMaterial}<br>";
    }

}

class Armchair extends Chair
{
    public $armMaterial;
    public function __construct($title = null, $comfort = null, $material = null, $wear = null, $backMaterial = null, $armMaterial = null)
    {
        parent::__construct($title, $comfort, $material, $wear, $backMaterial);
        $this->armMaterial = $armMaterial;
    }

    public function view()
    {
        parent::view();
        echo "Материал подлокотников: {$this->armMaterial}<br>";
    }


}

class Human
{
    protected $name;
    protected $health;
    protected $weight;


    public function __construct($name = null, $health = null, $weight = null)
    {
        $this->name = $name;
        $this->health = $health;
        $this->weight = $weight;
        $this->abilityToWear = $this->weight * 0.001;

    }

    public function say()
    {
        echo "<br>Меня зовут {$this->name} и у меня {$this->health} здоровья, мой вес {$this->weight}<br>";
    }

    public function eat()
    {
        $this->health += 20;
    }
    public function rest(Tabouret $target) {
        $target->wear += $this->weight * 0.001;
        $this->health += $target->comfort * 0.1;;
        echo "<br>Человек {$this->name} отдохнул на {$target->title} и увеличил его износ на {$this->abilityToWear}<br>";
    }

}
$man1 = new Human("Алекс", 100, 80);
$man2 = new Human("Петр", 100, 90);

$man1->say();
$chair = new Chair('стул',30,"дерево",0, "ткань");
$chair->view();
$armchair = new Armchair('кресло', 70, "металл",0, "кожа", "ткань");
$armchair->view();

$man1->rest($chair);
$chair->view();
$man2->rest($armchair);
$armchair->view();

//class A {
//    public function foo() {
//        //создается статическая переменная, принадлежит классу А
//        static $x = 0;
//        echo ++$x;
//    }
//}
//$a1 = new A();
//$a2 = new A();
//$a1->foo();
//$a2->foo();
//$a1->foo();
//$a2->foo();
// выводит 1234, поскольку переменная $x статическая, то ее значение сохраняется с предыдущего выполнения функции

//class A {
//    public function foo() {
//        static $x = 0;
//        echo ++$x;
//    }
//}
//class B extends A {
//}
//$a1 = new A();
//$b1 = new B();
//var_dump($a1);
//var_dump($b1);
//$a1->foo();
//$b1->foo();
//$a1->foo();
//$b1->foo();

// выводит 1122, поскольку переменная $x статическая, то ее значение сохраняется с предыдущего выполнения функции,
// то есть переменная $x будет меняться только внутри класса.

//class A {
//    public function foo() {
//        static $x = 0;
//        echo ++$x;
//    }
//}
//class B extends A {
//}
//$a1 = new A;
//
//$b1 = new B;
//var_dump($a1);
//var_dump($b1);
//$a1->foo();
//$b1->foo();
//$a1->foo();
//$b1->foo();
//выводит 1122, поскольку переменная $x статическая, то ее значение сохраняется с предыдущего выполнения функции,
// то есть переменная $x будет меняться только внутри класса. Здесь экземпляр класса создается без скобок,
// оказывается так можно, если нет конструктора.
//
//
