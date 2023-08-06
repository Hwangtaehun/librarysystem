<?php
session_start();
include_once __DIR__.'/../includes/Dbconnect.php';
include_once __DIR__.'/../class/TableManager.php';
include_once __DIR__.'/../templates/msgOutput.html.php';

$member = new TableManager($pdo, 'member', 'mem_no');
try {
    if(!isset($_SESSION['mem_state'])) {
        $mem_id = $_POST['user_id'];
        $mem_pw = $_POST['user_password'];
        $result = $member->loginCheck($mem_id, $mem_pw);
        $num = $result->rowCount();
    
        if($num != 0){
            $row = $result->fetch();
            $_SESSION['mem_no'] = $row['mem_no'];
            $_SESSION['mem_name'] = $row['mem_name'];
            $_SESSION['mem_state'] = $row['mem_state'];
    
            //echo "<script>location.replace('../index.php');</script>";
            header('location: ../index.php');
            exit;
        }
        else{
            echo "<script>alert('아이디와 비밀번호가 일치하지 않습니다.')</script>";
            //echo "<script>location.replace('../index.php');</script>";
            header('location: ../index.php');
            exit;
        }
    }
    else {
        if(isset($_Post['mem_zip'])) {
            $member->insertData($pod, 'member', $_POST);
            header('location: /../index.php');
            exit;
        }
        else {
            $_SESSION = [];
            //echo "<script>location.replace('../index.php');</script>";
            header('location: ../index.php');
            exit;
        }
    }
} catch(PDOException $e){
    $strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
}


?>