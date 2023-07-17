<?php
try{
  // include_once __DIR__.'/classes/ProcessManager.php';
  // include_once __DIR__.'/classes/StudentPage.php';
  include __DIR__.'/includes/autoload.php';
  $uri = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
  $ps = new \SjFrame\ProcessManager($uri, new \Student\StudentPage($uri));
  $ps->run();
}
catch(Exception $e){
  $outString='<p>오류발생:'.$e->getMessage().$e->getFile().' 행: '.$e->getLine().'</p>';
}