<?php

namespace app\models;

use app\engine\Db;
use app\interfaces\IModel;

abstract class Model implements IModel
{
    protected $db;
    abstract function getTableName();

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getOne($id)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = {$id}";
        return $this->db->queryOne($sql);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->getTableName()}";
        return $this->db->queryAll($sql);
    }

}