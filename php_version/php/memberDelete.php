<?php
include_once __DIR__.'/../includes/Dbconnect.php';
include_once __DIR__.'/../class/TableManager.php';

$title = $_GET['title'];
$member = new TableManager($pdo, 'member', 'mem_no');
$member->deleteData($_POST['mem_no']);
header('location: ../index.php');
?>