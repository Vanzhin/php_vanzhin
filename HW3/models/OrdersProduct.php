<?php

namespace app\models;

class OrdersProduct extends Model
{
    public $id;
    public $order_id;
    public $product_id;
    public $total;
    public $created_at;
    public $updated_at;
    public $session_id;
    public $price;

    public function getTableName()
    {
        return 'orders_products';
    }
}