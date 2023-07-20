<?php
class Foreignkey{ //lib_no는 상호대차부분 자료검색에 사용, pla_no는 etc_frame에 research_lent 함수 사용 
	private $add_no;
    private $kind_no;
    private $book_no;
    private $mem_no; 
    private $mat_no;
    private $del_no;
    private $len_no;
    private $lib_no;
    private $pla_no;
	public $kind_num;
    public $book_name;
	public $is_null_re_date = false;
	
	public function __construct() {
		$this->add_no = 0;
		$this->kind_no = 0;
		$this->book_no = 0;
		$this->mem_no = 0;
		$this->mat_no = 0;
		$this->del_no = 0;
		$this->len_no = 0;
		$this->lib_no = 0;
		$this->pla_no = 0;
	}

    public function __destruct() {}
	
	public function insert_kind_no(int $num) {
		$this->kind_no = $num;
	}
	
	public function insert_add_no(int $num) {
		$this->add_no = $num;
	}
	
	public function insert_book_no(int $num) {
		$this->book_no = $num;
	}
	
	public function insert_mem_no(int $num) {
		$this->mem_no = $num;
	}
	
	public function insert_mat_no(int $num) {
		$this->mat_no = $num;
	}
	
	public function insert_del_no(int num) {
		$this->del_no = $num;
	}
	
	public function insert_len_no(int $num) {
		$this->len_no = $num;
	}
	
	public function insert_lib_no(int $num) {
		$this->lib_no = $num;
	}
	
	public function insert_pla_no(int $num) {
		$this->pla_no = $num;
	}
	
	public function call_add_no() {
		return $this->add_no;
	}
	
	public function call_kind_no() {
		return $this->kind_no;
	}
	
	public function call_book_no() {
		return $this->book_no;
	}
	
	public function call_mem_no() {
		return $this->mem_no;	
	}
	
	public function call_mat_no() {
		return $this->mat_no;
	}
	
	public function call_del_no() {
		return $this->del_no;
	}
	
	public function call_len_no() {
		return $this->len_no;
	}
	
	public function call_lib_no() {
		return $this->lib_no;
	}
	
	public function call_pla_no() {
		return $this->pla_no;
	}
}