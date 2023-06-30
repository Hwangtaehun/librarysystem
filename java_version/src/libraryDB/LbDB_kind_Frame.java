package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.sql.*;

//kind테이블과 관련있는 event처리 클래스
public class LbDB_kind_Frame extends LbDB_main_Frame {
	private JComboBox <String> one_Box, two_Box, three_Box;
	private Combobox_Inheritance one_to_two, two_to_three;
	private Combobox_Manager one_manager, two_manager, three_manager;
	private JTextField tf_name, tf_kind_num;
	private String last_sql;
	
	public LbDB_kind_Frame() {}
	public LbDB_kind_Frame(String str, JTextField tf, foreignkey fk) {
		db = new LbDB_DAO();
		menu_title = str;
		tf_kind_num = tf;
		this.fk = fk;
		dialog(str);
		Initform();
		baseform();
		dialogform();
	}
	public LbDB_kind_Frame(LbDB_DAO db, Client cl, String str) {
		this.db = db;
		this.cl = cl;
		menu_title = str;
		pk = cl.primarykey();
		state = cl.state();
		
		if(state == 1) {
			manager_Initform();
		}
		else {
			member_Initform();
		}
		setTitle(str);
		Initform();
		if(str.equals("종류추가")) {
			baseform();
			addform();
		}
		else {
			editform();
		}
		addWindowListener(this);
	}
	
