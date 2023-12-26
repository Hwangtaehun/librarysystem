<?php
//$pdo = new PDO('mysql:host=192.168.1.30;dbname=test;charset=utf8','sj002','sj4321');
$pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8','mysejong','sj4321');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);