<?php
session_start();
class ResController{
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
        $mem_state = $_SESSION['mem_state'];
        if($mem_state != 1){
            $mem_no = $_SESSION['mem_no'];
            $this->sql = $this->sql." AND member.mem_no LIKE $mem_no".$this->sort;
        }
        $stmt = $this->resTable->joinSQL($this->sql);
        $result = $stmt->fetchAll();
        $title = '예약 현황';
        return ['tempName'=>'resList.html.php','title'=>$title,'result'=>$result];
    }

    public function research(){
        $value = $_POST['research_id'];
        $where = "WHERE reservation.mem_no LIKE '$value'".$this->sort;
        $stmt = $this->resTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $title = '예약 현황';
        return ['tempName'=>'resList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $this->resTable->deleteData($_POST['res_no']);
        header('location: /res/list');
    }

    public function addupdate(){
        if(isset($_POST['res_no'])) {
            if($_POST['res_no'] == ''){
                $this->resTable->insertData($_POST);
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

    public function mempop(){
        if(isset($_POST['user_research'])){
            $value= $_POST['user_research'];
            $where = "WHERE `mem_id` = '$value' OR `mem_name` = '$value'";
            $stmt = $this->memTable->whereSQL($where);
            $result = $stmt->fetchAll();
            $title = '회원찾기';
            return['tempName'=>'memberList.html.php', 'title'=>$title, 'result'=>$result];
        }
    }
}
?>