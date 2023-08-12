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
	
	public function mat_manyZeroCheck(String $mat_many) {
		if($mat_many === "0") {
			$result = '';
		}
		else {
			$result = $mat_many.' ';
		}
		
		return $result;
	}
}
?>