<?php
session_start();
include_once __DIR__.'/../includes/Dbconnect.php';
include_once __DIR__.'/../class/TableManager.php';
include_once __DIR__.'/../templates/msgOutput.html.php';

$title = $_GET['title'];
$member = new TableManager($pdo, 'member', 'mem_no');
try {
    if(isset($_POST['mem_id'])) {
        //회원가입
        $member->insertData($_POST);
        header('location: ../index.php');
    }
} catch(PDOException $e){
    $strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
}
include __DIR__.'/../templates/register.html.php';
?>