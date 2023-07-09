package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;

import libraryDB.LbDB_lent_Frame.tableListener;

import java.sql.*;

//연체관리와 대출장소관리 부분 사용하는 클래스
public class LbDB_etc_Frame extends LbDB_main_Frame { //kind와 member테이블 수정시 다시 작성
	private JTextField tf_mem_id, tf_book_name, tf_len_date, tf_len_re_date;
	private Combobox_Manager lib_len_manager, lib_re_manager;
	private String[] library_array;
	
	public LbDB_etc_Frame() {}
	public LbDB_etc_Frame(LbDB_DAO db, Client cl, String title) {
		this.db = db;
		this.cl = cl;
		menu_title = title;
		pk = cl.primarykey();
		state = cl.state();
		fk = new foreignkey();
		menuform();
		Initform();
		baseform();
		if(menu_title.equals("대출장소관리")) {
			//research_lent함수
			String temp = "";
			sql = "SELECT * FROM library";
			result = db.getResultSet(sql);
			
			try {
				while(result.next()) {
					temp += result.getString("library.lib_name");
					temp += "-";
				}
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			library_array = temp.split("-");
			
			placeform();
		}
		else {
			//research_member함수
			overdueform();
			sql = "SELECT * FROM overdue, lent, material, member, library, book, kind WHERE overdue.len_no = lent.len_no "
				+ "AND lent.mat_no = material.mat_no AND lent.mem_no = member.mem_no AND material.lib_no = library.lib_no "
				+ "AND material.book_no = book.book_no AND material.kind_no = kind.kind_no";
			sortsql = " ORDER BY mem_id";
		}
		baseform_fianl();
		
		if(menu_title.equals("연체관리")) {
			String now_sql = sql + sortsql;
			LoadList(now_sql);
		}
		setTitle(menu_title);
		addWindowListener(this);
	}
	
	private void baseform() { //공통적으로 사용하는 부분
		JButton bt;
		JLabel label;
		
		setGrid(gbc,1,1,1,1);
		label = new JLabel("                      "+ menu_title + "   ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,0,2,1,1);
		label = new JLabel("회원아이디");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,2,1,1);
		tf_mem_id = new JTextField(10);
		tf_mem_id.setEnabled(false);
		gbl.setConstraints(tf_mem_id, gbc);
		leftPanel.add(tf_mem_id);
		setGrid(gbc,2,2,1,1);
		if(menu_title.equals("대출장소관리")) {
			bt = new JButton("대출검색");
			bt.addActionListener(new lentButtonListener());
			gbl.setConstraints(bt, gbc);
			leftPanel.add(bt);
		}
		else {
			bt = new JButton("회원검색");
			bt.addActionListener(new memberButtonListener());
			gbl.setConstraints(bt, gbc);
			leftPanel.add(bt);
		}
		
		setGrid(gbc,0,3,1,1);
		label = new JLabel("자료이름");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,3,1,1);
		tf_book_name = new JTextField(10);
		tf_book_name.setEnabled(false);
		gbl.setConstraints(tf_book_name, gbc);
		leftPanel.add(tf_book_name);
		setGrid(gbc,0,4,1,1);
		label = new JLabel("대출일");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,4,1,1);
		tf_len_date = new JTextField(10);
		tf_len_date.setEnabled(false);
		gbl.setConstraints(tf_len_date, gbc);
		leftPanel.add(tf_len_date);
		setGrid(gbc,0,5,1,1);
		label = new JLabel("반납일");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,5,1,1);
		tf_len_re_date = new JTextField(10);
		tf_len_re_date.setEnabled(false);
		gbl.setConstraints(tf_len_re_date, gbc);
		leftPanel.add(tf_len_re_date);
	}
	
	private void overdueform() { //연체관리 프레임
		JButton bt;
		JLabel label;
		
		setGrid(gbc,0,6,1,1);
		label = new JLabel("해제일");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,6,1,1);
		tf_date = new JTextField(10);
		gbl.setConstraints(tf_date, gbc);
		leftPanel.add(tf_date);
		setGrid(gbc,1,7,1,1);
		label = new JLabel("  ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,0,8,1,1);
		bt = new JButton("해제");
		bt.addActionListener(new deleteButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,1,8,1,1);
		bt = new JButton("수정");
		bt.addActionListener(new updateButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		
		String columnName[] = {"회원아이디", "자료이름", "소장도서관", "도서기호", "대출일", "반납일", "해제일"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane); 
	}
	
	private void placeform() { //대출장소관리 프레임
		JButton bt;
		JLabel label;
		JComboBox <String> lib_Box = null;
		
		setGrid(gbc,0,6,1,1);
		label = new JLabel("대출도서관");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,6,1,1);
		lib_len_manager = new Combobox_Manager(lib_Box, "library", "lib_no");
		lib_Box = lib_len_manager.combox;
		gbl.setConstraints(lib_Box, gbc);
		leftPanel.add(lib_Box);
		setGrid(gbc,0,7,1,1);
		label = new JLabel("반납도서관");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,7,1,1);
		lib_re_manager = new Combobox_Manager(lib_Box, "library", "lib_no", true);
		lib_Box = lib_re_manager.combox;
		gbl.setConstraints(lib_Box, gbc);
		leftPanel.add(lib_Box);
		setGrid(gbc,1,8,1,1);
		label = new JLabel("  ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,9,1,1);
		bt = new JButton("수정");
		bt.addActionListener(new updateButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
	}
	
	private void baseform_fianl() {
		cpane.add("West", leftPanel);
		cpane.add("Center", centerPanel);
		pack();
	}
	
	private void removeTableRow(int row) {
		table.setValueAt(null, row, 0);
		table.setValueAt(null, row, 1);
		table.setValueAt(null, row, 2);
		table.setValueAt(null, row, 3);
		table.setValueAt(null, row, 4);
		table.setValueAt(null, row, 5);
		table.setValueAt(null, row, 6);
	}
	
	private void MoveData() {		
		try {
			String memberid = result.getString("member.mem_id");
			String bookname = result.getString("book.book_name");
			String lentdate = result.getString("lent.len_date");
			String returndate = result.getString("lent.len_re_date");
			String overduedate = result.getString("overdue.due_exp");

			tf_mem_id.setText(memberid);
			tf_book_name.setText(bookname);
			tf_len_date.setText(lentdate);
			tf_len_re_date.setText(returndate);
			tf_date.setText(overduedate);
			
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void LoadList(String now_sql) {
		String book_symbol, mat_many;
		
		result = db.getResultSet(now_sql);
		
		for(int i = 0; i < dataCount; i++) {
			removeTableRow(i);
		}
		try {
			if(resultempty_check(result)) {
				tableempty();
				repaint();
				tf_mem_id.setText(null);
				tf_book_name.setText(null);
				tf_len_date.setText(null);
				tf_len_re_date.setText(null);
				tf_date.setText(null);
				return;
			}
			else {
				for(dataCount = 0; result.next(); dataCount++) {
					mat_many = result.getString("material.mat_many");
					book_symbol = result.getString("kind.kind_num") + " " 
								+ mat_manyZeroCheck(mat_many) + result.getString("material.mat_overlap");
					table.setValueAt(result.getString("member.mem_id"), dataCount, 0);
					table.setValueAt(result.getString("book.book_name"), dataCount, 1);
					table.setValueAt(result.getString("library.lib_name"), dataCount, 2);
					table.setValueAt(book_symbol, dataCount, 3);
					table.setValueAt(result.getString("lent.len_date"), dataCount, 4);
					table.setValueAt(result.getString("lent.len_re_date"), dataCount, 5);
					table.setValueAt(result.getString("overdue.due_exp"), dataCount, 6);
				}
				repaint();
				
				result.first();
				MoveData();
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private LbDB_etc_Frame myself() {
		return this;
	}
	
	public void research_lent() {
		//장소관리
		int lib_no;
		String lib_no_len, lib_no_re;
		
		lib_no_len = "";
		lib_no_re = "";
		System.out.println("len_nd의 값: " + fk.call_len_no());
		sql = "SELECT * FROM place WHERE len_no = " + fk.call_len_no();
		result = db.getResultSet(sql);
		
		try {
			while(result.next()) {
				lib_no_len = result.getString("place.lib_no_len");
				lib_no_re = result.getString("place.lib_no_re");
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		lib_no = Integer.parseInt(lib_no_len);
		lib_len_manager.combox.setSelectedItem(library_array[lib_no-1]);
		System.out.println("대출도서관: " + library_array[lib_no-1]);
		
		if(lib_no_re == null) {
			lib_re_manager.combox.setEnabled(false);
			lib_re_manager.combox.setSelectedItem("없음");
		}
		else {
			lib_re_manager.combox.setEnabled(true);
			lib_no = Integer.parseInt(lib_no_re);
			lib_re_manager.combox.setSelectedItem(library_array[lib_no-1]);
			System.out.println("반납도서관: " + library_array[lib_no-1]);
		}
	}
	
	public void research_member() {
		//연체관리
		String now_sql = sql + " AND lent.mem_no = " + fk.call_mem_no();
		LoadList(now_sql);
	}
	
	public class lentButtonListener implements ActionListener {
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			SwingItem si = new SwingItem(tf_mem_id, tf_book_name, tf_len_date, tf_len_re_date);
			LbDB_lent_Frame lent = new LbDB_lent_Frame("대출찾기", fk, si, myself());
			lent.setVisible(true);
		}
	}
	
	public class memberButtonListener implements ActionListener {
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			LbDB_member_Frame member = new LbDB_member_Frame("회원찾기", tf_mem_id, fk, myself());
			member.setVisible(true);
		}
	}
	
	public class updateButtonListener implements ActionListener {
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			int code = 0;
			String now_sql;
			if(menu_title.equals("대출장소관리")) {
				try {
					code = result.getInt("place.pla_no");
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
				now_sql = "UPDATE place SET lib_no_len = " + lib_len_manager.foreignkey()
						+ ", lib_no_re = " + lib_re_manager.foreignkey() + " WHERE pla_no = " + code;
				db.Excute(now_sql);
			}
			else {
				String date;
				date = tf_date.getText();
				if(dateformat_check(date)){
					JOptionPane.showMessageDialog(null, "날짜 형식이 잘못되었습니다.",  "연체관리 오류", JOptionPane.PLAIN_MESSAGE);
				}
				
				try {
					code = result.getInt("overdue.due_no");
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
				now_sql = "UPDATE overdue SET due_exp = '" + date + "' WHERE due_no = " + code;
				db.Excute(now_sql);
			}
		}
	}
	
	public class deleteButtonListener implements ActionListener {
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			int code = 0, mem_no = 0;
			String now_sql;
			
			try {
				code = result.getInt("overdue.due_no");
				mem_no = result.getInt("member.mem_no");
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			now_sql = "DELETE FROM overdue WHERE due_no = " + code;
			db.Excute(now_sql);
			
			now_sql = "UPDATE member SET mem_state = 0 WHERE mem_no = " + mem_no; 
			db.Excute(now_sql);
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
					tf_mem_id.setText(table.getValueAt(selectedCol, 0).toString());
					tf_book_name.setText(table.getValueAt(selectedCol, 1).toString());
					tf_len_date.setText(table.getValueAt(selectedCol, 4).toString());
					tf_len_re_date.setText(table.getValueAt(selectedCol, 5).toString());
					tf_date.setText(table.getValueAt(selectedCol, 6).toString());
					try {
						result.absolute(selectedCol + 1);
						MoveData();
					} catch (SQLException e1) {
						e1.printStackTrace();
					}
					repaint();
				}
			}
		}
	}
}
