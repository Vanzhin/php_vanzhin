<?php

namespace app\models;


class Product extends Model
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $catalog_id;


    public function __construct($name = null, $description = null, $price = null, $catalog_id = null)
    {

        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->catalog_id = $catalog_id;
    }


    public function getTableName()
    {
        return 'products';
    }


}