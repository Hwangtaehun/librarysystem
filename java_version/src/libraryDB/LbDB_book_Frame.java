package libraryDB;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;
import java.sql.*;
import java.util.regex.*;

class book_symbol{
	private String[] cho = {"ㄱ", "ㄲ", "ㄴ", "ㄷ", "ㄸ", "ㄹ", "ㅁ", "ㅂ", "ㅃ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅉ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ"};
	private String[] joong = {"ㅏ", "ㅐ", "ㅑ", "ㅒ", "ㅓ", "ㅔ", "ㅕ", "ㅖ", "ㅗ", "ㅘ", "ㅙ", "ㅚ", "ㅛ", "ㅜ", "ㅝ", "ㅞ", "ㅟ", "ㅠ", "ㅡ", "ㅢ", "ㅣ"};
	private String[] jong = {"", "ㄱ", "ㄲ", "ㄳ", "ㄴ", "ㄵ", "ㄶ", "ㄷ", "ㄹ", "ㄺ", "ㄻ", "ㄼ", "ㄽ", "ㄾ", "ㄿ", "ㅀ", "ㅁ", "ㅂ", "ㅄ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ"};
	
	private String author_array[], author_symbol;
	private char author_char_array[];
	private boolean lastauthor_exist;
	
	public book_symbol(String author, boolean bool) {
		lastauthor_exist = bool;
		author_array = author.split(" ");
		
		for(int i = 0; i < author_array.length; i++) {
			System.out.println(author_array[i]);
		}
		
		inital();
	}
	
	private void inital() {
		int num = 0;
		
		while(english_check(author_array[num])) {
			if(author_array.length - 1 == num) {
				break;
			}
			num++;
		}
		
		if(num > 0) {
			if(korean_check(author_array[num])) {
				author_char_array = stringTochar(author_array[num]);
			}
			else {
				if(lastauthor_exist) {
					author_array = sequence_change(author_array);
				}
				author_array = englishTokorean(author_array[0]);
				author_char_array = first_word(author_array);
			}
		}
		else if(author_array.length > 1) {
			if(lastauthor_exist) {
				author_array = sequence_change(author_array);
			}
			author_char_array = stringTochar(author_array[0]);
		}
		else {
			if(korean_check(author_array[0])) {
				author_char_array = stringTochar(author_array[0]);
			}
		}
		
		if(author_char_array != null) {
			finish_symbol();
		}
	}
	
	private boolean korean_check(String str) {
		return Pattern.matches("^[ㄱ-ㅎ가-힣]*$", str);
	}
	
	private boolean english_check(String str) {
		String character[];
		
		character = str.split(".");
		
		if(character.length > 0) {
			return Pattern.matches("^[a-zA-Z]*$", character[0]);
		}
		else {
			return Pattern.matches("^[a-zA-Z]*$", str);
		}
	}
	
	private String[] sequence_change(String[] str) {
		String temp;
		
		temp = str[str.length-1];
		str[str.length-1] = str[0];
		str[0] = temp;
		
		return str;
	}
	
