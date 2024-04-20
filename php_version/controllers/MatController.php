<?php
include_once __DIR__.'/../includes/Controller.php';
session_start();

class MatController extends Controller{
    private $sql = "SELECT * FROM library, book, kind, material WHERE library.lib_no = material.lib_no AND book.book_no = material.book_no AND kind.kind_no = material.kind_no ";
    private $sort = "ORDER BY book.book_name";
    private $popSql;

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
        $this->tablename('mat');
    }

    //중복된 책인 있는 확인하는 함수
    private function book_count(array $param){
        $str_num = "c.";
        $lib_no = $param['lib_no'];
        $book_no = $param['book_no'];
        $where = "WHERE `lib_no` LIKE $lib_no AND `book_no` LIKE $book_no";
        if(isset($param['mat_no'])){
            if($_POST['mat_no'] != ''){
                $mat_no = $param['mat_no'];
                $where = $where." AND `mat_no` NOT LIKE $mat_no";
            }
        }
        $result = $this->matTable->whereSQL($where);
        $count = $result->rowCount() + 1;
        $str_num = $str_num.$count;
        return $str_num;
    }

    //관리자 계정이 아니면 SQL를 변동하는 함수
    private function basic_sql(){
        $this->sql = "SELECT * FROM library, book, material LEFT JOIN reservation ON material.mat_no = reservation.mat_no WHERE library.lib_no = material.lib_no AND book.book_no = material.book_no ";
    }

    //popSQL 선택할때 사용
    private function popSQL(string $title){
        if($title == '상세 검색'){
            $this->popSql = $this->sql;
        }
        else{
            $this->popSql = $this->sql."AND material.mat_no NOT IN (SELECT mat_no FROM lent WHERE len_re_st = 0 OR len_re_st = 2 UNION SELECT mat_no FROM reservation) ";
        }
    }

    public function list(){
        $title = '자료 현황';

        if(isset($_SESSION['mem_state'])){
            $mem_state = $_SESSION['mem_state'];
        }
        else{
            $mem_state = 2;
        }
        
        if($mem_state != 1){
            $this->basic_sql();
            $sql = $this->sql.$this->sort;
        }
        else{
            $sql = $this->sql.$this->sort;
        }
        
        $stmt = $this->matTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $pagi = $this->makePage($this->matTable, $total_cnt, $sql, false);
        $result = $this->getResult();

        return ['tempName'=>'matList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //팝업을 이용해서 자료 목록을 나타낼때 사용하는 함수 -- 요부분 다시하기
    public function poplist(){
        $title = $_GET['title'];
        $this->popSQL($title);
        $sql = $this->popSql.$this->sort;
        $stmt = $this->matTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);
        $this->funName('pop');

        $pagi = $this->makePage($this->matTable, $total_cnt, $sql, false);
        $result = $this->getResult();

        return ['tempName'=>'matList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //검색할때 사용하는 함수
    public function research(){
        $in = '';
        $ispop = false;
        $this->funName('');

        if(!isset($_SESSION['mem_state'])){
            $this->basic_sql();
        }

        if(isset($_GET['title'])){
            $title = $_GET['title'];
            $ispop = true;
        }
        else{
            $title = '자료 현황';
            $ispop = false;
        }

        if(isset($_POST)){
            $value = '%'.$_POST['user_research'].'%';
            $where = "WHERE book.book_name LIKE '$value' OR book.book_author LIKE '$value' OR book.book_publish LIKE '$value'";
            $m_result = $this->bookTable->whereSQL($where);
            $m_row = $m_result->fetchAll();
            for ($i=0; $i < sizeof($m_row); $i++) { 
                $in .= $m_row[$i][0].', ';
            }
            $in = rtrim($in, ', ');

            $lib_no = $_POST['lib_research'];
            if(sizeof($m_row) == 0){
                if($value == '%%'){
                    if($lib_no != 0){
                        $where = "AND library.lib_no LIKE $lib_no";
                        $value = "lib_no=$lib_no";
                    }
                }
                else{
                    return ['tempName'=>'matList.html.php','title'=>$title,'pagi'=>''];
                }
            }
            else{
                if($lib_no == 0){
                    $where = "AND book.book_no IN ($in)";
                    $value = "in=$in";
                }
                else{
                    $where = "AND library.lib_no LIKE $lib_no AND book.book_no IN ($in)";
                    $value = "lib_no=$lib_no,in=$in";
                }
            }
        }

        if(isset($_GET['value'])){
            $value = $_GET['value'];
            $key_array = explode(",",$value);
            if(sizeof($key_array) != 1){
                $lib_array = explode("=", $key_array[0]);
                $in_array = explode("=", $key_array[1]);
                $lib_no = $lib_array[1];
                $in = $in_array[1];
                $where = "AND library.lib_no LIKE $lib_no AND book.book_no IN ($in)";
            }else{
                $key_array = explode("=",$value);
                if($key_array[0] == "lib_no"){
                    $lib_no = $key_array[1];
                    $where = "AND library.lib_no LIKE $lib_no";
                }else{
                    $in = $key_array[1];
                    $where = "AND book.book_no IN ($in)";
                }
            }
        }
        
        if($ispop){
            $this->popSql($title);
            $sql = $this->popSql.$where;
            echo '<script>alert($title = '.$title.', $sql = '.$sql.');</script>';
        }
        else{
            $sql = $this->sql.$where;
        }
        
        $stmt = $this->matTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $pagi = $this->makePage($this->matTable, $total_cnt, $sql, false);
        $result = $this->getResult();

        return ['tempName'=>'matList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    public function delete(){
        $lib_no = $_POST['lib_no'];
        $book_no = $_POST['book_no'];
        $this->matTable->deleteData($_POST['mat_no']);
        if($_POST['mat_overlap'] != 'c.1'){
            $mat_overlap = $this->book_count($_POST);
            $sql = "UPDATE `material` SET `mat_overlap` = '$mat_overlap' WHERE `lib_no` = $lib_no  AND `book_no` = $book_no";
            $this->matTable->delupdateSQL($sql);
        }
        header('location: /mat/list');
    }

    public function addupdate(){
        include_once __DIR__.'/../includes/BookSymbol.php';

        if(isset($_POST['mat_no'])) {
            $lib_no = $_POST['lib_no'];
            $book_no = $_POST['book_no'];
            $symbol = new BookSymbol($_POST['book_author']);
            $mat_symbol = $symbol->call_symbol();

            $mat_many = 0;
            $array = explode('.', $_POST['mat_many']);
            if(sizeof($array) < 1){
                if($_POST['mat_many'] != 0){
                    $mat_many = 'v.'.$_POST['mat_many'];
                }
            }
            else{
                $mat_many = $_POST['mat_many'];
            }
            
            $mat_overlap = $this->book_count($_POST);

            if($_POST['mat_no'] == ''){
                $param = ['lib_no'=>$_POST['lib_no'], 'book_no'=>$_POST['book_no'], 'kind_no'=>$_POST['kind_no'], 'mat_symbol'=>$mat_symbol, 
                          'mat_many'=>$mat_many, 'mat_overlap'=>$mat_overlap];
                $this->matTable->insertData($param);
            }
            else{
                $param = ['lib_no'=>$_POST['lib_no'], 'book_no'=>$_POST['book_no'], 'kind_no'=>$_POST['kind_no'], 'mat_symbol'=>$mat_symbol, 
                          'mat_many'=>$mat_many, 'mat_overlap'=>$mat_overlap, 'mat_no'=>$_POST['mat_no']];
                $this->matTable->updateData($param);
            }
            $sql = "UPDATE `material` SET `mat_overlap` = '$mat_overlap' WHERE `lib_no` = $lib_no  AND `book_no` = $book_no";
            $this->matTable->delupdateSQL($sql);
            header('location: /mat/list');
        }
        if(isset($_GET['mat_no'])){
            $mat_no = $_GET['mat_no'];
            $sql = $this->sql."AND material.mat_no = $mat_no";
            $stmt = $this->matTable->joinSQL($sql);
            $row = $stmt->fetch();
            $title2 = ' 수정';
            $title = '자료'.$title2;
            return ['tempName'=>'matForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 입력';
            $title = '자료'.$title2;
            return ['tempName'=>'matForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }

    //예약 추가하는 함수
    public function resadd(){
        $mat_no = $_POST['mat_no'];
        $mem_no = $_SESSION['mem_no'];
        $where = "WHERE `mat_no` = $mat_no";
        $row = $this->resTable->whereSQL($where);
        $num = $row->rowCount();

        if($num == 0){
            $param = ['mem_no'=>$mem_no, 'mat_no'=>$mat_no];
            $this->resTable->insertData($param);
            header('location: /mat/list');
        }
        else{
            echo "<script>alert('다른 회원분이 예약했습니다.');</script>";
        }
    }

    //책 검색 팝업창을 불러오는 함수 
    public function bookpop(){
        echo "<script>location.href='/book/list?title=책검색&pop=true';</script>";
    }

    //자료 상세 검색 팝업창을 불러오는 함수
    public function matpop(){
        echo "<script>location.href='/mat/poplist?title=상세 검색&pop=true';</script>";

    }

    //상호대차 팝업창을 불러오는 함수
    public function delpop(){
        $mem_state = $_SESSION['mem_state'];
        if($mem_state == 0){
            $mat_no = $_GET['mat_no'];
            echo "<script>location.href='/del/addupdate?mat_no=$mat_no&pop=true';</script>";
        }
        else{
            echo "<script>alert('현재 계정은 상호대차 예약이 불가능합니다.');window.close();</script>";
        }
    }
}
?>