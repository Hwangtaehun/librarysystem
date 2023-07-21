<?php
class Automatic {
    private $pdo;
	private $sql;
	private $result;
	private $mem_no[];
    private static $today = date("Y-m-d");
	
	public function __construct(PDO pdo) {
		$this->pdo = pdo;
		overdue_manager();
		clearmember();
	}
	
	private funciont overdue_manager() {
		$num = 0;
		$len_no[];
		$estimate_date;
		
		$this->sql = "SELECT * FROM lent WHERE len_re_date is NULL";
		echo 'overdue_manager에 sql값: '.$sql.'<br>';
		$result = $pdo->query($sql);
		
		if(!resultempty_check(result)) {
			try {
				while(result.next()) {
					estimate_date = estimateReturndate(result.getString("len_date"), result.getInt("len_re_st"));
					System.out.println("대출일: " + result.getString("len_date") + ", 반납예정일: " + estimate_date);
					if(estimate_date.isBefore(today)) {
						num++;
					}
				}
				
				if(num != 0) {
					result.beforeFirst();
					len_no = new int[num];
					mem_no = new int[num];
					num = 0;
					
					while(result.next()) {
						estimate_date = estimateReturndate(result.getString("len_date"), result.getInt("len_re_st"));
						if(estimate_date.isBefore(today)) {
							len_no[num] = result.getInt("len_no");
							mem_no[num] = result.getInt("mem_no");
							System.out.println("len_no: " + len_no[num] + ", mem_no: " + mem_no[num]);
							num++;
						}
					}
				}
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
	
	private function resultempty_check(PDOStatement $rs) {
		$num = 0;
		$bool = false;
		
		try {
			while(rs.next()) {
				num++;
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		if(num == 0) {
			bool = true;
		}
		
		try {
			rs.beforeFirst();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		return bool;
	}
	
	public function estimateReturndate($lentdate, int $extend) { //lentdate타입 확인
		// TODO Auto-generated method stub
		$period = 15;

		$period += $extend;
		$date = date("Y-m-d", strtotime($extned.'day', $lentdate));
		ecah 'date의 값: '.$date.'<br>';

		return $date;
	}
}