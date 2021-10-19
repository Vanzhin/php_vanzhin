<?php
//ORM

class Db
{
    protected $tableName;
    protected $wheres = [];
    protected $joins = [];


    public function table($tableName) {
        $this->tableName = $tableName;

        return $this;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->tableName}";
        if (!empty($this->wheres)) {
            $sql .= " WHERE ";
            foreach ($this->wheres as $value) {
                $sql .= $value['field'] . " = " . $value['value'];
                if ($value != end($this->wheres)) $sql .= " AND ";
            }

        }
        return $sql;
    }
    public function get(...$fields)
    {
        $fieldsToGet = implode(", ", $fields);
        $sql = "SELECT {$fieldsToGet} FROM {$this->tableName}";
        if (!empty($this->joins)) {
            foreach ($this->joins as $join) {
                $sql .= " " . $join['type'] . " JOIN " . $join['joinTable'] . " ON " . $join['field1'] . " = " . $join['field2'];
            }
        }
        if (!empty($this->wheres)) {
            $sql .= " WHERE ";
            foreach ($this->wheres as $value) {
                $sql .= implode(" = ", $value);
                if ($value != end($this->wheres)) $sql .= " AND ";
            }
        }
        return $sql;
    }

    public function getOne($id)
    {
        return "SELECT * FROM {$this->tableName} WHERE id = {$id} <br>";
    }

    public function where($field, $value)
    {
        $this->wheres[] = [
            'field' => $field,
            'value' => $value
        ];
        return $this;
    }

    public function join($joinTable, $field1, $field2, $type = null)
    {
        $this->joins[] = [
            'joinTable' => $joinTable,
            'field1' => $field1,
            'field2' => $field2,
            'type' => $type

        ];
        return $this;
    }
    public function sum($field)
    {
        return "SELECT SUM({$field}) AS sum FROM {$this->tableName}<br>";

    }

}


$db = new Db();
//echo $db->table('goods')->getAll();
//echo $db->table('goods')->getOne(1);
//echo $db->table('user')->getOne(2);
echo $db->table('user')->where('name', 'admin')->where('session', 123)->get('session', 'name', 'id');
echo '<br>';
echo $db->table('products')->where('id', '1')->join('product_images', 'product_images.product_id','products.id')
    ->join('product_likes', 'product_likes.product_id','products.id',"LEFT")->get('products.id', 'products.name', 'products.description');
echo '<br>';
echo $db->table('products')->sum('price');
//echo $db->table('product')->where('name', 'Alex')->where('session', 123)->andWhere('id', 5)->getAll();
//echo $db->table('product')->where('name', 'Alex')->where('session', 123)->andWhere('id', 5)->get();