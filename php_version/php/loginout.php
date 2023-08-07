<?php
session_start();
include_once __DIR__.'/../includes/Dbconnect.php';

try {
    if(!isset($_SESSION['mem_state'])) {
        $mem_id = $_POST['user_id'];
        $mem_pw = $_POST['user_password'];
        $sql = "SELECT * FROM `member` WHERE `mem_id` = '$mem_id' AND `mem_pw` = '$mem_pw'";
    
        $result = $pdo->query($sql);
        $num = $result->rowCount();
    
        if($num != 0){
            $row = $result->fetch();
            $_SESSION['mem_no'] = $row['mem_no'];
            $_SESSION['mem_name'] = $row['mem_name'];
            $_SESSION['mem_state'] = $row['mem_state'];
            header('location: ../index.php');
            exit;
        }
        else{
            echo "<script>alert('아이디와 비밀번호가 일치하지 않습니다.')</script>";
            header('location: ../index.php');
            exit;
        }
    }
    else {
        $_SESSION = [];
        header('location: ../index.php');
        exit;
    }
} catch(PDOException $e){
    $strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
}


?>