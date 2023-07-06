package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;

import libraryDB.LbDB_lent_Frame.tableListener;

import java.sql.*;

public class LbDB_etc_Frame extends LbDB_main_Frame {
	private JTextField tf_mem_id, tf_book_name, tf_len_date, tf_len_re_date;
	private Combobox_Manager lib_len_manager, lib_re_manager;
	
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
			placeform();
		}
		else {
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
	
	private void baseform() {
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
	
	private void overdueform() {
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
		
		String columnName[] = {"회원아이디", "소장도서관", "자료이름", "도서기호", "대출일", "반납일", "해제일"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane); 
	}
	
	private void placeform() {
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
		lib_re_manager = new Combobox_Manager(lib_Box, "library", "lib_no");
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
				return;
			}
			else {
				for(dataCount = 0; result.next(); dataCount++) {
					mat_many = result.getString("material.mat_many");
					book_symbol = result.getString("kind.kind_num") + " " 
								+ mat_manyZeroCheck(mat_many) + result.getString("material.mat_overlap");
					table.setValueAt(result.getString("member.mem_id"), dataCount, 0);
					table.setValueAt(result.getString("library.lib_name"), dataCount, 1);
					table.setValueAt(result.getString("book.book_name"), dataCount, 2);
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
	
	public class lentButtonListener implements ActionListener {
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			
		}
	}
	
	public class memberButtonListener implements ActionListener {
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			//LbDB_member_Frame member = new LbDB_member_Frame("회원찾기", )
		}
	}
	
	public class updateButtonListener implements ActionListener {
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			
		}
	}
	
	public class deleteButtonListener implements ActionListener {
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			
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
					tf_book_name.setText(table.getValueAt(selectedCol, 2).toString());
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
