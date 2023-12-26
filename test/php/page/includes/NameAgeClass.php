<?php
  class NameAgeClass{
    private $name = '선조이름';
    public $age = 77;
    protected $age2;
    
    public function __construct(){
      $this->name = '선조이름';
      echo '생성자에서 이름은 '.$this->name.'입니다.<br>';
    }
    
    public function __destruct(){
      echo '소멸자 실행';
    }
    
    public function output(){
      echo '이름은 '.$this->name.', 나이는'.$this->age.'<br>';
    }
    
    public function setNameAge(string $name, int $age){
      $this->name = $name;
      $this->age = $age;
    }
    
    public function getName(){
      return $this->name;
    }
    
    final public function globalTest(){
      global $age;
      echo 'global $age = '.$age.'<br>';
    }
  }
?>
