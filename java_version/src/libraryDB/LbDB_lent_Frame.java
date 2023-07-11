package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.sql.*;
import java.time.*;
import java.time.format.*;

//lent테이블과 관련있는 event처리 클래스
public class LbDB_lent_Frame extends LbDB_main_Frame implements todayinterface{
	private JPanel northPanel;
	private Combobox_Manager lib_research, lib_select;
	private JTextField tf_research, tf_book_name, tf_mem_id;
	private JRadioButton rb_lent, rb_return, rb_etc, rb_normal, rb_extend;
	private ButtonGroup gr_return, gr_extend;
	private String columnName[];
	private SwingItem si;
	private LbDB_etc_Frame etc;
	private boolean booksea_use = false;
	
	public LbDB_lent_Frame() {}
	public LbDB_lent_Frame(LbDB_DAO db, Client cl, String title) {
		this.db = db;
		this.cl = cl;
		menu_title = title;
		pk = cl.primarykey();
		state = cl.state();
		fk = new foreignkey();
		menuform();
		Initform();
		baseform();
		
		if(menu_title.equals("대출중도서")) {
			sql = "SELECT * FROM `library`, `book`, `material`, `member`, `lent` WHERE material.lib_no = library.lib_no " +
				  "AND material.book_no = book.book_no AND lent.mat_no = material.mat_no AND lent.mem_no = member.mem_no " + 
				  "AND lent.mem_no = " + pk + " AND lent.len_re_st = 0";
			String str = "자료이름,소장도서관,대출일,반납일예정";
			columnName = str.split(",");
			tableform(columnName);
		}
		else if(menu_title.equals("모든대출내역")) {
			sql = "SELECT * FROM `library`, `book`, `material`, `member`, `lent` WHERE material.lib_no = library.lib_no " +
				  "AND material.book_no = book.book_no AND lent.mat_no = material.mat_no AND lent.mem_no = member.mem_no " + 
				  "AND lent.mem_no = " + pk;
			String str = "자료이름,소장도서관,대출일,반납일,반납상태";
			columnName = str.split(",");
			tableform(columnName);
		}
		else if(menu_title.equals("대출관리")) {
			managerform();
			lentform();
			editform();
			sql = "SELECT * FROM `library`, `book`, `material`, `member`, `lent` WHERE material.lib_no = library.lib_no " +
				  "AND material.book_no = book.book_no AND lent.mat_no = material.mat_no AND lent.mem_no = member.mem_no";
			String str = "회원아이디,자료이름,소장도서관,대출일,연장여부,반납일,반납상태,메모";
			columnName = str.split(",");
			tableform(columnName);
		}
		else if(menu_title.equals("대출추가")) {
			northPanel = new JPanel();
			managerform();
			lentform();
			lentaddform();
		}
		else {
			managerform();
			returnaddform();
			sql = "SELECT * FROM `library`, `book`, `material`, `member`, `lent` WHERE material.lib_no = library.lib_no " 
				+ "AND material.book_no = book.book_no AND lent.mat_no = material.mat_no AND lent.mem_no = member.mem_no "
				+ "AND `len_re_st` = 0";
			String str = "회원아이디,자료이름,소장도서관,대출일";
			columnName = str.split(",");
			tableform(columnName);
		}
		baseform_fianl();
		
		String now_sql;
		if(state == 1) {
			if(menu_title.equals("대출관리") || menu_title.equals("반납추가")) {
				sortsql = " ORDER BY `mem_name`";
				now_sql = sql + sortsql;
				LoadList(now_sql);
				tablefocus();
			}
		}
		else {
			sortsql = " ORDER BY `mem_name`";
			now_sql = sql + sortsql;
			LoadList(now_sql);
		}
		
		setTitle(menu_title);
		addWindowListener(this);
	}
	
	public LbDB_lent_Frame(LbDB_DAO db, Client cl, int len_no) {
		this.db = db;
		this.cl = cl;
		menu_title = "대출관리";
		pk = cl.primarykey();
		state = cl.state();
		fk = new foreignkey();
		menuform();
		Initform();
		baseform();
		managerform();
		lentform();
		editform();
		sql = "SELECT * FROM `library`, `book`, `material`, `member`, `lent` WHERE material.lib_no = library.lib_no " +
			  "AND material.book_no = book.book_no AND lent.mat_no = material.mat_no AND lent.mem_no = member.mem_no ";
		String str = "회원아이디,자료이름,소장도서관,대출일,연장여부,반납일,반납상태,메모";
		columnName = str.split(",");
		tableform(columnName);
		baseform_fianl();
		
		sortsql = " ORDER BY `mem_name`";
		String now_sql = sql + "AND lent.len_no = " + len_no + sortsql;
		LoadList(now_sql);
		tablefocus();
		setTitle(menu_title);
		addWindowListener(this);
	}
	
