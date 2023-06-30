package libraryDB;
import javax.swing.table.*;

//테이블 생성 클래스
public class LbDB_TableMode extends AbstractTableModel{
	private Object data[][];
	private String columnName[];
	private int nColumn, nRow, nData;
	
	public LbDB_TableMode() {}
	public LbDB_TableMode(int column, String header[]) {
		nData = 0;
		nRow = 20;
		nColumn = column;
		columnName = header;
		data = new Object[nRow][nColumn];
	}
	
	@Override
	public int getColumnCount() {
		return nColumn;
	}
	
	@Override
	public int getRowCount() {
		return nRow;
	}
	
	@Override
	public Object getValueAt(int row, int column) {
		return data[row][column];
	}
	
	public void setValueAt(Object value, int row , int column) {
		if(row >= nRow)
			expand(row);
		data[row][column] = value;
	}
	
	private void expand(int row) {
		Object temp[][] = new Object[nRow*2][nColumn];
		for(int i = 0; i < nRow; i++) {
			for(int j = 0; j < nColumn; j++) {
				temp[i][j] = data[i][j];
			}
		}
		nRow *= 2;
		data = temp;
	}
	
	public int getDataCount() {
		return nData;
	}
	
	public String getColumnName(int col) {
		return columnName[col];
	}
	
	public boolean isCellEditable(int row, int col) {
		boolean bool = (col != 0) ? true : false;
		return bool;
	}
}
