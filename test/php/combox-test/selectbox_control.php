<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title>Form Tag 사용</title>
    </head>
    <body>
        <h2>입력 내용 확인</h2>
        <?php
            include_once __DIR__.'/Assistance.php';
            $pdo = new PDO('mysql:host=localhost;dbname=librarydb;charset=utf8','mysejong','sj4321');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            function makeKey(String $str, bool $bool) {
                $assist = new Assistance();
                $text = "문제발생";
                global $pdo;

                if($bool) {
                    $array = mb_str_split($str, $split_length = 1, $encoding = "utf-8");
                    $final_position = $array[2];
                    $num = (int)$final_position;
                    if($num > 8) {
                        return $text;
                    }
                    $num++;
                    $text = $array[0].$array[1].$num;
                    echo '28줄 $text = '.$text.'<br>';
                }
                else {
                    $key = $str.'%';
                    echo '$key = '.$key.'<br>';
                    $sql = "SELECT * FROM `kind` WHERE `kind_no` LIKE '$key'";
                    $result = $pdo->query($sql);
                    $row = $result->fetchAll();
                    $num = $result->rowCount();
                    $text = $row[$num-1][0];
        
                    if($assist->isInteger($text)) {
                        $text=$text.".1";
                        echo '39줄 $text = '.$text.'<br>';
                    }
                    else {
                        if($assist->isFloat($text)) {
                            $str_array = explode( '.', $text );
                            $num = (int)$str_array[1];
                            $num++;
                            $text = $str_array[0].".".$num;
                            echo '48줄 $text = '.$text.'<br>'; 
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

            $key = $_POST['sup'];
            if($key == '0'){
                $key = $_POST['base'];
                $array = mb_str_split($key, $split_length = 1, $encoding = "utf-8");
                $num = $array[0].$array[1].'_';
                echo '72줄 $num = '.$num.'<br>';
                $sql = "SELECT * FROM `kind` WHERE `kind_no` LIKE '$num'";
                $result = $pdo->query($sql);
                $row = $result->fetchAll();

                for ($i=0; $i < sizeof($row) ; $i++) { 
                    $num = $row[$i][0];
                    echo '78줄 $num = '.$num.'<br>';
                    $num_array = mb_str_split($num, $split_length = 1, $encoding = "utf-8");
                    if($i != (int)$num_array[2]){
                        $key = $num;
                        break;
                    }
                    $key = $num;
                    echo '86줄 $num = '.$num.'<br>';
                }
                $kind_no = makeKey($key, true);
                echo '89줄 $kind_no = '.$kind_no.'<br>';
            }
            else{
                $kind_no = makeKey($key, false);
                echo '93줄 $kind_no = '.$kind_no.'<br>';
            }
        ?>
    </body>
</html>