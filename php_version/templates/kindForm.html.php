<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel = "stylesheet" herf = "../css/form.css">
    <title><?=$title?></title>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js">
        function checkInput(myform) {
            if(myform.id_name.value.length <= 0){
                alert("종류이름을 입력하세요.");
                myform.id_name.focus();
                return false;
            }
            return true;
        }
        <?php
        include_once __DIR__.'/../includes/Combobox_Manager.php';
        include_once __DIR__.'/../includes/Combobox_Inheritance.php';

        $super_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '_00'", false);
        $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '0_0'", false);
        $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '00_'", true);
    
        $super = $super_man->result_call();
        $base = $base_man->result_call();
        $sub = $sub_man->result_call();
        ?>
    </script>
</head>
<body>
    <form action="/kind/addupdate" method="post" onSubmit="return checkInput(this)">
        <fieldset id = form_fieldset>
        <legend>아래 내용을 <?= $title2 ?>하세요.</legend>
            <ul><label for = "kind_super">대분류</label>
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
                <label for = "kind_name">책이름</label>
                <input type= "text" name="kind_name" id="id_name" value="<?php if(isset($row)){echo $row['kind_name'];}?>"><br>
                <input type="hidden" name="kind_no" value="<?php if(isset($row)){echo $row['kind_no'];}?>">
                <?php
                $inherit1 = new Combobox_Inheritance("kind", "kind_no", "`kind_no` LIKE '?_0'", false);
                $inherit2 = new Combobox_Inheritance("kind", "kind_no", "`kind_no` LIKE '??_'", true);

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
    <script>
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