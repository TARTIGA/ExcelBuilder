<?php 

class Validate_Exception extends Exception {
	private $row_id;
	private $column_id;	

	public function get_cell(){
		return $this->column_id . $this->row_id;
	}

	public function set_column_id($column_id){
		$this->column_id = $column_id;
	}

	public function get_column_id(){
		return $this->column_id;
	}

	public function set_row_id($row_id){
		$this->row_id = $row_id;
	}

	public function get_row_id(){
		return $this->row_id;
	}

}