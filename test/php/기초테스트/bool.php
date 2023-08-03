<?php
  $a = false;
  $b = true;
  $c;

  if($a === false) {
    echo '$a는 false입니다.';
  }
  else{
    echo '$a는 true입니다.';
  }

  if(empty($c)) {
    echo '비어있습니다.'.empty($c);
  }
  else {
    echo '비어있지 않습니다.'.empty($c);
  }
?>