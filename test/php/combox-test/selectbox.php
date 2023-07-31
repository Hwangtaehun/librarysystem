<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset = "utf-8">
        <title>combox 연습</title>
        <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>
    <body>
    <?php
    class Manager {
        public $pri;
        public $name;
    }
    ?>
    <form action = "combox_control.php" method = "POST">
            <select id = "s1" name = "hundred" onchange='firstChange(this)'>
                <?php
                for ($z=0; $z < sizeof($super); $z++) { 
                    echo "<option value = $super[$z] > $super[$z] </option>";
                }
                ?>
            </select>
            <select id = "s2" name = "ten" onchange='secondChange(this)'>
                <?php
                for ($z=0; $z < sizeof($base); $z++) { 
                    echo "<option value = $base[$z] > $base[$z] </option>";
                }
                ?>
            </select>
            <select id = "s3" name = "one">
                <?php
                for ($z=0; $z < sizeof($sub); $z++) { 
                    echo "<option value = $sub[$z] > $sub[$z] </option>";
                }
                ?>
            </select>
            <input type="submit" value="등록" />
            <?php
             
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