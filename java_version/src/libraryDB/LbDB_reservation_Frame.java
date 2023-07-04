package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;

import libraryDB.LbDB_lent_Frame.tableListener;

import java.sql.*;
import java.time.*;
import java.time.format.*;

//reservation 테이블과 관련있는 event처리 클래스
public class LbDB_reservation_Frame extends LbDB_main_Frame {
	private JTextField tf_book_name, tf_research;
	private String columnName[];
	private JPanel northPanel;
	private SwingItem si;
	
	LbDB_reservation_Frame(){}
	LbDB_reservation_Frame(LbDB_DAO db, Client cl, String title) {
		String str;
		this.db = db;
		this.cl = cl;
		menu_title = title;
		pk = cl.primarykey();
		state = cl.state();
		fk = new foreignkey();
		menuform();
		Initform();
		
		sortsql = " ORDER BY library.lib_name, book.book_name";
		if(state == 1) {
			researchform();
			str = "도서관,자료이름,도서기호,예약일";
			columnName = str.split(",");
		}
		else {
			str = "도서관,자료이름,예약일";
			columnName = str.split(",");
			sql = "SELECT * FROM reservation, material, member, library, book, kind "
				+ "WHERE reservation.mat_no = material.mat_no AND reservation.mem_no = member.mem_no "
				+ "AND material.kind_no = kind.kind_no AND material.book_no = book.book_no AND material.lib_no = library.lib_no"
				+ " AND member.mem_no LIKE " + pk;
		}
		textfieldform();
		tableform(columnName);
		
		if(state == 1) {
			cpane.add("North", northPanel);
		}
		cpane.add("West", leftPanel);
		cpane.add("Center", centerPanel);
		pack();
		
		if(state != 1) {
			String now_sql = sql + sortsql;
			LoadList(now_sql);
			tablefocus();
		}
		
		addWindowListener(this);
	}
	
	LbDB_reservation_Frame(String title, SwingItem si, foreignkey fk) {
		String str;
		db = new LbDB_DAO();
		menu_title = title;
		this.si = si;
		this.fk = fk;
		dialog(menu_title);
		Initform();
		researchform();
		textfieldform();
		
		str = "도서관,자료이름,예약일";
		columnName = str.split(",");
		tableform(columnName);
		
		cpane.add("North", northPanel);
		cpane.add("Center", centerPanel);
		pack();
	}
	
	private void researchform() {
		JPanel titlePanel, researchPanel;
		JLabel label;
		JButton bt;
		
		northPanel = new JPanel();
		titlePanel = new JPanel();
		label = new JLabel(menu_title);
		titlePanel.add(label);
		
		researchPanel = new JPanel();
		label = new JLabel("검색");
		researchPanel.add(label);
		tf_research = new JTextField(10);
		tf_research.setEnabled(false);
		researchPanel.add(tf_research);
		bt = new JButton("회원검색");
		bt.addActionListener(new memberButtonListener());
		researchPanel.add(bt);
		
		northPanel.setLayout(new BoxLayout(northPanel, BoxLayout.Y_AXIS));
		northPanel.add(titlePanel);
		northPanel.add(researchPanel);
	}
	
