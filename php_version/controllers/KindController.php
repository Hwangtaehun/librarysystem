<?php
include_once __DIR__.'/../includes/Controller.php';
session_start();

class kindController extends Controller{
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

    public function list(){
        $title = '종류 현황';

        $where = '';
        $result = $this->kindTable->selectAll();
        $total_cnt = sizeof($result);

        $pagi = $this->makePage($this->kindTable, $total_cnt, $where, true);
        $result = $this->getResult();

        return ['tempName'=>'kindList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //검색
    public function research(){
        $title = '종류 현황';
        
        if(isset($_POST['sup'])){
            $value = $_POST['sup'];
            if($value === '0'){
                if($_POST['base'] === '0'){
                    if($_POST['super'] === '0'){
                        $value = '없음';
                    }else{
                        $array = mb_str_split($_POST['super'], $split_length = 1, $encoding = "utf-8");
                        $value = $array[0].'__';
                    }
                }
                else{
                    $array = mb_str_split($_POST['base'], $split_length = 1, $encoding = "utf-8");
                    $value = $array[0].$array[1].'_'; 
                }
            }
        }
        
        if(isset($_GET['value'])){
            $value = $_GET['value'];
        }

        $where = '';
        if($value != '없음'){
            $where = "WHERE `kind_no` LIKE '$value'";
        }

        $stmt = $this->kindTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $pagi = $this->makePage($this->kindTable, $total_cnt, $where, true);
        $result = $this->getResult();
        
        return ['tempName'=>'kindList.html.php','title'=>$title,'result'=>$result,'pagi'=>$pagi];
    }

    //중분류 종류번호 생성 및 소분류 종류번호 생성
    private function makeKey(String $str, bool $bool) {
        $text = "중분류";
        if($bool) {
            $array = mb_str_split($str, $split_length = 1, $encoding = "utf-8");
            $final_position = $array[2];
            $num = (int)$final_position;
            if($num > 8) {
                return $text;
            }
            $num++;
            $text = $array[0].$array[1].$num;
        }
        else {
            $key = $str.'%';
            $sql = "WHERE `kind_no` LIKE '$key'";
            $result = $this->kindTable->whereSQL($sql);
            $row = $result->fetchAll();
            $num = $result->rowCount();
            $text = $row[$num-1][0];

            if($this->isInteger($text)) {
                $text=$text.".1";
            }
            else {
                if($this->isFloat($text)) {
                    $str_array = explode( '.', $text );
                    $num = (int)$str_array[1];
                    $num++;
                    $text = $str_array[0].".".$num; 
                }
                else {
                    $text = "문제발생";
                }
            }
        }
        return $text;
    }

    public function delete(){
        $this->kindTable->deleteData($_POST['kind_no']);
        header('location: /kind/list');
    }

    public function addupdate(){
        if(isset($_POST['kind_no'])) {
            $key = $_POST['sup'];
            if($key == '0'){
                $key = $_POST['base'];
                $array = mb_str_split($key, $split_length = 1, $encoding = "utf-8");
                $num = $array[0].$array[1].'_';
                $where = "WHERE `kind_no` LIKE '$num'";
                $result = $this->kindTable->whereSQL($where);
                $row = $result->fetchAll();

                for ($i=0; $i < sizeof($row) ; $i++) { 
                    $num = $row[$i][0];
                    $num_array = mb_str_split($num, $split_length = 1, $encoding = "utf-8");
                    if($i != (int)$num_array[2]){
                        $key = $num;
                        break;
                    }
                    $key = $num;
                }
                $kind_no = $this->makeKey($key, true);
            }
            else{
                $kind_no = $this->makeKey($key, false);
            }
            
            if($kind_no == "문제발생"){
                echo "<script>alert('오류발생 했습니다.'); history.back();</script>";
            }
            else if($kind_no == "중분류"){
                echo "<script>alert('중분류에 등록 수가 초과로 인해 등록이 불가능합니다.'); location.href='/kind/list'</script>";
            }
            else{
                if($_POST['kind_no'] == ''){
                    $param = ['kind_no'=>$kind_no, 'kind_name'=>$_POST['kind_name']];
                    $this->kindTable->insertData($param);
                }
                else{
                    $pk = $_POST['kind_no'];
                    $kind_name = $_POST['kind_name'];
                    $sql = "UPDATE `kind` SET `kind_no` = '$kind_no', `kind_name` = '$kind_name' WHERE `kind_no` = '$pk'";
                    $this->kindTable->delupdateSQL($sql);
                }
                header('location: /kind/list');
            }
        }
        if(isset($_GET['kind_no'])){
            $row = $this->kindTable->selectID($_GET['kind_no']);
            $title2 = ' 수정';
            $title = '종류'.$title2;
            return ['tempName'=>'kindForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 입력';
            $title = '종류'.$title2;
            return ['tempName'=>'kindForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }
}
?>