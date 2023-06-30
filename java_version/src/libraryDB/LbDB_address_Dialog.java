package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.sql.*;

//주소를 검색을 쉽게하기 위해서 생성된 클래스
class Addresstool{
	private String sidobasic[] = {"서울특별시", "부산광역시", "대전광역시", "대구광역시", "인천광역시", "광주광역시", "울산광역시",
							 "충청북도", "충청남도", "전라북도", "전라남도", "경상북도", "경상남도", "제주특별자치도",
							 "세종특별자치시", "강원도", "경기도", "서울시", "부산시", "대전시", "대구시", "인천시", "광주시", "울산시",
							 "충북", "충남", "전북", "전남", "경북", "경남", "제주도", "세종시"};
	private String sigungusp[] = {"고양시", "성남시", "수원시", "안산시", "안양시", "용인시", "창원시", "포항시", "전주시", "천안시", "청주시",
								  "고양",   "성남",  "수원",  "안산",   "안양",  "용인",  "창원",   "포항",  "전주",   "천안",  "청주"};
	private String main[];
	private LbDB_DAO db;
	private int i;
	private ResultSet rs;
	public String sido, sigungu, eupmyun, doro, buildno1, buildno2, dong, ri, jibun1, jibun2;
	
	public Addresstool() {}
	public Addresstool(String str, LbDB_DAO db) {
		this.db = db;
		String word = str.trim();
		main = word.split(" ");
		print();
		sido = "%";
		sigungu = "%";
		eupmyun = "%";
		doro = "%";
		dong = "%";
		ri = "%";
		buildno1 = "%";
		buildno2 = "%";
		jibun1 = "%";
		jibun2 = "%";
		sort();
	}
	
	public void print() {
		for(int i = 0; i < main.length; i++) {
			System.out.print(main[i]+ " ");
		}
		System.out.print("\n");
	}
	
	public void print2() {
		System.out.print(sido + sigungu + eupmyun + dong + ri + doro);
	}
	
	private void sort() {
		i = 0;
		sido_method(main[i]);
		if(main.length == 2) {
			dong_method(main[i]);
			if(dong.equals("%")) {
				sigungu_method(main[i]);
				if(sigungu.charAt(sigungu.length()-1) == '시' || sigungu.charAt(sigungu.length()-1) == '구') {
					dong_method(main[i]);
				}
				else {
					eupmyun_method(main[i]);
					ri_method(main[i]);
				}
			}
		}
		else {
			sigungu_method(main[i]);
			if(sigungu.charAt(sigungu.length()-1) == '시' || sigungu.charAt(sigungu.length()-1) == '구') {
				dong_method(main[i]);
			}
			else {
				eupmyun_method(main[i]);
				ri_method(main[i]);
			}
		}
		
		if(dong.equals("%") && ri.equals("%")) {
			doro_method(main[i]);
		}
		
		number(main[i]);
	}
	
	private void sido_method(String str) {
		for(int j = 0; j < sidobasic.length; j++) {
			if(main[0].equals(sidobasic[i])) {
				if(j > 16) {
					int num = j % 17;
					sido = sidobasic[num];
				}
				else {
					sido = main[0];
				}
			}
		}
		if(!sido.equals("%")) {
			i++;
		}
	}
	