	private String[] englishTokorean(String str) {
		String result = "";
		String[] result_array;
		
		for(int i = 0; i < str.length(); i++) {
			System.out.println("str[" + i + "]: " + str.charAt(i));
		}
		
		for(int i = 0; i < str.length(); i++) {
			switch(str.charAt(i)) {
			case 'a':
			case 'A':
				if(i == str.length() - 1) {
					result += "ㅏ";
				}
				else {
					i++;
					if(str.charAt(i) == 'e') {
						result += "ㅐ";
					}
					else {
						i--;
						result += "ㅏ";
					}
				}
				break;
			case 'b':
			case 'B':
				result += "ㅂ";
				break;
			case 'c':
			case 'C':
				if(i == str.length() - 1) {
					result += "ㅋ";
				}
				else {
					i++;
					if(str.charAt(i) == 'h') {
						result += "ㅊ";
					}
					else {
						i--;
						result += "ㅋ";
					}
				}
				break;
			case 'd':
			case 'D':
				result += "ㄷ";
				break;
			case 'e':
			case 'E':
				if(i == str.length() - 1) {
					result += "ㅔ";
				}
				else {
					i++;
					if(str.charAt(i) == 'o') {
						result += "ㅓ";
					}
					else if(str.charAt(i) == 'u') {
						result += "ㅡ";
					}
					else if(str.charAt(i) == 'e') {
						result += "ㅣ";
					}
					else {
						i--;
						result += "ㅔ";
					}
				}
				break;
			case 'f':
			case 'F':
				result += "ㅍ";
				break;
			case 'G':
			case 'g':
				result += "ㄱ";
				break;
			case 'H':
			case 'h':
				result += "ㅎ";
				break;
			case 'I':
			case 'i':
				result += "ㅣ";
				break;
			case 'J':
			case 'j':
				if(i == str.length() - 1) {
					result += "ㅈ";
				}
				else {
					i++;
					if(str.charAt(i) == 'j') {
						result += "ㅉ";
					}
					else {
						i--;
						result += "ㅈ";
					}
				}
				break;
			case 'K':
			case 'k':
				if(i == str.length() - 1) {
					result += "ㅋ";
				}
				else {
					i++;
					if(str.charAt(i) == 'k') {
						result += "ㄲ";
					}
					else {
						i--;
						result += "ㅋ";
					}
				}
				break;
			case 'L':
			case 'l':
				result += "ㄹ";
				break;
			case 'M':
			case 'm':
				result += "ㅁ";
				break;
			case 'N':
			case 'n':
				if(i == str.length() - 1) {
					result += "ㄴ";
				}
				else {
					i++;
					if(str.charAt(i) == 'g') {
						result += "ㅇ";
					}
					else {
						i--;
						result += "ㄴ";
					}
				}
				break;
			case 'O':
			case 'o':
				if(i == str.length() - 1) {
					result += "ㅗ";
				}
				else {
					i++;
					if(str.charAt(i) == 'e') {
						result += "ㅚ";
					}
					else if(str.charAt(i) == 'o') {
						result += "ㅜ";
					}
					else {
						i--;
						result += "ㅗ";
					}
				}
				break;
			case 'P':
			case 'p':
				if(i == str.length() - 1) {
					result += "ㅍ";
				}
				else {
					i++;
					if(str.charAt(i) == 'p') {
						result += "ㅃ";
					}
					else {
						i--;
						result += "ㅍ";
					}
				}
				break;
			case 'Q':
			case 'q':
				result += "ㅋ";
				break;
			case 'R':
			case 'r':
				result += "ㄹ";
				break;
			case 'S':
			case 's':
				if(i == str.length() - 1) {
					result += "ㅅ";
				}
				else {
					i++;
					if(str.charAt(i) == 's') {
						result += "ㅆ";
					}
					else {
						i--;
						result += "ㅅ";
					}
				}
				break;
			case 'T':
			case 't':
				if(i == str.length() - 1) {
					result += "ㅌ";
				}
				else {
					i++;
					if(str.charAt(i) == 't') {
						result += "ㄸ";
					}
					else {
						i--;
						result += "ㅌ";
					}
				}
				break;
			case 'U':
			case 'u':
				if(i == str.length() - 1) {
					result += "ㅜ";
				}
				else {
					i++;
					if(str.charAt(i) == 'i') {
						result += "ㅢ";
					}
					else {
						i--;
						result += "ㅜ";
					}
				}
				break;
			case 'V':
			case 'v':
				result += "ㅂ";
				break;
			case 'W':
			case 'w':
				if(i == str.length() - 1) {
					result += "ㅝ";
				}
				else {
					i++;
					if(str.charAt(i) == 'a') {
						if(i == str.length() - 1) {
							result += "ㅘ";
						}
						else {
							i++;
							if(str.charAt(i) == 'e') {
								result += "ㅙ";
							}
							else {
								i--;
								result += "ㅘ";
							}
						}
					}
					else if(str.charAt(i) == 'e') {
						result += "ㅞ";
					}
					else if(str.charAt(i) == 'i') {
						result += "ㅟ";
					}
					else if(str.charAt(i) == 'o') {
						result += "ㅝ";
					}
					else {
						i--;
						result += "ㅝ";
					}
				}
				break;
			case 'X':
			case 'x':
				result += "ㅋ";
				result += "ㅡ";
				result += "ㅅ";
				result += "ㅡ";
				break;
			case 'Y':
			case 'y':
				if(i == str.length() - 1) {
					result += "ㅏ";
					result += "ㅇ";
					result += "ㅣ";
				}
				else {
					i++;
					if(str.charAt(i) == 'a') {
						if(i == str.length() - 1) {
							result += "ㅒ";
						}
						else {
							i++;
							if(str.charAt(i) == 'e') {
								result += "ㅑ";
							}
							else {
								i--;
								result += "ㅒ";
							}
						}
					}
					else if(str.charAt(i) == 'e') {
						if(i == str.length() - 1) {
							result += "ㅖ";
						}
						else {
							i++;
							if(str.charAt(i) == 'o') {
								result += "ㅕ";
							}
							else {
								i--;
								result += "ㅖ";
							}
						}
					}
					else if(str.charAt(i) == 'o') {
						result += "ㅛ";
					}
					else if(str.charAt(i) == 'u') {
						result += "ㅠ";
					}
					else {
						i--;
						result += "ㅣ";
					}
				}
				break;
			case 'Z':
			case 'z':
				result += "ㅅ";
				break;
			}
		}
		System.out.println("englishTokorean함수의 result: " + result);
		result_array = result.split("");
		
		return result_array;
	}
	
