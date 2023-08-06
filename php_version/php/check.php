<?php
session_start();
include_once __DIR__.'/../includes/Dbconnect.php';

$mem_id= $_GET["userid"];
$sql = "SELECT * FROM `member` WHERE `mem_id` = '$mem_id'";
$result = $pdo->query($sql);
$num = $result->rowCount();

if($num == 0){
    echo "<span style='color:blue;'>$mem_id</span> 는 사용 가능한 아이디입니다.";
    echo '<p><input type=button value="이 ID 사용" onclick="opener.parent.decide(); window.close();"></p>';
}
else{
    echo "<span style='color:red;'>$uid</span> 는 중복된 아이디입니다.";
    echo '<p><input type=button value="다른 ID 사용" onclick="opener.parent.change(); window.close()"></p>';
} 
?>