<?php

namespace app\models;

class ProductImage extends Model
{
    public $id;
    public $product_id;
    public $title;

    public function __construct($product_id = null, $title = null)
    {
        $this->product_id = $product_id;
        $this->title = $title;
    }


    public function getTableName()
    {
        return 'product_images';
    }
}