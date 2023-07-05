package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.sql.*;

public class LbDB_etc_Frame extends LbDB_main_Frame {
	private JTextField tf_mem_id, tf_book_name, tf_len_date, tf_len_re_date, tf_due_exp;
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
		
		setGrid(gbc,0,5,1,1);
		label = new JLabel("해제일");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,5,1,1);
		tf_due_exp = new JTextField(10);
		gbl.setConstraints(tf_due_exp, gbc);
		leftPanel.add(tf_due_exp);
		setGrid(gbc,1,6,1,1);
		label = new JLabel("  ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,7,1,1);
		bt = new JButton("해제");
		bt.addActionListener(new deleteButtonListener());
		gbl.setConstraints(bt, gbc);
		leftPanel.add(bt);
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
}
