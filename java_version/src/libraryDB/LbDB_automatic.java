package libraryDB;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.*;
import java.time.format.*;

public class LbDB_automatic implements todayinterface {
	private LbDB_DAO db;
	private String sql;
	private ResultSet result;
	private int len_no[];
	
	public LbDB_automatic() {}
	public LbDB_automatic(LbDB_DAO db) {
		int num = 0;
		this.db = db;
		sql = "SELECT * FROM member, lent WHERE lent.mem_no = member.mem_no AND lent.lent_re_date is NULL";
		result = db.getResultSet(sql);
		
		if(!resultempty_check(result)) {
			try {
				while(result.next()) {
					num++;
				}
				
				len_no = new int[num];
				num = 0;
				
				while(result.next()) {
					len_no[num] = result.getInt("lent.len_no");
					num++;
				}
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
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
		System.out.println("date: " + date + ", period: " + period);
		
		return date;
	}
}
