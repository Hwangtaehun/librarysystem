<?php
include_once __DIR__.'/../includes/Assistance.php';
session_start();
class LibController{
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
    private $assist;

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
        $this->assist = new Assistance();
    }

    public function list(){
        $result = $this->libTable->selectAll();
        $title = '도서관 현황';
        return ['tempName'=>'libList.html.php','title'=>$title,'result'=>$result];
    }

    public function research(){
        $value = '%'.$_POST['user_research'].'%';
        $where = "WHERE lib_name LIKE '$value'";
        $stmt = $this->libTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $title = '도서관 현황';
        return ['tempName'=>'libList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $this->libTable->deleteData($_POST['lib_no']);
        header('location: /lib/list');
    }

    public function addupdate(){
        if(isset($_POST['lib_no'])) {
            if($this->assist->dateformat_check($_POST['lib_date'])){
                setcookie('zip', $_POST['lib_zip']);
                setcookie('add', $_POST['lib_add']);
                echo "<script>alert('날짜형식이 잘못되었습니다.'); history.back();</script>";
            }
            else{
                if($_POST['lib_no'] == ''){
                    $this->libTable->insertData($_POST);
                }
                else{
                    $this->libTable->updateData($_POST);
                }
                header('location: /lib/list');
            }
        }
        if(isset($_GET['lib_no'])){
            $row = $this->libTable->selectID($_GET['lib_no']);
            $title2 = ' 수정';
            $title = '도서관'.$title2;
            return ['tempName'=>'libForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 입력';
            $title = '도서관'.$title2;
            return ['tempName'=>'libForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }
}
?>