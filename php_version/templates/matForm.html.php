<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel = "stylesheet" herf = "../css/form.css">
    <title><?=$title?></title>
    <!-- <script src="http://code.jquery.com/jquery-3.3.1.min.js"> -->
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

        function bookValue(no, name, aut){
            document.getElementById("id_book").value = no;
            document.getElementById("ib_name").value = name;
            document.getElementById("ib_author").value = aut;
        }
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';
    include_once __DIR__.'/../includes/Combobox_Inheritance.php';

    $super_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '_00'", false);
    $base_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '0_0'", false);
    $sub_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '00_'", false);
    $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", false);
    $super = $super_man->result_call();
    $base = $base_man->result_call();
    $sub = $sub_man->result_call();
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
                <label for = "book_author">저자</label>
                <input type= "text" name="book_author" id="ib_author" value="<?php if(isset($row)){echo $row['book_author'];}?>" readonly><br>
                <label for = "kind_super">대분류</label>
                <select id = "s1" name = "super" onchange='superChange(this)'>
                    <?php
                    for ($z=0; $z < sizeof($super); $z++) { 
                        $no[$z] = $super[$z][0];
                        $name[$z] = $super[$z][1];
                    }
                    for ($z=0; $z < sizeof($super); $z++) { 
                        echo "<option value = $no[$z] > $name[$z] </option>";
                    }
                    ?>
                </select><br>
                <label for = "kind_base">중분류</label>
                <select id = "s2" name = "base" onchange='baseChange(this)'>
                <?php
                for ($z=0; $z < sizeof($base); $z++) { 
                    $no[$z] = $base[$z][0];
                    $name[$z] = $base[$z][1];
                }
                for ($z=0; $z < sizeof($base); $z++) { 
                    echo "<option value = $no[$z] > $name[$z] </option>";
                }
                ?>
                </select><br>
                <label for = "kind_sub">소분류</label>
                <select id = "s3" name = "sup">
                <?php
                for ($z=0; $z < sizeof($sub); $z++) { 
                    $no[$z] = $sub[$z][0];
                    $name[$z] = $sub[$z][1];
                }
                for ($z=0; $z < sizeof($sub); $z++) { 
                    echo "<option value = $no[$z] > $name[$z] </option>";
                }
                ?>
                </select><br>
                <?php 
                if(isset($row)){
                    $kind_no = $row['kind_no'];
                    $array = mb_str_split($kind_no, $split_length = 1, $encoding = "utf-8");
                    $supvalue = $array[0].'00';
                    $bavalue = $array[0].$array[1].'0';
                    echo "document.getElementById('s1').value = $supvalue;";
                    echo "document.getElementById('s2').value = $bavalue;";
                    echo "document.getElementById('s3').value = $kind_no;";
                }
                ?>
                <label for = "mat_many">권차</label>
                <input type= "text" name="mat_many" id="mi_many" value="<?php if(isset($row)){echo $row['mat_many'];}?>"><br>
                <input type="hidden" name="mat_no" value="<?php if(isset($row)){echo $row['mat_no'];}?>">
                <input type="hidden" id="id_book" name="book_no" value="<?php if(isset($row)){echo $row['book_no'];}?>">
                <?php
                $inherit1 = new Combobox_Inheritance($pdo, "kind", "kind_no", "`kind_no` LIKE '?_0'", false);
                $inherit2 = new Combobox_Inheritance($pdo, "kind", "kind_no", "`kind_no` LIKE '??_'", false);

                $basearray = $inherit1->call_result();
                $subarray = $inherit2->call_result();
                ?>
            </ul>
            <div class="form_class">
                <input type= "submit" value="<?=$title2 ?>">
                <input type= "reset" value='지우기'>
            </div>
        </fieldset>
    </form>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js">
        function superChange(e){
            var stepCategoryJsonArray = <?php echo json_encode($basearray) ?>;
            $("select#s2 option").remove();
            var target = document.getElementById("s2");
            for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                  var opt = document.createElement('option');
                  opt.value = stepCategoryJsonArray[e.value][i][0];
                  opt.innerHTML = stepCategoryJsonArray[e.value][i][1];
                  target.appendChild(opt);
            }
            var stepCategoryJsonArray = <?php echo json_encode($subarray) ?>;
            $("select#s3 option").remove();
            var target = document.getElementById("s3");
            for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
              var opt = document.createElement('option');
              opt.value = stepCategoryJsonArray[e.value][i][0];
              opt.innerHTML = stepCategoryJsonArray[e.value][i][1];
              target.appendChild(opt);
            }
        }

        function baseChange(e){
            var stepCategoryJsonArray = <?php echo json_encode($subarray) ?>;
            $("select#s3 option").remove();
            var target = document.getElementById("s3");
            for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                var opt = document.createElement('option');
                opt.value = stepCategoryJsonArray[e.value][i][0];
                opt.innerHTML = stepCategoryJsonArray[e.value][i][1];
                target.appendChild(opt);
            }
        }
    </script>
</body>
</html>