	public LbDB_lent_Frame(String title, foreignkey fk, SwingItem si, LbDB_etc_Frame etc) { //etc_frame만 사용
		db = new LbDB_DAO();
		menu_title = title;
		this.fk = fk;
		this.si = si;
		this.etc = etc;
		
		dialog(menu_title);
		menuform();
		Initform();
		baseform();
		sql = "SELECT * FROM `library`, `book`, `material`, `member`, `lent` WHERE material.lib_no = library.lib_no " +
			  "AND material.book_no = book.book_no AND lent.mat_no = material.mat_no AND lent.mem_no = member.mem_no ";
		String str = "회원아이디,자료이름,소장도서관,대출일,연장여부,반납일,반납상태,메모";
		columnName = str.split(",");
		tableform(columnName);
		cpane.add("North", northPanel);
		cpane.add("Center", centerPanel);
		pack();
		
		sortsql = " ORDER BY `mem_name`";
		String now_sql = sql + sortsql;
		LoadList(now_sql);
	}
	
	private void baseform() {
		JPanel titlePanel, researchPanel;
		JLabel label;
		
		titlePanel = new JPanel();
		titlePanel.setLayout(new BoxLayout(titlePanel, BoxLayout.X_AXIS));
		label = new JLabel(menu_title);
		titlePanel.add(label);
		
		researchPanel = new JPanel();
		if(menu_title.equals("대출관리") || menu_title.equals("반납추가") || menu_title.equals("대출찾기")) {
			JComboBox <String> lib_Box = null;
			
			label = new JLabel("도서관");
			researchPanel.add(label);
			lib_research = new Combobox_Manager(lib_Box, "library", "lib_no");
			lib_Box = lib_research.combox;
			researchPanel.add(lib_Box);
		}
		label = new JLabel("검색");
		researchPanel.add(label);
		tf_research = new JTextField(20);
		researchPanel.add(tf_research);
		researchBt = new JButton("검색");
		researchBt.addActionListener(new researchButtonListener());
		researchPanel.add(researchBt);
		
		northPanel = new JPanel();
		northPanel.setLayout(new BoxLayout(northPanel, BoxLayout.Y_AXIS));
		northPanel.add(titlePanel);
		northPanel.add(researchPanel);
	}
	
