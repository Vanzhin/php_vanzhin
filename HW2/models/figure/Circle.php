<?php

namespace app\models\figure;

class Circle extends Figure
{
    public $radius;

    public function __construct($radius)
    {
        $this->radius = $radius;
    }

    public function getFigureName(): string
    {
        return 'circle';
    }

    public function getPerimeter(): float
    {
        return (2 * pi() * $this->radius);
    }

    public function getSquare(): float
    {
        return pi() * $this->radius * $this->radius;
    }
}