	private char[] first_word(String[] str) {
		int num = 0, cho_num = 99, joong_num = 99, jong_num = 0;
		String result;
		char unicode, result_array[] = null;
		
		for(int i = 0; i < cho.length; i++) {
			if(str[num].equals(cho[i])) {
				cho_num = i;
			}
		}
		
		if(cho_num == 99) {
			cho_num = 11;
		}
		
		System.out.println("cho_num: " + cho_num);
		
		num++;
		
		for(int i = 0; i < joong.length; i++) {
			if(str[num].equals(joong[i])) {
				joong_num = i;
			}
		}
		
		System.out.println("joong_num: " + joong_num);
		
		num++;
		
		for(int i = 0; i < jong.length; i++) {
			if(str[num].equals(jong[i])) {
				jong_num = i;
			}
		}
		
		System.out.println("jong_num: " + jong_num);
		
		if(jong_num == 0) {
			num--;
		}
		
		if(joong_num == 99) {
			return result_array;
		}
		
		num++;
		
		unicode = (char)((cho_num * 21 + joong_num) * 28 + jong_num + 0xAC00);
		System.out.println("unicode = " + unicode);
		
		result = String.valueOf(unicode);
		for(int i = num; i < str.length; i++) {
			result += str[i];
		}
		
		result_array = new char[result.length()];
		
		for(int i = 0; i < result.length(); i++) {
			result_array[i] = result.charAt(i);
		}
		
		return result_array;
	}
	
	private char[] stringTochar(String str) {
		String str_result;
		char uniVal, result_array[];
		
		str_result = String.valueOf(str.charAt(0));
		uniVal = str.charAt(1);
		
		str_result += separate_character(uniVal);
		
		result_array = new char[str_result.length()];
		
		for(int i = 0; i < str_result.length(); i++) {
			result_array[i] = str_result.charAt(i);
		}
		
		return result_array;
	}
	
