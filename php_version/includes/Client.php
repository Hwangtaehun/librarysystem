<?php
class Client{
	private $pk;
	private $state;
	
	public function __construct() {
		$this->pk = 0;
		$this->state = 0;
	}

    public function __destruct() {}
	
	public function insertnum(int $pk, int $state) {
		$this->pk = $pk;
		$this->state = $state;
	}
	
	public function primarykey() {
		return $this->pk;
	}
	
	public function state() {
		return $this->state;
	}
}