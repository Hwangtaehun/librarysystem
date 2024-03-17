<?php
class Common{
	private $listnum = 19;
    private $table = 'kind';
    private $func = '';
    private $m_get = '';
    private $result;

    //page번호 달기 만들기위한 html제작
	private function pagemanager(int $total_cnt, string $value){
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
                $outStr = '<div class="page"> <div aria-label="Page navigation example"> <ul class="pagination justify-content-center">';
                if($sup_pg != 0){
                    $go_pg = $sup_pg - 1;
                    $outStr .= '<li class="page-item"> <a class="page-link" href="/'.$this->table.'/'.$this->func.'list?sup_pg='.$go_pg.'&page='.$m_page.$this->m_get.'" aria-label="Previous"> 
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
                        $outStr .= '<li class="page-item"><a class="page-link" href="/'.$this->table.'/'.$this->func.'list?sup_pg='.$go_pg.'&page='.$start_num.$this->m_get.'">'.$str_num.'</a></li>';
                    }
                }

                if($sup_pg != $sp_pg-1){
                    $go_pg = $sup_pg + 1;
                    $outStr .= '<li class="page-item"> <a class="page-link" href="/'.$this->table.'/'.$this->func.'list?sup_pg='.$go_pg.'&page='.$m_page.$this->m_get.'" aria-label="Next"> 
                                <span aria-hidden="true">&raquo;</span> </a> </li>';
                }

                $outStr .= '</ul> </div> </div>';
            }else{
                $outStr = '<div class="page"> <div aria-label="Page navigation example"> <ul class="pagination justify-content-center">';
                if($sup_pg != 0){
                    $go_pg = $sup_pg - 1;
                    $outStr .= '<li class="page-item"> 
                                <a class="page-link" href="/'.$this->table.'/'.$this->func.'research?sup_pg='.$go_pg.'&page='.$m_page.'&value='.$value.$this->m_get.'" aria-label="Previous"> 
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
                        $outStr .= '<li class="page-item">
                                    <a class="page-link" href="/'.$this->table.'/'.$this->func.'research?sup_pg='.$go_pg.'&page='.$start_num.'&value='.$value.$this->m_get.'">'.$str_num.'</a></li>';
                    }
                }

                if($sup_pg != $sp_pg-1){
                    $go_pg = $sup_pg + 1;
                    $outStr .= '<li class="page-item"> 
                                <a class="page-link" href="/'.$this->table.'/'.$this->func.'research?sup_pg='.$go_pg.'&page='.$m_page.'&value='.$value.$this->m_get.'" aria-label="Next"> 
                                <span aria-hidden="true">&raquo;</span> </a> </li>';
                }

                $outStr .= '</ul> </div> </div>';
            }
        }
        return $outStr;
    }

    //페이지 번호 매기기에 맞는 sql제작
    private function pagesql(string $where){
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

    //테이블 이름
    protected function tablename(string $table){
        $this->table = $table;
    }

    //함수 이름
    protected function funName(string $func){
        $this->func = $func;
    }

    //get 파라미터 입력
    protected function getValue(string $m_get){
        $this->m_get = $m_get;
    }

    //result 값 가져오는 함수
    protected function getResult(){
        return $this->result;
    }

    //문자가 정수인지 확인하는 함수
	protected function isInteger(String $strValue) {
	    $num = (int)$strValue;
        return is_int($num);
	}
	
	//문자가 실수인지 확인하는 함수
	protected function isFloat(String $strValue) {
	    $num = (float)$strValue;
        return is_float($num);
	}

    //한 페이지에 보여지는 정보 크기
    protected function listchange(int $num){
        $this->listnum = $num;
    }
	
	//날짜형식 확인하는 함수
	protected function dateformat_check(String $date_string) { 
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
	protected function resultempty_check(PDOStatement $rs) {
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
	protected function estimateReturndate(string $lentdate, int $extend) {
		$period = 15;

		$period += $extend;
		$date = date("Y-m-d", strtotime($lentdate.'+ '.$period.' days'));

		return $date;
	}

    //페이그멘테이션 만들기
    protected function makePage(TableManager $mainTable, int $total_cnt, string $sql, bool $iswhere){
        $value = '없음';

        if(isset($_GET['value'])){
            $value = $_GET['value'];
        }
        
        $sql = $this->pagesql($sql);

        if($iswhere){
            $stmt = $mainTable->whereSQL($sql);
            $result = $stmt->fetchAll();
            $pagi = $this->pagemanager($total_cnt, $value);
        }else{
            $stmt = $mainTable->joinSQL($sql);
            $result = $stmt->fetchAll();
            $pagi = $this->pagemanager($total_cnt, $value);
        }

        $this->result = $result;
        return $pagi;
    }

    //대출이 가능한지 확인
    protected function lentpossible(int $mem_no, TableManager $memTable, TableManager $lenTable){
        $result = $memTable->selectID($mem_no);
        $mem_lent = $result['mem_lent'];

        $where = "WHERE `mem_no` = $mem_no AND `len_re_date` IS NULL";
        $rs = $lenTable->whereSQL($where);
        $num = $rs->rowCount();

        if($num > $mem_lent){
            echo "<script>alert('대출가능수를 초과했습니다.');</script>";
            return false;
        }

        return true;
    }

    //자료가 있는지 확인
    protected function existMat(int $mat_no, int $mat_exist, TableManager $lenTable, TableManager $delTable, TableManager $matTable){
        $bool = true;

        if($mat_exist == 1){
            $where = "WHERE `mat_no` = $mat_no AND `len_re_st` = 0";
            $rs = $lenTable->whereSQL($where);
            $bool = $this->resultempty_check($rs);

            if($bool){
                $where = "WHERE `mat_no` =  $mat_no AND `del_app` = 1 AND `len_no` IS NULL";
                $rs = $delTable->whereSQL($where);
                $bool = $this->resultempty_check($rs);
            }
            
            if($bool){
                $where = "WHERE `mat_no` =  $mat_no AND `del_app` = 2 AND `del_arr_date` IS NULL";
                $rs = $delTable->whereSQL($where);
                $bool = $this->resultempty_check($rs);
            }

            if($bool){
                $bool = false;
            }else{
                $bool = true;
            }
        }

        if($bool){
            $param = ['mat_no'=>$mat_no,'mat_exist'=>$mat_exist];
            $matTable->updateData($param);
        }
    }

    //예약도서인지 확인 만약에 예약도서이면 현재 회원키와 예약도서 예약된 회원키를 같으면 대출 아니면 대출 거절
    protected function reservationCheck(int $res_no, int $mat_no, TableManager $resTable){
        $rs = false;

        if($res_no == ''){
            $where = "WHERE `mat_no` = $mat_no";
            $stmt = $resTable->whereSQL($where);
            $num = $stmt->rowCount();
            
            if($num == 0){
                $rs = true;
            }
            else{
                $row = $stmt->fetch();
                if($row['mem_no'] == $_POST['mem_no']){
                    $rs = true;
                    $res_no = $row['res_no'];
                }
            }
        }
        else{
            $row = $resTable->selectID($res_no);//

            if($row['mem_no'] == $_POST['mem_no']){
                $rs = true;
            }
            else{
                $rs = false;
            }
        }
        
        if($rs == false){
            echo "<script>alert('다른 회원이 예약한 도서입니다.');</script>";
        }else{
            $resTable->deleteData($res_no);
        }

        return $rs;
    }
}
?>