	private void finish_symbol() {
		int num = 0;
		
		author_symbol = String.valueOf(author_char_array[num]);
		
		num++;
		
		switch(author_char_array[num]) {
		case 'ㄱ':
		case 'ㄲ':
			author_symbol += "1";
			break;
		case 'ㄴ':
			author_symbol += "19";
			break;
		case 'ㄷ':
		case 'ㄸ':
			author_symbol += "2";
			break;
		case 'ㄹ':
			author_symbol += "29";
			break;
		case 'ㅁ':
			author_symbol += "3";
			break;
		case 'ㅂ':
		case 'ㅃ':
			author_symbol += "4";
			break;
		case 'ㅅ':
		case 'ㅆ':
			author_symbol += "5";
			break;
		case 'ㅇ':
			author_symbol += "6";
			break;
		case 'ㅈ':
		case 'ㅉ':
			author_symbol += "7";
			break;
		case 'ㅊ':
			author_symbol += "8";
			break;
		case 'ㅋ':
			author_symbol += "87";
			break;
		case 'ㅌ':
			author_symbol += "88";
			break;
		case 'ㅍ':
			author_symbol += "89";
			break;
		case 'ㅎ':
			author_symbol += "9";
			break;
		}
		
		if(author_symbol.equals(String.valueOf(author_char_array[0]))) {
			author_symbol += "6";
		}
		else {
			num++;
		}
		
		if(author_char_array[num-1] == 'ㅊ') {
			switch(author_char_array[num]) {
			case 'ㅏ':
			case 'ㅐ':
			case 'ㅑ':
			case 'ㅒ':
				author_symbol += "2";
				break;
			case 'ㅓ':
			case 'ㅔ':
			case 'ㅕ':
			case 'ㅖ':
				author_symbol += "3";
				break;
			case 'ㅗ':
			case 'ㅘ':
			case 'ㅙ':
			case 'ㅚ':
			case 'ㅛ':
				author_symbol += "4";
				break;
			case 'ㅜ':
			case 'ㅝ':
			case 'ㅞ':
			case 'ㅟ':
			case 'ㅠ':
			case 'ㅡ':
			case 'ㅢ':
				author_symbol += "5";
				break;
			case 'ㅣ':
				author_symbol += "6";
				break;
			}
		}
		else {
			switch(author_char_array[num]) {
			case 'ㅏ':
				author_symbol += "2";
				break;
			case 'ㅐ':
			case 'ㅑ':
			case 'ㅒ':
				author_symbol += "3";
				break;
			case 'ㅓ':
			case 'ㅔ':
			case 'ㅕ':
			case 'ㅖ':
				author_symbol += "4";
				break;
			case 'ㅗ':
			case 'ㅘ':
			case 'ㅙ':
			case 'ㅚ':
			case 'ㅛ':
				author_symbol += "5";
				break;
			case 'ㅜ':
			case 'ㅝ':
			case 'ㅞ':
			case 'ㅟ':
			case 'ㅠ':
				author_symbol += "6";
				break;
			case 'ㅡ':
			case 'ㅢ':
				author_symbol += "7";
				break;	
			case 'ㅣ':
				author_symbol += "8";
				break;
			}
		}
	}
	
	public String separate_character(char uniVal) {
		String result = "";
		int num_cho, num_joong, num_jong;
		
		num_cho = (uniVal-0xAC00)/28/21;
		num_joong = (uniVal - 0xAC00)/28%21;
		num_jong = (uniVal - 0xAC00)%28;
		
		result += cho[num_cho];
		result += joong[num_joong];
		result += jong[num_jong];
		result.trim();
		
		return result;
	}
	
	public String call_symbol() {
		return author_symbol;
	}
}

//book테이블과 관련있는 event처리 클래스
public class LbDB_book_Frame extends LbDB_main_Frame{
	private JTextField tf_bookname, tf_author, tf_publish, tf_price, tf_year;
	private JButton sortBt;
	private int sw = 1;
	
