<?php
class Combobox_Manager {
	private $db;
	private $fk = 1;
	private $table; 
    private $key; 
    private $key_name
    private $sql
    private $parent_num;
	private $arraystring[];
	private $rs;
	private $ci;
	private $ci_exist = false;
	private $pa_exist = false;
	private $dialog = false;
	public $combox;
	
	public function __construct(JComboBox <String> cb, String table, String key) {
		$this->combox = cb;
		$this->db = new LbDB_DAO();
		$this->table = table;
		$this->key = key;
		
		makearray();
		combox = new JComboBox<String>(new DefaultComboBoxModel<String>(arraystring));
		combox.addItemListener(new ComboboxListener());
	}

	public function __construct(JComboBox <String> cb, String table, String key, boolean bool) {
		combox = cb;
		fk = 0;
		db = new LbDB_DAO();
		this.table = table;
		this.key = key;
		String str = "없음";
		
		makearray(str, bool);
		combox = new JComboBox<String>(new DefaultComboBoxModel<String>(arraystring));
		combox.addItemListener(new ComboboxListener());
	}

	public function __construct(JComboBox <String> cb, String table, String key, String where, boolean bool) {
		combox = cb;
		db = new LbDB_DAO();
		this.table = table;
		this.key = key;
		
		makearray(where, bool);
		combox = new JComboBox<String>(new DefaultComboBoxModel<String>(arraystring));
		combox.addItemListener(new ComboboxListener());
	}

	public function __construct(Combobox_Inheritance ci, JComboBox <String> cb, String table, String key, String where) {
		combox = cb;
		db = new LbDB_DAO();
		this.table = table;
		this.key = key;
		this.ci = ci;
		ci_exist = true;
		
		makearray(where, false);
		combox = new JComboBox<String>(new DefaultComboBoxModel<String>(arraystring));
		combox.addItemListener(new ComboboxListener());
	}
	
	private String changenamekey() {
		String str = "";
		char[] temp;
		int cnt = 0;
		
		temp = key.toCharArray();
		for(int i = 0; i < temp.length; i++) {
			if(temp[i] == '_') {
				cnt = i;
			}
		}
		
		for(int i = 0; i < cnt + 1; i++) {
			str += String.valueOf(temp[i]);
		}
		str += "name";
		
		return str;
	}
	
	private void makearray() {
		String sentence = "";
		
		key_name = changenamekey();
		sql = "SELECT `" + key_name + "` FROM `" + table + "`";
		rs = db.getResultSet(sql);
		try {
			while(rs.next()) {
				sentence += rs.getString(key_name);
				sentence += "-";
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		arraystring = sentence.split("-");
	}
	
	private void makearray(String str, boolean bool) {
		String sentence = "";
		
		if(str.isEmpty()) {
			return;
		}
		else if(str.equals("없음")) {
			str = "";
		}
		
		if(bool) {
			sentence = "없음-";
		}
		key_name = changenamekey();
		sql = "SELECT `" + key_name + "` FROM `" + table + "` " + str;
		rs = db.getResultSet(sql);
		try {
			while(rs.next()) {
				sentence += rs.getString(key_name);
				sentence += "-";
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		arraystring = sentence.split("-");
	}
	
	public int foreignkey() {
		return fk;
	}
	
	public void exist_parent(String str) {
		pa_exist = true;
		parent_num = str;
	}
	
	public void isDialog() {
		dialog = true;
	}
	
	public void repaintCombobox(String num) {
		String now_sql = "", pn;
		
		pn = ci.call_parent_name();
		if(pn.equals("대분류")) {
		    now_sql = "WHERE `kind_num` LIKE '" + String.valueOf(num.charAt(0)) + "_0'";
		    //System.out.println(now_sql);
		}
		else if(pn.equals("중분류")) {
			now_sql = "WHERE `kind_num` LIKE '" + String.valueOf(num.charAt(0)) + String.valueOf(num.charAt(1)); 
			if(dialog) {
				now_sql += "_%'";
			}
			else {
				now_sql += "_'";
			}
			//System.out.println(now_sql);
		}
		ci.child_combox.removeAllItems();
		makearray(now_sql, ci.call_nothing());
		for(int i = 0; i < arraystring.length ; i++) {
			ci.child_combox.addItem(arraystring[i]);
		}
	}
	
	public class ComboboxListener implements ItemListener{
		@Override
		public void itemStateChanged(ItemEvent e) {
			// TODO Auto-generated method stub
			String choice_str, terms = "", num = "";
			boolean fk_zero = false;
			
			if(fk == 0) {
				fk_zero = true;
			}
			
			if(e.getStateChange() == ItemEvent.SELECTED) {
				choice_str = e.getItem().toString();
				
				if(fk_zero) {
					fk = 0;
				}
				
				if(pa_exist) {
					if(ci_exist) {
						terms = String.valueOf(parent_num.charAt(0)) + "_0";
					}
					else {
						terms = String.valueOf(parent_num.charAt(0)) + String.valueOf(parent_num.charAt(1)) + "_";
					}
					sql = "SELECT * FROM `" + table + "` WHERE " + key_name + " LIKE '" + choice_str + "'" +
						  " AND kind_num LIKE '" + terms + "'";
				}
				else {
					sql = "SELECT * FROM `" + table + "` WHERE " + key_name + " LIKE '" + choice_str + "'";
				}
				System.out.println(sql);
				rs = db.getResultSet(sql);
				
				try {
					while(rs.next()) {
						fk = rs.getInt(key);
						if(key.equals("kind_no")) {
							num = rs.getString("kind_num");
							System.out.println(num);
						}
					}
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
				
				if(ci_exist) {
					ci.child_manager.exist_parent(num);
					repaintCombobox(num);
				}
			}
		}
	}
}
