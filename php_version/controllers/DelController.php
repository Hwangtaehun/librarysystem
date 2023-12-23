<?php
include_once __DIR__.'/../includes/Assistance.php';
session_start();
class DelController{
    private $sql = "SELECT * FROM delivery, material, member, book WHERE delivery.mat_no = material.mat_no AND delivery.mem_no = member.mem_no 
                    AND material.book_no = book.book_no";
    private $sort = "ORDER BY book.book_name";
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
    private $assist;

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
        $this->assist = new Assistance();
    }

    //게시판형마다 다른 sql 필요해서 정리
    private function sqlList(string $title){
        if($title == '상호대차 완료 현황'){
            $this->sql = $this->sql." AND delivery.len_no IS NOT NULL ";
        }
        else if($title == '상호대차 도착일 추가'){
            $this->sql = $this->sql." AND delivery.del_arr_date IS NULL AND delivery.del_app = 1 ";
        }
        else{
            //팝업창 확인
            if(isset($_GET['pop'])){
                if($_GET['pop'] == true){
                    $this->sql = $this->sql."AND len_no IS NULL AND del_arr_date IS NOT NULL ";
                }
            }
            else{
                $mem_state = $_SESSION['mem_state'];
                if($mem_state == 1){
                    $this->sql = $this->sql." AND NOT member.mem_state = 1 ";
                }
                else{
                    $mem_no = $_SESSION['mem_no'];
                    $this->sql = $this->sql." AND member.mem_no LIKE $mem_no ";
                }
            }
        }
    }

    //기본 목록 출력
    public function list(){
        $title = '상호대차 현황';
        
        //팝업창 일때
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        $this->sqlList($title);
        $sql = $this->sql.$this->sort;
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result];
    }

    //상호대차 완료 목록 출력
    public function completelist(){
        $title = '상호대차 완료 현황';
        $this->sqlList($title);
        $sql = $this->sql.$this->sort;
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result];
    }

    //상호대차 도착일 추가
    public function addlist(){
        $title = '상호대차 도착일 추가';
        $this->sqlList($title);
        $sql = $this->sql.$this->sort;
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result];
    }

    //검색
    public function research(){
        $title = '상호대차 현황';

        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        if(isset($_POST['title'])){
            $title = $_POST['title'];
        }

        $this->sqlList($title);

        $value = '%'.$_POST['user_research'].'%';
        if($_SESSION['mem_state'] == 1){
            if($_POST['mem_no'] == ''){
                $mat_no = $_POST['mat_no'];
                $sql = $this->sql." AND delivery.mat_no = $mat_no";
            }
            else if($_POST['mat_no'] == ''){
                $mem_no = $_POST['mem_no'];
                $sql = $this->sql." AND delivery.mem_no = $mem_no";
            }
            else{
                $mem_no = $_POST['mem_no'];
                $mat_no = $_POST['mat_no'];
                $sql = $this->sql." AND delivery.mat_no = $mat_no AND delivery.mem_no = $mem_no";
            }
        }
        else{
            $sql = $this->sql." AND book.book_name LIKE '$value'";
        }
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $this->delTable->deleteData($_POST['del_no']);
        header('location: /del/list');
    }

    public function addupdate(){
        if(isset($_POST['del_no'])) {
            $result = $this->matTable->selectID($_POST['mat_no']);

            //배송지와 소유지가 같으면 경고 메시지
            if($_POST['lib_no_arr'] == $result['lib_no']){
                    echo "<script>alert('자료가 있는 도서관과 배송되는 도서관이 같습니다'); history.back();</script>";
            }
            else{
                if($_POST['del_no'] == ''){
                    $param = ['mem_no'=>$_POST['mem_no'], 'mat_no'=>$_POST['mat_no'], 'lib_no_arr'=>$_POST['lib_no_arr']];
                    $this->delTable->insertData($param);
                    echo "<script>window.close();</script>";
                }
                else{
                    if($_POST['lib_arr_date'] == ''){
                        $param = ['del_no'=>$_POST['del_no'], 'mem_no'=>$_POST['mem_no'], 'mat_no'=>$_POST['mat_no'], 'lib_no_arr'=>$_POST['lib_no_arr'], 'del_app'=>$_POST['del_app']];
                        $this->delTable->updateData($param);
                    }
                    else{
                        $this->delTable->updateData($_POST);
                    }
                    header('location: /del/list');
                }
            }
        }
        if(isset($_GET['del_no'])){
            $del_no = $_GET['del_no'];
            $sql = $this->sql." AND `del_no` = $del_no";
            $stmt = $this->delTable->joinSQL($sql);
            $row =  $stmt->fetch();
            $title2 = ' 수정';
            $title = '상호대차'.$title2;
            return ['tempName'=>'delForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 신청';
            $title = '상호대차'.$title2;
            if(isset($_GET['mat_no'])){
                $mat_no = $_GET['mat_no'];
                $sql = "SELECT * FROM library, book, material WHERE library.lib_no = material.lib_no AND book.book_no = material.book_no AND material.mat_no = $mat_no";
                $stmt = $this->delTable->joinSQL($sql);
                $m_row =  $stmt->fetch();
                return ['tempName'=>'delForm.html.php', 'title'=>$title, 'title2'=>$title2, 'm_row'=>$m_row];
            }
            else{
                return ['tempName'=>'delForm.html.php', 'title'=>$title, 'title2'=>$title2];
            }
        }
    }

    //'상호대차도착일추가'할때 사용
    public function arrive(){
        $this->delTable->updateData($_POST);
        header('location: /del/list');
    }

    //회원 팝업창 열기
    public function mempop(){
        echo "<script>location.href='/member/list?title=회원찾기&pop=true';</script>";
    }

    //자료 검색 팝업창 열기
    public function matpop(){
        echo "<script>location.href='/mat/poplist?title=자료찾기&pop=true';</script>";
    }

    //자료 상세검색 팝업창 열기
    public function matlibpop(){
        echo "<script>location.href='/mat/poplist?title=상세검색&pop=true';</script>";
    }

    //대출 팝업창 열기
    public function pagelent(){
        $len_no = $_POST['len_no'];
        echo "<script>location.href='/len/listlen?len_no=$len_no'</script>";
    }
}
?>