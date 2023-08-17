<?php
include_once __DIR__.'/includes/Dbconnect.php';
include_once __DIR__.'/includes/Automatic.php';
$auto = new Automatic($pdo);

try{
    include_once __DIR__.'/classes/ProcessManager.php';
    $uri = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
      
    $ps = new ProcessManager($uri, $pdo);
    $ps->run();
  }
  catch(Exception $ex){
    $outString='<p>오류발생:'.$e->getMessage().$e->getFile().'행:'.$e->getLine().'</p>';
  }