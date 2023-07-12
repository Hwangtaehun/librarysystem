package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.sql.*;

//delivery테이블과 관련있는 event처리 클래스
public class LbDB_delivery_Frame extends LbDB_main_Frame{ //lib_no_arr의 값을 fk.insert_lib_no에 값 입력(OutData()함수 참고)
	private int mat_no;
	private String lib_name_array[], menu_subtitle[];
	private JTextField tf_bookname, tf_memberid, tf_lib_name;
	private Combobox_Manager manager;
	private JComboBox <String> lib_Box;
	private JButton completeBt;
	private JRadioButton rb_dis, rb_app, rb_ret;
	private ButtonGroup gr_approve;
	private SwingItem si;
	
	LbDB_delivery_Frame(){}
	LbDB_delivery_Frame(LbDB_DAO db, Client cl, String str){ //상호대차관리와 상호대차
		this.db = db;
		this.cl = cl;
		pk = cl.primarykey();
		state = cl.state();
		fk = new foreignkey();
		make_lib_array();
		
		menu_subtitle = str.split("-");
		menu_title = menu_subtitle[0];
		
		if(menu_subtitle.length < 2) {
			make_menu_subtitle();
		}
		
		setTitle(str);
		menuform();
		Initform();
		if(menu_title.equals("상호대차완료내역")) {
			completeform();
		}
		else if(menu_title.equals("상호대차도착일추가")) {
			arriveform();
		}
		else {
			makesql();
			baseform();
			if(menu_title.equals("상호대차관리")) {
				editform();
			}
			else {
				bookseaform();
			}
		}
		addWindowListener(this);
	}
	LbDB_delivery_Frame(Client cl, String str, int mat_no){ //회원 상호대차
		db = new LbDB_DAO();
		this.cl = cl;
		menu_title = str;
		this.mat_no = mat_no;
		pk = cl.primarykey();
		state = cl.state();
		fk = new foreignkey();
		
		dialog(menu_title);
		make_menu_subtitle();
		Initform();
		baseform();
		booksea_member_dialog();
	}
	
	LbDB_delivery_Frame(Client cl, String str, SwingItem si, foreignkey fk){ //관리자 상호대차
		db = new LbDB_DAO();
		this.cl = cl;
		menu_title = str;
		this.si = si;
		pk = cl.primarykey();
		state = cl.state();
		this.fk = fk;
		make_lib_array();
		
		sql = "SELECT * FROM delivery, material, member, book WHERE delivery.mat_no = material.mat_no AND " 
			+ "delivery.mem_no = member.mem_no AND material.book_no = book.book_no AND NOT member.mem_state = 1";
		sortsql = " ORDER BY book.book_name";
		dialog(menu_title);
		make_menu_subtitle();
		Initform();
		baseform();
		booksea_manager_dialog();
	}
	
