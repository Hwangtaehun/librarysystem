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
    //echo 'run 실행<br>';
    $page = $this->makePage();
    //echo  $page['title'].'<br>';
    if(isset($page['title'])){
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
  }
  
  private function makePage(){
    include __DIR__.'/../includes/Dbconnect.php';
    include __DIR__.'/../classes/TableManager.php';
    $libTable = new TableManager($pdo, 'library', 'lib_no');
    $bookTable = new TableManager($pdo, 'book', 'book_no');
    $kindTable = new TableManager($pdo, 'kind', 'kind_no');
    $memTable = new TableManager($pdo, 'member', 'mem_no');
    $matTable = new TableManager($pdo, 'material', 'mat_no');
    $resTable = new TableManager($pdo, 'reservation', 'res_no');
    $lenTable = new TableManager($pdo, 'lent', 'len_no');
    $dueTable = new TableManager($pdo, 'overdue', 'due_no');
    $plaTable = new TableManager($pdo, 'place', 'pla_no');
    $delTable = new TableManager($pdo, 'delivery', 'del_no');
    
    if($this->m_uri == '' || $this->m_uri == 'index.php'){
      $this->m_uri = 'member/home';
    }
    $uris = explode('/', $this->m_uri);
    //print_r($uris);
    $funcName = $uris[1];
    $className = ucfirst($uris[0]).'Controller';
    //echo '$className = '.$className.' $funcName = '.$funcName.'<br>';
    include __DIR__.'/../controllers/'.$className.'.php';
    $controller = new $className($libTable, $bookTable, $kindTable, $memTable, $matTable, $resTable, $lenTable, $dueTable, $plaTable, $delTable);
    $page = $controller->$funcName();
    
    return $page;
  }
}
