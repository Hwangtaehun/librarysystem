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
    echo 'run 실행<br>';
    $page = $this->makePage();
    echo  $page['title'].'<br>';
    $title = $page['title'];
    if(isset($_SESSION['mem_state'])){
      $outString = $this->outPage($page);
      include __DIR__.'/../templates/layout.html.php';
    }
    else{
      extract($page);
      include __DIR__.'/../templates/'.$tempName;
    }
  }
  
  private function makePage(){
    include __DIR__.'/../includes/Dbconnect.php';
    include __DIR__.'/../classes/TableManager.php';
    $memTable = new TableManager($pdo, 'member', 'mem_no');
    
    if($this->m_uri == '' || $this->m_uri == 'index.php'){
      $this->m_uri = 'member/home';
    }
    $uris = explode('/', $this->m_uri);
    $funcName = $uris[1];
    $className = ucfirst($uris[0]).'Controller';
    echo '$className = '.$className.' $funcName = '.$funcName.'<br>';
    include __DIR__.'/../controllers/'.$className.'.php';
    $controller = new $className($memTable);
    $page = $controller->$funcName();
    
    return $page;
  }
}
