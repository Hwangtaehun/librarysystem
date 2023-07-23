<?php
class Automatic {
    private $pdo;
	private $sql;
	private $result;
    private $str_today;
	
	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
		$this->str_today = date("Y-m-d");
		$this->overdue_manager();
		$this->clearmember();
	}
	
	private function overdue_manager() {
		$this->sql = "SELECT * FROM lent WHERE len_re_date is NULL";
		echo "overdue_manager에 sql값: $this->sql<br>";
		$result = $this->pdo->query($this->sql);
		$num = $result->columnCount();
		$count = 0;

		if($num != 0) {	
			try {
				while($row = $result->fetchObject()) {
					$str_estimate_date = $this->estimateReturndate($row->len_date, $row->len_re_st);
					$estimate_date = strtotime($str_estimate_date);
					$today = strtotime($this->str_today);
					echo "\$estimate_date: $estimate_date, \$today: $today";
					echo '<br>';
					if($estimate_date >= $today ) {
						echo "실행완료";
						$this->sql = "UPDATE member SET mem_state = 2 WHERE mem_no = $row->mem_no";
						echo '$sql: '.$this->sql;
						$this->pdo->exec($sql);
						$len_no_array[$count] = $row->len_no;
						$count++;
					}
				}

				for($i = 0; $i < $count; $i++) {
					$this->sql = "SELECT * FROM overdue WHERE len_no = $len_no_array[$i]";
					echo '$sql: '.$this->sql;
					$result = $this->pdo->query($this->sql);
					$num = $result->columnCount();

					if($num != 0){
						$this->sql = "INSERT INTO overdue SET len_no = $len_no_array[$i]";
						echo '$sql: '.$this->sql;
						$this->pdo->exec($sql);
					}
				}
			}
			catch(PDOException $e){
				$strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
			}
		}
	}
	
	private function clearmember() {
		$num = 0;
		$before_week_date = date("Y-m-d", strtotime($this->str_today.'-7 days'));
		$this->sql = "SELECT * FROM lent INNER JOIN overdue ON lent.len_no = overdue.len_no WHERE overdue.due_exp BETWEEN '$before_week_date' AND '$this->str_today'";
		echo '$sql: '.$this->sql;
		$result = $this->pdo->query($this->sql);
		$num = $result->columnCount();
		
		if($num != 0) {
			try {
				$num = 0;

				foreach ($result as $row) {
					$mem_no[num] = $row[lent.mem_no];
					$num++;
				}

				for($i = 0; $i < $num; $i++) {
					$this->sql = "UPDATE member SET mem_state = 0 WHERE mem_no = $mem_no[$i]";
					echo 'sql의 값: '.$this->sql;
					$pdo->exec($sql);
				}
			} catch(PDOException $e){
				$strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
			}
		}
	}
	
	public function estimateReturndate(string $lentdate, int $extend) {
		$period = 15;

		$period += $extend;
		$date = date("Y-m-d", strtotime($lentdate.'+ '.$period.' days'));

		return $date;
	}
}

$pdo = new PDO('mysql:host=localhost;dbname=librarydb;charset=utf8','mysejong','sj4321');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$class = new Automatic($pdo);