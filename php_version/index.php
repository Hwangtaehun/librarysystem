<?php

$title = '도서관 로그인'

ob_start();

include_once __DIR__.'/../include/Client.php';
include_once __DIR__.'/../include/Dbconnect.php';
include_once __DIR__.'/../class/TableManager.php';
include_once __DIR__.'/../templates/login.html.php';

$outString = ob_get_clean();