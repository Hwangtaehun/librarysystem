<?php
namespace Student\Controllers;
use \SjFrame\TableManager;
class StudentController
{
    private $stuTable;
    private $scoreTable;

    public function __construct(TableManager $stuTable, TableManager $scoreTable){
      $this->stuTable = $stuTable;
      $this->scoreTable = $scoreTable;
    }

    public function home(){
        $title = '성적 관리';
        return ['tempName'=>'home.html.php', 'title'=>$title];
    }

    public function list(){
        $result = $this->stuTable->selectAll();
        $title = '수강생 현황';
        return ['tempName'=>'stuList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $this->stuTable->deleteData($_POST['stu_no']);
        header('location: /student/list');
    }

    public function addupdate(){
        if(isset($_POST['stu_id'])){
            if($_POST['stu_id'] == ''){
              $this->stuTable->insertData($_POST);
            }
            else {
              $this->stuTable->updateData($_POST);
            }
            header('location: /student/list');
        }
        if(isset($_GET['id'])){
          $row = $this->stuTable->selectID($_GET['id']);
          $title2 = ' 수정';
          $title = '수강생'.$title2;
          return ['tempName'=>'stuForm.html.php','title'=>$title,'title2'=>$title2,'row'=>$row];
        }
        else{
          $title2 = ' 입력';
          $title = '수강생'.$title2;
          return ['tempName'=>'stuForm.html.php','title'=>$title,'title2'=>$title2];
        }
    }
}
