<head>
    <link rel="stylesheet" href="../css/form-base.css">
    <script>
        // 검색 내용이 있는 없는지 확인
        function checkResearch(myform) {
            if(myform.user_research.value.length <= 0){
                alert("검색할 내용을 입력해주세요.");
                myform.user_research.focus();
                return false;
            }
            return true;            
        } 
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';
    include_once __DIR__.'/../includes/Combobox_Inheritance.php';

    // 모든 분류 객체 생성
    $super_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '_00'", true);
    $base_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '0_0'", true);
    $sub_man = new Combobox_Manager($pdo, "kind", "kind_no", "`kind_no` LIKE '00_'", true);
    $inherit1 = new Combobox_Inheritance($pdo, "kind", "kind_no", "`kind_no` LIKE '?_0'", true);
    $inherit2 = new Combobox_Inheritance($pdo, "kind", "kind_no", "`kind_no` LIKE '??_'", true);
    
    $super = $super_man->result_call();
    $base = $base_man->result_call();
    $sub = $sub_man->result_call();
    $basearray = $inherit1->call_result();
    $subarray = $inherit2->call_result();
?>
<body>
    <div class="dynamic_search">
        <form action="/kind/research" method="post" onsubmit="return checkResearch(this)">
            <div class="sel">
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
                </select>
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
                </select>
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
                </select>
                <input type="submit" value = "검색">
            </div>
        </form>
    </div>
    <?php if(isset($result)){foreach($result as $row): ?>
    <fieldset id="fieldset_row">
        <div id="div_row">
            <?=htmlspecialchars($row['kind_no'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['kind_name'],ENT_QUOTES,'UTF-8');?>
        </div>
        <form action="/kind/delete" method="post">
                <input type="submit" value="삭제">
                <input type="hidden" name="kind_no" value="<?php if(isset($row)){echo $row['kind_no'];}?>">
                <a href="/kind/addupdate?kind_no=<?=$row['kind_no']?>"><input type="button" value="수정"></a>
        </form>
    </fieldset>
    <?php endforeach; }?>
    <script src="../js/search.js"></script>
    <script>
        // 대분류 선택이 바뀌었는데 중분류, 소분류 바뀌게 하는 함수
        function superChange(e){
            var stepCategoryJsonArray = <?php echo json_encode($basearray); ?>;
            var target = document.querySelector("#s2");
            var value = e.value;

            if(e.value === "0"){
                value = "000";
            }

            target.innerHTML = "";
            for(var i = 0; i < stepCategoryJsonArray[value].length; i++){
                var opt = document.createElement('option');
                opt.value = stepCategoryJsonArray[value][i][0];
                opt.innerHTML = stepCategoryJsonArray[value][i][1];
                target.appendChild(opt);
            }
            var stepCategoryJsonArray = <?php echo json_encode($subarray); ?>;
            var target = document.querySelector("#s3");
            target.innerHTML = "";
            for(var i = 0; i < stepCategoryJsonArray[value].length; i++){
                var opt = document.createElement('option');
                opt.value = stepCategoryJsonArray[value][i][0];
                opt.innerHTML = stepCategoryJsonArray[value][i][1];
                target.appendChild(opt);
            }
        }

        // 중분류 선택이 바뀌었을때, 소분류 바뀌게 하는 함수
        function baseChange(e){
            var stepCategoryJsonArray = <?php echo json_encode($subarray); ?>;
            var target = document.querySelector("#s3");
            var value = e.value;

            if(e.value === "0"){
                value = "000";
            }
            
            target.innerHTML = "";
            for(var i = 0; i < stepCategoryJsonArray[value].length; i++){
                var opt = document.createElement('option');
                opt.value = stepCategoryJsonArray[value][i][0];
                opt.innerHTML = stepCategoryJsonArray[value][i][1];
                target.appendChild(opt);
            }
        }
    </script>
</body>
