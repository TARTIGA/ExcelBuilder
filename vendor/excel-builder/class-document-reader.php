<?php
require_once(__DIR__ . '/PHPExcel_1.8.0/PHPExcel.php');

class Document_Reader{
	private $document;
	private $sheet_num;

	public function __construct($file){
		$this->document = PHPExcel_IOFactory::load($file);								
		$this->set_sheet_num(0);
	}

	public function is_sheet_num_exist($sheet_num){
		try{
			$this->document->getSheet($sheet_num);
		}catch(Exception $e){
			return false;
		}
		return true;
	}

	public function get_sheet_name(){
		return $this->document->getActiveSheet()->getTitle();
	}

	public function set_sheet_num($sheet_num){		
		$this->sheet_num = $sheet_num;
		return $this->document->setActiveSheetIndex($this->sheet_num);			
	}

	public function get_sheet_num(){		
		return $this->sheet_num;			
	}

	public function get_sheet(){
		return $this->document->getActiveSheet();
	}

	public function get_cell($cell_id){
		$sheet = $this->get_sheet();
		$cell = $sheet->getCell($cell_id);
		return $cell;
	}

	//$pattern = array("A" => new Value_Formatter(), "B" => new Date_Formatter());
	public function read_row_by_pattern($row_id, $pattern, $formatters){
		$sheet = $this->get_sheet();	
		$row = array();
		foreach($pattern as $column_id => $metadata){
			$type = $metadata['type'];
			$row[$column_id] = $formatters[$type]->formate($this->get_cell($column_id . $row_id));			
		}
		return $row;
	}		

	public function is_row_empty_by_column_id($row, $column_id){
		if(empty($row[$column_id])){
			return true;
		}
		return false;
	}
}