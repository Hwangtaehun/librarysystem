<?php
class ProcessManager{
  private $m_uri;
  private $m_pdo;
  
  public function __construct($uri, $pdo){
    $this->m_uri = $uri;
    $this->m_pdo = $pdo;
    //echo 'construct : '.$uri.'<br>';
  }
  
  //페이지 출력
  private function outPage($page = []){
    $pdo = $this->m_pdo;
    extract($page);
    ob_start();
    include __DIR__.'/../templates/'.$tempName;
    return ob_get_clean();
  }
  
  //실행
  public function run(){
    $page = $this->makePage();
    if(isset($page['title'])){
      $title = $page['title'];
      $outString = $this->outPage($page);
      include __DIR__.'/../templates/layout.html.php';
    }
  }
  
  //테이블을 객체를 생성하고 
  private function makePage(){
    include __DIR__.'/../classes/TableManager.php';
    $pdo = $this->m_pdo;
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
    $notTable = new TableManager($pdo, 'notification', 'not_no');
    
    if($this->m_uri == '' || $this->m_uri == 'index.php'){
      $this->m_uri = 'member/home';
    }
    $uris = explode('/', $this->m_uri);
    //print_r($uris);
    $funcName = $uris[1];
    $className = ucfirst($uris[0]).'Controller';
    //echo '$className = '.$className.' $funcName = '.$funcName.'<br>';
    include __DIR__.'/../controllers/'.$className.'.php';
    $controller = new $className($libTable, $bookTable, $kindTable, $memTable, $matTable, $resTable, $lenTable, $dueTable, $plaTable, $delTable, $notTable);
    $page = $controller->$funcName();
    
    return $page;
  }
}
