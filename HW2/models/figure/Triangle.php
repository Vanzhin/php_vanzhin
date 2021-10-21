<?php

namespace app\models\figure;

class Triangle extends Figure
{
    public $a;
    public $b;
    public $c;

    public function __construct($a, $b, $c)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function getFigureName(): string
    {
        return 'triangle';
    }

    public function getPerimeter()
    {
        return ($this->a + $this->b + $this->c);
    }

    public function getSquare(): float
    {
        $p2 = $this->getPerimeter() / 2;
        return sqrt(($p2) * ($p2 - $this->a) * ($p2 - $this->b) * ($p2 - $this->c));
    }
}