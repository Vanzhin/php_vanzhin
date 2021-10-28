<?php

namespace app\models;

use app\engine\Db;
use app\interfaces\IModel;

abstract class Model implements IModel
{
    abstract function getTableName();

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function getOne($id)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
//        return Db::getInstance()->queryOneResult($sql, ['id' => $id]);
//        метод queryOneObject возвращает полноценный объект с заполненными из БД свойствами, указанного класса
         return Db::getInstance()->queryOneObject($sql, ['id' => $id], get_called_class());
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->getTableName()}";
        return Db::getInstance()->queryAll($sql);
    }

    public function insert()
    {
        $params = [];

        foreach ($this as $key => $value){
            if ($key === 'id') continue;
            $params[$key] = $value;
        }
        $keysToString = implode(",", array_keys($params));
        $placeholders = ":" . implode(",:", array_keys($params));
        $sql = "INSERT INTO {$this->getTableName()} ({$keysToString}) VALUES ({$placeholders});";
        Db::getInstance()->execute($sql, $params);
        $this->id = Db::getInstance()->lastInsertId();
        return $this;
    }

    public function delete()
    {
        $id = $this->id;
        $sql = "DELETE FROM {$this->getTableName()} WHERE id = :id;";
        Db::getInstance()->execute($sql, ['id' => $id]);
        return $this;
    }

    public function update()
    {
        $id = $this->id;
        $valuesToUpdate = [];
        $productFromDb = $this->getOne($this->id);
        foreach ($productFromDb as $key => $value){
            if ($value != $this->$key AND $key != 'created_at') {
                $valuesToUpdate[$key] = $key . "='" . $this->$key . "'";
            }
        }
        if(!empty($valuesToUpdate)){
            $updatedToString = implode(",", $valuesToUpdate);
            $sql = "UPDATE {$this->getTableName()} SET {$updatedToString} WHERE id = :id;";
            Db::getInstance()->execute($sql,['id' => $id]);
        }
        return $this;
    }

}