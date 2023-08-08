<?php
class ProcessManager{
  private $m_uri;
  
  public function __construct($uri){
    $this->m_uri = $uri;
    //echo 'construct : '.$uri.'<br>';
  }
  
  private function outPage($page = []){
    extract($page);
    ob_start();
    include __DIR__.'/../templates/'.$tempName;
    return ob_get_clean();
  }
  
  public function run(){
    $page = $this->makePage();
    $title = $page['title'];
    $outString = $this->outPage($page);
    
    include __DIR__.'/../templates/layout.html.php';
  }
  
  private function makePage(){
    include __DIR__.'/../includes/Dbconnect.php';
    include __DIR__.'/../classes/TableManager.php';
    $stuTable = new TableManager($pdo, 'student', 'stu_no');
    $scoreTable = new TableManager($pdo, 'score', 'sc_id');

    // include __DIR__.'/../controllers/StudentControl.php';
    // include __DIR__.'/../controllers/ScoreControl.php';
    // if($this->m_uri == 'student/list'){
    //   $controller = new StudentController($stuTable, $scoreTable);
    //   $page = $controller->list();
    // }
    // else if($this->m_uri == 'student/addupdate'){
    //   $controller = new StudentController($stuTable, $scoreTable);
    //   $page = $controller->addupdate();
    // }
    // else if($this->m_uri == 'student/delete'){
    //   $controller = new StudentController($stuTable, $scoreTable);
    //   $page = $controller->delete();
    // }
    // else if($this->m_uri == 'score/list'){
    //   $controller = new ScoreController($stuTable, $scoreTable);
    //   $page = $controller->list();
    // }
    // else if($this->m_uri == 'score/addupdate'){
    //   $controller = new ScoreController($stuTable, $scoreTable);
    //   $page = $controller->addupdate();
    // }
    // else if($this->m_uri == 'score/delete'){
    //   $controller = new ScoreController($stuTable, $scoreTable);
    //   $page = $controller->delete();
    // }
    // else{
    //   $controller = new StudentController($stuTable, $scoreTable);
    //   $page = $controller->home();
    // }
    
    if($this->m_uri == '' || $this->m_uri == 'index.php'){
      $this->m_uri = 'student/home';
    }
    $uris = explode('/', $this->m_uri);
    $funcName = $uris[1];
    $className = ucfirst($uris[0]).'Controller';
    include __DIR__.'/../controllers/'.$className.'.php';
    $controller = new $className($stuTable, $scoreTable);
    $page = $controller->$funcName();
    
    return $page;
  }
}
