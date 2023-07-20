<?php
class Combobox_Inheritance{
	private $parent_name;
	private $nothing = false;
	public $child_manager;
	public $child_combox;
	
	public Combobox_Inheritance() {}
	public Combobox_Inheritance(Combobox_Manager cm, JComboBox <String> cb, String str) {
		$this->child_manager = cm;
		$this->child_combox = cb;
		$this->parent_name = str;
	}
	
	public function insert_nothing(boolean bool) {
		$this->nothing = bool;
	}
	
	public function call_parent_name() {
		return $this->parent_name;
	}
	
	public function call_nothing() {
		return $this->nothing;
	}
}