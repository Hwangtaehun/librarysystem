<?php
class Assistance{
	private $lib_sql = "SELECT * FROM `library`";
    private $lib_index = 'lib_name';

    //도서관 이름 배열 만들기
	public function libraryarray(PDO $pdo){
        $num = 1;
		
        $result = $pdo->query($this->lib_sql);
        $lib_array[0] = ' ';
        foreach($result as $row):
            $lib_array[$num] = $row[$this->lib_index];
            $num++;
        endforeach;
        return $lib_array;
    }

    //복권심볼 삭제
	public function removeSymbol(string $str) {
		$str_array = [];

		if(is_numeric($str)) {
			$str_fianl = "";
			return $str_fianl;
		}
		
		$str_fianl = "";
		$str_array = mb_str_split($str, $split_length = 1, $encoding = "utf-8");
		
		for($i = 2; $i < sizeof($str_array); $i++) {
			$str_fianl = $str_fianl.$str_array[$i];
		}

		return $str_fianl;
	}
}
?>