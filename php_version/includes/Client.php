<?php
class Client{
	private $pk;
	private $state;
	private $name;
	
	public function __construct() {
		$this->pk = 0;
		$this->name = '';
		$this->state = 0;
	}

    public function __destruct() {}
	
	public function insertnum(int $pk, string $name, int $state) {
		$this->pk = $pk;
		$this->name = $name;
		$this->state = $state;
	}
	
	public function call_primarykey() {
		return $this->pk;
	}
	
	public function call_state() {
		return $this->state;
	}

	public function call_name(){
		return $this->name;
	}
}