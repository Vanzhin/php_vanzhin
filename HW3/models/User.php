<?php
namespace app\models;

class User extends Model
{
    public $id;
    public $name;
    public $birthday_at;
    public $pass_hash;
    public $hash;
    public $created_at;
    public $updated_at;

    public function getTableName()
    {
        return 'users';
    }

}