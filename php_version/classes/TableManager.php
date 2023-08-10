<?php
class TableManager
{
    private $pdo;
    private $table;
    private $keyField;

    public function __construct(\PDO $pdo, string $table, string $keyField){
        $this->pdo      = $pdo;
        $this->table    = $table;
        $this->keyField = $keyField;
    }

    function get_result(string $sql){
        $result = $this->pdo->query($sql);
        return $result;
    }

    function selectAll()
    {
        $sql = 'SELECT * FROM `'.$this->table.'`';
        $stmt = $this->myQuery($sql);
        return $stmt->fetchAll();
    }

    function selectID($id){
        $sql = 'SELECT * FROM `'.$this->table.'` WHERE `'.$this->keyField.'` = :id' ;
        $param = ['id'=>$id];
        $stmt = $this->myQuery($sql, $param);
        return $stmt->fetch();
    }

    function joinSQL(string $sql){
        $stmt = $this->pdo->query($sql);
        return $stmt;
    }

    function whereSQL(string $where){
        $sql = 'SELECT * FROM `'.$this->table.'` '.$where;
        $stmt = $this->pdo->query($sql);
        return $stmt;
    }

    function myQuery($sql, $param = []){
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($param);
        return $stmt;
    }

    function insertData($param)
    {
        $sql = 'INSERT INTO `'.$this->table.'` SET ';
        foreach($param as $key=>$value){
            $sql .= '`'.$key.'`= :'.$key.', ';
        }
        $sql = rtrim($sql, ', ');
        $this->myQuery($sql, $param);
    }

    function deleteData($id)
    {
        $param = [':id'=>$id];
        $sql = 'DELETE FROM `'.$this->table.'` WHERE `'.$this->keyField.'`=:id';
        $this->myQuery($sql, $param);
    }

    function updateData($param){
        $sql = 'UPDATE`'.$this->table.'`SET ';
        foreach($param as $key=>$value){
            $sql .= '`'.$key.'`= :'.$key.', ';
        }
        $sql = rtrim($sql, ', ');
        $sql .= ' WHERE `'.$this->keyField.'`= :'.$this->keyField;
        $this->myQuery($sql, $param);
    }
}
?>