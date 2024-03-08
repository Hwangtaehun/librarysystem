<?php
include_once __DIR__.'/../includes/Common.php';
session_start();

class ResController extends Common{
    private $sql = "SELECT * FROM reservation, material, member, library, book, kind WHERE reservation.mat_no = material.mat_no AND reservation.mem_no = member.mem_no
                    AND material.kind_no = kind.kind_no AND material.book_no = book.book_no AND material.lib_no = library.lib_no";
    private $sort = " ORDER BY library.lib_name, book.book_name";
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
        $this->tablename('res');
    }

    public function list(){
        $title = '예약 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        if($_SESSION['mem_state'] != 1){
            $mem_no = $_SESSION['mem_no'];
            $this->sql = $this->sql." AND member.mem_no LIKE $mem_no";
        }
        $sql = $this->sql.$this->sort;
        $stmt = $this->resTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $pagi = $this->makePage($this->resTable, $total_cnt, $sql, false);
        $result = $this->getResult();
        
        return ['tempName'=>'resList.html.php','title'=>$title,'result'=>$result, 'pagi'=>$pagi];
    }

    //검색
    public function research(){
        $title = '예약 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        if($_SESSION['mem_state'] == 1){
            if(isset($_POST['mem_no'])){
                $value = $_POST['mem_no'];
                
            }
            
            if(isset($_GET['value'])){
                $value = $_GET['value'];
            }

            $sql = $this->sql." AND reservation.mem_no LIKE '$value'".$this->sort;
            $stmt = $this->resTable->joinSQL($sql);
            $result = $stmt->fetchAll();
        }
        else{
            if(isset($_POST['user_research'])){
                $value = $_POST['user_research'];
                
            }
            
            if(isset($_GET['value'])){
                $value = $_GET['value'];
            }

            $sql = $this->sql." AND book.book_name LIKE '%$value%'";
            $stmt = $this->resTable->joinSQL($sql);
            $result = $stmt->fetchAll();
        }

        $total_cnt = sizeof($result);
        $pagi = $this->makePage($this->resTable, $total_cnt, $sql, false);
        $result = $this->getResult();

        return ['tempName'=>'resList.html.php','title'=>$title,'result'=>$result, 'pagi'=>$pagi];
    }

    public function delete(){
        $this->resTable->deleteData($_POST['res_no']);
        header('location: /res/list');
    }

    public function addupdate(){
        if(isset($_POST['res_no'])) {
            if($_POST['res_no'] == ''){
                $param = ['res_date'=>$_POST['res_date'], 'mem_no'=>$_POST['mem_no'], 'mat_no'=>$_POST['mat_no']];
                $this->resTable->insertData($param);
            }
            else{
                $this->resTable->updateData($_POST);
            }
            header('location: /res/list');
        }
        if(isset($_GET['res_no'])){
            $row = $this->resTable->selectID($_GET['res_no']);
            $title2 = ' 수정';
            $title = '예약'.$title2;
            return ['tempName'=>'resForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 입력';
            $title = '예약'.$title2;
            return ['tempName'=>'resForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }

    //회원 찾기 팝업창으로 띄우는 함수
    public function mempop(){
        echo "<script>location.href='/member/list?title=회원찾기&pop=true';</script>";
    }
}
?>