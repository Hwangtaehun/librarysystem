<?php

include_once __DIR__.'/includes/Dbconnect.php';
include_once __DIR__.'/includes/Automatic.php';

$auto = new Automatic($pdo);

if(!isset($_SESSION['mem_state'])) {
    include_once __DIR__.'../templates/login.html.php';
}
else {
    if($_SESSION['mem_state'] == 1){
        include __DIR__.'../templates/managerlayout.html.php';
    }
    else{
        include __DIR__.'../templates/memberlayout.html.php';
    }
}