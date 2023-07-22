<?php
class Automatic {
    private $pdo;
	private $sql;
	private $result;
	private $mem_no[];
    private static $today = strtotime(date("Y-m-d"));
	
	public function __construct(PDO pdo) {
		$this->pdo = pdo;
		overdue_manager();
		clearmember();
	}
	
	private funciont overdue_manager() {
		$len_no[];
		$estimate_date;
		
		$this->sql = "SELECT * FROM lent WHERE len_re_date is NULL";
		echo 'overdue_manager에 sql값: '.$this->sql.'<br>';
		$result = $pdo->query($this->sql);
		$num = $result->columnCount();
		$count = 0;
		$len_no_array[];

		if($num != 0) {	
			try {
				while($row = $result->fetchObject()) {
					$estimate_date = estimateReturndate($row->len_date, $row->len_re_st);
					if(estimate_date >= today ) {
						$this->sql = 'UPDATE member SET mem_state = 2 WHERE mem_no = '.$row->mem_no;
						$pdo->exec($sql);
						$len_no_array[$count] = $row->len_no;
						$count++;
					}
				}

				for($i = 0; $i < $count + 1; $i++) {
					$this->sql = 'SELECT * FROM overdue WHERE len_no = '.$len_no_array[$i];
					$result = $pdo->query($this->sql);
					$num = $result->columnCount();

					if($num != 0){
						
					}
				}
			}
			catch(PDOException $e){
				$strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
			}
			
		}
		
		if() {
			try {
				// while(result.next()) {
				// 	$estimate_date = estimateReturndate(result.getString("len_date"), result.getInt("len_re_st"));
				// 	System.out.println("대출일: " + result.getString("len_date") + ", 반납예정일: " + estimate_date);
				// 	if(estimate_date.isBefore(today)) {
				// 		num++;
				// 	}
				// }
				
				
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			for(int i = 0; i < mem_no.length; i++) {
				sql = "UPDATE member SET mem_state = 2 WHERE mem_no = " + mem_no[i];
				System.out.println(sql);
				$pdo.Excute(sql);
			}
			
			for(int i = 0; i < len_no.length; i++) {
				sql = "SELECT * FROM overdue WHERE len_no = " + len_no[i];
				result = $pdo.getResultSet(sql);
				
				if(resultempty_check(result)) {
					sql = "INSERT INTO overdue SET len_no = " + len_no[i];
					System.out.println(sql);
					$pdo.Excute(sql);
				}
			}
		}
	}
	
	private funciont clearmember() {
		int num = 0;
		LocalDate before_week_date;
		
		before_week_date = today.minusDays(7);
		sql = "SELECT * FROM lent INNER JOIN overdue ON lent.len_no = overdue.len_no WHERE overdue.due_exp BETWEEN '" 
			+ before_week_date + "' AND '" + today + "'";
		System.out.println(sql);
		result = $pdo.getResultSet(sql);
		
		if(!resultempty_check(result)) {
			try {
				while(result.next()) {
					num++;
				}
				
				if(num != 0) {
					result.beforeFirst();
					mem_no = new int[num];
					num = 0;
					
					while(result.next()) {
						mem_no[num] = result.getInt("lent.mem_no");
						num++;
					}	
				}
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			for(int i = 0; i < mem_no.length; i++) {
				sql = "UPDATE member SET mem_state = 0 WHERE mem_no = " + mem_no[i];
				System.out.println(sql);
				$pdo.Excute(sql);
			}
		}
	}
	
	public function estimateReturndate(string $lentdate, int $extend) { //lentdate타입 확인
		// TODO Auto-generated method stub
		$period = 15;

		$period += $extend;
		$date = date("Y-m-d", strtotime($lentdate.'+ '.$period.' days'));
		echo 'date의 값: '.$date.'<br>';

		return $date;
	}
}