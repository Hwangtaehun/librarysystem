<?php
include_once __DIR__.'/../includes/Controller.php';
session_start();

class LibController extends Controller{
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
        $this->listchange(9);
        $this->tablename('lib');
    }

    //목록
    public function list(){
        $state = 2;
        $title = '도서관 현황';
    
        if(isset($_SESSION['mem_state'])) {
            $state = $_SESSION['mem_state'];
        }

        if($state != 1){
            $title = '도서관 정보';
        }

        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        $where = '';
        $result = $this->libTable->selectAll();
        $total_cnt = sizeof($result);

        $pagi = $this->makePage($this->libTable, $total_cnt, $where, true);
        $result = $this->getResult();

        if($title == '도서관 정보'){
            $lib_no = 1;
            if(isset($_GET['no'])){
                $lib_no = $_GET['no'];
            }

            foreach($result as $row){
                if($row['lib_no'] == $lib_no){
                    $map[0] = $row['lib_name'];
                    $map[1] = $row['lib_url'];
                    return ['tempName'=>'libList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi,'map'=>$map];
                }
            }
        }
        
        return ['tempName'=>'libList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //도서관 세부정보
    public function detail(){
        $row = $this->libTable->selectID($_POST['lib_no']);
        $title = '도서관 정보';
        return ['tempName'=>'libForm.html.php','title'=>$title, 'row'=>$row];
    }

    //검색
    public function research(){
        $title = '도서관 현황';

        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        if(isset($_POST)){
            $value = '%'.$_POST['user_research'].'%';
        }

        if(isset($_GET['value'])){
            $value = $_GET['value'];
        }
        
        $where = "WHERE lib_name LIKE '$value'";
        $stmt = $this->libTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $pagi = $this->makePage($this->libTable, $total_cnt, $where, true);
        $result = $this->getResult();

        return ['tempName'=>'libList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    public function delete(){
        $this->libTable->deleteData($_POST['lib_no']);
        header('location: /lib/list');
    }

    public function addupdate(){
        if(isset($_POST['lib_no'])) {
            if($this->dateformat_check($_POST['lib_date'])){
                setcookie('zip', $_POST['lib_zip']);
                setcookie('add', $_POST['lib_add']);
                echo "<script>alert('날짜형식이 잘못되었습니다.'); history.back();</script>";
            }
            else{
                if($_POST['lib_no'] == ''){
                    $this->libTable->insertData($_POST);
                }
                else{
                    $this->libTable->updateData($_POST);
                }
                header('location: /lib/list');
            }
        }
        if(isset($_GET['lib_no'])){
            $row = $this->libTable->selectID($_GET['lib_no']);
            $title2 = ' 수정';
            $title = '도서관'.$title2;
            return ['tempName'=>'libForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 입력';
            $title = '도서관'.$title2;
            return ['tempName'=>'libForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }
}
?>