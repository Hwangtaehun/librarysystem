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

    public function list(){
        $mem_state = $_SESSION['mem_state'];
        if($mem_state == 1){
            $this->sql = $this->sql." AND NOT member.mem_state = 1 ";
        }
        else{
            $mem_no = $_SESSION['mem_no'];
            $this->sql = $this->sql." AND member.mem_no LIKE $mem_no ";
        }
        $sql = $this->sql.$this->sort;
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $title = '상호대차 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result];
    }

    public function completelist(){
        $this->sql = $this->sql." AND delivery.len_no IS NOT NULL ";
        $sql = $this->sql.$this->sort;
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $title = '상호대차 완료 현황';
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result];
    }

    public function addlist(){
        $this->sql = $this->sql." AND delivery.del_arr_date IS NULL AND delivery.del_app = 1 ";
        $sql = $this->sql.$this->sort;
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $title = '상호대차 도착일 추가';
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result];
    }

    public function research(){
        $title = '상호대차 현황';

        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        if(isset($_POST['title'])){
            $title = $_POST['title'];
        }

        $value = '%'.$_POST['user_research'].'%';
        if($_POST['lib_research'] != 0){
            $lib_no = $_POST['lib_research'];
            $sql = $this->sql." AND book.book_name LIKE '$value' AND library.lib_no = $lib_no";
        }
        else if($_SESSION['mem_state'] == 1){
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

    //MatController 생성후 작성 ->completeButtonListener
    public function addupdate(){
        if(isset($_POST['del_no'])) {
            $result = $this->matTable->selectID($_POST['mat_no']);
            if($_POST['lib_no_arr'] == $result['lib_no']){
                    echo "<script>alert('자료가 있는 도서관과 배송되는 도서관이 같습니다'); history.back();</script>";
            }
            else{
                if($_POST['del_no'] == ''){
                    $param = ['mem_no'=>$_POST['mem_no'], 'mat_no'=>$_POST['mat_no'], 'lib_no_arr'=>$_POST['lib_no_arr']];
                    $this->delTable->insertData($param);
                    
                }
                else{
                    $mat_no = $_POST['mat_no'];
                    $where = "WHERE mat_no = $mat_no AND len_no IS NULL";
                    $stmt = $this->delTable->whereSQL($where);
                    $result = $stmt->fetch();
    
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
            //$row = $this->delTable->selectID($_GET['del_no']);
            $title2 = ' 수정';
            $title = '상호대차'.$title2;
            return ['tempName'=>'delForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 신청';
            $title = '상호대차'.$title2;
            if(isset($_GET['mat_no'])){
                return ['tempName'=>'delForm.html.php', 'title'=>$title, 'title2'=>$title2, 'mat_no'=>$_GET['mat_no']];
            }
            else{
                return ['tempName'=>'delForm.html.php', 'title'=>$title, 'title2'=>$title2];
            }
        }
    }

    public function arrive(){
        // $mat_no = $_POST['mat_no'];
        // $where = "WHERE mat_no = $mat_no AND len_no IS NULL";
        // $result = $this->delTable->whereSQL($where);

        // if($this->assist->resultempty_check($result)){
        //     echo "<script>alert('상호대차로 신청된 자료가 아닙니다.')</script>";
        // }
        // else if($this->assist->dateformat_check($_POST['lib_no_arr'])){
        //     echo "<script>alert('날짜형식이 잘못되었습니다.')</script>";
        // }
        // else{
        //     $this->delTable->updateData($_POST);
        //     header('location: /del/list');
        // }
        $this->delTable->updateData($_POST);
        header('location: /del/list');
    }

    public function mempop(){
        // if(isset($_POST['user_research'])){
        //     $value= $_POST['user_research'];
        //     $where = "WHERE `mem_id` = '$value' OR `mem_name` = '$value'";
        //     $stmt = $this->memTable->whereSQL($where);
        //     $result = $stmt->fetchAll();
        //     $title = '회원찾기';
        //     return['tempName'=>'memberList.html.php', 'title'=>$title, 'result'=>$result];
        // }
        echo "<script>location.href='/member/list?title=회원찾기&pop=true';</script>";
    }

    //MatController 생성후 작성
    public function matpop(){
        // if(isset($_POST['user_research'])){
        //     $value= $_POST['user_research'];
        //     $where = "WHERE `book_name` = '$value'";
        //     $stmt = $this->memTable->whereSQL($where);
        //     $result = $stmt->fetchAll();
        //     $title = '자료찾기';
        //     return['tempName'=>'matList.html.php', 'title'=>$title, 'result'=>$result];
        // }
        echo "<script>location.href='/mat/poplist?title=자료찾기&pop=true';</script>";
    }

    public function matlibpop(){
        // if(isset($_POST['user_research'])){
        //     $value= $_POST['user_research'];
        //     $where = "WHERE `book_name` = '$value'";
        //     $stmt = $this->memTable->whereSQL($where);
        //     $result = $stmt->fetchAll();
        //     $title = '상세검색';
        //     return['tempName'=>'matList.html.php', 'title'=>$title, 'result'=>$result];
        // }
        echo "<script>location.href='/mat/poplist?title=상세검색&pop=true';</script>";
    }

    //LentController 생성후 작성
    public function pagelent(){
        $len_no = $_POST['len_no'];
        echo "<script>location.href='/len/listlen?len_no=$len_no'</script>";
    }
}
?>