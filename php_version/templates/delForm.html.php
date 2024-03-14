<!DOCTYPE html>
<html>
<head>
    <?php
    if($title == '상호대차 신청'){
        echo '<link rel="stylesheet" href="../css/form-popup.css">';
        $ispop = true;
    }
    else{
        echo '<link rel="stylesheet" href="../css/form-base.css">';
        $ispop = false;
    }
    ?>
    
    <script>
        <?php
        $mem_state = $_SESSION['mem_state'];
        ?>

        // 필수 입력 확인하는 함수
        function checkInput(myform) {
            if(myform.ib_name.value.length <= 0){
                alert("책 정보를 찾아주세요.");
                myform.id_name.focus();
                return false;
            }
            return true;
        }

        //자료검색 팝업창 생성
        function checkmat() {
            url = "/len/matpop";
            window.open(url,"chkbk","width=500,height=445");
        }

        //팝업창에 찾은 내용을 웹페이지에게 넘기는 함수
        function matValue(no, name){
            document.querySelector("#id_mem").value = no;
            document.querySelector("#ib_name").value = name;
        }

        //쿠키 받는 함수
        function getCookie(key){
            key = new RegExp(key + '=([^;]*)');
            return key.test(document.cookie) ? unescape(RegExp.$1) : '';
        }
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';
    $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", false);
    $lib = $lib_man->result_call();
?>
<body>
    <form action="/del/addupdate" method="post" onSubmit="return checkInput(this)" onReset="return checkReset()">
        <fieldset id = form_fieldset>
            <?php if(!$ispop){?>
            <h2><?=$title?></h2>
            <?php } ?>
            <div class="form_text">
                <ul>
                    <li><label for  ="ib_name">책이름</label><br>
                        <input class="input" type="text" name="book_name" id="ib_name" value="<?php if(isset($row)){echo $row['book_name'];}elseif(isset($m_row)){echo $m_row['book_name'];}?>" readonly>
                    <!-- 수정할때만 생성 -->
                    <?php if(!isset($_GET['mat_no'])){ ?>
                        <input type="button" name="mat_check" id="mat_check" value="자료 찾기" onclick="checkmat();">
                    <?php } ?></li>
                    <li><?php if(isset($m_row['lib_no'])) {
                        $lib_arr[0] = '없음';
                        for ($z=0; $z < sizeof($lib); $z++) { 
                            $lib_arr[$z+1] = $lib[$z][1];
                        }
                        $value = $lib_arr[$m_row['lib_no']];?>
                        <label>소장도서관</label><br>
                        <input type="text" value="<?php echo $value; ?>" readonly>
                    <?php } ?>
                        <label for ="il_no">수신도서관</label><br>
                        <select id ="il_no" name="lib_no_arr">
                            <?php
                            for($z = 0; $z < sizeof($lib); $z++){
                                $no[$z] = $lib[$z][0]; 
                                $name[$z] = $lib[$z][1];
                            }
                            for($z = 0;$z < sizeof($lib); $z++){
                                echo "<option  value = $no[$z] > $name[$z] </option>";
                            }
                            ?>
                        </select></li>
                    <!-- 수정할때만 생성 -->
                    <?php if(isset($row)){ ?>
                    <li><label for ="id_arr_date">도착일</label><br>
                        <input type="date" name="del_arr_date" id="id_arr_date" value="<?php echo $row['del_arr_date']; ?>"></li>
                    <li><label>상태</label><br>
                        <input type="radio" name="del_app" id="id_st" value=""> 대기
                        <input type="radio" name="del_app" id="id_de" value="0"> 거절
                        <input type="radio" name="del_app" id="id_ap" value="1"> 승인
                        <input type="radio" name="del_app" id="id_re" value="2"> 반송</li>
                    <?php }?> 
                    <input type="hidden" name="len_no" value="<?php if(isset($row)){echo $row['len_no'];}?>">
                    <input type="hidden" id="id_mem" name="mem_no" value="<?php if(isset($row)){echo $row['mem_no'];}else if($mem_state == 0){echo $_SESSION['mem_no'];}?>">
                    <input type="hidden" id="id_mat" name="mat_no" value="<?php if(isset($row)){echo $row['mat_no'];}else if(isset($_GET['mat_no'])){echo $_GET['mat_no'];}?>">
                    <input type="hidden" name="del_no" value="<?php if(isset($row)){echo $row['del_no'];}?>">
                    <div class="form_bt">
                        <input type= "submit" value="<?= $title2 ?>">
                        <input type= "reset" value='지우기'>
                    </div>
                </ul>
            </div>
        </fieldset>
    </form>
</body>
<script>
    <?php
    //도착 도서관 값 할당하는 함수
    if(isset($row['lib_no_arr'])){
        echo "const li = document.querySelector('#il_no');";
        $lib_no = $row['lib_no_arr'];
        echo "var lib_no = $lib_no;";
        echo "li.value = lib_no;";
    }

    //라디오 버튼 값 할당하는 함수
    if(isset($row['del_app'])){ ?>
        const st = document.querySelector('#id_st');
        const de = document.querySelector('#id_de');
        const ap = document.querySelector('#id_ap');
        const re = document.querySelector('#id_re');
    <?php
        $del_app = $row['del_app'];
        if($del_app == ''){
            echo "st.checked = true;";
        }
        else if($del_app == 0){
            echo "de.checked = true;";
        }
        else if($del_app == 1){
            echo "ap.checked = true;";
        }
        else{
            echo "re.checked = true;";
        }
    }?>    
</script>
</html>