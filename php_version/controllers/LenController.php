<?php
include_once __DIR__.'/../includes/Controller.php';
session_start();

class LenController extends Controller{
    private $sql = "SELECT * FROM `library`, `book`, `material`, `member`, `lent` WHERE material.lib_no = library.lib_no 
                    AND material.book_no = book.book_no AND lent.mat_no = material.mat_no AND lent.mem_no = member.mem_no ";
    private $sort = " ORDER BY `mem_name`";

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
        $this->tablename('len');
    }

    //대출 게시판형마다 다른 sql 필요해서 정리 단. 대출 현황과 대출찾기는 제외
    private function sqlList(string $title){
        if($title == '반납 추가'){
            $this->sql = $this->sql."AND lent.len_re_st = 0";
        }
        else{
            $mem_no = $_SESSION['mem_no'];
            if($title == '대출중자료'){
                $this->sql = $this->sql."AND lent.mem_no = $mem_no AND lent.len_re_st = 0";
            }
            else{
                $this->sql = $this->sql."AND lent.mem_no = $mem_no";
            }
        }
    }

    public function list(){
        $title = '대출 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        $sql = $this->sql.$this->sort;
        $stmt = $this->lenTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $pagi = $this->makePage($this->lenTable, $total_cnt, $sql, false);
        $result = $this->getResult();

        return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //로그인한 회원의 현재 대출 목록 출력
    public function memlist(){
        $title = '대출중자료';

        $this->sqlList($title);
        $sql = $this->sql.$this->sort;
        $stmt = $this->lenTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);
        $this->funName('mem');

        $pagi = $this->makePage($this->lenTable, $total_cnt, $sql, false);
        $result = $this->getResult();

        return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //로그인한 회원의 모든 대출 목록 출력
    public function memAlllist(){
        $title = '모든대출내역';

        $this->sqlList($title);
        $sql = $this->sql.$this->sort;
        $stmt = $this->lenTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);
        $this->funName('memAll');

        $pagi = $this->makePage($this->lenTable, $total_cnt, $sql, false);
        $result = $this->getResult();

        return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //반납 목록
    public function returnlist(){
        $title = '반납 추가';
        $this->sqlList($title);
        $sql = $this->sql.$this->sort;
        $stmt = $this->lenTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);
        $this->funName('return');

        $pagi = $this->makePage($this->lenTable, $total_cnt, $sql, false);
        $result = $this->getResult();

        return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //검색
    public function research(){
        $title = '대출 현황';
        $this->funName('');
        
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        if(isset($_POST['title'])){
            $title = $_POST['title'];
        }
        
        if($title != '대출 현황' && $title != '대출찾기'){
            $this->sqlList($title);
        }

        if(isset($_POST)){
            if($_SESSION['mem_state'] == 1){
                if($_POST['mem_no'] == ''){
                    $mat_no = $_POST['mat_no'];
                    $sql = $this->sql." AND lent.mat_no = $mat_no";
                    $value = "mat_no=$mat_no";
                }
                else if($_POST['mat_no'] == ''){
                    $mem_no = $_POST['mem_no'];
                    $sql = $this->sql." AND lent.mem_no = $mem_no";
                    $value = "mem_no=$mem_no";
                }
                else{
                    $mem_no = $_POST['mem_no'];
                    $mat_no = $_POST['mat_no'];
                    $sql = $this->sql." AND lent.mat_no = $mat_no AND lent.mem_no = $mem_no";
                    $value = "mat_no=$mat_no,mem_no=$mem_no";
                }
            }
            else{
                $book_name = '%'.$_POST['user_research'].'%';
                $sql = $this->sql." AND book.book_name LIKE '$book_name'";
                $value = "book_name=$book_name";
            }
        }

        if(isset($_GET['value'])){
            $value = $_GET['value'];
            $key_array = explode(",",$value);
            if(sizeof($key_array) != 1){
                $mat = explode("=",$key_array[0]);
                $mem = explode("=",$key_array[1]);
                $mat_no = $mat[1];
                $mem_no = $mem[1];
                $sql = $this->sql." AND lent.mat_no = $mat_no AND lent.mem_no = $mem_no";
            }
            else{
                $key_array = explode("=",$value);
                if($key_array[0] == "mat_no"){
                    $mat_no = $key_array[1];
                    $sql = $this->sql." AND lent.mat_no = $mat_no";
                }else if($key_array[0] == "mem_no"){
                    $mem_no = $key_array[1];
                    $sql = $this->sql." AND lent.mem_no = $mem_no";
                }
                else{
                    $book_name = $key_array[1];
                    $sql = $this->sql." AND book.book_name LIKE '$book_name'";
                }
            }
        }
        
        $stmt = $this->lenTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $pagi = $this->makePage($this->lenTable, $total_cnt, $sql, false);
        $result = $this->getResult();

        return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //대출 정보로 이동하는 함수
    public function listlen(){
        $title = '대출 현황';
        $value = $_GET['len_no'];
        $sql = $this->sql." AND lent.len_no LIKE '$value'";
        $stmt = $this->lenTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $len_no = $_POST['len_no'];
        $sql = "DELETE FROM `place` WHERE len_no = $len_no";
        $this->plaTable->delupdateSQL($sql);
        $this->lenTable->deleteData($len_no);

        $row = $this->lenTable->selectID($len_no);
        $mat_no = $row['mat_no'];
        $this->existMat($mat_no, 1, $this->lenTable, $this->delTable, $this->matTable);

        header('location: /len/list');
    }

    public function addupdate(){
        if(isset($_POST['len_no'])) {
            $mem_no = $_POST['mem_no'];
            $mat_no = $_POST['mat_no'];
            if($this->reservationCheck($_POST['res_no'], $mat_no, $this->resTable) && $this->lentpossible($mem_no, $this->memTable, $this->lenTable)){
                if($_POST['len_no'] == ''){
                    $today = date("Y-m-d");
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
                    $this->existMat($mat_no, 0, $this->lenTable, $this->delTable, $this->matTable);
    
                    header('location: /len/addupdate');
                }
                else{
                    $len_no = $_POST['len_no'];
                    $row = $this->lenTable->selectID($_POST['len_no']);
                    if($row['len_re_st'] == 1){
                        if($_POST['len_re_st'] != 1){
                            $len_no = $_POST['len_no'];
                            $sql = "UPDATE `place` SET `lib_no_re` = NULL WHERE `len_no` = $len_no";
                            $this->plaTable->delupdateSQL($sql);
                            $sql = "UPDATE `overdue` SET `due_exp` = NULL WHERE `len_no` = $len_no";
                            $this->dueTable->delupdateSQL($sql);
                            $this->existMat($mat_no, 0, $this->lenTable, $this->delTable, $this->matTable);
                        }
                    }
                    
                    if(!isset($_POST['len_re_date'])){
                        $param = ['mem_no'=>$_POST['mem_no'], 'mat_no'=>$mat_no, 'len_date'=>$_POST['len_date'], 'len_ex'=>$_POST['len_ex'], 
                                  'len_re_st'=>$_POST['len_re_st'], 'len_memo'=>$_POST['len_memo'], 'len_no'=>$_POST['len_no']];
                    }
                    else{
                        $param = ['mem_no'=>$_POST['mem_no'], 'mat_no'=>$mat_no, 'len_date'=>$_POST['len_date'], 'len_ex'=>$_POST['len_ex'], 
                        'len_re_date'=>$_POST['len_re_date'], 'len_re_st'=>$_POST['len_re_st'], 'len_memo'=>$_POST['len_memo'], 'len_no'=>$_POST['len_no']];
                    }
                    $this->lenTable->updateData($param);
                    header('location: /len/list');
                }
            }else{
                echo "<script>history.back();</script>";
            }
        }
        if(isset($_GET['len_no'])){
            $len_no = $_GET['len_no'];
            $sql = $this->sql."AND lent.len_no = $len_no";
            $stmt = $this->matTable->joinSQL($sql);
            $row = $stmt->fetch();
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

    //반납 추가할 때 사용하는 함수
    public function returnadd(){
        $lib_no = $_POST['lib_no'];
        $mat_no = $_POST['mat_no'];
        $len_no = $_POST['len_no'];
        $today = date("Y-m-d");
        
        $this->existMat($mat_no, 1, $this->lenTable, $this->delTable, $this->matTable);
        $param = ['len_re_date'=>$_POST['len_re_date'], 'len_re_st'=>1, 'len_no'=>$len_no];
        $this->lenTable->updateData($param);
        $sql = "UPDATE `place` SET `lib_no_re` = $lib_no WHERE `len_no` = $len_no";
        $this->plaTable->delupdateSQL($sql);

        $row = $this->matTable->selectID($mat_no);
        if($row['lib_no'] != $lib_no){
            $mem_no = $_SESSION['mem_no'];
            $lib_no_arr = $lib_no;
            $param = ['mem_no'=>$mem_no, 'mat_no'=>$mat_no, 'lib_no_arr'=>$lib_no_arr, 'del_arr_date'=>$today, 'del_app'=>2];
            $this->delTable->insertData($param);
        }

        $where = "WHERE len_no = $len_no";
        $stmt = $this->dueTable->whereSQL($where);
        if(!$this->resultempty_check($stmt)){
            $row = $stmt->fetch();
            $due_no = $row['due_no'];
            $row = $this->lenTable->selectID($len_no);
            $prd = $this->estimateReturndate($row['len_date'], $row['len_ex']);
            $from = new DateTime($today);
            $to = new DateTime($prd);
            $diff = date_diff($from, $to);
            $day = $diff->days;
            $due_exp = date("Y-m-d", strtotime($today.' + '.$day.' days'));
            $param = ['due_no'=>$due_no,'due_exp'=>$due_exp];
            $this->dueTable->updateData($param);
        }
        header('location: /len/returnLent');
    }

    //회원 팝업창 열기
    public function mempop(){
        echo "<script>location.href='/member/list?title=회원찾기&pop=true';</script>";
    }

    //자료 팝업창 열기
    public function matpop(){
        echo "<script>location.href='/mat/poplist?title=상세 검색&pop=true';</script>";
    }

    //상호대차 팝업창 열기
    public function delpop(){
        echo "<script>location.href='/del/list?title=상호대차찾기&pop=true';</script>";
    }

    //예약 팝업창 열기
    public function respop(){
        echo "<script>location.href='/res/list?title=예약찾기&pop=true';</script>";
    }
}
?>