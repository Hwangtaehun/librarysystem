<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset = "utf-8">
        <title>combox 연습</title>
        <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>
    <body>
    <?php
    class SortType{
        public $type;
        public $num;
    }
    
    for ($i=0; $i < 10; $i++) { 
        $super[$i] = $i.'00';
    }

    for ($i=0; $i < 10; $i++) { 
        $base[$i] = '0'.$i.'0';
    }

    for ($i=0; $i < 10; $i++) { 
        $sub[$i] = '00'.$i;
    }
    ?>
    <form action = "combox_control.php" method = "POST">
            <select id = "s1" name = "hundred" onchange='categoryChange(this)'>
                <?php
                for ($i=0; $i < sizeof($super); $i++) { 
                    echo "<option value = $super[$i] > $super[$i] </option>";
                }
                ?>
            </select>
            <select id = "s2" name = "ten" onchange='categoryChange(this)'>
                <?php
                for ($i=0; $i < sizeof($base); $i++) { 
                    echo "<option value = $base[$i] > $base[$i] </option>";
                }
                ?>
            </select>
            <select id = "s3" name = "one">
                <?php
                for ($i=0; $i < sizeof($sub); $i++) { 
                    echo "<option value = $sub[$i] > $sub[$i] </option>";
                }
                ?>
            </select>
            <input type="submit" value="등록" />
            <?php
             for ($z=0; $z < 10; $z++) { 
                $a[$z] = '0'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $aa[$z] = '00'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ab[$z] = '01'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ac[$z] = '02'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ad[$z] = '03'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ae[$z] = '04'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $af[$z] = '05'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ag[$z] = '06'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ah[$z] = '07'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ai[$z] = '08'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $aj[$z] = '09'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $b[$z] = '1'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $ba[$z] = '10'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bb[$z] = '11'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bc[$z] = '12'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bd[$z] = '13'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $be[$z] = '14'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bf[$z] = '15'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bg[$z] = '16'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bh[$z] = '17'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bi[$z] = '18'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bj[$z] = '19'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $c[$z] = '2'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $ca[$z] = '20'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cb[$z] = '21'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cc[$z] = '22'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cd[$z] = '23'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ce[$z] = '24'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cf[$z] = '25'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cg[$z] = '26'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ch[$z] = '27'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ci[$z] = '28'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cj[$z] = '29'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $d[$z] = '3'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $e[$z] = '4'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $f[$z] = '5'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $g[$z] = '6'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $h[$z] = '7'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $i[$z] = '8'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $j[$z] = '9'.$z.'0';
             }
             $stepCategoryJsonArray = [
                '000' => $a;
                '010' => $ab;
                '100' => $b;
                '200' => $c;
                '300' => $d;
                '400' => $e;
                '500' => $f;
                '600' => $g;
                '700' => $h;
                '800' => $i;
                '900' => $j;
             ]
            ?>
    </form>
        <script>
            function categoryChange(e){
                var count = 0;
                var check = false;
                var stepCategoryJsonArray = <?php echo json_encode($stepCategoryJsonArray) ?>;
                var value = e.value;
                var array = value.split("");
                
                for(i = 0; i < array.length; i++) {
                    if(array[i] != '0'){
                        check = true;
                    }

                    if(check) {
                        if(array[i] == '0'){
                            count++;
                        }
                    }
                }

                if(count == 0){
                    document.write("백의 자리입니다.");
                }
                else if(count == 1){
                    document.write("십의 자리입니다.");
                }
                else{
                    document.write("오류발생");
                }
            }
        </script>
    </body>
</html>