<?php
class Assistance{
    //문자가 정수인지 확인하는 함수
	public function isInteger(String $strValue) {
	    $num = (int)$strValue;
        return is_int($num);
	}
	
	//문자가 실수인지 확인하는 함수
	public function isFloat(String $strValue) {
	    $num = (float)$strValue;
        return is_float($num);
	}
	
	//날짜형식 확인하는 함수
	public function dateformat_check(String $date_string) { 
		$bool = true;
		$year = 0;
		$month = 0;
		$day = 0;
		$max = 0;
		$date_array = explode( '-', $date_string );
		
		if(sizeof($date_array) == 3) {
			if($this->isInteger($date_array[0])) {
				$temp = $date_array[0];
				$year = (int)$temp;
				if($this->isInteger($date_array[1])) {
					$temp = $date_array[1];
					$month =  (int)$temp;
					if($this->isInteger($date_array[2])) {
						$temp = $date_array[2];
						$day =  (int)$temp;
					}
				}
			}
		}
		
		if($year > 0 && $month > 0 && $day > 0) {
			if($month < 13) {
				if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
					$max = 32;
				}
				else if($month == 4 || $month == 6 || $month == 9 || $month == 11) {
					$max = 31;
				}
				else {
					if($year%400 == 0 || ($year % 4 == 0 && $year % 100 != 0)) {
						$max = 30;
					}
					else {
						$max = 29;
					}
				}
				
				if(mb_strlen($date_array[0], "UTF-8") == 4) {
					if($day < $max) {
						$bool = false;
					}
				}
			}
		}
		
		return $bool;
	}
	
	//쿼리 결과가 없는지 확인
	public function resultempty_check(PDOStatement $rs) {
		$bool = false;
		
		try {
            $num = $rs->rowCount();
            
            if($num === 0) {
                $bool = true;
            }
		}
        catch (PDOException $e) {
			$strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
		}

		return $bool;
	}

	//반납 날짜 계산
	public function estimateReturndate(string $lentdate, int $extend) {
		$period = 15;

		$period += $extend;
		$date = date("Y-m-d", strtotime($lentdate.'+ '.$period.' days'));

		return $date;
	}

	//복권심볼 삭제
	public function removeSymbol(string $str) {
		$str_array = [];
		
		if($this->isInteger($str)) {
			$str_fianl = "";
			return $str_fianl;
		}
		
		$str_fianl = "";
		$str_array = mb_str_split($str, $split_length = 1, $encoding = "utf-8");
		
		for($i = 2; $i < sizeof($str_array); $i++) {
			$str_fianl += $str_array[$i];
		}

		return $str_fianl;
	}

	//도서관 이름 배열 만들기
	public function libraryarray(PDO $pdo){
        $num = 1;
		$sql = "SELECT * FROM `library`";
        $result = $pdo->query($sql);
        $lib_array[0] = '없음';
        foreach($result as $row):
            $lib_array[$num] = $row['lib_name'];
            $num++;
        endforeach;
        return $lib_array;
    }
}
?>