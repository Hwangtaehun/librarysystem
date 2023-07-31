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

    $super_man = new Combobox_Manager("kind", "kind_no", "`kind_num` LIKE '_00'");
    $base_man = new Combobox_Manager("kind", "kind_no", "`kind_num` LIKE '0_0'");
    $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_num` LIKE '00_'");

    $super = $super_man->result_call();
    $base = $base_man->result_call();
    $sub = $sub_man->result_call();
    ?>
    <form action = "combox_control.php" method = "POST">
            <select id = "s1" name = "hundred" onchange='firstChange(this)'>
                <?php
                for ($z=0; $z < sizeof($super); $z++) { 
                    echo "<option value = $super[$z]['kind_no'] > $super[$z]['kind_name'] </option>";
                }
                ?>
            </select>
            <select id = "s2" name = "ten" onchange='secondChange(this)'>
                <?php
                for ($z=0; $z < sizeof($base); $z++) { 
                    echo "<option value = $base[$z]['kind_no'] > $base[$z]['kind_name'] </option>";
                }
                ?>
            </select>
            <select id = "s3" name = "one">
                <?php
                for ($z=0; $z < sizeof($sub); $z++) { 
                    echo "<option value = $sub[$z]['kind_no'] > $sub[$z]['kind_name'] </option>";
                }
                ?>
            </select>
            <input type="submit" value="등록" />
            <?php
            //  $a = $base;
            //  $base_man = new Combobox_Manager("kind", "kind_no", "`kind_num` LIKE '1_0'");
            //  $b = $
            //  $aa = $sub;
            ?>
    </form>
        <script>
            function firstChange(e){
               var stepCategoryJsonArray = <?php echo json_encode($SecondArray) ?>;
               $("select#s2 option").remove();
               var target = document.getElementById("s2");
               for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                  var opt = document.createElement('option');
                  opt.value = stepCategoryJsonArray[e.value][i];
                  opt.innerHTML = stepCategoryJsonArray[e.value][i];
                  target.appendChild(opt);
               }
               var stepCategoryJsonArray = <?php echo json_encode($ThirdArray) ?>;
               $("select#s3 option").remove();
               var target = document.getElementById("s3");
               for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                  var opt = document.createElement('option');
                  opt.value = stepCategoryJsonArray[e.value][i];
                  opt.innerHTML = stepCategoryJsonArray[e.value][i];
                  target.appendChild(opt);
               }
            }

            function secondChange(e){
               var stepCategoryJsonArray = <?php echo json_encode($ThirdArray) ?>;
               $("select#s3 option").remove();
               var target = document.getElementById("s3");
               for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                  var opt = document.createElement('option');
                  opt.value = stepCategoryJsonArray[e.value][i];
                  opt.innerHTML = stepCategoryJsonArray[e.value][i];
                  target.appendChild(opt);
               }
            }
        </script>
    </body>
</html>