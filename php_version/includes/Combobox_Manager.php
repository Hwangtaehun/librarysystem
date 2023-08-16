<?php
class Combobox_Manager {
	private $pri;
    private $name;
	private $result;

	public function __construct(\PDO $pdo, string $table, string $key, string $where, bool $nothing) {
		try {
			$count = 0;
			$key_name = $this->changenamekey($key);
			// echo '$key_name = '.$key_name.'<br>';
			$sql = "SELECT * FROM `$table` WHERE $where";
			// echo '$sql = '.$sql.'<br>';
			$result = $pdo->query($sql);

			while ($row = $result->fetchObject()) {
				$this->pri[$count] = $row->$key;
				$this->name[$count] = $row->$key_name;
				$count++;
			}

			if($nothing){
				$this->result[0] = array(0, '없음');
				for ($i= 0; $i < $count ; $i++) { 
					$this->result[$i+1] = array($this->pri[$i], $this->name[$i]); //확인
				}
			}
			else{
				for ($i=0; $i < $count ; $i++) { 
					$this->result[$i] = array($this->pri[$i], $this->name[$i]);
				}
			}
		}
		catch(PDOException $e){
			$strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
		}
	}

	public function __destruct() { }

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

	public function result_call() {
		return $this->result;
	}
}
?>