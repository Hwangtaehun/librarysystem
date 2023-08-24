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
                myform.id_name.focus();
                return false;
            }
            if(myform.ib_name.value.length <= 0){
                alert("책 정보를 찾아주세요.");
                myform.id_name.focus();
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

        function memValue(name, no){
            document.getElementById("id_book").value = no;
            document.getElementById("im_id").value = name;
        }

        function matValue(name, no){
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
            <ul><label for ="mem_id">회원아이디</label>
                <input type="text" name="mem_id" id="im_id" value="<?php if(isset($row)){echo $row['mem_id'];}?>" readonly>
                <input type="button" name="mem_check" id="im_check" value="회원 찾기" onclick="checkmem();"><br>
                <label for ="lib_name">도서관</label>
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
                </select>
                <input type="button" name="del_check" id="ide_check" value="상호대차" onclick="checkdel();"><br>
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
                <input type="hidden" id="id_mat" name="mat_no" value="<?php if(isset($row)){echo $row['mat_no'];}?>">
                <input type="hidden" id="id_del" name="del_no" value="<?php if(isset($row)){if(!empty($row['del_no'])){echo $row['del_no'];}}?>">
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
    ?>
        const normal = document.getElementById('id_normal');
        const extend = document.getElementById('id_extend');
        const lent = document.getElementById('id_lent');
        const ret = document.getElementById('id_return');
        const etc = document.getElementById('id_etc');

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