<?php
//$pdo = new PDO('mysql:host=192.168.1.37;dbname=librarydb;charset=utf8','mysejong','sj4321');
$pdo = new PDO('mysql:host=localhost;dbname=librarydb;charset=utf8','mysejong','sj4321');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);