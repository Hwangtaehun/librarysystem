<?php
class Assistance{
	private $listnum = 19;

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

	//도서관 이름 배열 만들기
	public function libraryarray(PDO $pdo){
        $num = 1;
		$sql = "SELECT * FROM `library`";
        $result = $pdo->query($sql);
        $lib_array[0] = ' ';
        foreach($result as $row):
            $lib_array[$num] = $row['lib_name'];
            $num++;
        endforeach;
        return $lib_array;
    }

    public function listchange(int $num){
        $this->listnum = $num;
    }

    //page번호 달기 만들기위한 html제작
	public function pagemanager(int $total_cnt, string $value){
        $pagenum = 19;
        $outStr= '';

        if(20 < $total_cnt){
            $total_pages = floor($total_cnt/$this->listnum);
            $sp_pg = ceil($total_pages/$pagenum);

            if(isset($_GET['sup_pg'])){
                $sup_pg = $_GET['sup_pg'];
            }
            else{
                $sup_pg = 0;
            }

            if(isset($_GET['page'])){
                $m_page = $_GET['page'];
            }
            else{
                $m_page = 1;
            }
            
            if($value == '없음'){           
                $outStr = '<div class="page"> <div aria-label="Page navigation example"> <ul class="pagination justify-content-center"> <ul class="pagination">';
                if($sup_pg != 0){
                    $go_pg = $sup_pg - 1;
                    $outStr .= '<li class="page-item"> <a class="page-link" href="/kind/list?sup_pg='.$go_pg.'&page='.$m_page.'" aria-label="Previous"> 
                                <span aria-hidden="true">&laquo;</span> </a> </li>';
                }
                for ($i=0; $i < 19 ; $i++) { 
                    $go_pg = $sup_pg;
                    $page = $sup_pg * 19 + $i;

                    if($page <= $total_pages - 1){
                        $num = $page + 1;
                        if($num < 10){
                            $str_num = '0'.$num;
                        }else{
                            $str_num = strval($num);
                        }

                        $start_num = $page * $this->listnum;
                        $outStr .= '<li class="page-item"><a class="page-link" href="/kind/list?sup_pg='.$go_pg.'&page='.$start_num.'">'.$str_num.'</a></li>';
                    }
                }

                if($sup_pg != $sp_pg-1){
                    $go_pg = $sup_pg + 1;
                    $outStr .= '<li class="page-item"> <a class="page-link" href="/kind/list?sup_pg='.$go_pg.'&page='.$m_page.'" aria-label="Next"> 
                                <span aria-hidden="true">&raquo;</span> </a> </li>';
                }

                $outStr .= '</ul> </ul> </div> </div>';
            }else{
                $outStr = '<div class="page"> <div aria-label="Page navigation example"> <ul class="pagination justify-content-center"> <ul class="pagination">';
                if($sup_pg != 0){
                    $go_pg = $sup_pg - 1;
                    $outStr .= '<li class="page-item"> <a class="page-link" href="/kind/research?sup_pg='.$go_pg.'&page='.$m_page.'&value='.$value.'" aria-label="Previous"> 
                                <span aria-hidden="true">&laquo;</span> </a> </li>';
                }
                for ($i=0; $i < 19 ; $i++) { 
                    $go_pg = $sup_pg;
                    $page = $sup_pg * 19 + $i;

                    if($page <= $total_pages - 1){
                        $num = $page + 1;
                        if($num < 10){
                            $str_num = '0'.$num;
                        }else{
                            $str_num = strval($page);
                        }

                        $start_num = $page * $this->listnum;
                        $outStr .= '<li class="page-item"><a class="page-link" href="/kind/research?sup_pg='.$go_pg.'&page='.$start_num.'&value='.$value.'">'.$str_num.'</a></li>';
                    }
                }

                if($sup_pg != $sp_pg-1){
                    $go_pg = $sup_pg + 1;
                    $outStr .= '<li class="page-item"> <a class="page-link" href="/kind/research?sup_pg='.$go_pg.'&page='.$m_page.'&value='.$value.'" aria-label="Next"> 
                                <span aria-hidden="true">&raquo;</span> </a> </li>';
                }

                $outStr .= '</ul> </ul> </div> </div>';
            }
        }
        return $outStr;
    }

    //페이지 번호 매기기에 맞는 sql제작
    public function pagesql(string $where){
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        else{
            $page = 0;
        }

        $limit = " LIMIT $page,$this->listnum";

        if($where == ''){
            $where = $limit;
        }else{
            $where = $where.$limit;
        }

        return $where;
    }

    public function rentpossible($mem_no, $memTable, $lenTable){
        $result = $memTable->selectID($mem_no);
        $mem_lent = $result['mem_lent'];

        $where = "WHERE `mem_no` = $mem_no AND `len_re_date` IS NULL";
        $rs = $lenTable->whereSQL($where);
        $num = $rs->rowCount();

        if($num > $mem_lent){
            return false;
        }

        return true;
    }
}
?>