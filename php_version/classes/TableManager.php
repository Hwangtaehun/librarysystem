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

    //결과 얻기
    function get_result(string $sql){
        $result = $this->pdo->query($sql);
        return $result;
    }

    //검색 결과 모두 가져오기
    function selectAll()
    {
        $sql = 'SELECT * FROM `'.$this->table.'`';
        $stmt = $this->myQuery($sql);
        return $stmt->fetchAll();
    }

    //선택한 primary key에 대한 결과 얻기
    function selectID($id){
        $sql = 'SELECT * FROM `'.$this->table.'` WHERE `'.$this->keyField.'` = :id' ;
        $param = ['id'=>$id];
        $stmt = $this->myQuery($sql, $param);
        return $stmt->fetch();
    }

    //조인 쿼리를 사용할 때 사용하는 함수
    function joinSQL(string $sql){
        $stmt = $this->pdo->query($sql); //fetch, fetchAll, rowCount 따로 사용
        return $stmt;
    }

    //where절을 이용한 검색 함수
    function whereSQL(string $where){
        $sql = 'SELECT * FROM `'.$this->table.'` '.$where;
        $stmt = $this->pdo->query($sql); //fetch, fetchAll, rowCount 따로 사용
        return $stmt;
    }

    //연체나 장소를 del_no에 맞게 변경해야하므로 사용되는 함수
    function delupdateSQL(string $sql){
        $this->pdo->exec($sql);
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