	private void sigungu_method(String str) {
		String word = str;
		for(int j = 0; j < sigungusp.length; j++) {
			if(str.equals(sigungusp[j])) {
				if(j > 10) {
					int num = j % 11;
					word = sigungusp[num];
				}
				i++;
				word += " " + main[i];
			}
		}
		
		String sql = "SELECT DISTINCT `sigungu` FROM `address` WHERE `sigungu` LIKE '%" + word + "%'";
		rs = db.getResultSet(sql);
		
		try {
			while(rs.next()) {
				sigungu = rs.getString("sigungu");
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		if(!sigungu.equals("%")) {
			i++;
		}
	}
	
	private void eupmyun_method(String str) {
		String sql = "SELECT DISTINCT `eupmyun` FROM `address` WHERE `eupmyun` LIKE '" + str + "%'";
		rs = db.getResultSet(sql);
		
		try {
			while(rs.next()) {
				eupmyun = rs.getString("eupmyun");
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		if(!eupmyun.equals("%")) {
			i++;
		}
	}
	
	private void dong_method(String str) {
		String sql = "SELECT DISTINCT `dong` FROM `address` WHERE `dong` LIKE '" + str + "%' ORDER BY `dong` DESC";
		rs = db.getResultSet(sql);
		try {
			while(rs.next()) {
				dong = rs.getString("dong");
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		if(!dong.equals("%")) {
			i++;
		}
	}
	
	private void ri_method(String str) {
		String sql = "SELECT DISTINCT `ri` FROM `address` WHERE `ri` LIKE '" + str + "%'";
		rs = db.getResultSet(sql);
		
		try {
			while(rs.next()) {
				ri = rs.getString("ri");
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		if(!ri.equals("%")) {
			i++;
		}
	}
	
	private void doro_method(String str) {
		String sql = "SELECT DISTINCT `doro` FROM `address` WHERE `doro` LIKE '" + str + "'";
		rs = db.getResultSet(sql);
		
		try {
			while(rs.next()) {
				doro = rs.getString("doro");
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		if(!doro.equals("%")) {
			i++;
		}
	}
	
	private void number(String str) {
		String word[];
		word = str.split("-");
		if(doro.equals("%")) {
			if(word.length == 2) {
				jibun1 = word[0];
				jibun2 = word[1];
			}
			else {
				jibun1 = word[0];
			}
		}
		else {
			if(word.length == 2) {
				buildno1 = word[0];
				buildno2 = word[1];
			}
			else {
				buildno1 = word[0];
			}
		}
	}
}

//주소 검색 대화상자
public class LbDB_address_Dialog extends LbDB_main_Frame{
	private int dataCount, selectedCol;
	private String address; 
	private LbDB_DAO db;
	private JTextField tf_zipcode, tf_address, tf_research;	
	private JTable table;
	private LbDB_TableMode tablemodel;
	private Addresstool add;
	private ResultSet result;
	private foreignkey fk;
	
	public LbDB_address_Dialog() {}
	public LbDB_address_Dialog(JTextField tf_zipcode, JTextField tf_address, foreignkey fk) {
		db = new LbDB_DAO();
		this.tf_zipcode = tf_zipcode;
		this.tf_address = tf_address;
		this.fk = fk;
		dialog("우편번호 검색");
		initform();
		addWindowListener(this);
	}
	
	void initform() {
		Container cpane = getContentPane();
		JPanel northPanel = new JPanel();
		JPanel centerPanel = new JPanel();
		JPanel southPanel = new JPanel();
		JButton bt_research;
		JLabel label;
		selectedCol = -1;
		GridBagLayout gbl = new GridBagLayout();
		GridBagConstraints gbc = new GridBagConstraints();
		gbc.fill = GridBagConstraints.BOTH;
		gbc.weightx = 1;
		gbc.weighty = 1;
		
		label = new JLabel("우편번호 검색");
		northPanel.add("Center", label);
		
		centerPanel.setLayout(gbl);
		setGrid(gbc, 0, 0, 1, 1);
		tf_research = new JTextField(30);
		gbl.setConstraints(tf_research, gbc);
		centerPanel.add(tf_research);
		centerPanel.setLayout(gbl);
		setGrid(gbc, 3, 0, 1, 1);
		bt_research = new JButton("검색");
		bt_research.addActionListener(new researchButtonListener());
		gbl.setConstraints(bt_research, gbc);
		centerPanel.add(bt_research);
		
		String columnName[] = {"우편번호", "주소"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(470, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		table.getColumn("우편번호").setPreferredWidth(5);
		table.getColumn("주소").setPreferredWidth(300);
		JScrollPane scrollPane = new JScrollPane(table);
		southPanel.add(scrollPane);
		
		cpane.add("North", northPanel);
		cpane.add("Center", centerPanel);
		cpane.add("South", southPanel);
		pack();
	}
	
	private void inputTable(int cnt, String zipcode, String address) {
		table.setValueAt(zipcode, cnt, 0);
		table.setValueAt(address, cnt, 1);
	}
	
	private void removeTableRow(int row) {
		table.setValueAt(null, row, 0);
		table.setValueAt(null, row, 1);
	}
	
	private void MoveData() {
		try {
			tf_zipcode.setText(result.getString("zipcode"));
			tf_address.setText(address);
			fk.insert_add_no(result.getInt("add_no"));
			this.setVisible(false);
			this.dispose();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	class tableListener implements ListSelectionListener{
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
					tf_zipcode.setText(table.getValueAt(selectedCol, 0).toString());
					tf_address.setText(table.getValueAt(selectedCol, 1).toString());
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
	
	class researchButtonListener implements ActionListener{
		String[] temp;
		String sql, under = "";
		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			temp = tf_research.getText().trim().split(" ");
			if(temp.length < 2) {
				JOptionPane.showMessageDialog(null, "검색어를 2글자이상으로 입력해 주십시오",  "주소 검색 오류", JOptionPane.PLAIN_MESSAGE);
			}
			else {
				add = new Addresstool(tf_research.getText(), db);
				add.print();
				sql = "SELECT * FROM `address` WHERE " + "`sido` LIKE '" + add.sido + "' AND `sigungu` LIKE '" + add.sigungu + 
						  "' AND `eupmyun` LIKE '" + add.eupmyun + "' AND `dong` LIKE '" + add.dong + "' AND `ri` LIKE '" +
						  add.ri + "' AND `doro` LIKE '" + add.doro + "' AND `buildno1` LIKE '" + add.buildno1 + "' AND `buildno2` LIKE '" +
						  add.buildno2 + "' AND `jibun1` LIKE '" + add.jibun1 + "' AND `jibun2` LIKE '" + add.jibun2 + "'";
				System.out.println("sql문: " + sql);
				result = db.getResultSet(sql);
				
				if(resultempty_check(result)) {
					return;
				}
				
				for(int i = 0; i < dataCount; i++) {
					removeTableRow(i);
				}
				try {
					for(dataCount = 0; result.next(); dataCount++) {
						if(result.getString("under_yn").equals("1")) {
							under = "지하";
						}
						address = result.getString("sido") + " " + result.getString("sigungu") + " " + 
								  result.getString("doro") + " " + under + " " +
								  result.getString("buildno1") + "-" + result.getString("buildno2") + "(" +
								  result.getString("eupmyun") + " " + result.getString("dong") + " " + 
						          result.getString("ri") + " " + result.getString("jibun1") + "-" + result.getString("jibun2") + ")";
						inputTable(dataCount, result.getString("zipcode"), address);
					}
					repaint();
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
			}
		}
	}
}
