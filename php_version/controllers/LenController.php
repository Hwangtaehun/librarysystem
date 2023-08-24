<?php
include_once __DIR__.'/../includes/Assistance.php';
session_start();
class LenController{
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
    private $sql = "SELECT * FROM `library`, `book`, `material`, `member`, `lent` WHERE material.lib_no = library.lib_no 
                    AND material.book_no = book.book_no AND lent.mat_no = material.mat_no AND lent.mem_no = member.mem_no ";
    private $sort = " ORDER BY `mem_name`";
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

    private function reservationCheck(){
        $rs = false;

        if($_POST['res_no'] == ''){
            $mat_no = $_POST['mat_no'];
            $where = "WHERE `mat_no` = $mat_no";
            $stmt = $this->resTable->whereSQL($where);
            $num = $stmt->rowCount();
            
            if($num == 0){
                $rs = true;
            }
            else{
                $row = $stmt->fetch();
                if($row['mem_no'] == $_POST['mem_no']){
                    $rs = true;
                    $this->resTable->deleteData($row['res_no']);
                }
            }
        }
        else{
            $rs = true;
        }
        
        if($rs == false){
            echo "<script>alert('다른 회원이 예약한 도서입니다.')</script>";
        }

        return $rs;
    }

    public function list(){
        $sql = $this->sql.$this->sort;
        $stmt = $this->lenTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }
        $title = '대출 현황';
        return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result];
    }

    public function memLent(){
        $mem_no = $_SESSION['mem_no'];
        $this->sql = $this->sql."AND lent.mem_no = $mem_no AND lent.len_re_st = 0";
        $sql = $this->sql.$this->sort;
        $stmt = $this->lenTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $title = '대출중자료';
        return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result];
    }

    public function memAllLent(){
        $mem_no = $_SESSION['mem_no'];
        $this->sql = $this->sql."AND lent.mem_no = $mem_no";
        $sql = $this->sql.$this->sort;
        $stmt = $this->lenTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $title = '모든대출내역';
        return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result];
    }

    public function returnLent(){
        $this->sql = $this->sql."AND lent.len_re_st = 0";
        $sql = $this->sql.$this->sort;
        $stmt = $this->lenTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $title = '반납 추가';
        return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result];
    }

    public function research(){
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        if(isset($_POST['title'])){
            $title = $_POST['title'];
        }
        
        if($_SESSION['mem_state'] == 1){
            if($_POST['mem_no'] == ''){
                $mat_no = $_POST['mat_no'];
                $sql = $this->sql." AND lent.mat_no = $mat_no";
            }
            else if($_POST['mat_no'] == ''){
                $mem_no = $_POST['mem_no'];
                $sql = $this->sql." AND lent.mem_no = $mem_no";
            }
            else{
                $mem_no = $_POST['mem_no'];
                $mat_no = $_POST['mat_no'];
                $sql = $this->sql." AND lent.mat_no = $mat_no AND lent.mem_no = $mem_no";
            }
        }
        else{
            $value = '%'.$_POST['user_research'].'%';
            $sql = $this->sql." AND book_name LIKE '$value'";
        }
        $stmt = $this->lenTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $len_no = $_POST['len_no'];
        $sql = "DELETE FROM `place` WHERE len_no = $len_no";
        $this->plaTable->delupdateSQL($sql);
        $this->lenTable->deleteData($len_no);
        header('location: /len/list');
    }

    public function addupdate(){
        if(isset($_POST['len_no'])) {
            if($_POST['len_no'] == ''){
                if($this->reservationCheck()){
                    $today = date("Y-m-d");
                    $mat_no = $_POST['mat_no'];
                    $mem_no = $_POST['mem_no'];
                    $param = ['mat_no'=>$mat_no, 'mem_no'=>$mem_no, 'len_ex'=>$_POST['len_ex'], 'len_date'=>$today];
                    $this->lenTable->insertData($param);
                    $sql = "WHERE `mat_no` = $mat_no AND `mem_no` = $mem_no AND `len_date` = '$today'";
                    $stmt = $this->lenTable->whereSQL($sql);
                    $row = $stmt->fetch();
                    $len_no = $row['len_no'];
                    if($_POST['del_no'] != ''){
                        $param = ['del_no'=>$_POST['del_no'], 'len_no'=>$len_no];
                        $this->delTable->updateData($param);
                    }
                    $lib_no_len = $_POST['lib_no'];
                    $param = ['len_no'=>$len_no, 'lib_no_len'=>$lib_no_len];
                    $this->plaTable->insertData($param);
                    header('location: /len/list');
                }
            }
            else{
                if($this->assist->dateformat_check($_POST['len_date'])){
                    echo "<script>alert('날짜형식이 잘못되었습니다.')</script>"; 
                }
                else{
                    $this->lenTable->updateData($_POST);
                    $row = $this->lenTable->selectID($_POST['len_no']);
                    if($row['len_re_st'] == 1){
                        if($_POST['len_re_st'] != 1){
                            $len_no = $_POST['len_no'];
                            $sql = "UPDATE `place` SET `lib_no_re` = NULL WHERE `len_no` = $len_no";
                            $this->plaTable->delupdateSQL($sql);
                            $sql = "UPDATE overdue SET due_exp = NULL WHERE `len_no` = $len_no";
                            $this->dueTable->delupdateSQL($sql);
                            header('location: /len/list');
                        }
                    }
                }
            }
        }
        if(isset($_GET['len_no'])){
            $len_no = $_GET['len_no'];
            $sql = $this->sql."AND lent.len_no = $len_no";
            $stmt = $this->matTable->joinSQL($sql);
            $row = $stmt->fetch();
            //$row = $this->lenTable->selectID($_GET['len_no']);
            $title2 = ' 수정';
            $title = '대출'.$title2;
            return ['tempName'=>'lenForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 입력';
            $title = '대출 추가';
            return ['tempName'=>'lenForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }

    public function returnadd(){
        $lib_no = $_POST['lib_no'];
        $mat_no = $_POST['mat_no'];
        $len_re_date = $_POST['len_re_date'];
        $today = date("Y-m-d");

        $param = ['len_re_date'=>$len_re_date, 'len_re_st'=>1];
        $this->lenTable->updateData($param);
        $len_no = $_POST['len_no'];
        $sql = "UPDATE `place` SET `lib_no_re` = $lib_no WHERE `len_no` = $len_no";
        $this->plaTable->delupdateSQL($sql);

        $row = $this->matTable->selectID($mat_no);
        if($row['lib_no'] != $lib_no){
            $mem_no = $_SESSION['mem_no'];
            $lib_no_arr = $row['lib_no'];
            $param = ['mem_no'=>$mem_no, 'mat_no'=>$mat_no, 'lib_no_arr'=>$lib_no_arr, 'del_arr_date'=>$today, 'del_app'=>2];
            $this->delTable->insertData($param);
        }

        $where = "WHERE len_no = $len_no";
        $stmt = $this->dueTable->whereSQL($where);
        $row = $stmt->fetch();
        $due_no = $row['due_no'];
        if(!$this->assist->resultempty_check($stmt)){
            $row = $this->lenTable->selectID($len_no);
            $prd = $this->assist->estimateReturndate($row['len_date'], $row['len_ex']);
            $from = new DateTime($today);
            $to = new DateTime($prd);
            $diff = date_diff($from, $to);
            $due_exp = date("Y-m-d", strtotime($today.'+ '.$diff.' days'));
            $param = ['due_exp'=>$due_exp];
            $this->dueTable->updateData($param);
        }
    }

    public function mempop(){
        // $result = $this->memTable->selectAll();
        // $title = '회원찾기';
        // return ['tempName'=>'memberList.html.php','title'=>$title,'result'=>$result];
        echo "<script>location.href='/member/list?title=회원찾기&pop=true';</script>";
    }

    public function matpop(){
        // $result = $this->matTable->selectAll();
        // $title = '자료찾기';
        // return ['tempName'=>'matList.html.php','title'=>$title,'result'=>$result];
        echo "<script>location.href='/mat/poplist?title=상세 검색&pop=true';</script>";
    }

    public function delpop(){
        // $result = $this->delTable->selectAll();
        // $title = '상호대차';
        // return ['tempName'=>'matList.html.php','title'=>$title,'result'=>$result];
        echo "<script>location.href='/del/list?pop=true';</script>";
    }

    public function respop(){
        // $result = $this->resTable->selectAll();
        // $title = '예약찾기';
        // return ['tempName'=>'matList.html.php','title'=>$title,'result'=>$result];
        echo "<script>location.href='/res/list?title=예약찾기&pop=true';</script>";
    }
}
?>