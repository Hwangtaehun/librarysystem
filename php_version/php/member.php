<?php
session_start();
include_once __DIR__.'/../includes/Dbconnect.php';
include_once __DIR__.'/../class/TableManager.php';

$title = $_GET['title'];
$member = new TableManager($pdo, 'member', 'mem_no');
try {
    if(isset($_POST['mem_no'])) {
        if($_POST['mem_no'] == ''){
            $param = ['mem_name'=>$_POST['mem_name'], 'mem_id'=>$_POST['mem_id'], 'mem_pw'=>$_POST['mem_pw'], 
                    'mem_zip'=>$_POST['mem_zip'], 'mem_add'=>$_POST['mem_add'], 'mem_detail'=>$_POST['mem_detail']];
            $member->insertData($param);
            header('location: ../index.php');
        }
        else{
            $param = ['mem_no'=>$_POST['mem_no'], 'mem_name'=>$_POST['mem_name'], 'mem_id'=>$_POST['mem_id'], 'mem_pw'=>$_POST['mem_pw'], 
                    'mem_zip'=>$_POST['mem_zip'], 'mem_add'=>$_POST['mem_add'], 'mem_detail'=>$_POST['mem_detail']];
            $member->updateData($param);
            header('location: ../index.php');
        }
    }
    if(isset($_SESSION['mem_no'])){
        $mem_no = $_SESSION['mem_no'];
        $row = $member->selectID($mem_no);
    }
    if(isset($_GET['mem_no'])) {
        $mem_no = $_GET['mem_no'];
        $row = $member->selectID($mem_no);
    }
} catch(PDOException $e){
    $strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
}
include __DIR__.'/../templates/register.html.php';
?>