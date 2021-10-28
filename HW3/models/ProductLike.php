<?php

namespace app\models;

class ProductLike extends Model
{
    public $id;
    public $product_id;
    public $session_id;
    public $user_id;

    public function __construct($product_id = null, $session_id = null, $user_id = null)
    {
        $this->product_id = $product_id;
        $this->session_id = $session_id;
        $this->user_id = $user_id;
    }


    function getTableName()
    {
        return 'product_likes';
    }
}