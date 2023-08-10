<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title>Form Tag 사용</title>
    </head>
    <body>
        <h2>입력 내용 확인</h2>
        <?php
            $pdo = new PDO('mysql:host=localhost;dbname=librarydb;charset=utf8','mysejong','sj4321');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            function strTonumTostr(String $str, bool $bool) {
                $text = "문제발생";
                
                if($bool) {
                    $array = mb_str_split($str, $split_length = 1, $encoding = "utf-8");
                    $final_position = $array[2];
                    $num = (int)$final_position;
                    if($num > 8) {
                        return $text;
                    }
                    $num++;
                    $text = $array[0].$array[1].$num;
                }
                else {
                    $sql = "SELECT * FROM `kind` WHERE `kind_num` LIKE '$str%'";
                    $result = $pdo->query($sql);
                    $row = $result->fetchAll();
                    $num = $result->rowCount();
                    $text = $row[$num][0];

                    if(isInteger($text)) {
                        $text=$text.".1";
                    }
                    else {
                        if(isFloat($text)) {
                            $str_array = explode( '.', $text );
                            $num = (int)$str_array[1];
                            $num++;
                            $text = $str_array[0].".".$num; 
                        }
                        else {
                            $text = "문제발생";
                        }
                    }
                }
                return $text;
            }

            $super = $_POST['super'];
            $base = $_POST['base'];
            $sub = $_POST['sup'];

            echo "<p>From에서 전달된 내용입니다. </p>";
            echo "<p>대분류: $super<br>";
            echo "중분류: $base<br>";
            echo "소분류: $sub<br></p>";

            if($sub == '0'){
                $array = mb_str_split($base, $split_length = 1, $encoding = "utf-8");
                $kind_no = $array[0].$array[1].'_';
                $sql = "SELECT * FROM `kind` WHERE `kind_no` LIKE '$kind_no'";
                $result = $pdo->query($sql);
                $row = $result->fetchAll();


                for ($i=0; $i < sizeof($row) ; $i++) { 
                    $num = $row[$i][0];
                    $num_array = mb_str_split($num, $split_length = 1, $encoding = "utf-8");
                    if($i != (int)$num_array[2]){
                        $kind_no = $num;
                        break;
                    }
                    $kind_no = $num;
                }
                echo '$kind_no = '.$kind_no.'<br>';
            }
        ?>
    </body>
</html>