<?php
include_once __DIR__.'/../includes/Dbconnect.php';
include_once __DIR__.'/../class/TableManager.php';

$member = new TableManager($pdo, 'member', 'mem_no');
$result = $member->selectAll();

$title = '회원 관리';
ob_start()
include __DIR__.'/../templates/memberList.html.php';
$outString = ob_get_clean();
?>