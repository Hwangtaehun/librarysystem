<head>
    <?php
    if($title == '종류 현황'){
        echo '<link rel="stylesheet" href="../css/form-base.css">';
        $ispop = false;
        $action = "/kind/research";
    }
    else{
        echo '<link rel="stylesheet" href="../css/form-popup.css">';
        $ispop = true;
        $action = "/kind/research?title=$title&pop=true";
    }
    ?>
    <script>
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
<body style="background-image:url('../img/kind_bg.gif'); background-size: 100% 192vh;">
    <form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
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
    </form>
    <?php if(isset($result)){foreach($result as $row): ?>
    <fieldset id="fieldset_row">
        <div id="div_row">
            <?=htmlspecialchars($row['kind_no'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['kind_name'],ENT_QUOTES,'UTF-8');?>
        </div>
        <?php
            if($ispop){
                echo '<form>';
                $no = "'".$row['kind_no']."'";
                echo '<input type=button value="선택" onclick="opener.parent.kindValue('.$no.'); window.close();">';
            }
            else{
        ?>
        <form action="/kind/delete" method="post">
                <input type="submit" value="삭제">
                <a href="/kind/addupdate?kind_no=<?=$row['kind_no']?>"><input type="button" value="수정"></a>
        </form>
        <?php } ?>
    </fieldset>
    <?php endforeach; }?>
    <script>
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
