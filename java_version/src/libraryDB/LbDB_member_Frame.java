package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.sql.*;

//member테이블과 관련있는 event처리 클래스
public class LbDB_member_Frame extends LbDB_main_Frame {
	private JPanel northPanel, southPanel;
	private JTextField tf_name, tf_Id, tf_zipcode, tf_address, tf_detail, tf_research, tf_dialog;
	private JRadioButton rb_active, rb_stop, rb_normal, rb_special;
	private ButtonGroup gr_state, gr_lent;
	private JPasswordField tf_Pw, tf_Pw2;
	private JButton bt_complete;
	private int mem_state, mem_lent;
	private boolean state_bool = false; //계정정지
	private LbDB_reservation_Frame res = null;
	
	public LbDB_member_Frame() {}
	public LbDB_member_Frame(LbDB_DAO db, String title) {
		this.db = db;
		menu_title = title;
		fk = new foreignkey();
		Initform();
		baseform();
		baseform_final();
		dialog("회원 가입");
	}
	public LbDB_member_Frame(LbDB_DAO db, Client cl,  String title) {
		this.db = db;
		this.cl = cl;
		menu_title = title;
		fk = new foreignkey();
		pk = cl.primarykey();
		state = cl.state();
		menuform();
		Initform();
		baseform();
		textfield_controller();
		if(state == 1) {
			tableform();
			tableform_final();
			baseform_final();
		}
		else {
			baseform_final();
			textfield_setText();
		}
		setTitle(title);
		addWindowListener(this);
	}
	public LbDB_member_Frame(String title, JTextField tf, foreignkey fk, boolean bool) {
		db = new LbDB_DAO();
		menu_title = title;
		this.fk = fk;
		tf_dialog = tf;
		state_bool = bool;
		sql = "SELECT * FROM `member`, `address` WHERE `member`.`add_no` = `address`.`add_no` AND NOT `mem_state` = 1";
		sortsql = " ORDER BY `mem_name`";
		Initform();
		dialogform();
		tableform();
		dialogform_final();
		dialog(title);
	}
	public LbDB_member_Frame(String title, JTextField tf, foreignkey fk, LbDB_reservation_Frame res)//reservation_Frame일때 사용
	{
		db = new LbDB_DAO();
		menu_title = title;
		this.fk = fk;
		tf_dialog = tf;
		this.res = res;
		state_bool = true;
		sql = "SELECT * FROM `member`, `address` WHERE `member`.`add_no` = `address`.`add_no` AND NOT `mem_state` = 1";
		sortsql = " ORDER BY `mem_name`";
		Initform();
		dialogform();
		tableform();
		dialogform_final();
		dialog(title);
	}
	
