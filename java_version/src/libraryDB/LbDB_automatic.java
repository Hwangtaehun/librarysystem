package libraryDB;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.*;

public class LbDB_automatic implements todayinterface {
	private LbDB_DAO db;
	private String sql;
	private ResultSet result;
	private int mem_no[];
	private int due_no[];
	
	public LbDB_automatic() {}
	public LbDB_automatic(LbDB_DAO db) {
		this.db = db;
		clearmember();
		overdue_manager();
	}
	
	private void overdue_manager() {//대출일과 연장여부를 통해서 반납일 확인한 후에 반납일 지난 회원계정 정지
		int num = 0;
		int len_no[] = null;
		LocalDate estimate_date;
		
		sql = "SELECT * FROM lent WHERE len_re_date is NULL";
		System.out.println(sql);
		result = db.getResultSet(sql);
		
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
				db.Excute(sql);
			}
			
			for(int i = 0; i < len_no.length; i++) {
				sql = "SELECT * FROM overdue WHERE len_no = " + len_no[i];
				result = db.getResultSet(sql);
				
				if(resultempty_check(result)) {
					sql = "INSERT INTO overdue SET len_no = " + len_no[i];
					System.out.println(sql);
					db.Excute(sql);
				}
			}
		}
	}
	
	private void clearmember() {//해제일 지난 회원은 연체관리 테이블에서 삭제 및 회원계정 활성화
		int num = 0;
		LocalDate before_week_date;
		
		sql = "SELECT * FROM lent INNER JOIN overdue ON lent.len_no = overdue.len_no WHERE overdue.due_exp <= '"  + today + "'";
		System.out.println(sql);
		result = db.getResultSet(sql);
		
		if(!resultempty_check(result)) {
			try {
				while(result.next()) {
					num++;
				}
				
				if(num != 0) {
					result.beforeFirst();
					mem_no = new int[num];
					due_no = new int[num];
					num = 0;
					
					while(result.next()) {
						mem_no[num] = result.getInt("lent.mem_no");
						due_no[num] = result.getInt("overdue.due_no");
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
				db.Excute(sql);
				sql = "DELETE FROM overdue WHERE due_no = " + due_no[i];
				System.out.println(sql);
				db.Excute(sql);
			}
		}
	}
	
	private boolean resultempty_check(ResultSet rs) {
		int num;
		boolean bool;
		
		num = 0;
		bool = false;
		
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
	
	@Override
	public LocalDate estimateReturndate(String lentdate, int extend) {
		// TODO Auto-generated method stub
		int period = 15;
		LocalDate date;
		
		date = LocalDate.parse(lentdate);
		period += extend;
		date = date.plusDays(period);
		
		return date;
	}
}
