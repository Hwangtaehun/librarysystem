<?php
class Combobox_Manager {
	private $pdo;
	private $pri;
    private $name;
	private $result;
	private $where_array;

	public function __construct(PDO $pdo, string $table, string $key, string $where, bool $nothing) {
		$this->pdo = $pdo;
		$this->result = $this->comboxSql($table, $key, $where, $nothing);
	}

	public function __destruct() { }

	private function comboxSql(string $table, string $key, string $where, bool $nothing){
		try {
			$count = 0;
			$key_name = $this->changenamekey($key);
			
			if(empty($where)){
				$sql = "SELECT * FROM `$table`";
			}
			else{
				$sql = "SELECT * FROM `$table` WHERE $where";
			}
			//echo '$sql = '.$sql.'<br>';
			$result = $this->pdo->query($sql);

			while ($row = $result->fetchObject()) {
				$this->pri[$count] = $row->$key;
				$this->name[$count] = $row->$key_name;
				$count++;
			}

			if($nothing){
				$final[0] = array('0', '없음');
				for ($i= 0; $i < $count ; $i++) { 
					$final[$i+1] = array($this->pri[$i], $this->name[$i]);
				}
			}
			else{
				for ($i=0; $i < $count ; $i++) { 
					$final[$i] = array($this->pri[$i], $this->name[$i]);
				}
			}

			return $final;
		}
		catch(PDOException $e){
			$strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
		}
	}

	//테이블_no를 테이블_name으로 변경
	private function changenamekey(string $key) {
		$str = '';
		$cnt = 0;
		$temp = mb_str_split($key, $split_length = 1, $encoding = "utf-8");

		for($i = 0; $i < sizeof($temp); $i++) {
			if($temp[$i] == '_') {
				$cnt = $i;
			}
		}

		for($i = 0; $i < $cnt + 1; $i++) {
			$str = $str.$temp[$i];
		}
		$str = $str."name";
		
		return $str;
	}

	//대분류, 중분류, 소분류 분리
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

	//정수를 문자로 변환
	private function intTostr(int $num){
		if($num < 10){
			$str = '0'.$num;
		}
		else{
			$str = (string)$num;
		}

		return $str;
	}

	private function inheritData(string $table, string $key, string $where, bool $nothing){
		$result = [];
		$count = $this->where_edit($where);
		$word_front = $this->where_array[0].' '.$this->where_array[1];

		//$count가 1일이면 중분류 배열만들기, $count가 2일이면 대분류 배열 만들기
		if($count === 1){
			$max = 10;
			for ($i=0; $i < $max; $i++) { 
				$word_back = $i.$this->where_array[2];
				$base_where = "$word_front '$word_back'";
				//echo '$base_where = '.$base_where;
				$base_man = $this->comboxSql($table, $key, $base_where, $nothing);
				$name = $i.'00';
				$result += ["$name" => $base_man];
			}
		}
		else if($count === 2){
			$max = 100;
			for ($i = 0; $i < $max; $i++) { 
				$str_i = $this->intTostr($i);
				$word_back = $str_i.$this->where_array[2];
				$sub_where = "$word_front '$word_back'";
				//echo '$sub_where = '.$sub_where;
				$sub_man = $this->comboxSql($table, $key, $sub_where, $nothing);
				$name = $str_i.'0';
				$result += ["$name" => $sub_man];
			}
		}
		else{
			echo 'where에 ?가 없습니다.';
		}

		return $result;
	}

	public function result_call() {
		return $this->result;
	}

	public function base_call(){
		return $this->inheritData("kind", "kind_no", "`kind_no` LIKE '?_0'", true);
	}

	public function sub_call(){
		return $this->inheritData("kind", "kind_no", "`kind_no` LIKE '??_'", true);
	}
}
?>