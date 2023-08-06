<?php
session_start();
include_once __DIR__.'/includes/Dbconnect.php';
include_once __DIR__.'/includes/Automatic.php';

$auto = new Automatic($pdo);

if(!isset($_SESSION['mem_state'])) {
    include_once __DIR__.'../templates/login.html.php';
}
else {
    $title = '도서관 관리';

    ob_start(); 

    include __DIR__.'../templates/home.html.php';

    $outString = ob_get_clean();

    include __DIR__.'../templates/layout.html.php';
}