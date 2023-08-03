<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset = "utf-8">
        <title>combox 연습</title>
        <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>
    <body>
    <?php
    include_once __DIR__.'/Combobox_Manager.php';
    include_once __DIR__.'/Combobox_Inheritance.php';

    $super_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '_00'", false);
    $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '0_0'", false);
    $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '00_'", true);

    $super = $super_man->result_call();
    $base = $base_man->result_call();
    $sub = $sub_man->result_call();
    ?>
    <form action = "selectbox_control.php" method = "POST">
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
            <input type="submit" value="등록" />
            <?php
             $inherit1 = new Combobox_Inheritance("kind", "kind_no", "`kind_no` LIKE '?_0'", false);
             $inherit2 = new Combobox_Inheritance("kind", "kind_no", "`kind_no` LIKE '??_'", true);

             $basearray = $inherit1->call_result();
             $subarray = $inherit2->call_result();
            ?>
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