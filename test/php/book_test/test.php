<?php
include_once __DIR__.'/BookSymbol.php';

$one = new BookSymbol("세이노", false);
$two = new BookSymbol("J.K 롤링", true);
$three = new BookSymbol("Howard Phillips Lovecraft", true);

$result_one = $one->call_symbol();
$result_two = $two->call_symbol();
$result_three = $three->call_symbol();

echo '$result_one = '.$result_one.'<br>';
echo '$result_two = '.$result_two.'<br>';
echo '$result_three = '.$result_three.'<br>';
?>