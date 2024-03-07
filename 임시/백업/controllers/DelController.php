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
        $this->assist->listchange(6);
        $this->assist->tablename('del');
    }

    //게시판형마다 다른 sql 필요해서 정리
    private function sqlList(string $title){
        if($title == '상호대차 완료 현황'){
            $this->sql = $this->sql." AND delivery.len_no IS NOT NULL ";
        }
        else if($title == '상호대차 도착일 추가'){
            $this->sql = $this->sql." AND delivery.del_arr_date IS NULL AND delivery.del_app = 1 ";
        }
        else if($title == '상호대차 승인 거절'){
            $this->sql = $this->sql." AND delivery.del_app IS NULL ";
        }
        else{
            //팝업창 확인
            if(isset($_GET['pop'])){
                if($_GET['pop'] == true){
                    $this->sql = $this->sql." AND len_no IS NULL AND del_arr_date IS NOT NULL ";
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
        $total_cnt = sizeof($result);

        $sql = $this->assist->pagesql($sql);
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $pagi = $this->assist->pagemanager($total_cnt, '없음');

        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //상호대차 완료 목록 출력
    public function completelist(){
        $title = '상호대차 완료 현황';
        
        $this->sqlList($title);
        $sql = $this->sql.$this->sort;
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);
        $this->assist->funName('complete');
        
        $sql = $this->assist->pagesql($sql);
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $pagi = $this->assist->pagemanager($total_cnt, '없음');

        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //상호대차 도착일 추가
    public function addlist(){
        $title = '상호대차 도착일 추가';

        $this->sqlList($title);
        $sql = $this->sql.$this->sort;
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);
        $this->assist->funName('add');
        
        $sql = $this->assist->pagesql($sql);
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $pagi = $this->assist->pagemanager($total_cnt, '없음');

        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //상호대차 승인 거절
    public function aprelist(){
        $title = '상호대차 승인 거절';

        $this->sqlList($title);
        $sql = $this->sql.$this->sort;
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);
        $this->assist->funName('apre');
        
        $sql = $this->assist->pagesql($sql);
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $pagi = $this->assist->pagemanager($total_cnt, '없음');

        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
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
        $this->assist->funName('');

        if(isset($_POST)){
            if($_SESSION['mem_state'] == 1){
                if($_POST['mem_no'] == ''){
                    $mat_no = $_POST['mat_no'];
                    $sql = $this->sql." AND delivery.mat_no = $mat_no";
                    $value = "mat_no=$mat_no";
                }
                else if($_POST['mat_no'] == ''){
                    $mem_no = $_POST['mem_no'];
                    $sql = $this->sql." AND delivery.mem_no = $mem_no";
                    $value = "mem_no=$mem_no";
                }
                else{
                    $mem_no = $_POST['mem_no'];
                    $mat_no = $_POST['mat_no'];
                    $sql = $this->sql." AND delivery.mat_no = $mat_no AND delivery.mem_no = $mem_no";
                    $value = "mat_no=$mat_no,mem_no=$mem_no";
                }
            }
            else{
                $book_name = '%'.$_POST['user_research'].'%';
                $sql = $this->sql." AND book.book_name LIKE '$book_name'";
                $value = "book_name=$book_name";
            }
        }
        
        if(isset($_GET['value'])){
            $value = $_GET['value'];
            $key_array = explode(",",$value);
            if(sizeof($key_array) != 1){
                $mat = explode("=",$key_array[0]);
                $mem = explode("=",$key_array[1]);
                $mat_no = $mat[1];
                $mem_no = $mem[1];
                $sql = $this->sql." AND delivery.mat_no = $mat_no AND delivery.mem_no = $mem_no";
            }
            else{
                $key_array = explode("=",$value);
                if($key_array[0] == "mat_no"){
                    $mat_no = $key_array[1];
                    $sql = $this->sql." AND delivery.mat_no = $mat_no";
                }else if($key_array[0] == "mem_no"){
                    $mem_no = $key_array[1];
                    $sql = $this->sql." AND delivery.mem_no = $mem_no";
                }
                else{
                    $book_name = $key_array[1];
                    $sql = $this->sql." AND book.book_name LIKE '$book_name'";
                }
            }
        }
        
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $sql = $this->assist->pagesql($sql);
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $pagi = $this->assist->pagemanager($total_cnt, $value);
        
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //상호대차 도착일 검색
    public function addresearch(){
        $title = '상호대차 도착일 추가';

        $this->sqlList($title);

        if(isset($_POST)){
            if($_POST['lib_research'] == 0){
                $mat_no = $_POST['mat_no'];
                $sql = $this->sql." AND delivery.mat_no = $mat_no";
                $value = "mat_no=$mat_no";
            }
            else if($_POST['mat_no'] == ''){
                $lib_no = $_POST['lib_research'];
                $sql = $this->sql." AND delivery.lib_no_arr = $lib_no";
                $value = "lib_no=$lib_no";
            }
            else{
                $lib_no = $_POST['lib_research'];
                $mat_no = $_POST['mat_no'];
                $sql = $this->sql." AND delivery.mat_no = $mat_no AND delivery.lib_no_arr = $lib_no";
                $value = "mat_no=$mat_no,lib_no=$lib_no";
            }
        }
        
        if(isset($_GET['value'])){
            $value = $_GET['value'];
            $key_array = explode(",",$value);
            if(sizeof($key_array) != 1){
                $mat = explode("=",$key_array[0]);
                $mem = explode("=",$key_array[1]);
                $mat_no = $mat[1];
                $lib_no = $mem[1];
                $sql = $this->sql." AND delivery.mat_no = $mat_no AND delivery.lib_no_arr = $lib_no";
            }
            else{
                $key_array = explode("=",$value);
                if($key_array[0] == "mat_no"){
                    $mat_no = $key_array[1];
                    $sql = $this->sql." AND delivery.mat_no = $mat_no";
                }else if($key_array[0] == "lib_no"){
                    $lib_no_arr = $key_array[1];
                    $sql = $this->sql." AND delivery.lib_no_arr = $lib_no_arr";
                }
            }
        }
        
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $sql = $this->assist->pagesql($sql);
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $pagi = $this->assist->pagemanager($total_cnt, $value);
        
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //상호대차 승인 거절 검색
    public function apreresearch(){
        $title = '상호대차 승인 거절';

        $this->sqlList($title);

        if(isset($_POST)){
            $lib_no = $_POST['lib_research'];
            if($lib_no != 0){
                $sql = $this->sql." AND material.lib_no = $lib_no ";
                $value = "lib_no=$lib_no";
            }else{
                $sql = $this->sql." ";
                $value = "없음";
            }
        }
        
        if(isset($_GET['value'])){
            $lib_no = $_GET['value'];
            $sql = $this->sql." AND material.lib_no = $lib_no ";
        }

        $sql = $sql.$this->sort;
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $sql = $this->assist->pagesql($sql);
        $stmt = $this->delTable->joinSQL($sql);
        $result = $stmt->fetchAll();
        $pagi = $this->assist->pagemanager($total_cnt, $value);
        
        return ['tempName'=>'delList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    public function delete(){
        $del_no = $_POST['del_no'];
        $row = $this->delTable->selectID($del_no);
        $mat_no = $row['mat_no'];

        $this->delTable->deleteData($del_no);
        $this->assist->existMat($mat_no, 1, $this->lenTable, $this->delTable, $this->matTable);
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
                $mem_no = $_POST['mem_no'];
                $mat_no = $_POST['mat_no'];
                $res_no = '';
                if($this->assist->reservationCheck($res_no, $mat_no, $this->resTable) && $this->assist->lentpossible($mem_no, $this->memTable, $this->lenTable)){
                    if($_POST['del_no'] == ''){
                        $param = ['mem_no'=>$_POST['mem_no'], 'mat_no'=>$_POST['mat_no'], 'lib_no_arr'=>$_POST['lib_no_arr']];
                        $this->delTable->insertData($param);
                        echo "<script>window.close();</script>";
                    }
                    else{
                        if(empty($_POST['del_arr_date']) || empty($_POST['del_app'])){
                            if(!empty($_POST['del_app'])){
                                if($_POST['del_app'] == 0){
                                    $this->assist->existMat($mat_no, 1, $this->lenTable, $this->delTable, $this->matTable);
                                }else{
                                    $this->assist->existMat($mat_no, 0, $this->lenTable, $this->delTable, $this->matTable);
                                }
                                
                                $param = ['del_no'=>$_POST['del_no'], 'mem_no'=>$_POST['mem_no'], 'mat_no'=>$_POST['mat_no'], 'lib_no_arr'=>$_POST['lib_no_arr'], 'del_app'=>$_POST['del_app']];
                                $this->delTable->updateData($param);
                                $param = ['del_arr_date'=>''];
                                $id = $_POST['del_no'];
                                $this->delTable->updateNullData($param, $id);//질문
                            }else{
                                $this->assist->existMat($mat_no, 1, $this->lenTable, $this->delTable, $this->matTable);
                                $param = ['del_no'=>$_POST['del_no'], 'mem_no'=>$_POST['mem_no'], 'mat_no'=>$_POST['mat_no'], 'lib_no_arr'=>$_POST['lib_no_arr']];
                                $this->delTable->updateData($param);
                                $param = ['lib_arr_date'=>'', 'del_app'=>''];
                                $id = $_POST['del_no'];
                                $this->delTable->updateNullData($param, $id);
                            }
                        }
                        else{
                            if(empty($_POST['len_no'])){
                                $param = ['del_no'=>$_POST['del_no'], 'mem_no'=>$_POST['mem_no'], 'mat_no'=>$_POST['mat_no'], 'del_arr_date'=>$_POST['del_arr_date'], 
                                    'lib_no_arr'=>$_POST['lib_no_arr'], 'del_app'=>$_POST['del_app']];
                            }else{
                                $param = ['del_no'=>$_POST['del_no'], 'mem_no'=>$_POST['mem_no'], 'mat_no'=>$_POST['mat_no'], 'del_arr_date'=>$_POST['del_arr_date'], 
                                    'lib_no_arr'=>$_POST['lib_no_arr'], 'del_app'=>$_POST['del_app'], 'len_no'=>$_POST['len_no']];
                            }

                            $this->delTable->updateData($param);
    
                            if($_POST['del_app'] == 2){
                                $this->assist->existMat($mat_no, 1, $this->lenTable, $this->delTable, $this->matTable);
                            }
                        }
                        header('location: /del/list');
                    }
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

    //'상호대차도착일추가'와 '상호대차승인거절'할때 사용 
    public function arrive(){
        $this->delTable->updateData($_POST);
        echo "<script>history.back();</script>";
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

    //대출 정보로 이동
    public function pagelent(){
        $len_no = $_POST['len_no'];
        echo "<script>location.href='/len/listlen?len_no=$len_no'</script>";
    }
}
?>