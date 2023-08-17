<?php
include_once __DIR__.'/Combobox_Manager.php';

class Combobox_Inheritance{
	private $where_array;
	private $result = [];

	public function __construct(PDO $pdo, string $table, string $key, string $where, bool $nothing) {
		$count = $this->where_edit($where);
		$word_front = $this->where_array[0].' '.$this->where_array[1];

		if($count === 1){
			$max = 10;
			for ($i=0; $i < $max; $i++) { 
				$word_back = $i.$this->where_array[2];
				$base_where = "$word_front '$word_back'";
				//echo '$base_where = '.$base_where;
				$base_man = new Combobox_Manager($pdo, $table, $key, $base_where, $nothing);
				$name = $i.'00';
				$this->result += ["$name" => $base_man->result_call()];
			}
		}
		else if($count === 2){
			$max = 100;
			for ($i = 0; $i < $max; $i++) { 
				$str_i = $this->intTostr($i);
				$word_back = $str_i.$this->where_array[2];
				$sub_where = "$word_front '$word_back'";
				//echo '$sub_where = '.$sub_where;
				$sub_man = new Combobox_Manager($pdo, $table, $key, $sub_where, $nothing);
				$name = $str_i.'0';
				$this->result += ["$name" => $sub_man->result_call()];
			}
		}
		else{
			echo 'where에 ?가 없습니다.';
		}

		//print_r($this->result);
	}

	private function where_edit(string $where){
		$rest = null;
		$cnt = 0;
		$this->where_array = explode( ' ', $where);
		$temp = mb_str_split($this->where_array[sizeof($this->where_array)-1], $split_length = 1, $encoding = "utf-8");

		for($i = 0; $i < sizeof($temp); $i++) {
			if($temp[$i] === '?') {
				$cnt++;
			}
			else if($temp[$i] === "'"){}
			else{
				$rest = $rest.$temp[$i];
			}
		}
		$this->where_array[sizeof($this->where_array)-1] = $rest;

		return $cnt;
	}

	private function intTostr(int $num){
		if($num < 10){
			$str = '0'.$num;
		}
		else{
			$str = (string)$num;
		}

		return $str;
	}

	public function call_result(){
		return $this->result;
	}
}
?>