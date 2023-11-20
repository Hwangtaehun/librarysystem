<?php
session_start();
class DelController{
    private $sort = "ORDER BY not_no DESC";
    private $libTable;
    private $bookTable;
    private $kindTable;
    private $memTable;
    private $matTable;
    private $resTable;
    private $lenTable;
    private $dueTable;
    private $plaTable;
    private $delTable;
    private $notTable;

    public function __construct(TableManager $libTable, TableManager $bookTable, TableManager $kindTable, TableManager $memTable, TableManager $matTable, 
                                TableManager $resTable, TableManager $lenTable, TableManager $dueTable, TableManager $plaTable, TableManager $delTable, TableManager $notTable)
    {
        $this->libTable = $libTable;
        $this->bookTable = $bookTable;
        $this->kindTable = $kindTable;
        $this->memTable = $memTable;
        $this->matTable = $matTable;
        $this->resTable = $resTable;
        $this->lenTable = $lenTable;
        $this->dueTable = $dueTable;
        $this->plaTable = $plaTable;
        $this->delTable = $delTable;
        $this->notTable = $notTable;
    }

    public function list(){
        $title = '공지사항 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        $stmt = $this->notTable->whereSQL($this->sort);
        $result = $stmt->fetchAll();

        return ['tempName'=>'notList.html.php','title'=>$title,'result'=>$result];
    }

    public function research(){
        $title = '공지사항 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        $value = '%'.$_POST['user_research'].'%';
        $sql = "WHERE notification LIKE '$value' ".$this->sort;
        $stmt = $this->notTable->whereSQL($sql);
        $result = $stmt->fetchAll();

        return ['tempName'=>'notList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $this->delTable->deleteData($_POST['not_no']);
        header('location: /not/list');
    }

    public function addupdate(){
        if(isset($_POST['not_no'])) {
            if($_POST['not_no'] == ''){
                $this->notTable->insertData($_POST);
            }
            else{
                $this->notTable->updateData($_POST);
            }
            header('location: /not/list');
        }
        if(isset($_GET['not_no'])){
            $row = $this->notTable->selectID($_GET['not_no']);
            $title2 = ' 수정';
            $title = '공지사항'.$title2;
            return ['tempName'=>'bookForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 입력';
            $title = '공지사항'.$title2;
            return ['tempName'=>'bookForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }

    public function mempop(){
        echo "<script>location.href='/member/list?title=회원찾기&pop=true';</script>";
    }
}
?>