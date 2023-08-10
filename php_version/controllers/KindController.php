<?php
session_start();
class kindController{
    private $memTable;
    private $bookTable;
    private $kindTable;

    public function __construct(TableManager $memTable, TableManager $bookTable, TableManager $kindTable){
        $this->memTable = $memTable;
        $this->bookTable = $bookTable;
        $this->kindTable = $kindTable;
    }

    public function list(){
        $result = $this->kindTable->selectAll();
        $title = '종류 현황';
        return ['tempName'=>'kindList.html.php','title'=>$title,'result'=>$result];
    }

    public function research(){
        $value = '%'.$_POST['user_research'].'%';
        $where = "WHERE `kind_name` LIKE '$value'";
        $stmt = $this->kindTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $title = '종류 현황';
        return ['tempName'=>'kindList.html.php','title'=>$title,'result'=>$result];
    }

    private function makeKey(String $str, bool $bool) {
        include_once __DIR__.'../includes/Assistance.php';
        $assist = new Assistance();
        $text = "문제발생";
        
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
            $sql = "WHERE `kind_num` LIKE '$key'";
            $result = $this->kindTable->whereSQL($sql);
            $row = $result->fetchAll();
            $num = $result->rowCount();
            $text = $row[$num][0];

            if($assist->isInteger($text)) {
                $text=$text.".1";
            }
            else {
                if($assist->isFloat($text)) {
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
            
            

            if($_POST['kind_no'] == ''){
                $param = ['kind_no'=>$kind_no, 'kind_name'=>$_POST['kind_name']];
                $this->kindTable->insertData($param);
            }
            else{
                $pk = $_POST['kind_no'];
                $param = ['kind_no'=>$kind_no, 'kind_name'=>$_POST['kind_name'], 'pk'=>$pk];
                $this->kindTable->updateData($_POST);
            }
            header('location: /kind/list');
        }
        if(isset($_GET['kind_no'])){
            $row = $this->kindTable->selectID($_GET['mem_no']);
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