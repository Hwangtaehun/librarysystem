<?php
session_start();
class DelController{
    private $sql = "SELECT * FROM delivery, material, member, book WHERE delivery.mat_no = material.mat_no AND delivery.mem_no = member.mem_no 
                    AND material.book_no = book.book_no";
    private $sort = "ORDER BY book.book_name";

    private $memTable;
    private $bookTable;
    private $kindTable;
    private $delTable;

    public function __construct(TableManager $memTable, TableManager $bookTable, TableManager $kindTable, TableManager $delTable){
        $this->memTable = $memTable;
        $this->bookTable = $bookTable;
        $this->kindTable = $kindTable;
        $this->delTable = $delTable;
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
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result];
    }

    public function completelist(){
        $this->sql = $this->sql." AND len_no IS NOT NULL ";
        $sql = $this->sql.$this->sort;
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $title = '상호대차완료 현황';
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result];
    }

    public function research(){
        $value = '%'.$_POST['user_research'].'%';
        $where = "WHERE kind_name LIKE '$value'";
        $stmt = $this->delTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $title = '상호대차 현황';
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $this->delTable->deleteData($_POST['del_no']);
        header('location: /del/list');
    }

    public function addupdate(){
        if(isset($_POST['del_no'])) {
            if($_POST['del_no'] == ''){
                $param = ['mem_no'=>$_POST['mem_no'], 'mat_no'=>$_POST['mat_no'], 'lib_no_arr'=>$_POST['lib_no_arr']];
                $this->delTable->insertData($param);
            }
            else{
                $this->delTable->updateData($_POST);
            }
            header('location: /del/list');
        }
        if(isset($_GET['del_no'])){
            $row = $this->delTable->selectID($_GET['del_no']);
            $title2 = ' 수정';
            $title = '상호대차'.$title2;
            return ['tempName'=>'delForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 입력';
            $title = '상호대차'.$title2;
            return ['tempName'=>'delForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }

    public function mempop(){
        if(isset($_POST['user_research'])){
            $value= $_POST['user_research'];
            $where = "WHERE `mem_id` = '$value' OR `mem_name` = '$value'";
            $stmt = $this->memTable->whereSQL($where);
            $result = $stmt->fetchAll();
            $title = '회원 찾기';
            return['tempName'=>'memberList.html.php', 'title'=>$title, 'result'=>$result];
        }
    }

    //MatController 생성후 작성
    public function matpop(){
        if(isset($_POST['user_research'])){
            $value= $_POST['user_research'];
            $where = "WHERE `mat_name` = '$value' OR `mem_name` = '$value'";
            $stmt = $this->memTable->whereSQL($where);
            $result = $stmt->fetchAll();
            $title = '회원 찾기';
            return['tempName'=>'memberList.html.php', 'title'=>$title, 'result'=>$result];
        }
    }

    public function matlibpop(){

    }

    //LentController 생성후 작성
    public function pagelent(){

    }
}
?>