	private void baseform() {
		JLabel label;
		
		setGrid(gbc,1,1,1,1);
		label = new JLabel("    " + menu_title + "   ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,0,4,1,1);
		label = new JLabel("    소분류    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,4,1,1);
		String where = "WHERE `kind_num` LIKE '00_'";
		if(menu_title.equals("종류추가")) {
			three_manager = new Combobox_Manager(three_Box, "kind", "kind_no", where, true);
		}
		else {
			three_manager = new Combobox_Manager(three_Box, "kind", "kind_no", where, false);
		}
		three_Box = three_manager.combox;
		gbl.setConstraints(three_Box, gbc);
		leftPanel.add(three_Box);
		setGrid(gbc,0,3,1,1);
		label = new JLabel("    중분류    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,3,1,1);
		where = "WHERE `kind_num` LIKE '0_0'";
		two_to_three = new Combobox_Inheritance (three_manager, three_Box, "중분류");
		two_manager = new Combobox_Manager(two_to_three, two_Box, "kind", "kind_no", where); 
		two_Box = two_manager.combox;
		gbl.setConstraints(two_Box, gbc);
		leftPanel.add(two_Box);
		setGrid(gbc,0,2,1,1);
		label = new JLabel("    대분류    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,2,1,1);
		where = "WHERE `kind_num` LIKE '_00'";
		one_to_two = new Combobox_Inheritance (two_manager, two_Box, "대분류");
		one_manager = new Combobox_Manager(one_to_two, one_Box, "kind", "kind_no", where); 
		one_Box = one_manager.combox;
		gbl.setConstraints(one_Box, gbc);
		leftPanel.add(one_Box);
	}
	
	private void dialogform() {
		JButton bt;
		
		two_to_three.insert_nothing(false);
		three_manager.isDialog();
		setGrid(gbc,1,5,1,1);
		bt = new JButton("입력");
		gbl.setConstraints(bt, gbc);
		bt.addActionListener(new inputButtonListener());
		leftPanel.add(bt);
		
		cpane.add("Center", leftPanel);
		pack();
	}
	
	private void addform() {
		JLabel label;
		
		two_to_three.insert_nothing(true);
		setGrid(gbc,0,5,1,1);
		label = new JLabel("    이름  ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,5,1,1);
		tf_name = new JTextField(20);
		gbl.setConstraints(tf_name, gbc);
		leftPanel.add(tf_name);
		setGrid(gbc,1,6,1,1);
		addBt = new JButton("추가");
		gbl.setConstraints(addBt, gbc);
		addBt.addActionListener(new addButtonListener());
		leftPanel.add(addBt);
		
		cpane.add("Center", leftPanel);
		pack();
	}
	
	private void editform() {
		JLabel label;
		
		setGrid(gbc,1,1,1,1);
		label = new JLabel("    " + menu_title + "   ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,0,2,1,1);
		label = new JLabel("    검색  ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,2,1,1);
		tf_research = new JTextField(20);
		gbl.setConstraints(tf_research, gbc);
		leftPanel.add(tf_research);
		setGrid(gbc,2,2,1,1);
		researchBt = new JButton("검색");
		researchBt.addActionListener(new researchButtonListener());
		gbl.setConstraints(researchBt, gbc);
		leftPanel.add(researchBt);
		setGrid(gbc,1,3,1,1);
		label = new JLabel("    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,0,6,1,1);
		label = new JLabel("    소분류    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,6,1,1);
		String where = "WHERE `kind_num` LIKE '00_'";
		three_manager = new Combobox_Manager(three_Box, "kind", "kind_no", where, true);
		three_Box = three_manager.combox;
		gbl.setConstraints(three_Box, gbc);
		leftPanel.add(three_Box);
		setGrid(gbc,0,5,1,1);
		label = new JLabel("    중분류    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,5,1,1);
		where = "WHERE `kind_num` LIKE '0_0'";
		two_to_three = new Combobox_Inheritance (three_manager, three_Box, "중분류");
		two_to_three.insert_nothing(true);
		two_manager = new Combobox_Manager(two_to_three, two_Box, "kind", "kind_no", where); 
		two_Box = two_manager.combox;
		gbl.setConstraints(two_Box, gbc);
		leftPanel.add(two_Box);
		setGrid(gbc,0,4,1,1);
		label = new JLabel("    대분류    ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,4,1,1);
		where = "WHERE `kind_num` LIKE '_00'";
		one_to_two = new Combobox_Inheritance (two_manager, two_Box, "대분류");
		one_manager = new Combobox_Manager(one_to_two, one_Box, "kind", "kind_no", where); 
		one_Box = one_manager.combox;
		gbl.setConstraints(one_Box, gbc);
		leftPanel.add(one_Box);
		setGrid(gbc,0,7,1,1);
		label = new JLabel("    이름  ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,7,1,1);
		tf_name = new JTextField(20);
		gbl.setConstraints(tf_name, gbc);
		leftPanel.add(tf_name);
		setGrid(gbc,0,8,1,1);
		updateBt = new JButton("수정");
		updateBt.addActionListener(new updateButtonListener());
		gbl.setConstraints(updateBt, gbc);
		leftPanel.add(updateBt);
		setGrid(gbc,1,8,1,1);
		deleteBt = new JButton("삭제");
		deleteBt.addActionListener(new deleteButtonListener());
		gbl.setConstraints(deleteBt, gbc);
		leftPanel.add(deleteBt);
		
		String columnName[] = {"번호", "이름"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(300, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		centerPanel.add(scrollPane);
		
		cpane.add("West", leftPanel);
		cpane.add("Center", centerPanel);
		pack();
		
		sql = "SELECT * FROM `kind` ";
		last_sql = sql + "ORDER BY `kind_num`";
		LoadList(last_sql);
		
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
	}
	
	private String numToname(String str) {
		LbDB_DAO Database = new LbDB_DAO();
		ResultSet rs;
		String now_sql, text = "";
		
		now_sql = "SELECT * FROM `kind` WHERE `kind_num` LIKE '" + str + "'";
		rs = Database.getResultSet(now_sql);
		
		try {
			while(rs.next()) {
				text = rs.getString("kind_name");
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		return text;
	}
	
	private void MoveData() {
		try {
			String kind_num = result.getString("kind_num");
			String oneclass = numToname(String.valueOf(kind_num.charAt(0)) + "00");
			one_manager.repaintCombobox(kind_num);
			String twoclass = numToname(String.valueOf(kind_num.charAt(0)) + String.valueOf(kind_num.charAt(1)) + "0");
			two_manager.repaintCombobox(kind_num);
			String threeclass = numToname(String.valueOf(kind_num.charAt(0)) + String.valueOf(kind_num.charAt(1)) + String.valueOf(kind_num.charAt(2)));
			one_Box.setSelectedItem(oneclass);
			two_Box.setSelectedItem(twoclass);
			three_Box.setSelectedItem(threeclass);
			tf_name.setText(result.getString("kind_name"));
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void LoadList(String now_sql) {
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
				table.setValueAt(result.getString("kind_num"), dataCount, 0);
				table.setValueAt(result.getString("kind_name"), dataCount, 1);
			}
			repaint();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private String strTonumTostr(String str, boolean bool) {
		String text = "문제발생";
		
		if(bool) {
			String final_position = String.valueOf(str.charAt(2));
			int num = Integer.parseInt(final_position);
			if(num > 8) {
				return text;
			}
			num++;
			text = String.valueOf(str.charAt(0)) + String.valueOf(str.charAt(1)) + num;
		}
		else {
			String now_sql = "SELECT * FROM `kind` WHERE `kind_num` LIKE '" + str + "%'";
			result = db.getResultSet(now_sql);
			
			try {
				while(result.next()) {
					text = result.getString("kind_num");
				}
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			if(isInteger(text)) {
				text += ".1";
			}
			else {
				if(isFloat(text)) {
					String[] str_array = text.split(".");
					int num = Integer.parseInt(str_array[1]);
					num++;
					text = str_array[0] + "." + num; 
				}
				else {
					text = "문제발생";
				}
			}
		}
		return text;
	}
	
	public class inputButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			sql = "SELECT * FROM `kind` WHERE `kind_no` LIKE " + three_manager.foreignkey();
			result = db.getResultSet(sql);
			try {
				while(result.next()) {
					tf_kind_num.setText(result.getString("kind_num"));
					fk.insert_kind_no(result.getInt("kind_no"));
				}
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			closeFrame();
		}
	}
	
	public class researchButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String kind_name = "%" + tf_research.getText() + "%";
			String now_sql = sql + "WHERE kind_name LIKE '" + kind_name + "' ORDER BY `kind_num`";
			System.out.println(now_sql);
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
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			String next, previous = null, temp = "", now_sql;
			boolean bool = false;
			
			if(three_Box.getSelectedItem().equals("없음")) {
				now_sql = "SELECT * FROM `kind` WHERE `kind_no` LIKE " + two_manager.foreignkey();
				bool = true;
			}
			else {
				now_sql = "SELECT * FROM `kind` WHERE `kind_no` LIKE " + three_manager.foreignkey();
			}
			System.out.println(now_sql);
			result = db.getResultSet(now_sql);
			try {
				while(result.next()) {
					previous = result.getString("kind_num");
				}
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			next = strTonumTostr(previous, bool);
			
			if(next.equals("문제발생")) {
				JOptionPane.showMessageDialog(null, "삽입이 불가능합니다.", "삽입 오류", JOptionPane.WARNING_MESSAGE);
			}
			else {
				now_sql = "INSERT INTO `kind` ( `kind_num`, `kind_name` ) VALUES('" + next + "', '" + tf_name.getText() +"')";
				db.Excute(now_sql);
			}
		}
	}
	
	public class updateButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String result_name = null, next = null, previous = null, result_num = "", now_sql, three_num, three_name = null;
			boolean bool = false;
			int code = 0;
			
			if(selectedCol == -1) {
				System.out.println("변경할 셀이 선택되지 않았습니다.");
				return;
			}
			try {
				code = result.getInt("kind_no");
				result_num = result.getString("kind_num");
				result_name = result.getString("kind_name");
				
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			three_num = String.valueOf(result_num.charAt(0)) + String.valueOf(result_num.charAt(1)) + String.valueOf(result_num.charAt(2));
			System.out.println("three_num: " + three_num);
			now_sql = "SELECT * FROM `kind` WHERE `kind_num` LIKE '" + three_num + "'";
			result = db.getResultSet(now_sql);
			try {
				while(result.next()) {
					three_name = result.getString("kind_name");
				}
			} catch (SQLException e2) {
				// TODO Auto-generated catch block
				e2.printStackTrace();
			}
			System.out.println("three_name: " + three_name);
			
			if(three_name.equals(three_Box.getSelectedItem())) {
				now_sql = "UPDATE `kind` SET `kind_name` = '" + tf_name.getText() + "' WHERE `kind_no` = " + code;
			}
			else {
				if(three_Box.getSelectedItem().equals("없음")) {
					now_sql = "SELECT * FROM `kind` WHERE `kind_no` LIKE " + two_manager.foreignkey();
					bool = true;
				}
				else {
					now_sql = "SELECT * FROM `kind` WHERE `kind_no` LIKE " + three_manager.foreignkey();
				}
				System.out.println("수정부분에서 검색: " + now_sql);
				
				result = db.getResultSet(now_sql);
				try {
					while(result.next()) {
						previous = result.getString("kind_num");
					}
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
				next = strTonumTostr(previous, bool);
				now_sql = "UPDATE `kind` SET `kind_num` = '" + next + "', `kind_name` = '" + tf_name.getText() + 
						  "' WHERE `kind_no` = " + code;
			}
			System.out.println("수정부분: " + now_sql);
			
			if(next.equals("문제발생")) {
				JOptionPane.showMessageDialog(null, "삽입이 불가능합니다.", "삽입 오류", JOptionPane.WARNING_MESSAGE);
			}
			else {
				db.Excute(now_sql);
			}
			
			
			LoadList(last_sql);
			
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
				code = result.getInt("kind_no");
				
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			now_sql = "DELETE FROM `kind` WHERE `kind_no` = " + code;
			System.out.println(now_sql);
			db.Excute(now_sql);
			LoadList(last_sql);
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
					String kind_num = table.getValueAt(selectedCol, 0).toString();
					String oneclass = numToname(String.valueOf(kind_num.charAt(0)) + "00");
					one_manager.repaintCombobox(kind_num);
					String twoclass = numToname(String.valueOf(kind_num.charAt(0)) + String.valueOf(kind_num.charAt(1)) + "0");
					two_manager.repaintCombobox(kind_num);
					String threeclass = numToname(String.valueOf(kind_num.charAt(0)) + String.valueOf(kind_num.charAt(1)) + String.valueOf(kind_num.charAt(2)));
					one_Box.setSelectedItem(oneclass);
					two_Box.setSelectedItem(twoclass);
					three_Box.setSelectedItem(threeclass);
					tf_name.setText(table.getValueAt(selectedCol, 1).toString());
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