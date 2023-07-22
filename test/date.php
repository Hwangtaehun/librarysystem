<?php
$lentdate = date("Y-m-d"); 
$extend = 7;
$period = 15;

echo 'lentdate: '.$lentdate.'<br>';
printf('lentdate의 데이터 타입: %s<br>', gettype($lentdate));
$period += $extend;
echo 'period: '.$period.'<br>';
$date = strtotime(date("Y-m-d", strtotime($lentdate.'+ '.$period.' days')));
echo 'date의 값: '.$date;

$today = strtotime($lentdate);
$afterdate = strtotime($date);

if($today > $afterdate){
    echo '오늘이 더 큽니다.';
}
else{
    echo '오늘이 더 적습니다.';
}
?>