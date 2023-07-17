<?php
namespace SjFrame;
class ProcessManager{
  private $m_uri;
  private $m_makePage;
  
  public function __construct($uri, $makePage){
    $this->m_uri = $uri;
    $this->m_makePage = $makePage;
  }
  
  private function outPage($page = []){
    extract($page);
    ob_start();
    include __DIR__.'/../../templates/'.$tempName;
    return ob_get_clean();
  }
  
  public function run(){
    $page = $this->m_makePage->makePage();
    $title = $page['title'];
    $outString = $this->outPage($page);
    include __DIR__.'/../../templates/layout.html.php';
  }
}