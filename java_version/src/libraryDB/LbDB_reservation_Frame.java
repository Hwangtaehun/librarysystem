package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.sql.*;
import java.time.*;
import java.time.format.*;

//reservation 테이블과 관련있는 event처리 클래스
public class LbDB_reservation_Frame extends LbDB_main_Frame {
	private JTextField tf_mem_id, tf_mat_name, tf_research;
	
	LbDB_reservation_Frame(){}
	LbDB_reservation_Frame(LbDB_DAO db, Client cl, String title){
		this.db = db;
		this.cl = cl;
		menu_title = title;
		pk = cl.primarykey();
		state = cl.state();
		fk = new foreignkey();
		menuform();
		Initform();
		
		addWindowListener(this);
	}
	
	LbDB_reservation_Frame(Client cl, String str, SwingItem si, foreignkey fk){
		db = new LbDB_DAO();
		this.cl = cl;
		menu_title = str;
		pk = cl.primarykey();
		state = cl.state();
		fk = new foreignkey();
		dialog(menu_title);
		Initform();
	}
	
	
	private void baseform() {
		JPanel northPanel, titlePanel, researchPanel;
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
	
	private void listform() {
		
	}
	
	private void managerform() {
		
	}
	
	public void research() {
		String now_sql = "SELECT * FROM `reservation` WHERE `mem_no` = " + fk.call_mem_no();
	}
	
	class memberButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			
		}		
	}
	
	class deleteButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			
		}		
	}
}
