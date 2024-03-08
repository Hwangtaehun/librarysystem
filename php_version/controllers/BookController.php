<?php
include_once __DIR__.'/../includes/Common.php';
session_start();

class BookController extends Common{
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
        $this->listchange(6);
        $this->tablename('book');
    }

    public function list(){
        $title = '책 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        $where = '';
        $result = $this->bookTable->selectAll();
        $total_cnt = sizeof($result);

        $pagi = $this->makePage($this->bookTable, $total_cnt, $where, true);
        $result = $this->getResult();

        return ['tempName'=>'bookList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    public function research(){
        $title = '책 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }
        
        $where = '';
        if(isset($_POST['user_research'])){
            $value = '%'.$_POST['user_research'].'%';
        }

        if(isset($_GET['value'])){
            $value = $_GET['value'];
        }
        
        $where = "WHERE book_name LIKE '$value' OR book_author LIKE '$value' OR book_publish LIKE '$value'";
        $stmt = $this->bookTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $pagi = $this->makePage($this->bookTable, $total_cnt, $where, true);
        $result = $this->getResult();

        return ['tempName'=>'bookList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    public function delete(){
        $this->bookTable->deleteData($_POST['book_no']);
        header('location: /book/list');
    }

    public function addupdate(){
        if(isset($_POST['book_no'])) {
            if($_POST['bk_no'] == ''){
                unset($_POST['bk_no']);
                $this->bookTable->insertData($_POST);
            }
            else{
                $id = $_POST['bk_no'];
                unset($_POST['bk_no']);
                $this->bookTable->allupdataData($_POST, $id);
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

    public function isbn(){
        $title = '책검색';
        return ['tempName'=>'isbn.html.php', 'title'=>$title];
    }
}
?>