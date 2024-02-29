<?php
include_once __DIR__.'/../includes/Assistance.php';
session_start();
class MemberController{
    private $today;
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
    private $id = 1;
    private $board_sql;
    private $board_sort;

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
        $this->today = date('Y-m-d', time());
        $this->assist = new Assistance();
        $this->assist->listchange(9);
    }

    private function sqlSet(string $table){
        if($table == 'del'){
            $this->board_sql = "SELECT * FROM delivery, material, member, book WHERE delivery.mat_no = material.mat_no AND delivery.mem_no = member.mem_no 
                    AND material.book_no = book.book_no AND del_app = 2 AND del_arr_date IS NULL";
            $this->board_sort = "ORDER BY book.book_name";
        }else{
            $this->board_sql = "SELECT * FROM reservation, material, member, library, book, kind WHERE reservation.mat_no = material.mat_no AND reservation.mem_no = member.mem_no
                    AND material.kind_no = kind.kind_no AND material.book_no = book.book_no AND material.lib_no = library.lib_no";
            $this->board_sort = " ORDER BY library.lib_name, book.book_name";
        }
    }

    //홈화면 함수
    public function home(){
        $title = '도서관 관리';
        $mem_state = 3;

        if(isset($_SESSION['mem_state'])){
            $mem_state = $_SESSION['mem_state'];
        }

        if($mem_state != 1){
            //공지사항
            $sort = "ORDER BY not_no DESC";
            $sql = "WHERE `not_op_date` <= '$this->today' AND `not_cl_date` > '$this->today' $sort"; //배너
            $sql1 = "WHERE `not_op_date` <= '$this->today' $sort"; //공지사항 게시판
            $result = $this->notTable->whereSQL($sql);
            $result1 = $this->notTable->whereSQL($sql1);

            //휴일요일
            if(isset($_GET['lib_no'])){
                $this->id = $_GET['lib_no'];
            }
            $row = $this->libTable->selectID($this->id);
            $close = $row['lib_close'];

            return ['tempName'=>'home.html.php', 'title'=>$title, 'result'=>$result, 'result1'=>$result1, 'close'=>$close];
        }else{
            if(isset($_GET['lib_no'])){
                $this->id = $_GET['lib_no'];
            }
            $this->assist->listchange(3);

            $m_id = $this->id;
            $this->sqlSet("del");
            $del_sql = $this->board_sql." AND lib_no_arr = $m_id ".$this->board_sort;
            $this->sqlSet("res");
            $res_sql = $this->board_sql." AND library.lib_no = $m_id ".$this->board_sort;

            $result = $this->delTable->joinSQL($del_sql);
            $total_cnt = $result->rowCount();

            $result1 = $this->resTable->joinSQL($res_sql);
            $total_cnt1 = $result1->rowCount();

            return ['tempName'=>'home.html.php', 'title'=>$title, 'result'=>$result, 'result1'=>$result1, 'cnt'=>$total_cnt, 'cnt1'=>$total_cnt1];
        }
    }

    public function list(){
        $title = '회원 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        $where = "WHERE `mem_state` NOT LIKE 1";
        $stmt = $this->memTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $where = $this->assist->pagesql($where);
        $stmt = $this->memTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $pagi = $this->assist->pagemanager($total_cnt, '없음');
        
        return ['tempName'=>'memberList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //검색 함수
    public function research(){
        $title = '회원 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        if(isset($_POST)){
            $member = $_POST['user_research'];
        }

        if(isset($_GET['value'])){
            $value = $_GET['value'];
        }

        $where = "WHERE `mem_name` LIKE '$member' OR `mem_id` LIKE '$member' AND `mem_state` NOT LIKE 1";
        $stmt = $this->memTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $where = $this->assist->pagesql($where);
        $stmt = $this->memTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $pagi = $this->assist->pagemanager($total_cnt, $value);
        
        return ['tempName'=>'memberList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    public function login(){
        if(isset($_POST['user_id'])){
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
                header('location: /');
            }
            else{
                echo "<script>alert('아이디와 비밀번호가 일치하지 않습니다.'); history.back();</script>";
            }
        }
        else{
            $title = '로그인';
            return ['tempName'=>'login.html.php', 'title'=>$title];
        }
        
    }

    //로그아숫 함수
    public function logout(){
        //색션 삭제
        $_SESSION = [];
        header('location: /');
    }

    //로그인 필요하면 알림
    public function logalert(){
        echo "<script>alert('로그인을 해주세요.'); location.href='/member/login';</script>";
    }

    //중복아이디인지 확인하는 함수
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

    //회원 탈퇴 함수
    public function memdel(){
        $mem_no = $_GET['mem_no'];
        echo "<script>var msg = '정말로 회원 탈퇴 하시겠습니까?';";
        echo "if(confirm(msg)!=0) {";
        echo "alert('계정 탈퇴가 완료 되었습니다.'); location.href='/member/delete?mem_no=$mem_no'; }";
        echo "else { location.href='/'; }</script>";
    }

    public function delete(){
        if(isset($_POST['mem_no'])){
            $result = $this->memTable->selectID($_POST['mem_no']);
            $mem_state = $result['mem_state'];
            if($mem_state != 1){
                $this->memTable->deleteData($_POST['mem_no']);
                header('location: /member/list');
            }
            else{
                echo "<script>alert('관리자 계정은 삭제가 불가능합니다.'); location.href='/member/list';</script>"; 
            }
        }
        else{
            if(isset($_GET['mem_no'])){
                $this->memTable->deleteData($_GET['mem_no']);
                $_SESSION = [];
                echo "<script>location.href='/';</script>";
            }
        }
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