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
            if(state == 2){
                alert("정지된 계정입니다.");
                return false;
            }
            if(myform.ib_name.value.length <= 0){
                alert("책 정보를 찾아주세요.");
                myform.id_name.focus();
                return false;
            }
            if(myform.mi_many.value.length <= 0){
                ocument.getElementById("mi_many").value = '0';
            }
            return true;
        }

        function checkbook() {
            url = "/mat/bookpop";
            window.open(url,"chkbk","width=400,height=200");
        }

        function checkkind() {
            url = "/mat/kindpop";
            window.open(url,"chkbk","width=400,height=200");
        }

        function bookValue(no, name, aut){
            document.getElementById("id_book").value = no;
            document.getElementById("ib_name").value = name;
            document.getElementById("ib_author").value = aut;
        }

        function kindValue(no){
            document.getElementById("id_kind").value = no;
        }
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';

    $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", false);
    $lib = $lib_man->result_call();
?>
<body>
    <form action="/mat/addupdate" method="post" onSubmit="return checkInput(this)" onReset="return checkReset()">
        <fieldset id = form_fieldset>
        <legend>아래 내용을 <?= $title2 ?>하세요.</legend>
            <ul><label for = "lib_name">도서관</label>
                <select id = "il_no" name = "lib_no">
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
                <label for = "book_name">책이름</label>
                <input type= "text" name="book_name" id="ib_name" value="<?php if(isset($row)){echo $row['book_name'];}?>" readonly>
                <input type= "button" name="book_check" id="ib_check" value="책 찾기" onclick="checkbook();"><br>
                <label for = "book_name">종류번호</label>
                <input type= "text" name="kind_no" id="id_kind" value="<?php if(isset($row)){echo $row['kind_no'];}?>" readonly>
                <input type= "button" name="kind_check" id="ik_check" value="종류 찾기" onclick="checkkind();"><br>
                <label for = "mat_many">권차</label>
                <input type= "text" name="mat_many" id="mi_many" value="<?php if(isset($row)){echo $row['mat_many'];}?>"><br>
                <input type="hidden" name="mat_no" value="<?php if(isset($row)){echo $row['mat_no'];}?>">
                <input type="hidden" id="id_book" name="book_no" value="<?php if(isset($row)){echo $row['book_no'];}?>">
                <input type="hidden" id="ib_author" name="book_author" value="<?php if(isset($row)){echo $row['book_author'];}?>">
            </ul>
            <div class="form_class">
                <input type= "submit" value="<?= $title2 ?>">
                <input type= "reset" value='지우기'>
            </div>
        </fieldset>
    </form>
</body>
</html>