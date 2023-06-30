package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.sql.*;
import java.time.*;

//material테이블과 관련있는 event처리 클래스
public class LbDB_material_Frame extends LbDB_main_Frame {
	private JTextField tf_bookname, tf_author, tf_publish, tf_kind, tf_many, tf_dialog, tf_dialog2;
	private JButton bookBt, kindBt;
	private JComboBox <String> lib_Box;
	private SwingItem si;
	private Combobox_Manager manager;
	private JButton reservationBt, deliveryBt;
	
	public LbDB_material_Frame () {}
	public LbDB_material_Frame (SwingItem si, String title) {
		db = new LbDB_DAO();
		menu_title = title;
		this.si = si;
		Initform();
		baseform();
		dialogform();
		dialog(title);
	}
	public LbDB_material_Frame (LbDB_DAO db, Client cl, String str) {
		this.db = db;
		this.cl = cl;
		menu_title = str;
		pk = cl.primarykey();
		state = cl.state();
		fk = new foreignkey();
		
		menuform();
		Initform();
		baseform();
		
		if(menu_title.equals("자료검색")) {
			researchform();
		}
		else {
			managerform();
			if(menu_title.equals("자료추가")) {
				addform();
			}
			else if(menu_title.equals("자료관리")) {
				editform();
			}
		}
		
		setTitle(menu_title);
		addWindowListener(this);
	}
	public LbDB_material_Frame (String title, JTextField tf, foreignkey fk) {
		db = new LbDB_DAO();
		menu_title = title;
		tf_dialog = tf;
		this.fk = fk;
		Initform();
		baseform();
		dialogform();
		dialog(title);
	}
	public LbDB_material_Frame (String title, JTextField tf, JTextField tf2, foreignkey fk) {
		db = new LbDB_DAO();
		menu_title = title;
		tf_dialog = tf;
		tf_dialog2 = tf2;
		this.fk = fk;
		Initform();
		baseform();
		dialogform();
		dialog(title);
	}
	