	private void baseform() {
		JButton bt_clear, duplicateBt, addressBt, passwordBt;
		JLabel label;
		
		northPanel = new JPanel();
		southPanel = new JPanel();
		
		label = new JLabel(menu_title);
		northPanel.add("Center", label);
		
		setGrid(gbc, 0, 0, 1, 1);
		label = new JLabel("이 름");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc, 1, 0, 1, 1);
		tf_name = new JTextField(5);
		gbl.setConstraints(tf_name, gbc);
		leftPanel.add(tf_name);
		setGrid(gbc, 0, 1, 1, 1);
		label = new JLabel("아이디");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc, 1, 1, 1, 1);
		tf_Id = new JTextField(5);
		gbl.setConstraints(tf_Id, gbc);
		leftPanel.add(tf_Id);
		if(menu_title.equals("회원 가입")) {
			setGrid(gbc, 2, 1, 1, 1);
			duplicateBt = new JButton("중복 확인");
			duplicateBt.addActionListener(new DuplicateButtonListener());
			gbl.setConstraints(duplicateBt, gbc);
			leftPanel.add(duplicateBt);
		}
		else {
			setGrid(gbc, 2, 2, 1, 1);
			passwordBt = new JButton("비밀번호수정");
			passwordBt.addActionListener(new PasswordChangeButtonListener());
			gbl.setConstraints(passwordBt, gbc);
			leftPanel.add(passwordBt);
		}
		setGrid(gbc, 0, 2, 1, 1);
		label = new JLabel("비밀번호");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc, 1, 2, 1, 1);
		tf_Pw = new JPasswordField(5);
		gbl.setConstraints(tf_Pw, gbc);
		leftPanel.add(tf_Pw);
		setGrid(gbc, 0, 3, 1, 1);
		label = new JLabel("비밀번호 확인");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc, 1, 3, 1, 1);
		tf_Pw2 = new JPasswordField(5);
		gbl.setConstraints(tf_Pw2, gbc);
		leftPanel.add(tf_Pw2);
		setGrid(gbc, 0, 4, 1, 1);
		label = new JLabel("우편번호");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc, 1, 4, 1, 1);
		tf_zipcode = new JTextField(5);
		tf_zipcode.setEnabled(false);
		gbl.setConstraints(tf_zipcode, gbc);
		leftPanel.add(tf_zipcode);
		setGrid(gbc, 2, 4, 1, 1);
		addressBt = new JButton("우편검색");
		addressBt.addActionListener(new AddressButtonListener());
		gbl.setConstraints(addressBt, gbc);
		leftPanel.add(addressBt);
		setGrid(gbc, 0, 5, 1, 1);
		label = new JLabel("주소");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc, 1, 5, 1, 1);
		tf_address = new JTextField(50);
		tf_address.setEnabled(false);
		gbl.setConstraints(tf_address, gbc);
		leftPanel.add(tf_address);
		setGrid(gbc, 0, 6, 1, 1);
		label = new JLabel("상세 주소");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc, 1, 6, 1, 1);
		tf_detail = new JTextField(50);
		gbl.setConstraints(tf_detail, gbc);
		leftPanel.add(tf_detail);

		if(menu_title.equals("회원관리")) { //배치변경
			Panel state_pan, lent_pan;
			state_pan = new Panel();
			lent_pan = new Panel();
			
			setGrid(gbc, 0,7,1,1);
			label = new JLabel("반납상태");
			gbl.setConstraints(label, gbc);
			leftPanel.add(label);
			state_pan = new Panel();
			gr_state = new ButtonGroup();
			rb_active = new JRadioButton("활성화", true);
			rb_active.addActionListener(new radiobuttonListener());
			rb_active.addItemListener(new radiobuttonListener());
			rb_active.setActionCommand("state-0");
			gr_state.add(rb_active);
			state_pan.add(rb_active);
			rb_stop = new JRadioButton("정지", false);
			rb_stop.addActionListener(new radiobuttonListener());
			rb_stop.addItemListener(new radiobuttonListener());
			rb_stop.setActionCommand("state-2");
			gr_state.add(rb_stop);
			state_pan.add(rb_stop);
			setGrid(gbc, 1,7,1,1);
			gbl.setConstraints(state_pan, gbc);
			leftPanel.add(state_pan);
			
			setGrid(gbc, 0,8,1,1);
			label = new JLabel("회원구분");
			gbl.setConstraints(label, gbc);
			leftPanel.add(label);
			lent_pan = new Panel();
			gr_lent = new ButtonGroup();
			rb_normal = new JRadioButton("일반", true);
			rb_normal.addActionListener(new radiobuttonListener());
			rb_normal.addItemListener(new radiobuttonListener());
			rb_normal.setActionCommand("lent-5");
			gr_lent.add(rb_normal);
			lent_pan.add(rb_normal);
			rb_special = new JRadioButton("특별", true);
			rb_special.addActionListener(new radiobuttonListener());
			rb_special.addItemListener(new radiobuttonListener());
			rb_special.setActionCommand("lent-10");
			gr_lent.add(rb_special);
			lent_pan.add(rb_special);
			setGrid(gbc, 1,8,1,1);
			gbl.setConstraints(lent_pan, gbc);
			leftPanel.add(lent_pan);
		}
		
		southPanel.setLayout(gbl);
		setGrid(gbc, 0,0,1,1);
		bt_complete = new JButton("완료");
		bt_complete.addActionListener(new CompleteButtonListener()); 
		bt_complete.setEnabled(false);
		southPanel.add(bt_complete);
		setGrid(gbc, 1,0,1,1);
		bt_clear = new JButton("지우기");
		bt_clear.addActionListener(new ClearButtonListener());
		southPanel.add(bt_clear);
	}
	
	private void dialogform() {
		JLabel label;
		
		northPanel = new JPanel();
		label = new JLabel(menu_title);
		northPanel.add("Center", label);
		
		setGrid(gbc, 0, 1, 1, 1);
		label = new JLabel("검색");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc, 1, 1, 1, 1);
		tf_research = new JTextField(20);
		gbl.setConstraints(tf_research, gbc);
		leftPanel.add(tf_research);
		setGrid(gbc, 2, 1, 1, 1);
		researchBt = new JButton("검색");
		researchBt.addActionListener(new ResearchButtonListener());
		gbl.setConstraints(researchBt, gbc);
		leftPanel.add(researchBt);
	}
	
	private void baseform_final() {
		cpane.add("North", northPanel);
		cpane.add("West", leftPanel);
		cpane.add("Center", centerPanel);
		cpane.add("South", southPanel);
		pack();
	}
	
	private void dialogform_final() {
		cpane.add("North", northPanel);
		cpane.add("Center", leftPanel);
		cpane.add("South", centerPanel);
		pack();
	}
	
	private void tableform() {
		String columnName[] = {"이름", "아이디", "비밀번호", "우편번호", "주소", "상세주소", "대출가능수", "계정상태"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane);
	}
	
	private void tableform_final() {
		String now_sql;
		
		sql = "SELECT * FROM `member`, `address` WHERE `member`.`add_no` = `address`.`add_no` AND NOT `mem_state` = 1";
		sortsql = " ORDER BY `mem_name`";
		now_sql = sql + sortsql;
		LoadList(now_sql);
		
		try {
			result.first();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		MoveData();
	}
	
	private void textfield_setText() {
		String now_sql, address;
		int add_no = 0;
		
		now_sql = "SELECT * FROM `member`, `address` WHERE `member`.`add_no` = `address`.`add_no` AND `mem_no` = " + pk;
		result = db.getResultSet(now_sql);
		
		try {
			while(result.next()) {
				tf_name.setText(result.getString("member.mem_name"));
				tf_Id.setText(result.getString("member.mem_id"));
				tf_Pw.setText(result.getString("member.mem_pw"));
				tf_Pw2.setText(result.getString("member.mem_pw"));
				add_no = result.getInt("member.add_no");
				fk.insert_add_no(add_no);
				address = address(result);
				tf_address.setText(address);
				tf_zipcode.setText(result.getString("address.zipcode"));
				tf_detail.setText(result.getString("mem_detail"));
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		
	}
	
	private void removeTableRow(int row) {
		table.setValueAt(null, row, 0);
		table.setValueAt(null, row, 1);
		table.setValueAt(null, row, 2);
		table.setValueAt(null, row, 3);
		table.setValueAt(null, row, 4);
		table.setValueAt(null, row, 5);
		table.setValueAt(null, row, 6);
		table.setValueAt(null, row, 7);
	}
	
	private void MoveData() {
		try {
			String mem_name = result.getString("member.mem_name");
			String mem_id = result.getString("member.mem_id");
			String mem_pw = result.getString("member.mem_pw");
			String mem_detail = result.getString("member.mem_detail");
			String address = address(result);
			String zipcode = result.getString("address.zipcode");
			int add_no = result.getInt("address.add_no");
			int mem_lent = result.getInt("member.mem_lent");
			int mem_state = result.getInt("member.mem_state");
			tf_name.setText(mem_name);
			tf_Id.setText(mem_id);
			tf_Pw.setText(mem_pw);
			tf_Pw2.setText(mem_pw);
			tf_detail.setText(mem_detail);
			
			if(mem_lent == 0) {
				rb_active.setSelectedIcon(null);
				//rb_active.setSelected(true);
			}
			else {
				rb_stop.setSelectedIcon(null);
				//rb_stop.setSelected(true);
			}
			
			if(mem_state == 5) {
				rb_normal.setSelectedIcon(null);
				//rb_normal.setSelected(true);
			}
			else {
				rb_special.setSelectedIcon(null);
				//rb_special.setSelected(true);
			}
			
			tf_address.setText(address);
			tf_zipcode.setText(zipcode);
			
			fk.insert_add_no(add_no);
			this.mem_lent = mem_lent;
			this.mem_state = mem_state;
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void OutData() {
		try {
			if(state_bool) {
				if(result.getInt("member.mem_state") == 2) {
					JOptionPane.showMessageDialog(null, "정지된 계정입니다.",  menu_title + " 오류", JOptionPane.PLAIN_MESSAGE);
					return;
				}
			}
			tf_dialog.setText(result.getString("member.mem_id"));
			fk.insert_mem_no(result.getInt("member.mem_no"));
			
			if(res != null) {
				res.research();
			}
			
			closeFrame();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void LoadList(String now_sql) {
		String state, lent, address;
		System.out.println(now_sql);
		result = db.getResultSet(now_sql);
		
		if(resultempty_check(result)) {
			return;
		}
		
		for(int i = 0; i < dataCount; i++) {
			removeTableRow(i);
		}
		try {
			for(dataCount = 0; result.next(); dataCount++) {
				int mem_lent = result.getInt("member.mem_lent");
				int mem_state = result.getInt("member.mem_state");
				address = address(result);
				
				if(mem_state == 0) {
					state = "활성화";
				}
				else {
					state = "정지";
				}
				
				if(mem_lent == 5) {
					lent = "일반";
				}
				else {
					lent = "특별";
				}
				
				table.setValueAt(result.getString("member.mem_name"), dataCount, 0);
				table.setValueAt(result.getString("member.mem_id"), dataCount, 1);
				table.setValueAt(result.getString("member.mem_pw"), dataCount, 2);
				table.setValueAt(result.getString("address.zipcode"), dataCount, 3);
				table.setValueAt(address, dataCount, 4);
				table.setValueAt(result.getString("member.mem_detail"), dataCount, 5);
				table.setValueAt(lent, dataCount, 6);
				table.setValueAt(state, dataCount, 7);
			}
			repaint();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private String address(ResultSet rs) {
		String address = null, under = "";
		
		try {
			if(rs.getString("under_yn").equals("1")) {
				under = "지하";
			}
			address = rs.getString("sido") + " " + rs.getString("sigungu") + " " + 
					  rs.getString("doro") + " " + under + " " +
					  rs.getString("buildno1") + "-" + rs.getString("buildno2") + "(" +
					  rs.getString("eupmyun") + " " + rs.getString("dong") + " " + 
			          rs.getString("ri") + " " + rs.getString("jibun1") + "-" + rs.getString("jibun2") + ")";
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		return address;
	}
	
	private void textfield_controller() {
		tf_Id.setEnabled(false);
		tf_Pw.setEnabled(false);
		tf_Pw2.setEnabled(false);
		bt_complete.setEnabled(true);
	}
	
	class AddressButtonListener implements ActionListener{

		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			LbDB_address_Dialog add_Dialog = new LbDB_address_Dialog(tf_zipcode, tf_address, fk);
			add_Dialog.setVisible(true);
		}
		
	}
	
	class CompleteButtonListener implements ActionListener{
		@SuppressWarnings("deprecation")
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			int add_no, code = 0;
			String now_sql;
			
			if(tf_name.getText().isEmpty()) {
				JOptionPane.showMessageDialog(null, "이름을 입력해주세요.",  menu_title + " 오류", JOptionPane.PLAIN_MESSAGE);
			}
			else if(tf_Pw.getText().isEmpty())
			{
				JOptionPane.showMessageDialog(null, "비밀번호를 입력해주세요.",  menu_title + " 오류", JOptionPane.PLAIN_MESSAGE);
			}
			else if(tf_zipcode.getText().isEmpty())
			{
				JOptionPane.showMessageDialog(null, "주소를 입력해주세요.",  menu_title + " 오류", JOptionPane.PLAIN_MESSAGE);
			}
			else if(!tf_Pw.getText().equals(tf_Pw2.getText())) {
				JOptionPane.showMessageDialog(null, "비밀번호를 다시 입력해주세요.",  menu_title + " 오류", JOptionPane.PLAIN_MESSAGE);
			}
			else {
				add_no = fk.call_add_no();
				if(menu_title.equals("회원 가입")) {
					now_sql = "INSERT INTO `member` (`mem_name`, `mem_id`, `mem_pw`, `add_no`, `mem_detail`) VALUES ('" + tf_name.getText() + 
							     "', '" + tf_Id.getText() + "', '" + tf_Pw.getText() + "', " + add_no + ", '" + tf_detail.getText() + "')";
					System.out.println(now_sql);
					db.Excute(now_sql);
					closeFrame();
				}
				if(menu_title.equals("회원관리")) {
					try {
						code = result.getInt("mem_no");
					} catch (SQLException e1) {
						// TODO Auto-generated catch block
						e1.printStackTrace();
					}
					
					now_sql = "UPDATE `member` SET `mem_name` = '" + tf_name.getText() + "', `mem_pw` = '" + tf_Pw.getText() 
						+ "', `add_no` = " + add_no + ", `mem_detail` = '" + tf_detail.getText() + "', `mem_lent` = " + mem_lent 
						+ ", `mem_state` = " + mem_state + " WHERE `mem_no` = " + code;
					System.out.println(now_sql);
					db.Excute(now_sql);
					tf_Pw.setEnabled(false);
					tf_Pw2.setEnabled(false);
					LoadList(sql + sortsql);
					
					try {
						result.first();
					} catch (SQLException e1) {
						// TODO Auto-generated catch block
						e1.printStackTrace();
					}
				}
				else {
					now_sql = "UPDATE `member` SET `mem_name` = '" + tf_name.getText() + "', `mem_pw` = '" + tf_Pw.getText() +
						  "', `add_no` = " + add_no + ", `mem_detail` = '" + tf_detail.getText() + "' WHERE `mem_no` = " + pk;
					db.Excute(now_sql);
					tf_name.setEnabled(false);
					tf_Pw.setEnabled(false);
					tf_Pw2.setEnabled(false);
					tf_detail.setEnabled(false);
				}
			}
		}
		
	}
	
	class ClearButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			tf_name.setText("");
			tf_zipcode.setText("");
			tf_address.setText("");
			tf_detail.setText("");
			if(menu_title.equals("회원 가입")) {
				tf_Id.setText("");
				tf_Pw.setText("");
				tf_Pw2.setText("");
				bt_complete.setEnabled(false);
			}
		}
		
	}
	
	class DuplicateButtonListener implements ActionListener{
		ResultSet rs;
		String sql;
		boolean check = true;
		
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			if(tf_Id.getText().isEmpty()) {
				JOptionPane.showMessageDialog(null, "아이디를 입력해주세요.",  menu_title + " 오류", JOptionPane.PLAIN_MESSAGE);
			}
			else {
				sql = "SELECT `mem_id` FROM `member`";
				rs = db.getResultSet(sql);
				
				try {
					while(rs.next()) {
						if(rs.getString("mem_id").equals(tf_Id.getText()))
							check = false;
					}
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
				
				if(check) {
					bt_complete.setEnabled(true);
				}
				else {
					JOptionPane.showMessageDialog(null, "아이디 중복 되었습니다. 다른 아이디를 입력해주세요.",  "아이디 중복", JOptionPane.PLAIN_MESSAGE);
				}
			}
		}
	}
	
	class PasswordChangeButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			tf_Pw.setText("");
			tf_Pw2.setText("");
			tf_Pw.setEnabled(true);
			tf_Pw2.setEnabled(true);
		}
	}
	
	public class ResearchButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String mem_name, mem_id, now_sql, in_sql;
			
			mem_name = "%" + tf_research.getText() + "%";
			mem_id = "%" + tf_research.getText() + "%";
			
			in_sql = "SELECT `mem_no` FROM `member` WHERE `mem_name` LIKE '" + mem_name + "' OR `mem_id` LIKE '" + mem_id + "'";
			now_sql = sql + " AND member.mem_no IN (" + in_sql + ")" + sortsql;
			System.out.println(now_sql);
			LoadList(now_sql);
			
			try {
				result.first();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			if(menu_title.equals("회원관리")) {
				MoveData();
			}
		}
	}
	
	public class radiobuttonListener implements ItemListener, ActionListener{

		@Override
		public void itemStateChanged(ItemEvent arg0) {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			String cmd, str_array[];
			
			cmd = e.getActionCommand();
			str_array = cmd.split("-");
			
			for(int i = 0; i < str_array.length; i++) {
				System.out.print(str_array[i]);
			}
			System.out.println();
			
			if(str_array[0].equals("state")) {
				mem_state = Integer.parseInt(str_array[1]);
			}
			else {
				mem_lent = Integer.parseInt(str_array[1]);
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
					if(!menu_title.equals("회원찾기")) {
						tf_name.setText(table.getValueAt(selectedCol, 0).toString());
						tf_Id.setText(table.getValueAt(selectedCol, 1).toString());
						tf_Pw.setText(table.getValueAt(selectedCol, 2).toString());
						tf_Pw2.setText(table.getValueAt(selectedCol, 2).toString());
						tf_zipcode.setText(table.getValueAt(selectedCol, 3).toString());
						tf_address.setText(table.getValueAt(selectedCol, 4).toString());
						tf_detail.setText(table.getValueAt(selectedCol, 5).toString());
						
						if(table.getValueAt(selectedCol, 6).toString().equals("일반")) {
							rb_normal.setSelected(true);
						}
						else {
							rb_special.setSelected(true);
						}
						
						if(table.getValueAt(selectedCol, 7).toString().equals("활성화")) {
							rb_active.setSelected(true);
						}
						else {
							rb_stop.setSelected(true);
						}
					}
					
					try {
						result.absolute(selectedCol + 1);
						if(menu_title.equals("회원찾기")) {
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