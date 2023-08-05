<?php
include_once __DIR__.'/Client.php';


class MemberControl{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function loginCheck(object &$client, string $id, string $pw){
        $sql = "SELECT * FROM member WHERE mem_id = '$id' AND mem_pw = '$pw'";
        $result = $this->pdo->query($sql);
        $num = $result->rowCount();

        if($num != 0){
            try {
                $row = $result->fetch();
                $pk = $row['mem_no'];
                $name = $row['mem_name'];
                $state = $row['mem_state'];
                $client->insertnum($pk, $name, $state);
                return true;
            } catch(PDOException $e){
                $strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일: '.$e->getFile().'<br>오류 발생 행: '.$e->getLine();
            }
        }
        else{
            return false;
        }
    }

    public function memInsert(string $name, string $id, string $pw, string $zip, string $add, string $detail) {
        try {
            $sql = "INSERT INTO `member` (`mem_name`, `mem_id`, `mem_pw`, `mem_zip`, `mem_add`, `mem_detail`) VALUES ('$name', '$id', '$pw', '$zip', '$add', '$detail)";
            $this->pdo->exec($sql);
        } catch(PDOException $e){
            $strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일: '.$e->getFile().'<br>오류 발생 행: '.$e->getLine();
        }
        
    }

    public function memUpdate(int $code, string $name, string $id, string $pw, string $zip, string $add, string $detail) {
        try {
            $sql = "UPDATE `member` SET `mem_name` = '$name', `mem_id` = '$id', `mem_pw` = '$pw', `mem_zip` = '$zip', `mem_add` = '$add', `mem_detail` = '$detail' WHERE `mem_no` = $code"; 
            $this->pdo->exec($sql);
        } catch(PDOException $e){
            $strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일: '.$e->getFile().'<br>오류 발생 행: '.$e->getLine();
        }
    }

    public function memStateLent(int $code, int $lent, int $state){
        try {
            $sql = "UPDATE `member` SET `mem_lent` = $lent, `mem_state` = $state WHERE `mem_no` = $code"; 
            $this->pdo->exec($sql);
        } catch(PDOException $e){
            $strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일: '.$e->getFile().'<br>오류 발생 행: '.$e->getLine();
        }
    }
}
?>