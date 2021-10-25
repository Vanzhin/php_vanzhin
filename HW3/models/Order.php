<?php

namespace app\models;

class Order extends Model
{
    public $id;
    public $user_id;
    public $created_at;
    public $updated_at;
    public $session_id;
    public $status;
    public $name;
    public $tel;
    public $comment;

    public function getTableName()
    {
        return 'orders';
    }
}