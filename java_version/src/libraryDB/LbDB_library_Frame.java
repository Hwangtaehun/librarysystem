package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.sql.*;
import java.time.*;

//library테이블과 관련있는 event처리 클래스
public class LbDB_library_Frame extends LbDB_main_Frame {
	private boolean push_addbt;
	private JTextField tf_lib_name, tf_lib_date, tf_zipcode, tf_address, tf_lib_detail;
	
	public LbDB_library_Frame() {}
	public LbDB_library_Frame(LbDB_DAO db, Client cl, String str) {
		this.db = db;
		this.cl = cl;
		menu_title = str;
		fk = new foreignkey();
		pk = cl.primarykey();
		state = cl.state();
		push_addbt = false;
		
		menuform();
		
		if(menu_title.equals("도서관관리")) {
			Initform();
			baseform();
			managerform();
			tableform();
			baseform_final();
			tableform_final();
		}
		else {
			Initform();
			baseform();
			insertform();
			baseform_final();
		}
		setTitle(menu_title);
		addWindowListener(this);
	}
	
	private void baseform() {
		JLabel label;
		JButton addressbt;
		
		setGrid(gbc,1,1,1,1);
		label = new JLabel("                                                     " + menu_title);
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,0,4,1,1);
		label = new JLabel("    이름    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,4,1,1);
		tf_lib_name = new JTextField(10);
		gbl.setConstraints(tf_lib_name, gbc);
		leftPanel.add(tf_lib_name);
		setGrid(gbc,0,5,1,1);
		label = new JLabel("    설립일  ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,5,1,1);
		tf_lib_date = new JTextField(20);
		gbl.setConstraints(tf_lib_date, gbc);
		leftPanel.add(tf_lib_date);
		setGrid(gbc,0,6,1,1);
		label = new JLabel("    우편번호   ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,6,1,1);
		tf_zipcode = new JTextField(5);
		tf_zipcode.setEnabled(false);
		gbl.setConstraints(tf_zipcode, gbc);
		leftPanel.add(tf_zipcode);
		setGrid(gbc,2,6,1,1);
		addressbt = new JButton("우편검색");
		addressbt.addActionListener(new AddressButtonListener());
		gbl.setConstraints(addressbt, gbc);
		leftPanel.add(addressbt);
		setGrid(gbc,0,7,1,1);
		label = new JLabel("    주소  ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,7,1,1);
		tf_address = new JTextField(50);
		tf_address.setEnabled(false);
		gbl.setConstraints(tf_address, gbc);
		leftPanel.add(tf_address);
		setGrid(gbc,0,8,1,1);
		label = new JLabel("    상세주소  ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,8,1,1);
		tf_lib_detail = new JTextField(20);
		gbl.setConstraints(tf_lib_detail, gbc);
		leftPanel.add(tf_lib_detail);
	}
	
	private void managerform() {
		JLabel label;
		setGrid(gbc,0,2,1,1);
		label = new JLabel("도서관 이름 검색");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,2,1,1);
		tf_research = new JTextField(10);
		gbl.setConstraints(tf_research, gbc);
		leftPanel.add(tf_research);
		setGrid(gbc,2,2,1,1);
		researchBt = new JButton("검색");
		researchBt.addActionListener(new researchButtonListener());
		gbl.setConstraints(researchBt, gbc);
		leftPanel.add(researchBt);
		setGrid(gbc,1,3,1,1);
		label = new JLabel("       ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		
		setGrid(gbc,0,9,1,1);
		updateBt = new JButton("수정");
		updateBt.addActionListener(new updateButtonListener());
		gbl.setConstraints(updateBt, gbc);
		leftPanel.add(updateBt);
		setGrid(gbc,1,9,1,1);
		deleteBt = new JButton("삭제");
		deleteBt.addActionListener(new deleteButtonListener());
		gbl.setConstraints(deleteBt, gbc);
		leftPanel.add(deleteBt);
		setGrid(gbc,2,9,1,1);
		clearBt = new JButton("공백");
		clearBt.addActionListener(new clearButtonListener());
		gbl.setConstraints(clearBt, gbc);
		leftPanel.add(clearBt);
	}
	
	private void insertform() {	
		setGrid(gbc,2,9,1,1);
		addBt = new JButton("추가");
		addBt.addActionListener(new addButtonListener());
		gbl.setConstraints(addBt, gbc);
		leftPanel.add(addBt);
		setGrid(gbc,0,9,1,1);
		clearBt = new JButton("공백");
		clearBt.addActionListener(new clearButtonListener());
		gbl.setConstraints(clearBt, gbc);
		leftPanel.add(clearBt);
	}
	
	private void tableform() {
		String columnName[] = {"이름", "설립일", "우편번호", "주소", "상세 주소"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane);
	}
	
	private void baseform_final() {
		cpane.add("West", leftPanel);
		cpane.add("Center", centerPanel);
		pack();
	}
	
	private void tableform_final() {
		sql = "SELECT * FROM library, address WHERE library.add_no = address.add_no";
		LoadList(sql);
		
		try {
			result.first();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		MoveData();
	}
	
	private void removeTableRow(int row) {
		table.setValueAt(null, row, 0);
		table.setValueAt(null, row, 1);
		table.setValueAt(null, row, 2);
		table.setValueAt(null, row, 3);
		table.setValueAt(null, row, 4);
	}
	
	private void MoveData() {
		try {
			String under = "";
			if(result.getString("address.under_yn").equals("1")) {
				under = "지하";
			}
			
			String lib_name = result.getString("library.lib_name");
			String lib_date = result.getString("library.lib_date");
			String zipcode = result.getString("address.zipcode");
			String address = result.getString("address.sido") + " " + result.getString("address.sigungu") + " " + 
					  result.getString("address.doro") + " " + under + " " +
					  result.getString("address.buildno1") + "-" + result.getString("address.buildno2") + "(" +
					  result.getString("address.eupmyun") + " " + result.getString("address.dong") + " " + 
			          result.getString("address.ri") + " " + result.getString("address.jibun1") + "-" + 
					  result.getString("address.jibun2") + ")";
			String lib_detail = result.getString("library.lib_detail");
			tf_lib_name.setText(lib_name);
			tf_lib_date.setText(lib_date);
			tf_zipcode.setText(zipcode);
			tf_address.setText(address);
			tf_lib_detail.setText(lib_detail);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void LoadList(String now_sql) {
		String under = "";
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
				if(result.getString("address.under_yn").equals("1")) {
					under = "지하";
				}
				String address = result.getString("address.sido") + " " + result.getString("address.sigungu") + " " + 
						         result.getString("address.doro") + " " + under + " " +
						         result.getString("address.buildno1") + "-" + result.getString("address.buildno2") + "(" +
						         result.getString("address.eupmyun") + " " + result.getString("address.dong") + " " + 
						         result.getString("address.ri") + " " + result.getString("address.jibun1") + "-" + 
						         result.getString("address.jibun2") + ")";
				
				table.setValueAt(result.getString("library.lib_name"), dataCount, 0);
				table.setValueAt(result.getString("library.lib_date"), dataCount, 1);
				table.setValueAt(result.getString("address.zipcode"), dataCount, 2);
				table.setValueAt(address, dataCount, 3);
				table.setValueAt(result.getString("library.lib_detail"), dataCount, 4);
			}
			repaint();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private boolean textfield_check(String date) {
		boolean bool = true;
		String[] array_str = date.split("-");
		
		if(tf_lib_name.getText().isEmpty()) {
			JOptionPane.showMessageDialog(null, "이름을 입력해주세요.",  menu_title + " 오류", JOptionPane.PLAIN_MESSAGE);
			bool = false;
		}
		else if(tf_lib_date.getText().isEmpty()) {
			LocalDate localDateNow = LocalDate.now();
			tf_lib_date.setText(localDateNow.toString());
		}
		else if(array_str.length < 3) {
			JOptionPane.showMessageDialog(null, "날짜형식이 잘못됬습니다.(형식: 년-월-일, 예시: 2023-05-30)",  menu_title + " 오류", JOptionPane.PLAIN_MESSAGE);
			bool = false;
		}
		else if(tf_zipcode.getText().isEmpty()) {
			JOptionPane.showMessageDialog(null, "주소를 입력해주세요.",  menu_title + " 오류", JOptionPane.PLAIN_MESSAGE);
			bool = false;
		}
		return bool;
	}
	
	public class researchButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String lib_name = "%" + tf_research.getText() + "%";
			String now_sql = sql + " AND library.lib_name LIKE '" + lib_name + "'";
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
			String now_sql;
			
			if(textfield_check(tf_lib_date.getText())) {
				now_sql = "INSERT INTO `library` ( `lib_name`, `lib_date`, `add_no`, `lib_detail` ) VALUES('" +
						  tf_lib_name.getText() + "','" + tf_lib_date.getText() + "'," + fk.call_add_no() + ",'" + tf_lib_detail.getText() + "')";
				System.out.println(now_sql);
				db.Excute(now_sql);
			}
		}	
	}
	
	public class updateButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String now_sql;
			int code = 0;
			
			if(selectedCol == -1) {
				System.out.println("변경할 셀이 선택되지 않았습니다.");
				return;
			}
			try {
				code = result.getInt("library.lib_no");
				
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			if(textfield_check(tf_lib_date.getText())) {
				if(push_addbt) {
					now_sql = "UPDATE `library` SET `lib_name` = '" + tf_lib_name.getText() + "', `lib_date` = '" + tf_lib_date.getText() +
							  "', `add_no` = " + fk.call_add_no() + ", `lib_detail` = '" + tf_lib_detail.getText() + "' WHERE `lib_no` = " + code;
				}
				else {
					now_sql = "UPDATE `library` SET `lib_name` = '" + tf_lib_name.getText() + "', `lib_date` = '" + tf_lib_date.getText() +
							  "', `lib_detail` = '" + tf_lib_detail.getText() + "' WHERE `lib_no` = " + code;
				}
				System.out.println(now_sql);
				db.Excute(now_sql);
			}
			LoadList(sql);
			
			try {
				result.absolute(selectedCol + 1);
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			MoveData();
		}	
	}
	
	public class deleteButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String now_sql;
			int code = 0;
			if(selectedCol == -1) {
				System.out.println("변경할 셀이 선택되지 않았습니다.");
				return;
			}
			try {
				code = result.getInt("library.lib_no");
				
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			now_sql = "DELETE FROM `library` WHERE `lib_no` = " + code;
			System.out.println(now_sql);
			db.Excute(now_sql);
			LoadList(sql);
		}	
	}
	
	public class clearButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			tf_lib_name.setText(null);
			tf_lib_date.setText(null);
			tf_zipcode.setText(null);
			tf_address.setText(null);
			tf_lib_detail.setText(null);
		}	
	}
	
	class AddressButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			push_addbt = true;
			LbDB_address_Dialog add_Dialog = new LbDB_address_Dialog(tf_zipcode, tf_address, fk);
			add_Dialog.setVisible(true);
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
					tf_lib_name.setText(table.getValueAt(selectedCol, 0).toString());
					tf_lib_date.setText(table.getValueAt(selectedCol, 1).toString());
					tf_zipcode.setText(table.getValueAt(selectedCol, 2).toString());
					tf_address.setText(table.getValueAt(selectedCol, 3).toString());
					tf_lib_detail.setText(table.getValueAt(selectedCol, 4).toString());
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
