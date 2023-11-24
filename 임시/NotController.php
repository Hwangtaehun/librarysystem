<?php
session_start();
class DelController{
    private $sort = "ORDER BY not_no DESC";
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

    private function img_uplode(array $file, string $key_name, int $cnt){
        $split = explode("_", $key_name);
        $filename = $split[1].$cnt;
        $tempFile = $file[$key_name]['tmp_name'];
        $fileTypeExt = explode("/", $file[$key_name]['type']);
        $fileType = $fileTypeExt[0];
        $fileExt = $fileTypeExt[1];
        $extStatus = false;

        switch($fileExt){
            case 'jpeg':
            case 'jpg':
            case 'gif':
            case 'bmp':
            case 'png':
                $extStatus = true;
                $filename .= '.'.$fileExt;
                break;
            default:
                echo "<script>alert('이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다.')</script>";
                exit;
                break;
        }
        echo '$filename = '.$filename.'<br>';
        if($fileType == 'image'){
            if($extStatus){
                $resFile = "../img/not/$filename";
                $imageUpload = move_uploaded_file($tempFile, $resFile);
                
                if($imageUpload == true){
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

    public function list(){
        $title = '공지사항 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        $stmt = $this->notTable->whereSQL($this->sort);
        $result = $stmt->fetchAll();

        return ['tempName'=>'notList.html.php','title'=>$title,'result'=>$result];
    }

    public function research(){
        $title = '공지사항 현황';
        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }

        $value = '%'.$_POST['user_research'].'%';
        $sql = "WHERE `notification` LIKE '$value' ".$this->sort;
        $stmt = $this->notTable->whereSQL($sql);
        $result = $stmt->fetchAll();

        return ['tempName'=>'notList.html.php','title'=>$title,'result'=>$result];
    }

    public function delete(){
        $this->notTable->deleteData($_POST['not_no']);
        header('location: /not/list');
    }

    public function addupdate(){
        if(isset($_POST['not_no'])) {
            if($_POST['not_no'] == ''){
                $tmp_sql = "SELECT * FROM `notification`";
                $temp_result = $this->notTable->get_result($tmp_sql);
                $cnt = $temp_result->rowCount();
                if(isset($_POST['not_ban_url'])){
                    $_POST['not_ban_url'] = $this->img_uplode($_FILES, 'not_ban_url', $cnt);
                }
                if(isset($_POST['not_pop_url'])){
                    $_POST['not_pop_url'] = $this->img_uplode($_FILES, 'not_pop_url', $cnt);
                }
                $this->notTable->insertData($_POST);
            }
            else{
                if(isset($_POST['not_ban_url'])){
                    $_POST['not_ban_url'] = $this->img_uplode($_FILES, 'not_ban_url', $_POST['not_no']);
                }
                if(isset($_POST['not_pop_url'])){
                    $_POST['not_pop_url'] = $this->img_uplode($_FILES, 'not_pop_url', $_POST['not_no']);
                }
                $this->notTable->updateData($_POST);
            }
            header('location: /not/list');
        }
        if(isset($_GET['not_no'])){
            $row = $this->notTable->selectID($_GET['not_no']);
            $title2 = ' 수정';
            $title = '공지사항'.$title2;
            return ['tempName'=>'bookForm.html.php','title'=>$title, 'title2'=>$title2, 'row'=>$row];
        }
        else{
            $title2 = ' 입력';
            $title = '공지사항'.$title2;
            return ['tempName'=>'bookForm.html.php', 'title'=>$title, 'title2'=>$title2];
        }
    }
}
?>