	private void baseform() {
		JLabel label;
		
		setGrid(gbc,1,1,1,1);
		label = new JLabel("    "+ menu_title + "   ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,0,2,1,1);
		label = new JLabel("    도서관       ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,2,1,1);
		manager = new Combobox_Manager(lib_Box, "library", "lib_no");
		lib_Box = manager.combox;
		gbl.setConstraints(lib_Box, gbc);
		leftPanel.add(lib_Box);
		setGrid(gbc,0,3,1,1);
		label = new JLabel("    책이름    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,3,1,1);
		tf_bookname = new JTextField(50);
		gbl.setConstraints(tf_bookname, gbc);
		leftPanel.add(tf_bookname);
	}
	
	private void dialogform() {
		setGrid(gbc,0,4,1,1);
		researchBt = new JButton("검색");
		researchBt.addActionListener(new researchButtonListener());
		gbl.setConstraints(researchBt, gbc);
		leftPanel.add(researchBt);
		
		String columnName[] = {"도서관", "종류번호", "책 이름", "권차", "복권", "저자", "출판사"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane);
		
		cpane.add("West", leftPanel);
		cpane.add("Center", centerPanel);
		pack();
		
		if(menu_title.equals("자료찾기")) {
			sql = "SELECT * " + "FROM library, book, kind, material " + 
				  "WHERE library.lib_no = material.lib_no AND book.book_no = material.book_no AND kind.kind_no = material.kind_no " +
				  "AND material.mat_no NOT IN (SELECT mat_no FROM lent WHERE len_re_st = 0 OR len_re_st = 2 UNION SELECT mat_no FROM reservation)";
		}
		else {
			sql = "SELECT * " + "FROM library, book, kind, material " + 
				  "WHERE library.lib_no = material.lib_no AND book.book_no = material.book_no AND kind.kind_no = material.kind_no";
		}
		
		System.out.println(sql);
		LoadList(sql);
		
		try {
			result.first();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		MoveData();
	}
	
	private void researchform() {
		JLabel label;
		
		setGrid(gbc,0,4,1,1);
		label = new JLabel("    저자   ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,4,1,1);
		tf_author = new JTextField(20);
		gbl.setConstraints(tf_author, gbc);
		leftPanel.add(tf_author);
		setGrid(gbc,0,5,1,1);
		label = new JLabel("    출판사  ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,5,1,1);
		tf_publish = new JTextField(20);
		gbl.setConstraints(tf_publish, gbc);
		leftPanel.add(tf_publish);
		setGrid(gbc,2,5,1,1);
		deliveryBt = new JButton("상호대차");
		deliveryBt.addActionListener(new deliveryButtonListener());
		gbl.setConstraints(deliveryBt, gbc);
		leftPanel.add(deliveryBt);
		setGrid(gbc,0,6,1,1);
		clearBt = new JButton("공백");
		clearBt.addActionListener(new clearButtonListener());
		gbl.setConstraints(clearBt, gbc);
		leftPanel.add(clearBt);
		setGrid(gbc,1,6,1,1);
		researchBt = new JButton("검색");
		researchBt.addActionListener(new researchButtonListener());
		gbl.setConstraints(researchBt, gbc);
		leftPanel.add(researchBt);
		setGrid(gbc,2,6,1,1);
		reservationBt = new JButton("예약");
		reservationBt.addActionListener(new reservationButtonListener());
		gbl.setConstraints(reservationBt, gbc);
		leftPanel.add(reservationBt);
		
		String columnName[] = {"도서관", "책 이름", "저자", "출판사", "대출가능", "예약여부"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane);
		
		cpane.add("West", leftPanel);
		cpane.add("Center", centerPanel);
		pack();
		
		sql = "SELECT * " + "FROM library, book, material LEFT JOIN lent ON material.mat_no = lent.mat_no "
			+ "LEFT JOIN reservation ON material.mat_no = reservation.mat_no "
			+ "WHERE library.lib_no = material.lib_no AND book.book_no = material.book_no";
		System.out.println(sql);
		LoadList(sql);
		
		try {
			result.first();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		MoveData();
	}
	
	private void managerform() {
		JLabel label;
		
		setGrid(gbc,2,3,1,1);
		bookBt = new JButton("책검색");
		bookBt.addActionListener(new bookListener());
		gbl.setConstraints(bookBt, gbc);
		leftPanel.add(bookBt);
		setGrid(gbc,0,4,1,1);
		label = new JLabel("     종류    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,4,1,1);
		tf_kind = new JTextField(5);
		gbl.setConstraints(tf_kind, gbc);
		leftPanel.add(tf_kind);
		setGrid(gbc,2,4,1,1);
		kindBt = new JButton("종류검색");
		kindBt.addActionListener(new kindListener());
		gbl.setConstraints(kindBt, gbc);
		leftPanel.add(kindBt);
		setGrid(gbc,0,5,1,1);
		label = new JLabel("     권차    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,5,1,1);
		tf_many = new JTextField(5);
		gbl.setConstraints(tf_many, gbc);
		leftPanel.add(tf_many);
	}
	
	private void addform() {
		tf_bookname.setEnabled(false);
		tf_kind.setEnabled(false);
		setGrid(gbc,1,6,1,1);
		addBt = new JButton("추가");
		addBt.addActionListener(new addButtonListener());
		gbl.setConstraints(addBt, gbc);
		leftPanel.add(addBt);
		
		cpane.add("Center", leftPanel);
		pack();
	}
	
	private void editform() {
		JButton bt;
		
		tf_bookname.setEnabled(false);
		tf_kind.setEnabled(false);
		setGrid(gbc,2,2,1,1);
		bt = new JButton("자료검색");
		bt.addActionListener(new materialListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,1,6,1,1);
		deleteBt = new JButton("삭제");
		deleteBt.addActionListener(new deleteButtonListener());
		gbl.setConstraints(deleteBt, gbc);
		leftPanel.add(deleteBt);
		setGrid(gbc,2,6,1,1);
		updateBt = new JButton("수정");
		updateBt.addActionListener(new updateButtonListener());
		gbl.setConstraints(updateBt, gbc);
		leftPanel.add(updateBt);
		clearBt = new JButton("공백");
		clearBt.addActionListener(new clearButtonListener());
		gbl.setConstraints(clearBt, gbc);
		leftPanel.add(clearBt);
		
		String columnName[] = {"도서관", "종류번호", "책 이름", "저자", "출판사", "권차", "복본"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane);
		
		cpane.add("West", leftPanel);
		cpane.add("Center", centerPanel);
		pack();
		
		sql = "SELECT * " + "FROM library, book, material, kind " + 
			"WHERE library.lib_no = material.lib_no AND book.book_no = material.book_no AND kind.kind_no = material.kind_no";
		LoadList(sql);
			
		try {
			result.first();
		} catch (SQLException e) {
				// TODO Auto-generated catch block
			e.printStackTrace();
		}
			
		MoveData();
	}
	
	private String book_count() {
		int lib_no, book_no, num = 0;
		String str_num = "c.";
		String now_sql;
		
		lib_no = manager.foreignkey();
		book_no = fk.call_book_no();
		
		now_sql = "SELECT * FROM `material` WHERE `lib_no` LIKE " + lib_no + " AND `book_no` LIKE " + book_no;
		System.out.println(now_sql);
		result = db.getResultSet(now_sql);
		try {
			while(result.next()){
				num++;
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		num++;
		str_num += num;
		
		return str_num;
	}
	
	private boolean warning() {
		boolean bool;
		if(tf_bookname.getText().isEmpty()) {
			JOptionPane.showMessageDialog(null, "책정보를 찾아주세요.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			bool = false;
		}
		else if(tf_kind.getText().isEmpty()) {
			JOptionPane.showMessageDialog(null, "종류정보를 찾아주세요.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			bool = false;
		}
		else if(!isInteger(tf_many.getText()) && !tf_many.getText().isEmpty()) {
			JOptionPane.showMessageDialog(null, "권차 정보는 정수만 입력해주세요.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			bool = false;
		}
		else {
			bool = true;
		}
		return bool;
	}
	
	private String removeSymbol(String str) {
		String str_fianl, str_array[];
		
		if(isInteger(str)) {
			str_fianl = "";
			return str_fianl;
		}
		
		str_fianl = "";
		str_array = str.split("");
		
		for(int i = 2; i < str_array.length; i++) {
			str_fianl += str_array[i];
		}

		return str_fianl;
	}
	
	private void removeTableRow(int row) {
		if(menu_title.equals("자료검색")) {
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
	
	private void MoveData() { //예약버튼부분 확인
		try {
			String libraryname = result.getString("library.lib_name");
			String bookname = result.getString("book.book_name");
			lib_Box.setSelectedItem(libraryname);
			tf_bookname.setText(bookname);
			
			if(menu_title.equals("자료검색")) {
				String author = result.getString("book.book_author");
				String publish = result.getString("book.book_publish");
				String len_re_st = result.getString("lent.len_re_st");
				String res_no = result.getString("reservation.res_no");
				tf_author.setText(author);
				tf_publish.setText(publish);
				if(len_re_st == null || len_re_st.equals("1")) {
					deliveryBt.setEnabled(true);
				}
				else {
					deliveryBt.setEnabled(false);
					if(len_re_st.equals("0")) {
						if(res_no == null) {
							reservationBt.setEnabled(true);
						}
					}
					else {
						reservationBt.setEnabled(false);
					}
				}
			}
			else if(menu_title.equals("자료관리")) {
				String kind_num = result.getString("kind.kind_num");
				String many = removeSymbol(result.getString("material.mat_many"));
				tf_kind.setText(kind_num);
				tf_many.setText(many);
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void LoadList(String now_sql) {
		result = db.getResultSet(now_sql);
		
		if(resultempty_check(result)) {
			return;
		}
		
		for(int i = 0; i < dataCount; i++) {
			removeTableRow(i);
		}
		
		if(menu_title.equals("자료검색")) {
			String lent_re_state, res_state;
			try {
				for(dataCount = 0; result.next(); dataCount++) {
					table.setValueAt(result.getString("library.lib_name"), dataCount, 0);
					table.setValueAt(result.getString("book.book_name"), dataCount, 1);
					table.setValueAt(result.getString("book.book_author"), dataCount, 2);
					table.setValueAt(result.getString("book.book_publish"), dataCount, 3);
					String state = result.getString("lent.len_re_st");
					String ifelse = result.getString("reservation.res_no");
					
					if(state == null || state.equals("1")) {
						lent_re_state = "대출가능";
					}
					else if(state.equals("2")) {
						lent_re_state = "대출불가";
					}
					else {
						lent_re_state = "대출중";
					}
					
					res_state = "예약불가";
					if(state != null) {
						if(state.equals("0")) {
							if(ifelse == null) {
								res_state = "예약가능";
							}
							else {
								res_state = "예약있음";
							}
						}
					}
					
					table.setValueAt(lent_re_state, dataCount, 4);
					table.setValueAt(res_state, dataCount, 5);
				}
				repaint();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		else if(menu_title.equals("상세검색") || menu_title.equals("자료찾기")) {
			try {
				for(dataCount = 0; result.next(); dataCount++) {
					table.setValueAt(result.getString("library.lib_name"), dataCount, 0);
					table.setValueAt(result.getString("kind.kind_num"), dataCount, 1);
					table.setValueAt(result.getString("book.book_name"), dataCount, 2);
					table.setValueAt(result.getString("material.mat_many"), dataCount, 3);
					table.setValueAt(result.getString("material.mat_overlap"), dataCount, 4);
					table.setValueAt(result.getString("book.book_author"), dataCount, 5);
					table.setValueAt(result.getString("book.book_publish"), dataCount, 6);
				}
				repaint();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		else {
			try {
				for(dataCount = 0; result.next(); dataCount++) {
					table.setValueAt(result.getString("library.lib_name"), dataCount, 0);
					table.setValueAt(result.getString("kind.kind_num"), dataCount, 1);
					table.setValueAt(result.getString("book.book_name"), dataCount, 2);
					table.setValueAt(result.getString("book.book_author"), dataCount, 3);
					table.setValueAt(result.getString("book.book_publish"), dataCount, 4);
					String many = removeSymbol(result.getString("material.mat_many"));
					if(many.equals("0")) {
						many = "없음";
					}
					
					table.setValueAt(many, dataCount, 5);
					String overlap = removeSymbol(result.getString("material.mat_overlap"));
					table.setValueAt(overlap, dataCount, 6);
				}
				repaint();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
	}
	
	public class researchButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String now_sql;
			
			if(menu_title.equals("자료검색")) {
				String lib_name = lib_Box.getSelectedItem().toString() + "%";
				String book_name = tf_bookname.getText() + "%";
				String book_author = tf_author.getText() + "%";
				String book_publish = tf_publish.getText() + "%";
				
				now_sql = sql + " AND library.lib_name LIKE '" + lib_name + "' AND book.book_name LIKE '" + book_name +
						  "' AND book.book_author LIKE '" + book_author +  "' AND book.book_publish LIKE '" + 
						  book_publish + "'";
						
			   /*sql = "SELECT library.lib_name, book.book_name, book.book_author, book.book_publish, lent.len_re_st " +
					   "FROM library, book, material LEFT JOIN lent ON material.mat_no = lent.mat_no " + 
					   "WHERE library.lib_no = material.lib_no AND book.book_no = material.book_no" +
					   " AND library.lib_name LIKE '" + lib_name + "' AND book.book_name LIKE '" + book_name + "' AND book.book_author LIKE '" + book_author 
					   +  "' AND book.book_publish LIKE '" + book_publish + "'"; */
				//System.out.println(sql);
				
			}
			else {
				now_sql = sql + " AND library.lib_no LIKE " + manager.foreignkey() + " AND book.book_name LIKE '%" +
						  tf_bookname.getText() + "%'";
				System.out.println(now_sql);
			}
			
			LoadList(now_sql);
			
			try {
				result.first();
			} catch (SQLException e) {
					// TODO Auto-generated catch block
				e.printStackTrace();
			}
				
			MoveData();
		}
	}
	
	public class addButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String mat_many, mat_overlap, now_sql;
			
			if(warning()) {
				if(tf_many.getText().isEmpty()) {
					mat_many = "0";
				}
				else {
					mat_many = "v." + tf_many.getText();
				}
				
				mat_overlap = book_count();
				now_sql = "INSERT INTO `material` ( lib_no, book_no, kind_no, mat_many, mat_overlap ) VALUES (" +
						  manager.foreignkey() + ", " +  fk.call_book_no() + ", " + fk.call_kind_no() + ", '" +
						  mat_many + "', '" + mat_overlap + "')";
				System.out.println(now_sql);
				db.Excute(now_sql);
				
				now_sql = "UPDATE `material` SET `mat_overlap` = '" + mat_overlap + "' WHERE `lib_no` = " + manager.foreignkey() +
						  " AND `book_no` = " + fk.call_book_no();
				System.out.println(now_sql);
				db.Excute(now_sql);
			}
		}	
	}
	
	public class updateButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String mat_many, mat_overlap, now_sql;			
			int book_no, kind_no, code = 0;
			
			book_no = fk.call_book_no();
			kind_no = fk.call_kind_no();
			if(selectedCol == -1) {
				System.out.println("변경할 셀이 선택되지 않았습니다.");
				return;
			}
			
			if(warning()) {
				try {
					code = result.getInt("mat_no");
					if(book_no == 0) {
						book_no = result.getInt("book_no");
					}
					if(kind_no == 0) {
						kind_no = result.getInt("kind_no");
					}
				} catch (SQLException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				
				if(tf_many.getText().isEmpty()) {
					mat_many = "0";
				}
				else {
					mat_many = "v." + tf_many.getText();
				}
				
				mat_overlap = book_count();
				//요부분부터
				now_sql = "UPDATE `material` SET `lib_no` = " + manager.foreignkey() + ", `book_no` = " + book_no +
						  ", `kind_no` = " + kind_no + ", `mat_many` = '" + mat_many + "', `mat_overlap` = '" +
						  mat_overlap + "' WHERE mat_no = " + code;
				System.out.println(now_sql);
				db.Excute(now_sql);
				
				now_sql = "UPDATE `material` SET `mat_overlap` = '" + mat_overlap + "' WHERE `lib_no` = " + manager.foreignkey() +
						  " AND `book_no` = " + book_no;
				System.out.println(now_sql);
				db.Excute(now_sql);
				
				LoadList(sql);
			}
		}	
	}
	
	public class deleteButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String now_sql, mat_overlap;
			int book_no = 0, code = 0;
			
			if(selectedCol == -1) {
				System.out.println("변경할 셀이 선택되지 않았습니다.");
				return;
			}
			
			try {
				code = result.getInt("mat_no");
				book_no = result.getInt("book.book_no");
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			System.out.println("book_no = " + book_no);
			now_sql = "DELETE FROM `material` WHERE `mat_no` = " + code;
			System.out.println(now_sql);
			db.Excute(now_sql);
			
			mat_overlap = book_count();
			now_sql = "UPDATE `material` SET `mat_overlap` = '" + mat_overlap + "' WHERE `lib_no` = " + manager.foreignkey() +
					  " AND `book_no` = " + book_no;
			System.out.println(now_sql);
			db.Excute(now_sql);
			
			LoadList(sql);
		}	
	}
	
	public class clearButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			lib_Box.setSelectedIndex(1);
			tf_bookname.setText(null);
			tf_author.setText(null);
			tf_publish.setText(null);
		}	
	}
	//06.09 저녁 여기부터
	public class reservationButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			int answer, field_count, mat_no, mem_no;
			String now_sql;
			LocalDate now;
			
			//field_count = 0;
			mat_no = 0;
			
			if(state == 2) {
				JOptionPane.showMessageDialog(null, "정지된 계정이어서 예약이 불가능합니다.", "예약불가", JOptionPane.PLAIN_MESSAGE);
				return;
			}
			
			answer = JOptionPane.showConfirmDialog(null, "예약하시겠습니까?", "예약", JOptionPane.YES_NO_OPTION );
			if(answer == JOptionPane.YES_OPTION){
				//사용자가 yes를 눌렀을 떄
				try {
					mat_no = result.getInt("material.mat_no");
					now_sql = "SELECT * FROM `reservation` WHERE `mat_no` = " + mat_no;
					result = db.getResultSet(now_sql);
					/*
					while(result.next()) {
						field_count++;
					}
					*/
				} catch (SQLException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				
				if(resultempty_check(result)) {
					mem_no = cl.primarykey();
					now = LocalDate.now();
					now_sql = "INSERT INTO `reservation` SET `res_date` = '" + now + "', `mem_no` = " + mem_no 
							   + ", `mat_no` = " + mat_no;
					System.out.println(now_sql);
					db.Excute(now_sql);
					System.out.println("예약완료");
				}
				else {
					JOptionPane.showMessageDialog(null, "다른 회원분이 예약했습니다.", "예약불가", JOptionPane.PLAIN_MESSAGE);
				}
			} else{
				//사용자가 Yes 외 값 입력시
				System.out.println("예약취소");
			}
			LoadList(sql);
		}
	}
	
	public class deliveryButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			if(state == 2) {
				JOptionPane.showMessageDialog(null, "정지된 계정이어서 상호대차가 불가능합니다.", "상호대차불가", JOptionPane.PLAIN_MESSAGE);
				return;
			}
			
			try {
				LbDB_delivery_Frame booksea = new LbDB_delivery_Frame(cl, "상호대차", result.getInt("material.mat_no"));
				booksea.setVisible(true);
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
		}
	}
	
	public class bookListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			LbDB_book_Frame book = new LbDB_book_Frame("책검색", tf_bookname, fk);
			book.setVisible(true);
		}
		
	}
	
	public class kindListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			LbDB_kind_Frame kind = new LbDB_kind_Frame("종류검색", tf_kind, fk);
			kind.setVisible(true);
		}
		
	}
	
	public class materialListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			si = new SwingItem(lib_Box, tf_bookname, tf_kind, tf_many);
			LbDB_material_Frame material = new LbDB_material_Frame(si, "상세검색");
			material.setVisible(true);
		}
	}
	
	public class tableListener implements ListSelectionListener{
		@Override
		public void valueChanged(ListSelectionEvent e) {
			String state = "";
			boolean res_exist = true; 
			
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
					lib_Box.setSelectedItem(table.getValueAt(selectedCol, 0).toString());
					if(menu_title.equals("자료검색")) {
						tf_bookname.setText(table.getValueAt(selectedCol, 1).toString());
						tf_author.setText(table.getValueAt(selectedCol, 2).toString());
						tf_publish.setText(table.getValueAt(selectedCol, 3).toString());
						state = table.getValueAt(selectedCol, 4).toString();
						if(state.equals("대출가능")) {
							deliveryBt.setEnabled(true);
						}
						else {
							deliveryBt.setEnabled(false);
						}
						
						state = table.getValueAt(selectedCol, 5).toString();
						if(state.equals("예약가능")) {
							reservationBt.setEnabled(true);
						}
						else {
							reservationBt.setEnabled(false);
						}
					}
					else if(menu_title.equals("자료관리")){
						tf_kind.setText(table.getValueAt(selectedCol, 1).toString());
						tf_bookname.setText(table.getValueAt(selectedCol, 2).toString());
						if(table.getValueAt(selectedCol, 5).toString().equals("0")) {
							tf_many.setText("");
						}
						else {
							tf_many.setText(table.getValueAt(selectedCol, 5).toString());
						}	
					}
					else{
						tf_bookname.setText(table.getValueAt(selectedCol, 2).toString());
					}
					try {
						result.absolute(selectedCol + 1);
						if(menu_title.equals("상세검색")) {
							if(tf_dialog2 != null) {
								tf_dialog.setText(result.getString("book.book_name"));
								tf_dialog2.setText(result.getString("library.lib_name"));
								fk.insert_mat_no(result.getInt("material.mat_no"));
							}
							else {
								si.set_lib_Box(result.getString("library.lib_name"));
								si.set_bookname(result.getString("book.book_name"));
								si.set_kind(result.getString("kind.kind_num"));
								si.set_many(result.getString("material.mat_many"));
							}
							closeFrame();
						}
						else if(menu_title.equals("자료찾기")) {
							if(res_exist) {
								tf_dialog.setText(result.getString("book.book_name"));
								fk.insert_mat_no(result.getInt("material.mat_no"));
								fk.insert_lib_no(result.getInt("material.lib_no")); //lib_no는 상호대차부분 자료검색에 사용
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
