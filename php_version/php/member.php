<?php
session_start();
include_once __DIR__.'/../includes/Dbconnect.php';
include_once __DIR__.'/../class/TableManager.php';
include_once __DIR__.'/../templates/msgOutput.html.php';

$member = new TableManager($pdo, 'member', 'mem_no');
$cookie = $_COOKIE['myname2'];
if($cookie == 'namevalue2'){
    include __DIR__.'/../templates/register.html.php';
    setcookie('myname2');
}
else{
    try {
        if(!isset($_SESSION['mem_state'])) {
            //로그인
            $mem_id = $_POST['user_id'];
            $mem_pw = $_POST['user_password'];
            $result = $member->loginCheck($mem_id, $mem_pw);
            $num = $result->rowCount();
        
            if($num != 0){
                $row = $result->fetch();
                $_SESSION['mem_no'] = $row['mem_no'];
                $_SESSION['mem_name'] = $row['mem_name'];
                $_SESSION['mem_state'] = $row['mem_state'];
    
                header('location: ../index.php');
            }
            else{
                echo "<script>alert('아이디와 비밀번호가 일치하지 않습니다.')</script>";
                header('location: ../index.php');
            }
        }
        else {
            if(isset($_POST['mem_id'])) {
                //회원가입
                $member->insertData($_POST);
                header('location: ../index.php');
            }
            include __DIR__.'/../templates/register.html.php';
        }
    } catch(PDOException $e){
        $strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
    }
}
?>