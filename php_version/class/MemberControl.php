<?php
class MemberControl{
    private $tableName;
    private $pdo;

    public function __construct(string $tableName, PDO $pdo)
    {
        $this->tableName = $tableName;
        $this->pdo = $pdo;
    }

    public function logincheck(){
        
    }
}
?>