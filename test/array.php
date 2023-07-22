<?php
 $arr[2] = ' 2 번째';
 $arr[0] = ' 0 번째';
 $arr[3] = ' 3 번째';
 $cnt = sizeof($arr);
 echo "배열 요소 수 = $cnt, arr = $arr[0], $arr[1], $arr[2]<br>";

 $num = 1;

 for($i = 0; $i < 4; $i++){
    $num_arr[$i] = $num;
    $num += 2;
 }

 for($i = 0; $i < 4; $i++){
    echo '$num_arr['.$i.'] = '.$num_arr[$i].'<br>';
 }
?>