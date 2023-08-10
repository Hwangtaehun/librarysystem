<?php
session_start();
class MemberController{
    private $memTable;
    private $bookTable;
    private $kindTable;

    public function __construct(TableManager $memTable, TableManager $bookTable, TableManager $kindTable){
        $this->memTable = $memTable;
        $this->bookTable = $bookTable;
        $this->kindTable = $kindTable;
    }

    public function home(){
        //echo 'home 실행<br>';
        if(!isset($_SESSION['mem_state'])) {
            //echo 'mem_state 확인완료<br>';
            $title = '도서관 관리 로그인';
            return ['tempName'=>'login.html.php', 'title'=>$title];
        }
        else {
            $title = '도서관 관리';
            return ['tempName'=>'home.html.php', 'title'=>$title];
        }
    }

    public function list(){
        $result = $this->memTable->selectAll();
        $title = '회원 현황';
        return ['tempName'=>'memberList.html.php','title'=>$title,'result'=>$result];
    }

    public function research(){
        $value = $_POST['user_research'];
        $where = "WHERE `mem_name` LIKE '$value' OR `mem_id` LIKE '$value'";
        $stmt = $this->memTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $title = '회원 현황';
        return ['tempName'=>'memberList.html.php','title'=>$title,'result'=>$result];
    }

    public function login(){
        $mem_id = $_POST['user_id'];
        $mem_pw = $_POST['user_password'];
        $where = "WHERE `mem_id` = '$mem_id' AND `mem_pw` = '$mem_pw'";
        $result = $this->memTable->whereSQL($where);
        $num = $result->rowCount();
    
        if($num != 0){
            $row = $result->fetch();
            $_SESSION['mem_no'] = $row['mem_no'];
            $_SESSION['mem_name'] = $row['mem_name'];
            $_SESSION['mem_state'] = $row['mem_state'];
            header('location: ../index.php');
        }
        else{
            $title = '도서관 관리 로그인';
            echo "<script>alert('아이디와 비밀번호가 일치하지 않습니다.')</script>";
            header('location: ../index.php');
        }
    }

    public function idCheck(){
        $mem_id= $_GET["userid"];
        $where = "WHERE `mem_id` = '$mem_id'";
        $result = $this->memTable->whereSQL($where);
        $num = $result->rowCount();

        if($num == 0){
            echo "<span style='color:blue;'>$mem_id</span> 는 사용 가능한 아이디입니다.";
            echo '<p><input type=button value="이 ID 사용" onclick="opener.parent.decide(); window.close();"></p>';
        }
        else{
            echo "<span style='color:red;'>$mem_id</span> 는 중복된 아이디입니다.";
            echo '<p><input type=button value="다른 ID 사용" onclick="opener.parent.change(); window.close()"></p>';
        }
    }

    public function logout(){
        $_SESSION = [];
        $title = '도서관 관리 로그인';
        header('location: ../index.php');
    }

    public function delete(){
        $result = $this->memTable->selectID($_POST['mem_no']);
        $mem_state = $result['mem_state'];
        if($mem_state != 1){
            $this->memTable->deleteData($_POST['mem_no']);
        }
        else{
            echo "<script>alert('관리자 계정은 삭제가 불가능합니다.')</script>"; 
        }
        header('location: /member/list');
    }

    public function addupdate(){
        if(isset($_POST['mem_no'])) {
            if($_POST['mem_no'] == ''){
                $param = ['mem_name'=>$_POST['mem_name'], 'mem_id'=>$_POST['mem_id'], 'mem_pw'=>$_POST['mem_pw'], 
                        'mem_zip'=>$_POST['mem_zip'], 'mem_add'=>$_POST['mem_add'], 'mem_detail'=>$_POST['mem_detail']];
                $this->memTable->insertData($param);
                header('location: /');
            }
            else{
                $param = ['mem_no'=>$_POST['mem_no'], 'mem_name'=>$_POST['mem_name'], 'mem_id'=>$_POST['mem_id'], 'mem_pw'=>$_POST['mem_pw'], 
                        'mem_zip'=>$_POST['mem_zip'], 'mem_add'=>$_POST['mem_add'], 'mem_detail'=>$_POST['mem_detail']];
                $this->memTable->updateData($param);
                header('location: /member/list');
            }
        }
        if(isset($_GET['mem_no'])){
            $row = $this->memTable->selectID($_GET['mem_no']);
            $title2 = ' 수정';
            $title = '회원'.$title2;
            return ['tempName'=>'memberForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = '등록';
            $title = '회원가입';
            return ['tempName'=>'memberForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }
}
?>