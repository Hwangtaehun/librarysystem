package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.sql.*;

//로그인 화면
public class LbDB_Login_Frame extends LbDB_Frame{
	private LbDB_DAO logDB;
	private Client logCL;
	private JTextField tf_Id;
	private JPasswordField tf_Pw;
	private String title;
	
	LbDB_Login_Frame() {}
	LbDB_Login_Frame(LbDB_DAO db, Client cl){
		logDB = db;
		logCL = cl;
		initform();
		addWindowListener(this);
		setTitle("로그인");
	}
	
	void initform() {
		Container cpane = getContentPane();
		JPanel northPanel = new JPanel();
		JPanel centerPanel = new JPanel();
		JPanel southPanel = new JPanel();
		JButton bt_Login, bt_singup;
		JLabel label;
		GridBagLayout gbl = new GridBagLayout();
		GridBagConstraints gbc = new GridBagConstraints();
		gbc.fill = GridBagConstraints.BOTH;
		gbc.weightx = 1;
		gbc.weighty = 1;
		
		label = new JLabel("아이디와 비밀번호를 입력해주세요.");
		northPanel.add("Center", label);
		
		centerPanel.setLayout(gbl);
		setGrid(gbc, 0, 0, 1, 1);
		label = new JLabel("  아이디 ");
		gbl.setConstraints(label, gbc);
		centerPanel.add(label);
		setGrid(gbc, 1, 0, 1, 1);
		tf_Id = new JTextField(5);
		gbl.setConstraints(tf_Id, gbc);
		centerPanel.add(tf_Id);
		setGrid(gbc, 0, 1, 1, 1);
		label = new JLabel(" 비밀번호 ");
		gbl.setConstraints(label, gbc);
		centerPanel.add(label);
		setGrid(gbc, 1, 1, 1, 1);
		tf_Pw = new JPasswordField(5);
		gbl.setConstraints(tf_Pw, gbc);
		centerPanel.add(tf_Pw);
		
		title = "회원 가입";
		southPanel.setLayout(gbl);
		setGrid(gbc, 0,0,1,1);
		bt_Login = new JButton("로그인");
		bt_Login.addActionListener(new logbuttonListener());
		southPanel.add(bt_Login);
		setGrid(gbc, 1,0,1,1);
		bt_singup = new JButton(title);
		bt_singup.addActionListener(new registerbuttonListener());
		southPanel.add(bt_singup);
		
		cpane.add("North", northPanel);
		cpane.add("Center", centerPanel);
		cpane.add("South", southPanel);
		pack();
	}
	
	private void setGrid(GridBagConstraints gbc, int dx, int dy, int width, int height) {
		// TODO Auto-generated method stub
		gbc.gridx = dx;
		gbc.gridy = dy;
		gbc.gridwidth = width;
		gbc.gridheight = height;
	}

	public class logbuttonListener implements ActionListener{
		String pk = "0";
		String state;
		ResultSet rs;
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			if(tf_Id.getText().isEmpty() || tf_Pw.getText().isEmpty()) {
				JOptionPane.showMessageDialog(null, "아이디와 비밀번호를 입력해주세요.", "로그인 오류", JOptionPane.WARNING_MESSAGE);
			}
			else {
				String sql = "SELECT * FROM `member` WHERE `mem_id` = '" + tf_Id.getText() + "' AND `mem_pw` = '" + tf_Pw.getText() + "'";
				rs = logDB.getResultSet(sql);
				try {
					while(rs.next()) {
						pk = rs.getString("mem_no");
						state = rs.getString("mem_state");
						System.out.println("mem_no = " + pk + " mem_state = " + state);
					}
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
				if(pk.equals("0")) {
					JOptionPane.showMessageDialog(null, "아이디와 비밀번호가 일치하지 않습니다.",  "로그인 오류", JOptionPane.WARNING_MESSAGE);
				}
				else {
					logCL.insertnum(Integer.parseInt(pk), Integer.parseInt(state));
					LbDB_main_Frame frame = new LbDB_main_Frame(logDB, logCL);
					frame.setVisible(true);
					setVisible(false);
					dispose();
				}
			}
		}	
	}
	
	public class registerbuttonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			LbDB_member_Frame info = new LbDB_member_Frame(logDB, title);
			info.setVisible(true);
		}
	}
}