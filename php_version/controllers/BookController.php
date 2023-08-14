<?php
session_start();
class BookController{
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

    public function __construct(TableManager $libTable, TableManager $bookTable, TableManager $kindTable, TableManager $memTable, TableManager $matTable, 
                                TableManager $resTable, TableManager $lenTable, TableManager $dueTable, TableManager $plaTable, TableManager $delTable)
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
    }

    public function list(){
        $result = $this->bookTable->selectAll();
        $title = '책 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }
        return ['tempName'=>'bookList.html.php','title'=>$title,'result'=>$result];
    }

    public function research(){
        $value = '%'.$_POST['user_research'].'%';
        $where = "WHERE book_name LIKE '$value'";
        $stmt = $this->bookTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $title = '책 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }
        return ['tempName'=>'bookList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $this->bookTable->deleteData($_POST['book_no']);
        header('location: /book/list');
    }

    public function addupdate(){
        if(isset($_POST['book_no'])) {
            if($_POST['book_no'] == ''){
                $this->bookTable->insertData($_POST);
            }
            else{
                $this->bookTable->updateData($_POST);
            }
            header('location: /book/list');
        }
        if(isset($_GET['book_no'])){
            $row = $this->bookTable->selectID($_GET['book_no']);
            $title2 = ' 수정';
            $title = '책'.$title2;
            return ['tempName'=>'bookForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 입력';
            $title = '책'.$title2;
            return ['tempName'=>'bookForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }
}
?>