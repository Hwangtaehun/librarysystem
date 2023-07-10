//java프로그램 실행
package libraryDB;

//회원 정보와 회원 상태 담은 클래스
class Client{
	private int pk;
	private int state;
	
	public Client() {
		this.pk = 0;
		this.state = 0;
	}
	
	public void insertnum(int pk, int state) {
		this.pk = pk;
		this.state = state;
	}
	
	public int primarykey() {
		return pk;
	}
	
	public int state() {
		return state;
	}
}

//외래키와 외래키를 통해서 알 수 있는 정보를 담는 클래스
class foreignkey{ //lib_no는 상호대차부분 자료검색에 사용, pla_no는 etc_frame에 research_lent 함수 사용 
	private int add_no, kind_no, book_no, mem_no, mat_no, del_no, len_no, lib_no, pla_no;
	public String kind_num, book_name;
	public boolean is_null_re_date = false;
	
	public foreignkey() {
		add_no = 0;
		kind_no = 0;
		book_no = 0;
		mem_no = 0;
		mat_no = 0;
		del_no = 0;
		len_no = 0;
		lib_no = 0;
		pla_no = 0;
	};
	
	public void insert_kind_no(int num) {
		kind_no = num;
	}
	
	public void insert_add_no(int num) {
		add_no = num;
	}
	
	public void insert_book_no(int num) {
		book_no = num;
	}
	
	public void insert_mem_no(int num) {
		mem_no = num;
	}
	
	public void insert_mat_no(int num) {
		mat_no = num;
	}
	
	public void insert_del_no(int num) {
		del_no = num;
	}
	
	public void insert_len_no(int num) {
		len_no = num;
	}
	
	public void insert_lib_no(int num) {
		lib_no = num;
	}
	
	public void insert_pla_no(int num) {
		pla_no = num;
	}
	
	public int call_add_no() {
		return add_no;
	}
	
	public int call_kind_no() {
		return kind_no;
	}
	
	public int call_book_no() {
		return book_no;
	}
	
	public int call_mem_no() {
		return mem_no;	
	}
	
	public int call_mat_no() {
		return mat_no;
	}
	
	public int call_del_no() {
		return del_no;
	}
	
	public int call_len_no() {
		return len_no;
	}
	
	public int call_lib_no() {
		return lib_no;
	}
	
	public int call_pla_no() {
		return pla_no;
	}
}

public class LbDB_main {
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		LbDB_DAO db = new LbDB_DAO();
		db.printMetaData("address");
		db.printMetaData("book");
		db.printMetaData("delivery");
		db.printMetaData("kind");
		db.printMetaData("lent");
		db.printMetaData("library");
		db.printMetaData("material");
		db.printMetaData("member");
		db.printMetaData("overdue");
		db.printMetaData("place");
		db.printMetaData("reservation");
		Client cl = new Client();
		LbDB_Login_Frame log = new LbDB_Login_Frame(db, cl);
		log.setVisible(true);
	}
}