	private void baseform(){
		JLabel label;
		JButton bt;
		
		manager = new Combobox_Manager(lib_Box, "library", "lib_no");
		
		setGrid(gbc,1,1,1,1);
		label = new JLabel("                                                  상호 대차   ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		if(menu_subtitle[1].equals("자료")) {
			setGrid(gbc,0,2,1,1);
			label = new JLabel("    책이름    ");
			gbl.setConstraints(label, gbc);
			leftPanel.add(label);
			setGrid(gbc,1,2,1,1);
			tf_bookname = new JTextField(50);
			tf_bookname.setEnabled(false);
			gbl.setConstraints(tf_bookname, gbc);
			leftPanel.add(tf_bookname);
			/*
			setGrid(gbc,0,5,1,1);
			label = new JLabel("    회원아이디   ");
			gbl.setConstraints(label, gbc);
			leftPanel.add(label);
			setGrid(gbc,1,5,1,1);
			tf_memberid = new JTextField(10);
			tf_memberid.setEnabled(false);
			gbl.setConstraints(tf_memberid, gbc);
			leftPanel.add(tf_memberid);
			*/
		}
		else {
			setGrid(gbc,0,2,1,1);
			label = new JLabel("    회원아이디   ");
			gbl.setConstraints(label, gbc);
			leftPanel.add(label);
			setGrid(gbc,1,2,1,1);
			tf_memberid = new JTextField(10);
			tf_memberid.setEnabled(false);
			gbl.setConstraints(tf_memberid, gbc);
			leftPanel.add(tf_memberid);
			setGrid(gbc,0,5,1,1);
			label = new JLabel("    책이름    ");
			gbl.setConstraints(label, gbc);
			leftPanel.add(label);
			setGrid(gbc,1,5,1,1);
			tf_bookname = new JTextField(50);
			tf_bookname.setEnabled(false);
			gbl.setConstraints(tf_bookname, gbc);
			leftPanel.add(tf_bookname);
		}
		if(menu_title.equals("상호대차관리")) {
			if(menu_subtitle[1].equals("자료")) {
				setGrid(gbc,2,2,1,1);
				bt = new JButton("자료찾기");
				bt.addActionListener(new materialButtonListener());
				gbl.setConstraints(bt, gbc);
				leftPanel.add(bt);
//				setGrid(gbc,2,5,1,1);
//				bt = new JButton("회원찾기");
//				bt.addActionListener(new memberButtonListener());
//				gbl.setConstraints(bt, gbc);
//				leftPanel.add(bt);
			}
			else {
				setGrid(gbc,2,2,1,1);
				bt = new JButton("회원찾기");
				bt.addActionListener(new memberButtonListener());
				gbl.setConstraints(bt, gbc);
				leftPanel.add(bt);
				setGrid(gbc,2,5,1,1);
				bt = new JButton("자료찾기");
				bt.addActionListener(new materialButtonListener());
				gbl.setConstraints(bt, gbc);
				leftPanel.add(bt);
			}
			setGrid(gbc,1,3,1,1);
			bt = new JButton("검색");
			bt.addActionListener(new researchButtonListener());
			gbl.setConstraints(bt, gbc);
			leftPanel.add(bt);
			setGrid(gbc,1,4,1,1);
			label = new JLabel("        ");
			gbl.setConstraints(label, gbc);
			leftPanel.add(label);
		}
		setGrid(gbc,0,6,1,1);
		label = new JLabel("    배송되는 도서관    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,6,1,1);
		lib_Box = manager.combox;
		gbl.setConstraints(lib_Box, gbc);
		leftPanel.add(lib_Box);
	}
	
	private void completeform() {
		JPanel researchPanel, northPanel;
		JLabel label;
		JButton bt;
		
		northPanel = new JPanel();
		label = new JLabel(menu_title);
		northPanel.add(label);
		
		researchPanel = new JPanel();
		label = new JLabel("검색");
		researchPanel.add(label);
		tf_research = new JTextField(50);
		tf_research.setEnabled(false);
		researchPanel.add(tf_research);
		bt = new JButton("자료찾기");
		bt.addActionListener(new materialButtonListener());
		researchPanel.add(bt);
		bt = new JButton("검색");
		bt.addActionListener(new researchButtonListener());
		researchPanel.add(bt);
		
		String columnName[] = {"회원아이디", "책이름", "소장도서관", "수신도서관", "도착일", "상태"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane);
		
		cpane.add("North", northPanel);
		cpane.add("Center", researchPanel);
		cpane.add("South", centerPanel);
		pack();
		
		sql = "SELECT * FROM delivery, material, member, book WHERE delivery.mat_no = material.mat_no AND " 
			+ "delivery.mem_no = member.mem_no AND material.book_no = book.book_no ";
		sortsql = "ORDER BY book.book_name";
		
		LoadList(sql + sortsql);
	}
	
	private void editform() {
		JPanel panel;
		JLabel label;
		JButton bt;
		
		setGrid(gbc,0,7,1,1);
		label = new JLabel("    도착일    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,7,1,1);
		tf_date = new JTextField(10);
		gbl.setConstraints(tf_date, gbc);
		leftPanel.add(tf_date);
		setGrid(gbc,2,7,1,1);
		bt = new JButton("오늘");
		bt.addActionListener(new todayButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,0,8,1,1);
		label = new JLabel("     승인    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,8,1,1);
		panel = new JPanel();
		gr_approve = new ButtonGroup();
		rb_dis = new JRadioButton("거절", true);
		rb_dis.addActionListener(new radiobuttonListener());
		rb_dis.addItemListener(new radiobuttonListener());
		rb_dis.setActionCommand("st-0");
		gr_approve.add(rb_dis);
		panel.add(rb_dis);
		rb_app = new JRadioButton("승인", false);
		rb_app.addActionListener(new radiobuttonListener());
		rb_app.addItemListener(new radiobuttonListener());
		rb_app.setActionCommand("st-1");
		gr_approve.add(rb_app);
		panel.add(rb_app);
		rb_ret = new JRadioButton("반송", false);
		rb_ret.addActionListener(new radiobuttonListener());
		rb_ret.addItemListener(new radiobuttonListener());
		rb_ret.setActionCommand("st-2");
		gr_approve.add(rb_ret);
		panel.add(rb_ret);
		gbl.setConstraints(panel, gbc);
		leftPanel.add(panel);
		setGrid(gbc,0,9,1,1);
		bt = new JButton("공백");
		bt.addActionListener(new completeButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,1,9,1,1);
		bt = new JButton("수정");
		bt.addActionListener(new updateButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,2,9,1,1);
		bt = new JButton("삭제");
		bt.addActionListener(new deleteButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		
		String columnName[] = {"책이름", "권차", "복권", "소장도서관", "수신도서관", "도착일", "상태"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane);
		
		cpane.add("West", leftPanel);
		cpane.add("Center", centerPanel);
		pack();
	}
	
	private void bookseaform() {
		JPanel southPanel;
		String now_sql;
		JButton bt;
		
		String columnName[] = {"책이름", "권차", "복권", "소장도서관", "수신도서관", "도착일", "상태"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane);
		
		southPanel = new JPanel();
		bt = new JButton("상호대차 취소");
		bt.addActionListener(new deleteButtonListener());
		southPanel.add(bt);
		
		cpane.add("Center", centerPanel);
		cpane.add("South", southPanel);
		pack();
		
		now_sql = sql +  " AND member.mem_no LIKE " + pk + sortsql;
		
		LoadList(now_sql);
		tablefocus();
	}
	
	private void booksea_member_dialog() {
		tf_bookname.setEnabled(false);
		tf_memberid.setEnabled(false);
		
		sql = "SELECT * FROM material, book WHERE material.book_no = book.book_no AND material.mat_no = " +  mat_no;
		result = db.getResultSet(sql);
		try {
			while(result.next()) {
				tf_bookname.setText(result.getString("book.book_name"));
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		sql = "SELECT * FROM member WHERE mem_no = " + pk;
		result = db.getResultSet(sql);
		try {
			while(result.next()) {
				tf_memberid.setText(result.getString("member.mem_id"));
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		setGrid(gbc,1,8,1,1);
		completeBt = new JButton("완료");
		completeBt.addActionListener(new completeButtonListener());
		gbl.setConstraints(completeBt, gbc);
		leftPanel.add(completeBt);
		
		cpane.add("West", leftPanel);
		pack();
	}
	
	private void booksea_manager_dialog() {
		JLabel label;
		JButton bt;
		
		setGrid(gbc,2,2,1,1);
		bt = new JButton("회원찾기");
		bt.addActionListener(new memberButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,1,3,1,1);
		bt = new JButton("검색");
		bt.addActionListener(new researchButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,1,4,1,1);
		label = new JLabel("        ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		lib_Box.setEnabled(false);
		
		String columnName[] = {"책이름", "소장도서관", "수신도서관"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane);
		
		cpane.add("West", leftPanel);
		cpane.add("Center", centerPanel);
		pack();
	}
	
	private void arriveform() {
		JLabel label;
		JButton bt;
		
		manager = new Combobox_Manager(lib_Box, "library", "lib_no");
		
		setGrid(gbc,1,1,1,1);
		label = new JLabel("                                                  " + menu_title + "   ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,0,2,1,1);
		label = new JLabel("    도서관    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,2,1,1);
		tf_lib_name = new JTextField(50);
		tf_lib_name.setEnabled(false);
		gbl.setConstraints(tf_lib_name, gbc);
		leftPanel.add(tf_lib_name);
		setGrid(gbc,0,3,1,1);
		label = new JLabel("    책이름    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,3,1,1);
		tf_bookname = new JTextField(50);
		tf_bookname.setEnabled(false);
		gbl.setConstraints(tf_bookname, gbc);
		leftPanel.add(tf_bookname);
		setGrid(gbc,2,3,1,1);
		bt = new JButton("자료찾기");
		bt.addActionListener(new materialButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,0,4,1,1);
		label = new JLabel("    도착일    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,4,1,1);
		tf_date = new JTextField(10);
		gbl.setConstraints(tf_date, gbc);
		leftPanel.add(tf_date);
		setGrid(gbc,2,4,1,1);
		bt = new JButton("오늘");
		bt.addActionListener(new todayButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,1,5,1,1);
		addBt = new JButton("추가");
		addBt.addActionListener(new addButtonListener());
		gbl.setConstraints(addBt, gbc);
		leftPanel.add(addBt);
		
		cpane.add("Center", leftPanel);
		pack();
	}
	
	private void makesql() {
		sql = "SELECT * FROM delivery, material, member, book WHERE delivery.mat_no = material.mat_no AND " 
			+ "delivery.mem_no = member.mem_no AND material.book_no = book.book_no AND len_no IS NULL";
		sortsql = " ORDER BY book.book_name";
	}
	
	private void tablefocus() {
		try {
			result.first();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		MoveData();
	}
	
	private void make_lib_array() {
		String now_sql, sentence = "";
		
		now_sql = "SELECT * FROM library";
		result = db.getResultSet(now_sql);
		
		try {
			while(result.next()) {
				sentence += result.getString("lib_name");
				sentence += "-";
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		lib_name_array = sentence.split("-");
	}
	
	private void make_menu_subtitle() {
		menu_subtitle = new String[2];
		menu_subtitle[0] = "";
		menu_subtitle[1] = "";
	}
	
	private void removeTableRow(int row) {
		if(menu_title.equals("상호대차")) {
			table.setValueAt(null, row, 0);
			table.setValueAt(null, row, 1);
			table.setValueAt(null, row, 2);
		}
		else if(menu_title.equals("상호대차완료내역")) {
			table.setValueAt(null, row, 0);
			table.setValueAt(null, row, 1);
			table.setValueAt(null, row, 2);
			table.setValueAt(null, row, 3);
			table.setValueAt(null, row, 4);
			table.setValueAt(null, row, 5);
		}
		else {
			table.setValueAt(null, row, 0);
			table.setValueAt(null, row, 1);
			table.setValueAt(null, row, 2);
			table.setValueAt(null, row, 3);
			table.setValueAt(null, row, 4);
			table.setValueAt(null, row, 5);
			table.setValueAt(null, row, 6);
		}
	}
	
	private void MoveData() {
		try {
			String book_name, lib_arr_name;
			int lib_no_arr;
			
			lib_no_arr = result.getInt("delivery.lib_no_arr");
			book_name = result.getString("book.book_name");
			lib_arr_name = lib_name_array[lib_no_arr - 1];
			
			tf_bookname.setText(book_name);
			lib_Box.setSelectedItem(lib_arr_name);
			
			if(menu_title.equals("상호대차관리")) {
				String del_date_arr = result.getString("delivery.del_arr_date");
				int del_app = result.getInt("delivery.del_app");
				
				tf_date.setText(del_date_arr);
				if(del_app == 0) {
					rb_dis.setSelected(true);
				}
				else if(del_app == 1) {
					rb_app.setSelected(true);
				}
				else {
					rb_ret.setSelected(true);
				}
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void OutData() {
		int lib_no_arr;
		
		try {
			lib_no_arr = result.getInt("delivery.lib_no_arr");
			
			fk.insert_del_no(result.getInt("delivery.del_no"));
			si.set_memid(result.getString("member.mem_id"));
			fk.insert_mem_no(result.getInt("member.mem_no"));
			si.set_bookname(result.getString("book.book_name"));
			fk.insert_mat_no(result.getInt("material.mat_no"));
			si.set_lib_Box(lib_name_array[lib_no_arr-1]);
			fk.insert_lib_no(lib_no_arr);
			closeFrame();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void LoadList(String now_sql) {
		int lib_no, lib_no_arr;
		System.out.println(now_sql);
		result = db.getResultSet(now_sql);
		
		if(resultempty_check(result)) {
			tableempty();
			return;
		}
		
		for(int i = 0; i < dataCount; i++) {
			removeTableRow(i);
		}
		try {
			if(!now_sql.equals("")) {
				for(dataCount = 0; result.next(); dataCount++) {				
					lib_no = result.getInt("material.lib_no");
					lib_no_arr = result.getInt("delivery.lib_no_arr");
					
					if(menu_title.equals("상호대차완료내역")) {
						int app, len_no;
						String app_str;
						
						table.setValueAt(result.getString("member.mem_id"), dataCount, 0);
						table.setValueAt(result.getString("book.book_name"), dataCount, 1);
						table.setValueAt(lib_name_array[lib_no - 1], dataCount, 2);
						table.setValueAt(lib_name_array[lib_no_arr - 1], dataCount, 3);
						table.setValueAt(result.getString("delivery.del_arr_date"), dataCount, 4);
						app = result.getInt("delivery.del_app");
						len_no = result.getInt("delivery.len_no");
						
						if(app == 0) {
							app_str = "거절";
						}
						else if(app == 1) {
							app_str = "승인";
							if(len_no != 0) {
								app_str = "대출";
							}
						}
						else {
							app_str = "반송";
						}
						
						table.setValueAt(app_str, dataCount, 5);
					}
					if(menu_title.equals("상호대차")) {
						table.setValueAt(result.getString("book.book_name"), dataCount, 0);
						table.setValueAt(lib_name_array[lib_no - 1], dataCount, 1);
						table.setValueAt(lib_name_array[lib_no_arr - 1], dataCount, 2);
					}
					else {
						int app;
						String app_str;
						
						table.setValueAt(result.getString("book.book_name"), dataCount, 0);
						table.setValueAt(result.getString("material.mat_many"), dataCount, 1);
						table.setValueAt(result.getString("material.mat_overlap"), dataCount, 2);
						table.setValueAt(lib_name_array[lib_no - 1], dataCount, 3);
						table.setValueAt(lib_name_array[lib_no_arr - 1], dataCount, 4);
						
						if(result.getString("delivery.del_arr_date") == null) {
							table.setValueAt("", dataCount, 5);
						}
						else {
							table.setValueAt(result.getString("delivery.del_arr_date"), dataCount, 5);
						}
						
						app = result.getInt("delivery.del_app");
						if(app == 0) {
							app_str = "거절";
						}
						else if(app == 1) {
							app_str = "승인";
						}
						else {
							app_str = "반송";
						}
						
						table.setValueAt(app_str, dataCount, 6);
					}
				}
			}
			repaint();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public class completeButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			int lib_no_arr = manager.foreignkey();
			int lib_no_mat = 0;
			sql = "SELECT * FROM `material` WHERE `mat_no` LIKE " + mat_no;
			result = db.getResultSet(sql);
			try {
				while(result.next()) {
					lib_no_mat = result.getInt("lib_no");
				}
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			if(lib_no_mat == lib_no_arr) {
				JOptionPane.showMessageDialog(null, "자료가 있는 도서관과 배송되는 도서관이 같습니다.",  "상호대차 오류", JOptionPane.PLAIN_MESSAGE);
			}
			else {
				sql = "INSERT INTO `delivery` (`mem_no`, `mat_no`, `lib_no_arr`) VALUES (" +
					  pk + ", " + mat_no + ", " + lib_no_arr + ")";
				System.out.println(sql);
				db.Excute(sql);
				closeFrame();
			}
		}	
	}
	
	public class clearButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			tf_bookname.setText("");
			tf_date.setText("");
		}
	}
	
	public class addButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			int del_no = 0;
			
			sql = "SELECT * FROM delivery WHERE mat_no = " + fk.call_mat_no() +" AND len_no IS NULL";
			System.out.println(sql);
			result = db.getResultSet(sql);
			
			try {
				while(result.next()) {
					del_no = result.getInt("del_no");
				}
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			if(dateformat_check(tf_date.getText())) {
				JOptionPane.showMessageDialog(null, "날짜형식이 잘못되었습니다.", "수정 오류", JOptionPane.WARNING_MESSAGE);
				return;
			}
			else if(del_no == 0) {
				JOptionPane.showMessageDialog(null, "상호대차에 등록된 자료가 없습니다.", "테이블 오류", JOptionPane.WARNING_MESSAGE);
				return;
			}
			else {
				sql = "UPDATE delivery SET del_arr_date = '" + tf_date.getText() + "' WHERE del_no = " + del_no;
				System.out.println(sql);
				db.Excute(sql);
			}
		}
	}
	
	public class updateButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			int code = 0;
			String now_sql;
			
			if(selectedCol == -1) {
				System.out.println("변경할 셀이 선택되지 않았습니다.");
				return;
			}
			
			if(dateformat_check(tf_date.getText())) {
				JOptionPane.showMessageDialog(null, "날짜형식이 잘못되었습니다.", "수정 오류", JOptionPane.WARNING_MESSAGE);
				return;
			}
			
			try {
				code = result.getInt("delivery.del_no");
				if(fk.call_mat_no() == 0) {
					fk.insert_mat_no(result.getInt("delivery.mat_no"));
				}
				
				if(fk.call_lib_no() == manager.foreignkey()) {
					JOptionPane.showMessageDialog(null, "자료가 있는 도서관과 배송되는 도서관이 같습니다.",  "상호대차 오류", JOptionPane.PLAIN_MESSAGE);
					return;
				}
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			now_sql = "UPDATE delivery SET mat_no = " + fk.call_mat_no() + ", del_arr_date = '" + tf_date.getText()
					+ "', del_app = " + st + ", lib_no_arr = " + manager.foreignkey() + " WHERE del_no = " + code;
			System.out.println(now_sql);
			db.Excute(now_sql);
			now_sql = "";
			LoadList(now_sql);
		}
	}
	
	public class deleteButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			int code = 0;
			String now_sql;
			
			if(selectedCol == -1) {
				System.out.println("변경할 셀이 선택되지 않았습니다.");
				return;
			}
			
			try {
				code = result.getInt("delivery.del_no");
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			now_sql = "DELECT FROM delivery WHERE del_no = " + code;
			System.out.println(now_sql);
			db.Excute(now_sql);
			now_sql = "";
			LoadList(now_sql);
		}
	}
	
	public class researchButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			String now_sql;
			
			if(menu_subtitle[1].equals("회원")) {
				if(tf_memberid.getText().isEmpty()) {
					System.out.println("회원아이디를 찾아주세요.");
					return;
				}
				
				now_sql = sql +  " AND member.mem_no = " + fk.call_mem_no() + sortsql;
			}
			else {
				if(tf_bookname.getText().isEmpty()) {
					System.out.println("자료를 찾아주세요.");
					return;
				}
				now_sql = sql +  " AND material.mat_no = " + fk.call_mat_no() + sortsql;
			}
			
			LoadList(now_sql);
			tablefocus();
		}
	}
	
	public class memberButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			 LbDB_member_Frame mem_frame = new LbDB_member_Frame ("회원찾기", tf_memberid, fk, false);
			 mem_frame.setVisible(true);
		}
	}
	
	public class materialButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			LbDB_material_Frame	mat_frame;
			if(menu_title.equals("상호대차도착일추가")) {
				mat_frame = new LbDB_material_Frame("상세검색", tf_bookname, tf_lib_name, fk);
			}
			else {
				mat_frame = new LbDB_material_Frame("자료찾기", tf_bookname, fk);
			}
			mat_frame.setVisible(true);
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
					if(menu_title.equals("상호대차관리")) {
						tf_bookname.setText(table.getValueAt(selectedCol, 0).toString());
						lib_Box.setSelectedItem(table.getValueAt(selectedCol, 3).toString());
						tf_date.setText(table.getValueAt(selectedCol, 5).toString());
						
						if(table.getValueAt(selectedCol, 6).toString().equals("거절")) {
							rb_dis.setSelected(true);
						}
						else if(table.getValueAt(selectedCol, 6).toString().equals("승인")) {
							rb_app.setSelected(true);
						}
						else {
							rb_ret.setSelected(true);
						}
					}
					
					try {
						result.absolute(selectedCol + 1);
						if(menu_title.equals("상호대차")) {
							OutData();
						}
						else if(menu_title.equals("상호대차완료내역")) {
							if(result.getString("delivery.len_no") == null) {
								System.out.println("대출내역이 없습니다.");
							}
							else {
								LbDB_lent_Frame len = new LbDB_lent_Frame(db, cl, result.getInt("delivery.len_no"));
								len.setVisible(true);
								closeFrame();
							}
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