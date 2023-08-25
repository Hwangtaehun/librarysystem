<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel = "stylesheet" herf = "../css/form.css">
    <title><?=$title?></title>
    <script>
        <?php
        echo 'var state = '.$_SESSION['mem_state'];
        ?>

        function checkInput(myform) {
            if(myform.im_id.value.length <= 0){
                alert("아이디를 찾아주세요.");
                myform.im_id.focus();
                return false;
            }
            if(myform.ib_name.value.length <= 0){
                alert("책 정보를 찾아주세요.");
                myform.ib_name.focus();
                return false;
            }
            if(myform.id_sta.value == '2'){
                alert("정지된 계정이어서 대출이 불가능합니다.");
                myform.im_id.focus();
                return false;
            }
            if(myform.mi_many.value.length <= 0){
                document.getElementById("mi_many").value = '0';
            }
            return true;
        }

        function checkmem() {
            url = "/len/mempop";
            window.open(url,"chkme","width=400,height=200");
        }

        function checkmat() {
            url = "/len/matpop";
            window.open(url,"chkma","width=400,height=200");
        }

        function checkdel() {
            url = "/len/delpop";
            window.open(url,"chkde","width=400,height=200");
        }

        function checkres() { //reservation의 template을 완성후 사용해보기
            // url = "/len/respop";
            // window.open(url,"chkde","width=400,height=200");
        }

        function memValue(no, name, state){
            document.getElementById("id_mem").value = no;
            document.getElementById("im_id").value = name;
            document.getElementById("id_sta").value = state;
        }

        function matValue(no, name){
            document.getElementById("id_mat").value = no;
            document.getElementById("ib_name").value = name;
        }

        function delValue(mem, id, mat, book, del){
            document.getElementById("id_mem").value = mem;
            document.getElementById("im_id").value = id;
            document.getElementById("id_mat").value = mat;
            document.getElementById("ib_name").value = book;
            document.getElementById("id_del").value = del;
        }
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';
    $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", false);
    $lib = $lib_man->result_call();
?>
<body>
    <form action="/len/addupdate" method="post" onSubmit="return checkInput(this)" onReset="return checkReset()">
        <fieldset id = form_fieldset>
        <legend>아래 내용을 <?= $title2 ?>하세요.</legend>
            <ul><?php
                    if($title == '대출 추가'){
                ?>
                <input type="button" name="del_check" id="ide_check" value="상호대차" onclick="checkdel();">
                <input type="button" name="del_check" id="ide_check" value="예약" onclick="checkdel();"><br>
                <?php
                    }
                ?>
                <label for ="mem_id">회원아이디</label>
                <input type="text" name="mem_id" id="im_id" value="<?php if(isset($row)){echo $row['mem_id'];}?>" readonly>
                <input type="button" name="mem_check" id="im_check" value="회원 찾기" onclick="checkmem();"><br>
                <?php
                    if($title == '대출 추가'){
                ?>
                <label for ="lib_name">대출 도서관</label>
                <select id ="il_no" name="lib_no">
                    <?php
                    for($z = 0; $z < sizeof($lib); $z++){
                        $no[$z] = $lib[$z][0]; 
                        $name[$z] = $lib[$z][1];
                    }
                    for($z = 0;$z < sizeof($lib); $z++){
                        echo "<option  value = $no[$z] > $name[$z] </option>";
                    }
                    ?>
                </select><br>
                <?php
                    }
                ?>
                <label for ="book_name">책이름</label>
                <input type="text" name="book_name" id="ib_name" value="<?php if(isset($row)){echo $row['book_name'];}?>" readonly>
                <input type="button" name="mat_check" id="mat_check" value="자료 찾기" onclick="checkmat();"><br>
                <?php if(isset($row)){ ?>
                    <label for ="len_date">대출일</label>
                    <input type="date" name="len_date" id="id_date" value="<?php echo $row['len_date']; ?>"><br>
                <?php }?>
                <label for ="len_ex">연장여부</label>
                <input type="radio" name="len_ex" id="id_extend" value="7"> 예 
                <input type="radio" name="len_ex" id="id_normal" value="0"> 아니요<br>
                <?php if(isset($row)){ ?>
                <label for ="len_ex">반납일</label>
                <input type="date" name="len_re_date" id="id_re_date" value="<?php echo $row['len_re_date']; ?>"><br>
                <label for ="len_ex">반납상태</label>
                <input type="radio" name="len_re_st" id="id_lent" value="0"> 대출중
                <input type="radio" name="len_re_st" id="id_return" value="1"> 반납
                <input type="radio" name="len_re_st" id="id_etc" value="2"> 기타 <br>
                <label for ="len_ex">메모</label>
                <input type="text" name="len_memo" id="id_memo" value="<?php echo $row['len_memo']; ?>"><br>
                <?php }?> 
                <input type="hidden" name="len_no" value="<?php if(isset($row)){echo $row['len_no'];}?>">
                <input type="hidden" id="id_mem" name="mem_no" value="<?php if(isset($row)){echo $row['mem_no'];}?>">
                <input type="hidden" id="id_sta" name="mem_state" value="<?php if(isset($row)){echo $row['mem_state'];}?>">
                <input type="hidden" id="id_mat" name="mat_no" value="<?php if(isset($row)){echo $row['mat_no'];}?>">
                <?php if($title == '대출 추가'){ ?>
                <input type="hidden" id="id_del" name="del_no" value="<?php if(isset($row)){if(!empty($row['del_no'])){echo $row['del_no'];}}?>">
                <?php } ?>
                <input type="hidden" id="id_res" name="res_no" value="<?php if(isset($row)){echo $row['mat_no'];}?>">
            </ul>
            <div class="form_class">
                <input type= "submit" value="<?= $title2 ?>">
                <input type= "reset" value='지우기'>
            </div>
        </fieldset>
    </form>
    <script>
    <?php
    if(isset($row)){
        $len_ex = $row['len_ex'];
        $len_re_st = $row['len_re_st'];
        $lib_no = $row['lib_no'];
        echo "var lib_no = $lib_no;";
    ?>
        const normal = document.getElementById('id_normal');
        const extend = document.getElementById('id_extend');
        const lent = document.getElementById('id_lent');
        const ret = document.getElementById('id_return');
        const etc = document.getElementById('id_etc');
        const li = document.getElementById('il_no');
        li.value = lib_no;

    <?php
        if($len_ex == 0){
    ?>
            normal.checked = true;
    <?php
        }
        else{
    ?>
            extend.checked = true;
    <?php
        }

        if($len_re_st == 0){
    ?>
            lent.checked = true;
    <?php
        }
        else if($len_re_st == 1){
    ?>
            ret.checked = true;
    <?php
        }
        else{
    ?>
            etc.checked = true;
    <?php
        }
    }
    ?>
    </script>
</body>
</html>