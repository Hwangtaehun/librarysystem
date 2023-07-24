<?php
class Automatic {
    private $pdo;
	private $sql;
	private $result;
    private $str_today;
	
	public function __construct(PDO pdo) {
		$this->pdo = $pdo;
		$this->str_today = date("Y-m-d");
		$this->overdue_manager();
		$this->clearmember();
	}
	
	private function overdue_manager() {
		$this->sql = "SELECT * FROM lent WHERE len_re_date is NULL";
		echo "overdue_manager에 sql값: $this->sql<br>";
		$result = $this->pdo->query($this->sql);
		$num = $result->rowCount();
		$count = 0;
		echo '$num = '.$num.', $count = '.$count;

		if($num != 0) {	
			try {
				while($row = $result->fetchObject()) {
					$str_estimate_date = $this->estimateReturndate($row->len_date, $row->len_re_st);
					$estimate_date = strtotime($str_estimate_date);
					$today = strtotime($this->str_today);
					echo "\$estimate_date: $estimate_date, \$today: $today";
					echo '<br>';
					if($estimate_date < $today ) {
						$len_no_array[$count] = $row->len_no;
						echo '$len_no_array['.$count.'] = '.$len_no_array[$count].'<br>';
						$count++;
						$this->sql = "UPDATE member SET mem_state = 2 WHERE mem_no = $row->mem_no";
						echo '$sql: '.$this->sql.'데이터타입: '.gettype($this->sql);
						$this->pdo->exec($this->sql);
					}
				}

				for($i = 0; $i < $count; $i++) {
					$this->sql = "SELECT * FROM overdue WHERE len_no = $len_no_array[$i]";
					echo '$sql: '.$this->sql.'<br>';
					$result = $this->pdo->query($this->sql);
					$num = $result->rowCount();

					if($num == 0){
						$this->sql = "INSERT INTO overdue SET len_no = $len_no_array[$i]";
						echo '$sql: '.$this->sql.'<br>';
						$this->pdo->exec($this->sql);
					}
				}
			}
			catch(PDOException $e){
				$strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
			}
		}
	}
	
	private function clearmember() {
		$this->sql = "SELECT * FROM lent INNER JOIN overdue ON lent.len_no = overdue.len_no WHERE overdue.due_exp <= '$this->str_today'";
		echo '$sql: '.$this->sql.'<br>';
		$result = $this->pdo->query($this->sql);
		$result->setFetchMode(PDO::FETCH_NUM);
		$num = $result->rowCount();

		// 속성 값과 컬럼 값 출력
		// while($row = $result->fetchObject()) {
		// 	echo "<pre>";
    	// 	print_r($row);
    	// 	echo "</pre>";
		// 	echo '$row[mem]'.$row[mem];
		// }

		if($num != 0) {
			try {
				$num = 0;
				while($row = $result->fetchObject()) {
					$mem_no[$num] = $row->mem_no;
					$due_no[$num] = $row->due_no;
					$num++;
				}

				for($i = 0; $i < $num; $i++) {
					$this->sql = "UPDATE member SET mem_state = 0 WHERE mem_no = $mem_no[$i]";
					echo 'sql의 값: '.$this->sql;
					$this->pdo->exec($this->sql);
					$this->sql = "DELETE FROM overdue WHERE due_no = $due_no[$i]";
					echo 'sql의 값: '.$this->sql;
					$this->pdo->exec($this->sql);
				}
			} catch(PDOException $e){
				$strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
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