	private void textfieldform() {
		JLabel label;
		JButton bt;
		
		setGrid(gbc,1,1,1,1);
		label = new JLabel("                      "+ menu_title + "   ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,0,2,1,1);
		label = new JLabel("    자료이름        ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,2,1,1);
		tf_book_name = new JTextField(20);
		tf_book_name.setEnabled(false);
		gbl.setConstraints(tf_book_name, gbc);
		leftPanel.add(tf_book_name);
		setGrid(gbc,0,3,1,1);
		label = new JLabel("    예약일        ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,3,1,1);
		tf_date = new JTextField(10);
		tf_date.setEnabled(false);
		gbl.setConstraints(tf_date, gbc);
		leftPanel.add(tf_date);
		setGrid(gbc,1,4,1,1);
		label = new JLabel("  ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,5,1,1);
		bt = new JButton("취소");
		bt.addActionListener(new deleteButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
	}
	
	private void tableform(String columnName[]) {
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane);
	}
	
	private void tablefocus() {
		try {
			result.first();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void removeTableRow(int row) {
		if(menu_title.equals("예약관리")) {
			table.setValueAt(null, row, 0);
			table.setValueAt(null, row, 1);
			table.setValueAt(null, row, 2);
			table.setValueAt(null, row, 3);
		}
		else {
			table.setValueAt(null, row, 0);
			table.setValueAt(null, row, 1);
			table.setValueAt(null, row, 2);
		}
	}
	
	private void MoveData() {		
		try {
			String bookname = result.getString("book.book_name");
			String date = result.getString("reservation.res_date");
			
			tf_book_name.setText(bookname);
			tf_date.setText(date);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void OutData() {
		try {
			fk.insert_mat_no(result.getInt("reservation.mat_no"));
			fk.insert_mem_no(result.getInt("reservation.mem_no"));
			si.set_lib_Box(result.getString("library.lib_name"));
			si.set_bookname(result.getString("book.book_name"));
			si.set_memid(result.getString("member.mem_id"));
			closeFrame();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void LoadList(String now_sql) {
		String kind_symbol, mat_many;
		
		System.out.println(now_sql);
		result = db.getResultSet(now_sql);
		
		for(int i = 0; i < dataCount; i++) {
			removeTableRow(i);
		}
		try {
			if(resultempty_check(result)) {
				tf_book_name.setText("");
				tf_date.setText("");
			}
			else {
				for(dataCount = 0; result.next(); dataCount++) {
					table.setValueAt(result.getString("library.lib_name"), dataCount, 0);
					table.setValueAt(result.getString("book.book_name"), dataCount, 1);
					
					mat_many = mat_manyZeroCheck(result.getString("material.mat_many"));
					kind_symbol = result.getString("kind.kind_num") + mat_many + result.getString("material.mat_overlap");
					
					if(menu_title.equals("예약내역")) {
						table.setValueAt(result.getString("reservation.res_date"), dataCount, 2);
					}
					else if(menu_title.equals("예약관리")) {
						table.setValueAt(kind_symbol, dataCount, 2);
						table.setValueAt(result.getString("reservation.res_date"), dataCount, 3);
					}
					else {
						table.setValueAt(kind_symbol, dataCount, 2);
					}
				}
			}
			repaint();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private String mat_manyZeroCheck(String mat_many) {
		String result;
		
		if(mat_many.equals("0")) {
			result = "";
		}
		else {
			result = mat_many;
		}
		
		return result;
	}
	
	private LbDB_reservation_Frame myself() {
		return this;
	}
	
	public void research() {
		sql = "SELECT * FROM reservation, material, member, library, book, kind "
			+ "WHERE reservation.mat_no = material.mat_no AND reservation.mem_no = member.mem_no "
			+ "AND material.kind_no = kind.kind_no AND material.book_no = book.book_no AND material.lib_no = library.lib_no "
			+ "AND reservation.mem_no = " + fk.call_mem_no();
		String now_sql = sql + sortsql;
		LoadList(now_sql);
		tablefocus();
		
		if(menu_title.equals("예약관리")) {
			MoveData();
		}
	}
	
	public class memberButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			LbDB_member_Frame member = new LbDB_member_Frame("회원찾기", tf_research, fk, myself());
			member.setVisible(true);
		}		
	}
	
	public class deleteButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			try {
				String now_sql = "DELETE FROM reservation WHERE res_no = " + result.getInt("reservation.res_no");
				System.out.println(now_sql);
				db.Excute(now_sql);
				now_sql = sql + sortsql;
				LoadList(now_sql);
				if(!resultempty_check(result)) {
					tablefocus();
					MoveData();
				}
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
		}		
	}
	
	public class tableListener implements ListSelectionListener{
		@Override
		public void valueChanged(ListSelectionEvent e) {
			if(e.getValueIsAdjusting())
				return;
			ListSelectionModel lsm = (ListSelectionModel)e.getSource();
			if(lsm.isSelectionEmpty())
				System.out.println("No columns are selected");
			else {
				selectedCol = lsm.getMinSelectionIndex();
				if(selectedCol >= dataCount)
					System.out.println("data is Empty");
				else {
					tf_book_name.setText(table.getValueAt(selectedCol, 0).toString());
					if(menu_title.equals("예약관리")) {
						tf_date.setText(table.getValueAt(selectedCol, 3).toString());
					}
					
					try {
						result.absolute(selectedCol + 1);
						if(menu_title.equals("예약찾기")) {
							OutData();
						}
						else {
							MoveData();
						}
					} catch (SQLException e1) {
						e1.printStackTrace();
					}
					repaint();
				}
			}
		}
	}
}
