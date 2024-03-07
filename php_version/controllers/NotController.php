<?php
include_once __DIR__.'/../includes/Common.php';
session_start();
class NotController extends Common{
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
    private $today;
    private $sort = "ORDER BY not_no DESC";

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
        $this->today = date("Y-m-d");
        $this->tablename('not');
    }

    //이미지 업로드 전체적으로 관리하는 함수
    private function img_manage(array $post, array $file){
        $cnt = $post['not_no'];
        
        if($file['not_det_url']['name'] != ''){
            $temp_url = explode("/", $post['not_det_url']);
            $not_del_url = end($temp_url);
            if($not_del_url != $file['not_det_url']['name']){
                $path = './img/not/'.$cnt.'/det';
                if (file_exists($path)){
                    $this->delete_img($path);
                }
                //경로를 $_POST['not_det_url']에 저장
                $post['not_det_url'] = $this->img_uplode($file, 'not_det_url', $cnt);
            }
        }
        if($file['not_ban_url']['name'] != ''){
            $temp_url = explode("/", $post['not_ban_url']);
            $not_ban_url = end($temp_url);
            if($not_ban_url != $file['not_ban_url']['name']){
                $path = './img/not/'.$cnt.'/ban';
                if (file_exists($path)){
                    $this->delete_img($path);
                }
                //경로를 $_POST['not_ban_url']에 저장
                $post['not_ban_url'] = $this->img_uplode($file, 'not_ban_url', $cnt);
            }
        }
        if($file['not_pop_url']['name'] != ''){
            $temp_url = explode("/", $post['not_pop_url']);
            $not_pop_url = end($temp_url);
            if($not_pop_url != $file['not_pop_url']['name']){
                $path = './img/not/'.$cnt.'/pop';
                if (file_exists($path)){
                    $this->delete_img($path);
                }
                //경로를 $_POST['not_pop_url']에 저장
                $post['not_pop_url'] = $this->img_uplode($file, 'not_pop_url', $cnt);
            }
        }
        return $post;   
    }

    //이미지 업로드 함수
    private function img_uplode(array $file, string $key_name, string $cnt){
        $tempFile = $file[$key_name]['tmp_name'];
        $fileTypeExt = explode("/", $file[$key_name]['type']);
        $fileType = $fileTypeExt[0];
        $fileExt = $fileTypeExt[1];
        $extStatus = false;

        //이미지 형식 분류 확인
        switch($fileExt){
            case 'jpeg':
            case 'jpg':
            case 'gif':
            case 'bmp':
            case 'png':
                $extStatus = true;
                break;
            default:
                echo "<script>alert('이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다.')</script>";
                exit;
                break;
        }

        //파일이 이미지 인지확인
        if($fileType == 'image'){
            //jpg, bmp, gif, png이면 이미지 업로드
            if($extStatus){
                $split = explode("_", $key_name);
                //디렉토리 경로
                $foldername = './img/not/'.$cnt.'/'.$split[1].'/';
                if (!file_exists($foldername)) {
                    //디렉토리 생성
                    mkdir($foldername, 0777, true);
                }

                //서버에 이미지 파일 저장
                $resFile = "$foldername{$file[$key_name]['name']}";
                $imageUpload = move_uploaded_file($tempFile, $resFile);
                
                if($imageUpload == true){
                    //이미지 파일 성공하면 경로를 리턴
                    return $resFile;
                }else{
                    echo "<script>alert('파일 업로드에 실패하였습니다.')</script>";
                }
            }
            else {
                echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.')</script>";
                exit;
            }	
        }	
        else {
            echo "<script>alert('이미지 파일이 아닙니다.')</script>";
            exit;
        }
    }

    //이미지 삭제 함수
    private function delete_img($path) {
        echo '$path = '.$path.'<br>';
        $dirs = dir($path);

        while(false !== ($entry = $dirs->read())) {
            if(($entry != '.') && ($entry != '..')) {            
                if(is_dir($path.'/'.$entry)) {
                    $this->delete_img($path.'/'.$entry);
                } else {
                    @unlink($path.'/'.$entry);
                }
            }
        }

        $dirs->close();
        @rmdir($path);
    }

    private function sqlList(){
        $sql = '';
        $mem_state = 2;

        if(isset($_SESSION['mem_state'])){
            $mem_state = $_SESSION['mem_state'];
        }
        
        if($mem_state != 1){
            $sql = "WHERE `not_op_date` <= '$this->today' AND `not_cl_date` >= '$this->today' ";
        }

        return $sql;
    }

    public function list(){
        $title = '공지사항 현황';

        $where = $this->sqlList().$this->sort;
        $stmt = $this->notTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);

        $where = $this->pagesql($where);
        $stmt = $this->notTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $pagi = $this->pagemanager($total_cnt, "없음");

        return ['tempName'=>'notList.html.php','title'=>$title,'result'=>$result,'$pagi'=>$pagi];
    }

    public function research(){
        $title = '공지사항 현황';
        $value = '';

        if(isset($_POST['user_research'])){
            $value = '%'.$_POST['user_research'].'%';
        }
        
        if(isset($_GET['value'])){
            $value = $_GET['value'];
        }
        
        $where = $this->sqlList()."AND `not_name` LIKE '$value' ".$this->sort;
        $stmt = $this->notTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $total_cnt = sizeof($result);
        $where = $this->pagesql($where);
        $stmt = $this->notTable->whereSQL($where);
        $result = $stmt->fetchAll();
        $pagi = $this->pagemanager($total_cnt, $value);

        return ['tempName'=>'notList.html.php','title'=>$title,'result'=>$result, 'pagi'=>$pagi];
    }

    public function delete(){
        //이미지 파일부터 삭제
        $path = './img/not/'.$_POST['not_no'];
        if (file_exists($path)){
            $this->delete_img($path);
        }

        $this->notTable->deleteData($_POST['not_no']);
        header('location: /not/list');
    }

    public function addupdate(){
        if(isset($_POST['not_no'])) {
            if($_POST['not_no'] == ''){
                $this->notTable->insertData($_POST);

                $tmp_sql = "SELECT `not_no` FROM `notification`";
                $result = $this->notTable->get_result($tmp_sql);
                foreach ($result as $row) {
                    $_POST['not_no'] = $row['not_no']; 
                }
                $_POST = $this->img_manage($_POST, $_FILES);
                $this->notTable->updateData($_POST);
            }
            else{
                $_POST =  $this->img_manage($_POST, $_FILES);
                $this->notTable->updateData($_POST);
            }
            header('location: /not/list');
        }
        if(isset($_GET['not_no'])){
            $row = $this->notTable->selectID($_GET['not_no']);
            $title2 = ' 수정';
            $title = '공지사항'.$title2;
            return ['tempName'=>'notForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 입력';
            $title = '공지사항'.$title2;
            return ['tempName'=>'notForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }
}
?>