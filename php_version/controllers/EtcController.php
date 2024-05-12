<?php
session_start();

class EtcController{
    private $sql = "SELECT * FROM overdue, lent, material, member, book WHERE overdue.len_no = lent.len_no AND lent.mat_no = material.mat_no 
                    AND lent.mem_no = member.mem_no AND material.book_no = book.book_no";
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
    }

    //연체 페이지 불러오는 함수
    public function duelist(){
        $title = '연체 현황';
        return ['tempName'=>'dueList.html.php','title'=>$title];
    }

    //장소 페이지를 불러오는 함수
    public function plalist(){
        $title = '대출 장소 현황';
        return ['tempName'=>'plaList.html.php','title'=>$title];
    }

    //연체 검색
    public function dueresearch(){
        $value = $_POST['mem_no'];
        $sql= $this->sql." AND lent.mem_no = $value";
        $stmt = $this->dueTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $title = '연체 현황';
        return ['tempName'=>'dueList.html.php','title'=>$title,'result'=>$result];
    }

    //장소 검색
    public function plaresearch(){
        $value = $_POST['len_no'];
        $where = "WHERE len_no = $value";
        $stmt = $this->plaTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $title = '대출 장소 현황';
        return ['tempName'=>'plaList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $this->dueTable->deleteData($_POST['due_no']);
        $mem_no = $_POST['mem_no'];
        $param = ['mem_no'=>$mem_no, 'mem_state'=>0];
        $this->memTable->updateData($param);
        $sql= $this->sql." AND lent.mem_no = $mem_no";
        $stmt = $this->dueTable->joinSQL($sql);
        $count = $stmt->rowCount();
        if($count != 0){
            $param = ['mem_no'=>$mem_no, 'mem_state'=>2];
            $this->memTable->updateData($param);
        }
        header('location: /etc/duelist');
    }

    public function addupdate(){
        if(isset($_POST['pla_no'])) {
            $this->plaTable->updateData($_POST);
            header('location: /etc/plalist');
        }
        else if(isset($_POST['due_no'])){
            
            if(empty($_POST['due_exp'])){
                $param = ['due_exp'=>''];
                $this->dueTable->updateNullData($param, $_POST['due_no']);
            }else{
                $this->dueTable->updateData($_POST);
            }
            
            header('location: /etc/duelist');
        }

        if(isset($_GET['pla_no'])){
            $row = $this->plaTable->selectID($_GET['pla_no']);
            $title2 = ' 수정';
            $title = '대출 장소'.$title2;
            return ['tempName'=>'plaForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else if(isset($_GET['due_no'])){
            $due_no = $_GET['due_no'];
            $sql = $this->sql." AND overdue.due_no = $due_no";
            $stmt = $this->delTable->joinSQL($sql);
            $row =  $stmt->fetch();
            $title2 = ' 수정';
            $title = '연체'.$title2;
            return ['tempName'=>'dueForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
    }
}
?>