	public LbDB_book_Frame() {}
	public LbDB_book_Frame(String str, JTextField tf, foreignkey fk) {
		db = new LbDB_DAO();
		menu_title = str;
		tf_bookname = tf;
		this.fk = fk;
		dialog(str);
		Initform();
		dialogform();
	}
	public LbDB_book_Frame(LbDB_DAO db, Client cl, String str) {
		this.db = db;
		this.cl = cl;
		menu_title = str;
		pk = cl.primarykey();
		state = cl.state();
		
		setTitle(str);
		Initform();
		baseform();
		
		if(state == 1) {
			manager_Initform();
		}
		else {
			member_Initform();
		}
		
		if(menu_title.equals("책추가")) {
			addform();
		}
		else {
			managerform();
			tableform();
			baseform_final();
			tableform_final();
		}
		addWindowListener(this);
	}
	
	private void baseform() {
		JLabel label;
		
		setGrid(gbc,1,1,1,1);
		label = new JLabel("    " + menu_title + "   ");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		if(menu_title.equals("책관리")) {
			setGrid(gbc,0,2,1,1);
			label = new JLabel(" 검색");
			gbl.setConstraints(label, gbc);
			leftPanel.add(label);
			setGrid(gbc,1,2,1,1);
			tf_research = new JTextField(50);
			gbl.setConstraints(tf_research, gbc);
			leftPanel.add(tf_research);
			setGrid(gbc,2,2,1,1);
			researchBt = new JButton("검색");
			researchBt.addActionListener(new researchButtonListener());
			gbl.setConstraints(researchBt, gbc);
			leftPanel.add(researchBt);
			setGrid(gbc,2,3,1,1);
			sortBt = new JButton("정렬");
			sortBt.addActionListener(new sortButtonListener());
			gbl.setConstraints(sortBt, gbc);
			leftPanel.add(sortBt);
			setGrid(gbc,0,3,1,1);
			label = new JLabel("        ");
			gbl.setConstraints(label, gbc);
			leftPanel.add(label);
			
		}
		setGrid(gbc,0,4,1,1);
		label = new JLabel("책이름");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,4,1,1);
		tf_bookname = new JTextField(50);
		gbl.setConstraints(tf_bookname, gbc);
		leftPanel.add(tf_bookname);
		setGrid(gbc,0,5,1,1);
		label = new JLabel(" 저자");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,5,1,1);
		tf_author = new JTextField(20);
		gbl.setConstraints(tf_author, gbc);
		leftPanel.add(tf_author);
		setGrid(gbc,0,6,1,1);
		label = new JLabel("출판사");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,6,1,1);
		tf_publish = new JTextField(20);
		gbl.setConstraints(tf_publish, gbc);
		leftPanel.add(tf_publish);
		setGrid(gbc,0,7,1,1);
		label = new JLabel(" 가격");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,7,1,1);
		tf_price = new JTextField(10);
		gbl.setConstraints(tf_price, gbc);
		leftPanel.add(tf_price);
		setGrid(gbc,0,8,1,1);
		label = new JLabel(" 년도");
		gbl.setConstraints(label, gbc);
		leftPanel.add(label);
		setGrid(gbc,1,8,1,1);
		tf_year = new JTextField(10);
		gbl.setConstraints(tf_year, gbc);
		leftPanel.add(tf_year);
		
	}
	
	private void tableform() {
		String columnName[] = {"책 이름", "저자", "출판사", "가격", "출판년도"};
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
		String now_sql;
		
		sql = "SELECT * FROM `book`";
		sortsql = " ORDER BY `book_name`";
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
	
	private void dialogform() {
		JLabel label;
		
		JPanel northPanel = new JPanel();
		label = new JLabel("책검색");
		northPanel.add("Center", label);
		
		setGrid(gbc,0,0,1,1);
		tf_research = new JTextField(50);
		gbl.setConstraints(tf_research, gbc);
		centerPanel.add(tf_research);
		setGrid(gbc,1,0,1,1);
		researchBt = new JButton("검색");
		researchBt.addActionListener(new researchButtonListener());
		gbl.setConstraints(researchBt, gbc);
		centerPanel.add(researchBt);
		setGrid(gbc,2,0,1,1);
		sortBt = new JButton("정렬");
		sortBt.addActionListener(new sortButtonListener());
		gbl.setConstraints(sortBt, gbc);
		centerPanel.add(sortBt);
		
		String columnName[] = {"책 이름", "저자", "출판사", "가격", "출판년도"};
		tablemodel = new LbDB_TableMode(columnName.length, columnName);
		table = new JTable(tablemodel);
		table.setPreferredScrollableViewportSize(new Dimension(700, 14*16));
		table.getSelectionModel().addListSelectionListener(new tableListener());
		JScrollPane scrollPane = new JScrollPane(table);
		leftPanel.add(scrollPane);
		
		cpane.add("North", northPanel);
		cpane.add("Center", centerPanel);
		cpane.add("South", leftPanel);
		pack();
	}
	
	private void addform() {
		setGrid(gbc,0,9,1,1);
		addBt = new JButton("추가");
		addBt.addActionListener(new addButtonListener());
		gbl.setConstraints(addBt, gbc);
		leftPanel.add(addBt);
		setGrid(gbc,2,9,1,1);
		clearBt = new JButton("공백");
		clearBt.addActionListener(new clearButtonListener());
		gbl.setConstraints(clearBt, gbc);
		leftPanel.add(clearBt);
		
		cpane.add("Center", leftPanel);
		pack();
	}
	
	private void managerform() {
		setGrid(gbc,0,9,1,1);
		deleteBt = new JButton("삭제");
		deleteBt.addActionListener(new deleteButtonListener());
		gbl.setConstraints(deleteBt, gbc);
		leftPanel.add(deleteBt);
		setGrid(gbc,1,9,1,1);
		updateBt = new JButton("수정");
		updateBt.addActionListener(new updateButtonListener());
		gbl.setConstraints(updateBt, gbc);
		leftPanel.add(updateBt);
		setGrid(gbc,2,9,1,1);
		clearBt = new JButton("공백");
		clearBt.addActionListener(new clearButtonListener());
		gbl.setConstraints(clearBt, gbc);
		leftPanel.add(clearBt);
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
			String bookname = result.getString("book_name");
			String author = result.getString("book_author");
			String publish = result.getString("book_publish");
			int price = result.getInt("book_price");
			int year = result.getInt("book_year");
			tf_bookname.setText(bookname);
			tf_author.setText(author);
			tf_publish.setText(publish);
			tf_price.setText(Integer.toString(price));
			tf_year.setText(Integer.toString(year));
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void OutData() {
		try {
			tf_bookname.setText(result.getString("book_name"));
			fk.insert_book_no(result.getInt("book_no"));
			closeFrame();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private void LoadList(String now_sql) {
		result = db.getResultSet(now_sql);
		
		if(resultempty_check(result)) {
			tableempty();
			return;
		}
		
		for(int i = 0; i < dataCount; i++) {
			removeTableRow(i);
		}
		try {
			for(dataCount = 0; result.next(); dataCount++) {
				table.setValueAt(result.getString("book_name"), dataCount, 0);
				table.setValueAt(result.getString("book_author"), dataCount, 1);
				table.setValueAt(result.getString("book_publish"), dataCount, 2);
				table.setValueAt(result.getInt("book_price"), dataCount, 3);
				table.setValueAt(result.getInt("book_year"), dataCount, 4);
			}
			repaint();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private boolean isYear(String strValue) {
		boolean bool = false;
		
		if(isInteger(strValue) && strValue.length() == 4)
			bool = true;
		
		return bool;
	}
	
	public class researchButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String book_name = "%" + tf_research.getText() + "%";
			String book_author = "%" + tf_research.getText() + "%";
			String book_publish = "%" + tf_research.getText() + "%";
			
			sql = "SELECT * FROM book WHERE `book_name` LIKE '" + book_name + "' OR `book_author` LIKE '" +
				  book_author + "' OR `book_publish` LIKE '" + book_publish + "'";
			String now_sql = sql + sortsql;
			System.out.println(now_sql);
			LoadList(now_sql);
			
			try {
				result.first();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			if(menu_title.equals("책관리")) {
				MoveData();
			}
		}
	}
	
	public class sortButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			String now_sql;
			
			if(sw == 1) {
				sortsql = " ORDER BY `book_name`";
				now_sql = sql + sortsql;				
			}
			else {
				sortsql = " ORDER BY `book_year` DESC";
				now_sql = sql + sortsql;
			}
			LoadList(now_sql);
			sw *= -1;
			
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
			
			if(tf_bookname.getText().isEmpty()) {
				JOptionPane.showMessageDialog(null, "책이름을 넣어주세요.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			}
			else if(tf_author.getText().isEmpty()) {
				JOptionPane.showMessageDialog(null, "저자를 넣어주세요.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			}
			else if(tf_publish.getText().isEmpty()) {
				JOptionPane.showMessageDialog(null, "출판사를 넣어주세요.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			}
			else if(!isInteger(tf_price.getText())) {
				JOptionPane.showMessageDialog(null, "가격부분이 숫자가 아닙니다.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			}
			else if(!isYear(tf_year.getText())){
				JOptionPane.showMessageDialog(null, "년도부분이 잘못되었습니다.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			}
			else {
				now_sql = "INSERT INTO `book` (`book_name`, `book_author`, `book_publish`, `book_price`, `book_year`) VALUES ('"
						+ tf_bookname.getText() + "', '" + tf_author.getText() + "', '" + tf_publish.getText() + "', "
						+ tf_price.getText() + ", " + tf_year.getText() + ")";
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
				code = result.getInt("book_no");
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			if(!isInteger(tf_price.getText())) {
				JOptionPane.showMessageDialog(null, "가격부분이 숫자가 아닙니다.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			}
			else if(!isYear(tf_year.getText())){
				JOptionPane.showMessageDialog(null, "년도부분이 잘못되었습니다.", "추가 오류", JOptionPane.WARNING_MESSAGE);
			}
			else {
				now_sql = "UPDATE `book` SET `book_name` = '" + tf_bookname.getText() + "', `book_author` = '" +
						  tf_author.getText() + "', `book_publish` = '" + tf_publish.getText() + "', `book_price` = " +
						  tf_price.getText() + ", `book_year` = " + tf_year.getText() + " WHERE `book_no` = " + code;
				System.out.println(now_sql);
				db.Excute(now_sql);
				now_sql = sql + sortsql;
				LoadList(now_sql);
			}
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
				code = result.getInt("book_no");
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			now_sql = "DELETE FROM `book` WHERE `book_no` = " + code;
			db.Excute(now_sql);
			now_sql = sql + sortsql;
			LoadList(now_sql);
		}	
	}
	
	public class clearButtonListener implements ActionListener{
		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			tf_bookname.setText(null);
			tf_author.setText(null);
			tf_publish.setText(null);
			tf_price.setText(null);
			tf_year.setText(null);
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
					if(menu_title.equals("책검색")) {
						OutData();
					}
					else {
						tf_bookname.setText(table.getValueAt(selectedCol, 0).toString());
						tf_author.setText(table.getValueAt(selectedCol, 1).toString());
						tf_publish.setText(table.getValueAt(selectedCol, 2).toString());
						tf_price.setText(table.getValueAt(selectedCol, 3).toString());
						tf_year.setText(table.getValueAt(selectedCol, 4).toString());
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
}