	private void managerform() {
		JButton bt;
		JLabel label;
		JComboBox <String> lib_Box = null;
		
		setGrid(gbc,1,1,1,1);
		label = new JLabel("                      "+ menu_title + "   ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		if(menu_title.equals("대출추가")) {
			setGrid(gbc,0,2,1,1);
			label = new JLabel("    대출도서관       ");
			gbl.setConstraints(label, gbc);
			leftPanel.add(label);
			setGrid(gbc,1,2,1,1);
			lib_select = new Combobox_Manager(lib_Box, "library", "lib_no", false);
			lib_Box = lib_select.combox;
			gbl.setConstraints(lib_Box, gbc);
			leftPanel.add(lib_Box);
			setGrid(gbc,2,1,1,1);
			bt = new JButton("예약");
			bt.addActionListener(new reservationButtonListener());
			gbl.setConstraints(bt, gbc);
			leftPanel.add(bt);
			setGrid(gbc,3,1,1,1);
			bt = new JButton("상호대차");
			bt.addActionListener(new bookseaButtonListener());
			gbl.setConstraints(bt, gbc);
			leftPanel.add(bt);
		}
		setGrid(gbc,0,3,1,1);
		label = new JLabel("    자료이름        ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,3,1,1);
		tf_book_name = new JTextField(20);
		tf_book_name.setEnabled(false);
		gbl.setConstraints(tf_book_name, gbc);
		leftPanel.add(tf_book_name);
		setGrid(gbc,0,4,1,1);
		label = new JLabel("    회원아이디       ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,4,1,1);
		tf_mem_id = new JTextField(10);
		tf_mem_id.setEnabled(false);
		gbl.setConstraints(tf_mem_id, gbc);
		leftPanel.add(tf_mem_id);
	}
	
	private void lentform() {
		JButton bt;
		JLabel label;
		JPanel extendPanel;
		
		setGrid(gbc,2,3,1,1);
		bt = new JButton("자료검색");
		bt.addActionListener(new materialButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,2,4,1,1);
		bt = new JButton("회원검색");
		bt.addActionListener(new memberButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,0,5,1,1);
		label = new JLabel("    연장          ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,5,1,1);
		extendPanel = new JPanel();
		gr_extend = new ButtonGroup();
		rb_normal = new JRadioButton("예", false);
		rb_normal.addActionListener(new radiobuttonListener());
		rb_normal.addItemListener(new radiobuttonListener());
		rb_normal.setActionCommand("ex-7");
		gr_extend.add(rb_normal);
		extendPanel.add(rb_normal);
		rb_extend = new JRadioButton("아니오", true);
		rb_extend.addActionListener(new radiobuttonListener());
		rb_extend.addItemListener(new radiobuttonListener());
		rb_extend.setActionCommand("ex-0");
		gr_extend.add(rb_extend);
		extendPanel.add(rb_extend);
		gbl.setConstraints(extendPanel, gbc);
		leftPanel.add(extendPanel);
	}
	
	private void editform() {
		JLabel label;
		JButton bt;
		JPanel statePanel = null;
		
		setGrid(gbc,0,6,1,1);
		label = new JLabel("    반납일         ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,6,1,1);
		tf_date = new JTextField(10);
		gbl.setConstraints(tf_date, gbc);
		leftPanel.add(tf_date);
		setGrid(gbc,2,6,1,1);
		bt = new JButton("오늘");
		bt.addActionListener(new todayButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,0,7,1,1);
		label = new JLabel("    반납상태        ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,7,1,1);
		statePanel = extendpanelform(statePanel);
		gbl.setConstraints(statePanel, gbc);
		leftPanel.add(statePanel);
		setGrid(gbc,0,8,1,1);
		label = new JLabel("    메모          ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,8,1,1);
		tf_memo = new JTextField(20);
		gbl.setConstraints(tf_memo, gbc);
		leftPanel.add(tf_memo);
		setGrid(gbc,0,9,1,1);
		bt = new JButton("삭제");
		bt.addActionListener(new deleteButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,1,9,1,1);
		bt = new JButton("수정");
		bt.addActionListener(new updateButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
		setGrid(gbc,2,9,1,1);
		bt = new JButton("공백");
		bt.addActionListener(new clearButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
	}
	
	private void lentaddform() {
		JButton bt;
		
		setGrid(gbc,2,6,1,1);
		bt = new JButton("추가");
		bt.addActionListener(new addButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
	}
	
	private void returnaddform() {
		JButton bt;
		JLabel label;
		JComboBox <String> lib_Box = null;
		
		setGrid(gbc,0,5,1,1);
		label = new JLabel("    반납도서관       ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,5,1,1);
		lib_select = new Combobox_Manager(lib_Box, "library", "lib_no");
		lib_Box = lib_select.combox;
		gbl.setConstraints(lib_Box, gbc);
		leftPanel.add(lib_Box);
		setGrid(gbc,2,6,1,1);
		bt = new JButton("추가");
		bt.addActionListener(new addButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
	}
	
	private JPanel extendpanelform(JPanel extendPanel) {
		extendPanel = new JPanel();
		gr_return = new ButtonGroup();
		rb_lent = new JRadioButton("대출중", true);
		rb_lent.addActionListener(new radiobuttonListener());
		rb_lent.addItemListener(new radiobuttonListener());
		rb_lent.setActionCommand("st-0");
		gr_return.add(rb_lent);
		extendPanel.add(rb_lent);
		rb_return = new JRadioButton("반납", false);
		rb_return.addActionListener(new radiobuttonListener());
		rb_return.addItemListener(new radiobuttonListener());
		rb_return.setActionCommand("st-1");
		gr_return.add(rb_return);
		extendPanel.add(rb_return);
		rb_etc = new JRadioButton("기타", false);
		rb_etc.addActionListener(new radiobuttonListener());
		rb_etc.addItemListener(new radiobuttonListener());
		rb_etc.setActionCommand("st-2");
		gr_return.add(rb_etc);
		extendPanel.add(rb_etc);
		return extendPanel;
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
		
		MoveData();
	}
	
	private void baseform_fianl() {
		cpane.add("North", northPanel);
		cpane.add("West", leftPanel);
		cpane.add("Center", centerPanel);
		pack();
	}
	
	private void removeTableRow(int row) {
		if(menu_title.equals("모든대출내역")) {
			table.setValueAt(null, row, 0);
			table.setValueAt(null, row, 1);
			table.setValueAt(null, row, 2);
			table.setValueAt(null, row, 3);
			table.setValueAt(null, row, 4);
		}
		else if(menu_title.equals("대출관리")) {
			table.setValueAt(null, row, 0);
			table.setValueAt(null, row, 1);
			table.setValueAt(null, row, 2);
			table.setValueAt(null, row, 3);
			table.setValueAt(null, row, 4);
			table.setValueAt(null, row, 5);
			table.setValueAt(null, row, 6);
			table.setValueAt(null, row, 7);
		}
		else {
			table.setValueAt(null, row, 0);
			table.setValueAt(null, row, 1);
			table.setValueAt(null, row, 2);
			table.setValueAt(null, row, 3);
		}
	}
	
	private void MoveData() {		
		try {
			String memberid = result.getString("member.mem_id");
			String bookname = result.getString("book.book_name");

			tf_mem_id.setText(memberid);
			tf_book_name.setText(bookname);
			
			if(menu_title.equals("대출관리")) {
				String returndate = result.getString("lent.len_re_date");
				String memo = result.getString("lent.len_memo");
				int len_ex = result.getInt("lent.len_ex");
				int len_re_st = result.getInt("lent.len_re_st");
				
				tf_date.setText(returndate);
				tf_memo.setText(memo);
				
				if(len_ex == 0) {
					rb_extend.setSelected(true);
				}
				else {
					rb_normal.setSelected(true);
				}
				
				if(len_re_st == 0) {
					rb_lent.setSelected(true);
				}
				else if(len_re_st == 1) {
					rb_return.setSelected(true);
				}
				else {
					rb_etc.setSelected(true);
				}
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void LoadList(String now_sql) {
		String date, len_state, memo;
		
		result = db.getResultSet(now_sql);
		
		for(int i = 0; i < dataCount; i++) {
			removeTableRow(i);
		}
		try {
			for(dataCount = 0; result.next(); dataCount++) {
				if(menu_title.equals("대출중도서")) {
					table.setValueAt(result.getString("book.book_name"), dataCount, 0);
					table.setValueAt(result.getString("library.lib_name"), dataCount, 1);
					table.setValueAt(result.getString("lent.len_date"), dataCount, 2);
					date = String.valueOf(estimateReturndate(result.getString("lent.len_date"), result.getInt("lent.len_ex")));
					table.setValueAt(date, dataCount, 3);
				}
				else if(menu_title.equals("모든대출내역")) {
					table.setValueAt(result.getString("book.book_name"), dataCount, 0);
					table.setValueAt(result.getString("library.lib_name"), dataCount, 1);
					table.setValueAt(result.getString("lent.len_date"), dataCount, 2);
					table.setValueAt(result.getString("lent.len_re_date"), dataCount, 3);
					len_state = return_state(result.getInt("lent.len_re_st"));
					table.setValueAt(len_state, dataCount, 4);
				}
				else if(menu_title.equals("대출관리") || menu_title.equals("대출찾기")) {
					table.setValueAt(result.getString("member.mem_id"), dataCount, 0);
					table.setValueAt(result.getString("book.book_name"), dataCount, 1);
					table.setValueAt(result.getString("library.lib_name"), dataCount, 2);
					table.setValueAt(result.getString("lent.len_date"), dataCount, 3);
					table.setValueAt(result.getString("lent.len_ex"), dataCount, 4);
					if(result.getString("lent.len_re_date") == null) {
						date = "";
					}
					else {
						date = result.getString("lent.len_re_date");
					}
					table.setValueAt(date, dataCount, 5);
					len_state = return_state(result.getInt("lent.len_re_st"));
					table.setValueAt(len_state, dataCount, 6);
					if(result.getString("lent.len_memo") ==  null) {
						memo = "";
					}
					else {
						memo = result.getString("lent.len_memo");
					}
					table.setValueAt(memo, dataCount, 7);
				}
				else {
					table.setValueAt(result.getString("member.mem_id"), dataCount, 0);
					table.setValueAt(result.getString("book.book_name"), dataCount, 1);
					table.setValueAt(result.getString("library.lib_name"), dataCount, 2);
					table.setValueAt(result.getString("lent.len_date"), dataCount, 3);
				}
			}
			repaint();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private boolean warning() {
		boolean bool;
		if(tf_book_name.getText().isEmpty()) {
			JOptionPane.showMessageDialog(null, "책정보를 찾아주세요.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			bool = false;
		}
		else if(tf_mem_id.getText().isEmpty()) {
			JOptionPane.showMessageDialog(null, "회원정보를 찾아주세요.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			bool = false;
		}
		else {
			bool = true;
		}
		
		return bool;
	}
	
	private String return_state(int num) {
		String len_state;
		
		if(num == 0) {
			len_state = "대출중";
		}
		else if(num == 1) {
			len_state = "반납";
		}
		else {
			len_state = "기타";
		}
		
		return len_state;
	}
	
	private void reservation_check() {
		int mem_no = 0, res_no = 0;
		String now_sql;
		boolean bool = false;
		
		now_sql = "SELECT * FROM `reservation` WHERE `mat_no` = " + fk.call_mat_no();
		System.out.println(now_sql);
		result = db.getResultSet(now_sql);
		
		try {
			while(result.next()) {
				bool = true;
				mem_no = result.getInt("mem_no");
				res_no = result.getInt("res_no");
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		if(mem_no == fk.call_mem_no()) {
			bool = false;
			now_sql = "DELECT FROM `reservation` WHERE `res_no` = " + res_no;
			db.Excute(now_sql);
		}
		
		if(bool) {
			JOptionPane.showMessageDialog(null, "예약도서입니다.", "대출 오류", JOptionPane.WARNING_MESSAGE);
			return;
		}
	}
	
	public LocalDate estimateReturndate(String lentdate, int extend) {
		int period = 15;
		LocalDate date;
		
		date = LocalDate.parse(lentdate);
		period += extend;
		date = date.plusDays(period);
		System.out.println("date: " + date + ", period: " + period);
		
		return date;
	}
	
	public class researchButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			String  now_sql, sub_sql;
			int mat_no, mem_no;
			
			if(tf_research.getText().isEmpty()) {
				now_sql = sql + sortsql;
				System.out.println(now_sql);
				LoadList(now_sql);
				tablefocus();
				return;
			}
			
			if(state == 1) {
				mat_no = 0;
				mem_no = 0;
				
				sub_sql = "SELECT * FROM material, book WHERE material.book_no = book.book_no AND " 
						 + "material.lib_no = " + lib_research.foreignkey() 
						 + " AND book_name LIKE '%" + tf_research.getText() + "%'";
				result = db.getResultSet(sub_sql);
				
				try {
					while(result.next()) {
						mat_no = result.getInt("material.mat_no");
					}
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
				
				sub_sql = "SELECT * FROM member WHERE mem_id LIKE '%" + tf_research.getText() + "%'";
				result = db.getResultSet(sub_sql);
				
				try {
					while(result.next()) {
						mem_no = result.getInt("mem_no");
					}
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
				
				if(mat_no == 0) {
					now_sql = sql + " AND lent.mem_no = " + mem_no;
				}
				else if(mem_no == 0) {
					now_sql = sql + " AND lent.mat_no = " + mat_no;
				}
				else {
					now_sql = sql + " AND lent.mat_no = " + mat_no + " UNION " + sql + " AND lent.mem_no = " + mem_no;
				}
			}
			else {
				now_sql = sql + "AND book.book_name LIKE '%" + tf_research.getText() + "%'";
			}
			System.out.println(now_sql);
			LoadList(now_sql);
			tablefocus();
		}
	}
	
	public class addButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			int code = 0, mat_lib_no = 0, len_ex = 0;
			String now_sql, next_sql, len_date = null;
			 
			if(warning()) {
				if(menu_title.equals("대출추가")) {
					reservation_check();
					
					now_sql = "INSERT INTO `lent` ( mat_no, mem_no, len_ex, len_date ) VALUES(" + fk.call_mat_no() + ", "
							+ fk.call_mem_no() + ", " + ex + ", '" + today + "')";
					System.out.println(now_sql);
					db.Excute(now_sql);
					
					next_sql = "SELECT `len_no` FROM `lent` WHERE `mat_no` = " + fk.call_mat_no() + " AND `mem_no` = "
							 + fk.call_mem_no() + " AND `len_date` = '" + today + "'";
					result = db.getResultSet(next_sql);
					
					try {
						while(result.next()) {
							code = result.getInt("len_no");
						}
					} catch (SQLException e1) {
						// TODO Auto-generated catch block
						e1.printStackTrace();
					}
					if(booksea_use) {
						String booksea_sql;
						booksea_sql = "UPDATE delivery SET len_no = " + code + " WHERE del_no = " + fk.call_del_no();
						System.out.println(booksea_sql);
						db.Excute(booksea_sql);
					}
					next_sql = "INSERT INTO `place` (`len_no`, `lib_no_len`) VALUES(" + code +", " + lib_select.foreignkey() + ")";
				}
				else {
					if(selectedCol == -1) {
						System.out.println("변경할 셀이 선택되지 않았습니다.");
						return;
					}
					try {
						code = result.getInt("lent.len_no");
						len_ex = result.getInt("lent.len_ex");
						mat_lib_no = result.getInt("material.lib_no");
						len_date = result.getString("lent.len_date");
					} catch (SQLException e1) {
						// TODO Auto-generated catch block
						e1.printStackTrace();
					}
					now_sql = "UPDATE `lent` SET `len_re_date` = '" + today + "', `len_re_st` = 1 WHERE len_no = " + code;
					System.out.println(now_sql);
					db.Excute(now_sql);
					next_sql = "SELECT `pla_no` FROM `place` WHERE `len_no` = " + code;
					result = db.getResultSet(next_sql);
					try {
						while(result.next()) {
							code = result.getInt("pla_no");
						}
					} catch (SQLException e1) {
						// TODO Auto-generated catch block
						e1.printStackTrace();
					}
					System.out.println("lib_no_re = " + lib_select.foreignkey());
					next_sql = "UPDATE `place` SET `lib_no_re` = " + lib_select.foreignkey() + " WHERE `pla_no` = " + code;
				}
				System.out.println(next_sql);
				db.Excute(next_sql);
				
				if(menu_title.equals("반납추가")) {
					if(mat_lib_no != lib_select.foreignkey()) {
						now_sql = "INSERT INTO delivery (mem_no, mat_no, lib_no_arr, del_arr_date, del_app) VALUES (" 
								+ pk + ", " + code + ", " + lib_select.foreignkey() + ", '" + today +"', 2)";
						System.out.println("타자료반납: " + now_sql);
					}
					
					now_sql = "SELECT * FROM overdue WHERE len_no = " + code;
					System.out.println(now_sql);
					result = db.getResultSet(now_sql);
					
					if(!resultempty_check(result)) {
						LocalDate prd, due_exp;
						Period diff;
						
						try {
							code = result.getInt("overdue.due_no");
						} catch (SQLException e1) {
							// TODO Auto-generated catch block
							e1.printStackTrace();
						}
						
						prd = estimateReturndate(len_date, len_ex);
						diff = Period.between(prd, today);
						due_exp = today;
						due_exp.plus(diff);
						System.out.println("해제일: " + due_exp);
						
						now_sql = "UPDATE overdue SET due_exp = '"  + due_exp + "' WHERE due_no = " + code;
					}
				}
				
				if(menu_title.equals("대출관리")) {
					now_sql = sql + sortsql;
					LoadList(now_sql);
				}
			}
		}
	}
	
	public class updateButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			int code = 0;
			int len_re_st = 0;
			String now_sql;
			
			if(selectedCol == -1) {
				System.out.println("변경할 셀이 선택되지 않았습니다.");
				return;
			}
			
			if(st == 1) {
				if(dateformat_check(tf_date.getText())) {
					JOptionPane.showMessageDialog(null, "날짜형식이 잘못되었습니다.", "수정 오류", JOptionPane.WARNING_MESSAGE);
					return;
				}
			}
			
			reservation_check();
			
			try {
				code = result.getInt("lent.len_no");
				len_re_st = result.getInt("lent.len_re_st");
				if(fk.call_mem_no() == 0) {
					fk.insert_mem_no(result.getInt("lent.mem_no"));
				}
				if(fk.call_mat_no() == 0) {
					fk.insert_mat_no(result.getInt("lent.mat_no"));
				}
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			System.out.println("tf_memo의 내용: " + tf_memo.getText() + ", bool의 값" + tf_memo.getText().equals(""));
			
			if(tf_memo.getText().equals("")) {
				now_sql = "UPDATE `lent` SET mem_no = " + fk.call_mem_no() + ", mat_no = " + fk.call_mat_no() + ", len_ex = " 
						+ ex + ", len_re_date = null, len_re_st = " + st + ", len_memo = '" + tf_memo.getText() 
						+ "' WHERE len_no = " + code;
			}
			else {
				now_sql = "UPDATE `lent` SET mem_no = " + fk.call_mem_no() + ", mat_no = " + fk.call_mat_no() + ", len_ex = " 
						+ ex + ", len_re_date = '" + tf_date.getText() + "', len_re_st = " + st + ", len_memo = '" 
						+ tf_memo.getText() + "' WHERE len_no = " + code;
			}
			System.out.println(now_sql);
			db.Excute(now_sql);
			
			if(len_re_st == 1) {
				if(st != 1) {
					now_sql = "UPDATE `place` SET `lib_no_re` = NULL WHERE `len_no` = " + code;
					System.out.println(now_sql);
					db.Excute(now_sql);
				}
			}
			
			LoadList(sql + sortsql);
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
				code = result.getInt("lent.len_no");
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			now_sql = "DELETE FROM `place` WHERE len_no = " + code;
			db.Excute(now_sql);
			now_sql = "DELETE FROM `lent` WHERE len_no = " + code;
			db.Excute(now_sql);
			LoadList(sql + sortsql);
		}
	}
	
	public class clearButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			tf_book_name.setText("");
			tf_mem_id.setText("");
			tf_date.setText("");
			tf_memo.setText("");
		}
	}
	
	public class materialButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			LbDB_material_Frame mat = new LbDB_material_Frame("자료찾기", tf_book_name, fk);
			mat.setVisible(true);
		}
	}
	
	public class memberButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			LbDB_member_Frame men = new LbDB_member_Frame("회원찾기", tf_mem_id, fk, true);
			men.setVisible(true);
		}
	}
	
	public class bookseaButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			SwingItem si = new SwingItem(lib_select.combox, tf_book_name, tf_mem_id);
			LbDB_delivery_Frame booksea = new LbDB_delivery_Frame(cl, "상호대차", si, fk);
			booksea_use = true;
			booksea.setVisible(true);
		}		
	}
	
	public class reservationButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			SwingItem si = new SwingItem(lib_select.combox, tf_book_name, tf_mem_id);
			LbDB_reservation_Frame reservation = new LbDB_reservation_Frame("예약찾기", si, fk);
			reservation.setVisible(true);
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
					if(state == 1) {
						tf_mem_id.setText(table.getValueAt(selectedCol, 0).toString());
						tf_book_name.setText(table.getValueAt(selectedCol, 1).toString());
						
						if(!menu_title.equals("반납추가")) {
							if(table.getValueAt(selectedCol, 4).toString().equals("0")) {
								rb_normal.setSelected(true);
							}
							else {
								rb_extend.setSelected(true);
							}
							
							tf_date.setText(table.getValueAt(selectedCol, 5).toString());
							
							if(table.getValueAt(selectedCol, 6).toString().equals("대출중")) {
								rb_normal.setSelected(true);
							}
							else if(table.getValueAt(selectedCol, 6).toString().equals("반납")) {
								rb_return.setSelected(true);
							}
							else {
								rb_etc.setSelected(true);
							}
							
							tf_memo.setText(table.getValueAt(selectedCol, 7).toString());
						}
						
						try {
							result.absolute(selectedCol + 1);
							MoveData();
						} catch (SQLException e1) {
							e1.printStackTrace();
						}
						repaint();
					}
					
					if(menu_title.equals("대출찾기")) {
						try {
							result.absolute(selectedCol + 1);
							si.set_memid(result.getString("member.mem_id"));
							si.set_bookname(result.getString("book.book_name"));
							si.set_len_date(result.getString("lent.len_date"));
							si.set_len_re_date(result.getString("lent.len_re_date"));
							fk.insert_len_no(result.getInt("lent.len_no"));
							if(result.getString("lent.len_re_date") == null) {
								fk.is_null_re_date = true;
							}
							etc.research_lent();
							closeFrame();
						} catch (SQLException e1) {
							e1.printStackTrace();
						}
						repaint();
					}
				}
			}
		}
	}
}