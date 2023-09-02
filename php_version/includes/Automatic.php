<?php
class Automatic {
    private $pdo;
    private $str_today;
	
	public function __construct($pdo) {
		$this->pdo = $pdo;
		$this->str_today = date("Y-m-d");
		$this->clearmember();
		$this->overdue_manager();
		$this->delreturn();
	}
	
	private function overdue_manager() {
		$sql = "SELECT * FROM lent WHERE len_re_date is NULL";
		$result = $this->pdo->query($sql);
		$num = $result->rowCount();
		$count = 0;

		if($num != 0) {	
			try {
				while($row = $result->fetchObject()) {
					$str_estimate_date = $this->estimateReturndate($row->len_date, $row->len_re_st);
					$estimate_date = strtotime($str_estimate_date);
					$today = strtotime($this->str_today);
					if($estimate_date < $today ) {
						$len_no_array[$count] = $row->len_no;
						$count++;
						$sql = "UPDATE member SET mem_state = 2 WHERE mem_no = $row->mem_no";
						$this->pdo->exec($sql);
					}
				}

				for($i = 0; $i < $count; $i++) {
					$sql = "SELECT * FROM overdue WHERE len_no = $len_no_array[$i]";
					$result = $this->pdo->query($sql);
					$num = $result->rowCount();

					if($num == 0){
						$sql = "INSERT INTO overdue SET len_no = $len_no_array[$i]";
						$this->pdo->exec($sql);
					}
				}
			}
			catch(PDOException $e){
				$strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
				echo $strMsg;
			}
		}
	}
	
	private function clearmember() {
		$sql = "SELECT * FROM lent INNER JOIN overdue ON lent.len_no = overdue.len_no WHERE overdue.due_exp <= '$this->str_today'";
		$result = $this->pdo->query($sql);
		$result->setFetchMode(PDO::FETCH_NUM);//null값 때문에 사용
		$num = $result->rowCount();

		if($num != 0) {
			try {
				$num = 0;
				while($row = $result->fetchObject()) {
					$mem_no[$num] = $row->mem_no;
					$due_no[$num] = $row->due_no;
					$num++;
				}

				for($i = 0; $i < $num; $i++) {
					$sql = "UPDATE member SET mem_state = 0 WHERE mem_no = $mem_no[$i]";
					$this->pdo->exec($sql);
					$sql = "DELETE FROM overdue WHERE due_no = $due_no[$i]";
					$this->pdo->exec($sql);
					$sql= "SELECT * FROM overdue, lent WHERE overdue.len_no = lent.len_no AND lent.mem_no = $mem_no[$i]";
					$stmt = $this->pdo->query($sql);
					$count = $stmt->rowCount();
					if($count != 0){
						$sql = "UPDATE member SET mem_state = 2 WHERE mem_no = $mem_no[$i]";
						$this->pdo->exec($sql);
					}
				}
			} catch(PDOException $e){
				$strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
				echo $strMsg;
			}
		}
	}

	private function delreturn(){
		$date = date("Y-m-d", strtotime($this->str_today.'-4 days'));
		$sql = "SELECT `del_no` FROM `delivery` WHERE len_no IS NULL AND `del_arr_date` < '$date'";
		$result = $this->pdo->query($sql);
		$num = $result->rowCount();

		if($num != 0){
			try {
				$num = 0;
				while($row = $result->fetchObject()){
					$del_no[$num] = $row->del_no;
					$num++;
				}

				for ($i=0; $i < $num; $i++) { 
					$sql = "UPDATE delivery SET del_app = 2 WHERE del_no = $del_no[$i]";
					$this->pdo->exec($sql);
				}
			} catch (PDOException $e){
				$strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
				echo $strMsg;
			}
		}
	}
	
	private function estimateReturndate(string $lentdate, int $extend) {
		$period = 15;

		$period += $extend;
		$date = date("Y-m-d", strtotime($lentdate.'+ '.$period.' days'));

		return $date;
	}
}