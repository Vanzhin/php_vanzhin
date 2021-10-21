<?php

namespace app\models\figure;

class Rectangle extends Figure
{
    public $a;
    public $b;

    public function __construct($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function getFigureName(): string
    {
        return 'rectangle';
    }

    public function getPerimeter()
    {
        return ($this->a + $this->b) * 2;
    }

    public function getSquare(): float
    {
        return $this->a * $this->b;
    }
}