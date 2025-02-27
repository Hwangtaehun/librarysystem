<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/form-base.css">
    <script>
        //필수 입력을 확인 함수
        function checkInput(myform) {
            if(myform.id_name.value.length <= 0){
                alert("종류이름을 입력하세요.");
                myform.id_name.focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';

    $super_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '_00'", false);
    $base_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '0_0'", false);
    $sub_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '00_'", true);
    
    $super = $super_man->result_call();
    $base = $base_man->result_call();
    $sub = $sub_man->result_call();
    $basearray = $base_man->base_call();
    $subarray = $sub_man->sub_call();
?>
<body>
    <form action="/kind/addupdate" method="post" onSubmit="return checkInput(this)">
        <fieldset id = form_fieldset>
            <h2><?=$title?></h2>
            <div class="form_text">
                <ul>
                    <li><label for = "s1">대분류</label><br>
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
                        </select></li>
                    <li><label for = "s2">중분류</label><br>
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
                        </select></li>
                    <li><label for = "s3">소분류</label><br>
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
                        </select></li>
                    <li><label for  ="id_name">종류 이름</label><br>
                        <input class="input" type= "text" name="kind_name" id="id_name" value="<?php if(isset($row)){echo $row['kind_name'];}?>"></li>
                        <input type="hidden" name="kind_no" value="<?php if(isset($row)){echo $row['kind_no'];}?>">
                    <div class="form_bt">
                        <input type= "submit" value="<?=$title2 ?>">
                        <input type= "reset" value='지우기'>
                    </div>
                </ul>
            </div>
        </fieldset>
    </form>
    <script>
        // 대분류 선택이 바뀌었는데 중분류, 소분류 바뀌게 하는 함수
        function superChange(e){
            var stepCategoryJsonArray = <?php echo json_encode($basearray); ?>;
            var target = document.querySelector("#s2");
            target.innerHTML = "";
            for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                var opt = document.createElement('option');
                opt.value = stepCategoryJsonArray[e.value][i][0];
                opt.innerHTML = stepCategoryJsonArray[e.value][i][1];
                target.appendChild(opt);
            }
            var stepCategoryJsonArray = <?php echo json_encode($subarray); ?>;
            var target = document.querySelector("#s3");
            target.innerHTML = "";
            for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                var opt = document.createElement('option');
                opt.value = stepCategoryJsonArray[e.value][i][0];
                opt.innerHTML = stepCategoryJsonArray[e.value][i][1];
                target.appendChild(opt);
            }
        }

        // 중분류 선택이 바뀌었을때, 소분류 바뀌게 하는 함수
        function baseChange(e){
            var stepCategoryJsonArray = <?php echo json_encode($subarray); ?>;
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