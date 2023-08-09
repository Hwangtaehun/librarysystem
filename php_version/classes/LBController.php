<?php
class LBController
{
    private $memTable;
    
    public function __construct(TableManager $memTable){
        $this->memTable = $memTable;
    }

    public function home(){
        $title = '도서관 관리';
        ob_start(); 
        include __DIR__.'../templates/home.html.php';
        $outString = ob_get_clean();
        include __DIR__.'../templates/layout.html.php';

        return ['outString'=>$outString, 'title'=>$title];
    }

    public function loginout(){
        if(!isset($_SESSION['mem_state'])) {
            $mem_id = $_POST['user_id'];
            $mem_pw = $_POST['user_password'];
            $sql = "SELECT * FROM `member` WHERE `mem_id` = '$mem_id' AND `mem_pw` = '$mem_pw'";
        
            $result = $this->memTable->get_result($sql);
            $num = $result->rowCount();
        
            if($num != 0){
                $row = $result->fetch();
                $_SESSION['mem_no'] = $row['mem_no'];
                $_SESSION['mem_name'] = $row['mem_name'];
                $_SESSION['mem_state'] = $row['mem_state'];
                header('location: ../index.php');
                exit;
            }
            else{
                echo "<script>alert('아이디와 비밀번호가 일치하지 않습니다.')</script>";
                header('location: ../index.php');
                exit;
            }
        }
        else {
            $_SESSION = [];
            header('location: ../index.php');
            exit;
        }
    }

    public function memberAddUpdate(){
        if(isset($_POST['mem_no'])) {
            if($_POST['mem_no'] == ''){
                $param = ['mem_name'=>$_POST['mem_name'], 'mem_id'=>$_POST['mem_id'], 'mem_pw'=>$_POST['mem_pw'], 
                        'mem_zip'=>$_POST['mem_zip'], 'mem_add'=>$_POST['mem_add'], 'mem_detail'=>$_POST['mem_detail']];
                $this->memTable->insertData($param);
                header('location: ../index.php');
            }
            else{
                $param = ['mem_no'=>$_POST['mem_no'], 'mem_name'=>$_POST['mem_name'], 'mem_id'=>$_POST['mem_id'], 'mem_pw'=>$_POST['mem_pw'], 
                        'mem_zip'=>$_POST['mem_zip'], 'mem_add'=>$_POST['mem_add'], 'mem_detail'=>$_POST['mem_detail']];
                $this->memTable->updateData($param);
                header('location: ../index.php?func=memberList');
            }
        }
    }
}
?>