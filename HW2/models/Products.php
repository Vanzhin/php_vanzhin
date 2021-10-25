<?php

namespace app\models;


class Products extends Model
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $catalog_id;
    public $created_at;
    public $updated_at;

    public function getTableName()
    {
        return 'products';
    }


}