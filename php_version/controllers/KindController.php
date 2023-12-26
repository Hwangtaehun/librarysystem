<?php
include_once __DIR__.'/../includes/Assistance.php';
session_start();
class kindController{
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
    private $listnum = 19;

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

    private function pagemanager(int $total_cnt, string $value){
        $pagenum = 19;
        $outStr= '';

        if(20 < $total_cnt){
            $total_pages = floor($total_cnt/$this->listnum);
            $sp_pg = ceil($total_pages/$pagenum);

            if(isset($_GET['sup_pg'])){
                $sup_pg = $_GET['sup_pg'];
            }
            else{
                $sup_pg = 0;
            }

            if(isset($_GET['page'])){
                $m_page = $_GET['page'];
            }
            else{
                $m_page = 1;
            }
            
            if($value == '없음'){           
                $outStr = '<div class="page"> <div aria-label="Page navigation example"> <ul class="pagination justify-content-center"> <ul class="pagination">';
                if($sup_pg != 0){
                    $go_pg = $sup_pg - 1;
                    $outStr .= '<li class="page-item"> <a class="page-link" href="/kind/list?sup_pg='.$go_pg.'&page='.$m_page.'" aria-label="Previous"> 
                                <span aria-hidden="true">&laquo;</span> </a> </li>';
                }
                for ($i=0; $i < 19 ; $i++) { 
                    $num = $i + 1;
                    $go_pg = $sup_pg;
                    $page = $sup_pg * 19 + $num;

                    if($page <= $total_pages){
                        if($page < 10){
                            $str_num = '0'.$page;
                        }else{
                            $str_num = strval($page);
                        }

                        $start_num = ($page - 1) * $this->listnum + 1;
                        
                        $outStr .= '<li class="page-item"><a class="page-link" href="/kind/list?sup_pg='.$go_pg.'&page='.$start_num.'">'.$str_num.'</a></li>';
                    }
                }

                if($sup_pg != $sp_pg-1){
                    $go_pg = $sup_pg + 1;
                    $outStr .= '<li class="page-item"> <a class="page-link" href="/kind/list?sup_pg='.$go_pg.'&page='.$m_page.'" aria-label="Next"> 
                                <span aria-hidden="true">&raquo;</span> </a> </li>';
                }

                $outStr .= '</ul> </ul> </div> </div>';
            }else{
                $outStr = '<div class="page"> <div aria-label="Page navigation example"> <ul class="pagination justify-content-center"> <ul class="pagination">';
                if($sup_pg != 0){
                    $go_pg = $sup_pg - 1;
                    $outStr .= '<li class="page-item"> <a class="page-link" href="/kind/research?sup_pg='.$go_pg.'&page='.$m_page.'&value='.$value.'" aria-label="Previous"> 
                                <span aria-hidden="true">&laquo;</span> </a> </li>';
                }
                for ($i=0; $i < 19 ; $i++) { 
                    $num = $i + 1;
                    $go_pg = $sup_pg;
                    $page = $sup_pg * 19 + $num;

                    if($page <= $total_pages){
                        if($page < 10){
                            $str_num = '0'.$page;
                        }else{
                            $str_num = strval($page);
                        }

                        $start_num = ($page - 1) * $this->listnum + 1;
                        $outStr .= '<li class="page-item"><a class="page-link" href="/kind/research?sup_pg='.$go_pg.'&page='.$start_num.'&value='.$value.'">'.$str_num.'</a></li>';
                    }
                }

                if($sup_pg != $sp_pg-1){
                    $go_pg = $sup_pg + 1;
                    $outStr .= '<li class="page-item"> <a class="page-link" href="/kind/research?sup_pg='.$go_pg.'&page='.$m_page.'&value='.$value.'" aria-label="Next"> 
                                <span aria-hidden="true">&raquo;</span> </a> </li>';
                }

                $outStr .= '</ul> </ul> </div> </div>';
            }
        }
        return $outStr;
    }

    private function pagesql(string $value){
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        else{
            $page = 1;
        }

        $limit = "LIMIT $page,$this->listnum";

        if($value == '없음'){
            $where = $limit;
        }else{
            $where = "WHERE `kind_no` LIKE '$value'".$limit;
        }

        return $where;
    }

    public function list(){
        $m_result = $this->kindTable->selectAll();
        $total_cnt = sizeof($m_result);
        $where = $this->pagesql('없음');
        $result = $this->kindTable->whereSQL($where);
        $title = '종류 현황';
        $page = $this->pagemanager($total_cnt, '없음');
        return ['tempName'=>'kindList.html.php','title'=>$title,'result'=>$result, 'page'=>$page];
    }

    //검색
    public function research(){
        if(isset($_POST['sup'])){
            $value = $_POST['sup'];
            if($value == 0){
                if($_POST['base'] == 0){
                    if($_POST['super'] == 0){
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
        }else if(isset($_GET['value'])){
            $value = $_GET['value'];
        }

        $where = ' ';
        if($value != '없음'){
            $where = "WHERE `kind_no` LIKE '$value'";
        }

        $stmt = $this->kindTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);
        $where = $this->pagesql($value);
        $stmt = $this->kindTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $title = '종류 현황';
        $page = $this->pagemanager($total_cnt, $value);
        return ['tempName'=>'kindList.html.php','title'=>$title,'result'=>$result, 'page'=>$page];
    }

    //중분류 종류번호 생성 및 소분류 종류번호 생성
    private function makeKey(String $str, bool $bool) {
        $assist = new Assistance();
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