<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/form-base.css">
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
                ocument.querySelector("#mi_many").value = '0';
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
            document.querySelector("#id_book").value = no;
            document.querySelector("#ib_name").value = name;
            document.querySelector("#ib_author").value = aut;
        }

        function kindValue(no){
            document.querySelector("#id_kind").value = no;
        }
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';
    include_once __DIR__.'/../includes/Combobox_Inheritance.php';

    $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", false);
    $super_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '_00'", false);
    $base_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '0_0'", false);
    $sub_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '00_'", false);
    $inherit1 = new Combobox_Inheritance($pdo, "kind", "kind_no", "`kind_no` LIKE '?_0'", false);
    $inherit2 = new Combobox_Inheritance($pdo, "kind", "kind_no", "`kind_no` LIKE '??_'", false);
    
    $lib = $lib_man->result_call();
    $super = $super_man->result_call();
    $base = $base_man->result_call();
    $sub = $sub_man->result_call();
    $basearray = $inherit1->call_result();
    $subarray = $inherit2->call_result();
?>
<body>
    <form action="/mat/addupdate" method="post" onSubmit="return checkInput(this)" onReset="return checkReset()">
        <fieldset id = form_fieldset>
        <h2><?=$title?></h2>
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
                <label for  = "book_name">책이름</label>
                <input class="input" type= "text" name="book_name" id="ib_name" value="<?php if(isset($row)){echo $row['book_name'];}?>" readonly>
                <input type = "button" name="book_check" id="ib_check" value="책 찾기" onclick="checkbook();"><br>
                <label for  = "book_name">종류번호</label><br>
                <label for  = "kind_super">대분류</label>
                <select id  = "s1" name = "super" onchange='superChange(this)'>
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
                <label for = "kind_no">소분류</label>
                <select id = "s3" name = "kind_no">
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
                <label for  = "mat_many">권차</label>
                <input class="input" type= "text" name="mat_many" id="mi_many" value="<?php if(isset($row)){echo $row['mat_many'];}?>"><br>
                <input type ="hidden" name="mat_no" value="<?php if(isset($row)){echo $row['mat_no'];}?>">
                <input type ="hidden" id="id_book" name="book_no" value="<?php if(isset($row)){echo $row['book_no'];}?>">
                <input type ="hidden" id="ib_author" name="book_author" value="<?php if(isset($row)){echo $row['book_author'];}?>">
            </ul>
            <div class="form_class">
                <input type= "submit" value="<?= $title2 ?>">
                <input type= "reset" value='지우기'>
            </div>
        </fieldset>
    </form>
    <script>
        <?php
        if(isset($row['lib_no'])){
            $lib_no = $row['lib_no'];
            echo "var lib_no = $lib_no;";
        ?>
            const li = document.querySelector('#il_no');
            li.value = lib_no;
        <?php    
        }

        if(isset($row['kind_no'])){
            $kind_no = $row['kind_no'];
            $temp = (int)$kind_no / 100;
            $hundred = (int)$temp;
            $temp = ((int)$kind_no % 100) / 10;
            $ten = (int)$temp;
            $one = (int)$kind_no % 10;

            if($hundred == 0){
                $major = "000";
                $middle = "0";
                $small = "0";
            }
            else{
                $major = (string)$hundred."00";
                $middle = (string)$hundred;
                $small = (string)$hundred;
            }

            if($ten == 0){
                $middle = $middle."00";
                $small = $small."0";
            }
            else{
                $middle = $middle.(string)$ten."0";
                $small = $small.(string)$ten;
            }

            if($one == 0){
                $small = $small."0";
            }
            else{
                $small = $small.(string)$one;
            }
            
            echo "var major = $major;";
            echo "var middle = $middle;";
            echo "var small = $small;";
            echo "let s1 = document.querySelector('#s1');";
            echo "let s2 = document.querySelector('#s2');";
            echo "let s3 = document.querySelector('#s3');";
            echo "s1.value = major;";
            echo "majorChange(major);";
            echo "s2.value = middle;";
            echo "middleChange(middle);";
            echo "s3.value = small;";
        }
        ?>

        function majorChange(n){
            var stepCategoryJsonArray = <?php echo json_encode($basearray) ?>;
            var target = document.querySelector("#s2");
            target.innerHTML = "";
            for(var i = 0; i < stepCategoryJsonArray[n].length; i++){
                var opt = document.createElement('option');
                opt.value = stepCategoryJsonArray[n][i][0];
                opt.innerHTML = stepCategoryJsonArray[n][i][1];
                target.appendChild(opt);
            }
            var stepCategoryJsonArray = <?php echo json_encode($subarray) ?>;
            var target = document.querySelector("#s3");
            target.innerHTML = "";
            for(var i = 0; i < stepCategoryJsonArray[n].length; i++){
                var opt = document.createElement('option');
                opt.value = stepCategoryJsonArray[n][i][0];
                opt.innerHTML = stepCategoryJsonArray[n][i][1];
                target.appendChild(opt);
            }
        }

        function middleChange(n){
            var stepCategoryJsonArray = <?php echo json_encode($subarray) ?>;
            var target = document.querySelector("#s3");
            target.innerHTML = "";
            for(var i = 0; i < stepCategoryJsonArray[n].length; i++){
                var opt = document.createElement('option');
                opt.value = stepCategoryJsonArray[n][i][0];
                opt.innerHTML = stepCategoryJsonArray[n][i][1];
                target.appendChild(opt);
            }
        }

        function superChange(e){
            var stepCategoryJsonArray = <?php echo json_encode($basearray) ?>;
            var target = document.querySelector("#s2");
            target.innerHTML = "";
            for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                var opt = document.createElement('option');
                opt.value = stepCategoryJsonArray[e.value][i][0];
                opt.innerHTML = stepCategoryJsonArray[e.value][i][1];
                target.appendChild(opt);
            }
            var stepCategoryJsonArray = <?php echo json_encode($subarray) ?>;
            var target = document.querySelector("#s3");
            target.innerHTML = "";
            for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                var opt = document.createElement('option');
                opt.value = stepCategoryJsonArray[e.value][i][0];
                opt.innerHTML = stepCategoryJsonArray[e.value][i][1];
                target.appendChild(opt);
            }
        }

        function baseChange(e){
            var stepCategoryJsonArray = <?php echo json_encode($subarray) ?>;
            var target = document.querySelector("#s3");
            target.innerHTML = "";
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