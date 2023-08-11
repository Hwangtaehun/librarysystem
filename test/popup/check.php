<?php
include_once __DIR__.'/../includes/Dbconnect.php';

if(isset($_POST['user_research'])){
    $value= $_POST['user_research'];
    $sql = "SELECT * FROM `member` WHERE `mem_id` = '$value' OR `mem_name` = '$value'";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll();
}

include __DIR__.'/memberPop.html.php';
?>