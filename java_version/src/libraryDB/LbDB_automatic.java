package libraryDB;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.*;
import java.time.format.*;

public class LbDB_automatic implements todayinterface {
	
	public LbDB_automatic() {}
	
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
