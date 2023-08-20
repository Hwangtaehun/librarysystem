<?php
session_start();
class MatController{
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
    private $sql = "SELECT * FROM library, book, kind, material WHERE library.lib_no = material.lib_no AND book.book_no = material.book_no AND kind.kind_no = material.kind_no ";
    private $popSql;
    private $sort = "ORDER BY book.book_name";

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

    private function book_count(array $param){
        $str_num = "c.";
        $lib_no = $param['lib_no'];
        $book_no = $param['book_no'];
        $where = "WHERE `lib_no` LIKE $lib_no AND `book_no` LIKE $book_no";
        if(isset($param['mat_no'])){
            $mat_no = $param['mat_no'];
            $where = $where." AND `mat_no` NOT LIKE $mat_no";
        }
        $result = $this->matTable->whereSQL($where);
        $count = $result->rowCount() + 1;
        $str_num = $str_num.$count;
        return $str_num;
    }

    public function list(){
        $mem_state = $_SESSION['mem_state'];
        if($mem_state != 1){
            $this->sql = "SELECT * FROM library, book, material LEFT JOIN lent ON material.mat_no = lent.mat_no LEFT JOIN reservation ON material.mat_no = reservation.mat_no 
                WHERE library.lib_no = material.lib_no AND book.book_no = material.book_no ";
            $sql = $this->sql.$this->sort;
        }
        else{
            $sql = $this->sql.$this->sort;
        }
        
        $stmt = $this->matTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $title = '자료 현황';
        return ['tempName'=>'matList.html.php','title'=>$title,'result'=>$result];
    }

    public function poplist(){
        $title = $_GET['title'];
        if($title == '상세 검색'){
            $this->popSql = $this->sql;
        }
        else{
            $this->popSql = $this->sql."AND material.mat_no NOT IN (SELECT mat_no FROM lent WHERE len_re_st = 0 OR len_re_st = 2 UNION SELECT mat_no FROM reservation) ";
        }
        $sql = $this->popSql.$this->sort;
        $stmt = $this->matTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        return ['tempName'=>'matList.html.php','title'=>$title,'result'=>$result];
    }

    public function research(){
        $ispop = false;
        if(isset($_GET['title'])){
            $title = $_GET['title'];
            $ispop = true;
        }
        else{
            $title = '자료 현황';
            $ispop = false;
        }
        $value = '%'.$_POST['user_research'].'%';
        $lib_no = $_POST['lib_research'];
        if($lib_no == 0){
            $where = "OR book.book_name LIKE '$value' OR book.book_author LIKE '$value' OR book.book_publish LIKE '$value'";
        }
        else{
            $where = "AND library.lib_no LIKE $lib_no OR book.book_name LIKE '$value' OR book.book_author LIKE '$value' OR book.book_publish LIKE '$value'";
        }
        
        if($ispop){
            $sql = $this->popSql.$where;
        }
        else{
            $sql = $this->sql.$where;
        }
        $stmt = $this->matTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        return ['tempName'=>'matList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $lib_no = $_POST['lib_no'];
        $book_no = $_POST['book_no'];
        $this->matTable->deleteData($_POST['mat_no']);
        $sql = "UPDATE `material` SET `mat_overlap` = 'mat_overlap' WHERE `lib_no` = $lib_no  AND `book_no` = $book_no";
        $this->matTable->delupdateSQL($sql);
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
            $param = ['lib_no'=>$_POST['lib_no'], 'book_no'=>$_POST['book_no'], 'kind_no'=>$_POST['kind_no'], 'mat_symbol'=>$mat_symbol, 'mat_may'=>$mat_many, 'mat_overlap'=>$mat_overlap];

            if($_POST['mat_no'] == ''){
                $this->matTable->insertData($param);
            }
            else{
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
            //$row = $this->matTable->selectID($_GET['mat_no']);
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

    //ResController 생성후 제작-정지 계정 제한 및 자료확인 함수 html.php에서 만들기
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
            echo "<script>alert('다른 회원분이 예약했습니다.')</script>";
        }
    }

    public function bookpop(){
        // $result = $this->bookTable->selectAll();
        // $title = '책검색';
        // return ['tempName'=>'bookList.html.php','title'=>$title,'result'=>$result];
        echo "<script>location.href='/book/list?title=책검색&pop=true';</script>";
    }

    public function kindpop(){
        // $result = $this->kindTable->selectAll();
        // $title = '종류검색';
        // return ['tempName'=>'kindList.html.php','title'=>$title,'result'=>$result];
        echo "<script>location.href='/kind/list?title=종류검색&pop=true';</script>";
    }

    public function matpop(){
        // $result = $this->matTable->selectAll();
        // $title = '상세 검색';
        // return ['tempName'=>'matList.html.php','title'=>$title,'result'=>$result];
        echo "<script>location.href='/mat/poplist?title=상세 검색&pop=true';</script>";

    }

    public function delpop(){
        // $result = $this->matTable->selectID($_POST['mat_no']);
        // $title = '상호대차';
        // return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result];
        $mat_no = $_GET['mat_no'];
        echo "<script>location.href='/del/addupdate?mat_no=$mat_no&pop=true';</script>";
    }
}
?>