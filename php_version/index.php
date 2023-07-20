<?php

$title = '도서관 로그인'

ob_start();

include __DIR__.'/../templates/login.html.php';

$outString = ob_get_clean();