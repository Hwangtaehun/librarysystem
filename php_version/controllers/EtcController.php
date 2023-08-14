<?php
session_start();
class EtcController{
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
    private $sql = "SELECT * FROM overdue, lent, material, member, library, book, kind WHERE overdue.len_no = lent.len_no AND lent.mat_no = material.mat_no AND lent.mem_no = member.mem_no 
                    AND material.lib_no = library.lib_no AND material.book_no = book.book_no AND material.kind_no = kind.kind_no";
    private $sort = " ORDER BY mem_id";

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

    public function duelist(){
        $sql= $this->sql.$this->sql;
        $stmt = $this->dueTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $title = '연체 현황';
        return ['tempName'=>'dueList.html.php','title'=>$title,'result'=>$result];
    }

    public function plalist(){
        $result = $this->plaTable->selectAll();
        $title = '대출 장소 현황';
        return ['tempName'=>'plaList.html.php','title'=>$title,'result'=>$result];
    }

    public function dueresearch(){
        $value = $_POST['user_id'];
        $sql= $this->sql." AND lent.mem_no = $value".$this->sql;
        $stmt = $this->dueTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $title = '연체 현황';
        return ['tempName'=>'dueList.html.php','title'=>$title,'result'=>$result];
    }

    public function plaresearch(){
        $value = $_POST['user_id'];
        $where = "WHERE len_no = $value";
        $stmt = $this->plaTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $title = '대출 장소 현황';
        return ['tempName'=>'plaList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $this->dueTable->deleteData($_POST['due_no']);
        $param = ['mem_state'=>0];
        $this->memTable->updateData($param);
        header('location: /etc/duelist');
    }

    public function addupdate(){
        if(isset($_POST['pla_no'])) {
            $this->plaTable->updateData($_POST);
            header('location: /etc/plalist');
        }
        else if(isset($_POST['due_no'])){
            $this->dueTable->updateData($_POST);
            header('location: /etc/duelist');
        }

        if(isset($_GET['pla_no'])){
            $row = $this->plaTable->selectID($_GET['pla_no']);
            $title2 = ' 수정';
            $title = '대출 장소'.$title2;
            return ['tempName'=>'plaForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else if(isset($_GET['due_no'])){
            $row = $this->dueTable->selectID($_GET['due_no']);
            $title2 = ' 수정';
            $title = '연체'.$title2;
            return ['tempName'=>'plaForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }

        
    }

    public function mempop(){
        // $result = $this->memTable->selectAll();
        // $title = '회원찾기';
        // return ['tempName'=>'memberList.html.php','title'=>$title,'result'=>$result];
        echo "<script>location.href='/member/list?title=회원찾기';</script>";
    }

    public function lenpop(){
        // $result = $this->lenTable->selectAll();
        // $title = '대출찾기';
        // return ['tempName'=>'lenList.html.php','title'=>$title,'result'=>$result];
        echo "<script>location.href='/len/list?title=대출찾기';</script>";
    }

    public function libraryarray(){
        $num = 1;
        $result = $this->libTable->selectAll();
        $lib_array[0] = '없음';
        foreach($result as $row):
            $lib_array[$num] = $row['lib_name'];
            $num++;
        endforeach;
        return $lib_array;
    }
}
?>