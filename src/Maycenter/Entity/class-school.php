<?php 
require_once(__DIR__ . '/../../../vendor/excel-builder/class-document-reader.php');
require_once(__DIR__ . '/../../../vendor/excel-builder/class-page-builder.php');
require_once(__DIR__ . '/../../../vendor/excel-builder/class-dom-editor.php');
require_once(__DIR__ . '/../../../vendor/excel-builder/formatter/class-value-formatter.php');
require_once(__DIR__ . '/../../../vendor/excel-builder/formatter/class-date-formatter.php');
require_once(__DIR__ . '/../../../vendor/excel-builder/validator/class-length-validator.php');
require_once(__DIR__ . '/../../../vendor/excel-builder/validator/class-not-null-validator.php');
require_once(__DIR__ . '/../../../vendor/excel-builder/validator/class-date-validator.php');
require_once(__DIR__ . '/../../../vendor/excel-builder/validator/class-day-validator.php');
require_once(__DIR__ . '/../../../vendor/excel-builder/validator/class-page-exist-validator.php');
require_once(__DIR__ . '/../../../vendor/excel-builder/exception/class-page-not-found-exception.php');

class School {	
	private $START_ROW = 2;	
	private $document_reader;	
	private $formatters;	
	private $roles;

	public function __construct($file){		

		$this->formatters = array(
			'value' => new Value_Formatter(),
			'date' => new Date_Formatter()
		);

		$this->validators = array(
			'not_null' => new Not_Null_Validator(),
			'length' => new Length_Validator(),
			'date' => new Date_Validator(),
			'day' => new Day_Validator(),
			'page_exist' => new Page_Exist_Validator()
		);		

		$this->document_reader = new Document_Reader($file);				
	}			

	public function update($pattern, $build_plan){
		try{
			$this->validate($pattern);
			$this->save($pattern, $build_plan);
		}catch(Page_Not_Found_Exception $e){	
			error_log($e->getMessage());
		}catch(Validate_Exception $e){
			error_log($e->getMessage() . ' in ' . $e->get_cell());
		}		
	}

	private function validate($pattern){
		$this->to_start_shedule();
		$new_school_data = null;
		do{			
			if(!$this->is_calendar_exist()){
				throw new Page_Not_Found_Exception($this->document_reader->get_sheet_name());
			}			
			$this->validate_by_pattern($pattern);																										
		}while($this->next_shedule() != null);
	}

	private function save($pattern, $build_plan){
		$this->to_start_shedule();
		$new_school_data = null;
		do{
			if($this->is_calendar_exist()){				
				$new_school_data = $this->read_by_pattern($pattern);														
				$this->save_shedule($new_school_data, $build_plan);				
			}
		}while($this->next_shedule() != null);
	}

	private function next_shedule(){
		$sheet_num = $this->document_reader->get_sheet_num() + 1;
		if($this->document_reader->is_sheet_num_exist($sheet_num)){
			$this->document_reader->set_sheet_num($sheet_num);
			return $this->document_reader->get_sheet();
		}
		return null;
	}

	private function to_start_shedule(){
		$this->document_reader->set_sheet_num(0);		
	}

	private function is_calendar_exist(){
		$calendar_title = $this->document_reader->get_sheet_name();		
		if(Page_Builder::is_page_exist_by_title($calendar_title)){
			return true;
		}
		return false;
	}

	private function validate_by_pattern($pattern){		
		$row_id = $this->START_ROW;								
		$document_reader = $this->document_reader;
		while(!$document_reader->is_row_empty_by_column_id($row = $document_reader->read_row_by_pattern($row_id, $pattern, $this->formatters), 'B')) {											
			try{
				$this->validate_row_by_pattern($row, $pattern, $this->validators);
			}catch(Validate_Exception $e){
				$e->set_row_id($row_id);
				throw $e;
			}			
			$row_id++;
		}			
	}

	private function read_by_pattern($pattern){		
		$row_id = $this->START_ROW;						
		$data = array();
		$document_reader = $this->document_reader;
		while(!$document_reader->is_row_empty_by_column_id($row = $document_reader->read_row_by_pattern($row_id, $pattern, $this->formatters), 'B')) {														
			$data[$row_id] = $row;						
			$row_id++;
		}	
		return $data;		
	}

	private function validate_row_by_pattern($row, $pattern){		
		foreach($row as $column_id => $value){
			$metadata = $pattern[$column_id];			
			if($metadata['rules'] != null){
				$rules = $metadata['rules'];
				foreach($rules as $rule => $params){					
					$validator = $this->validators[$rule];
					if($validator != null){
						$validator->set_rules($params);						
						try{
							$validator->validate($row[$column_id]);						
						}catch(Validate_Exception $e){
							$e->set_column_id($column_id);
							throw $e;
						}
					}
				}
			}						
		}		
	}	

	private function save_shedule($data, $build_plan){							
		$page_builder = new Page_Builder();
		$calendar_builder = new Page_Builder();

		$calendar_title = $this->document_reader->get_sheet_name();
		$calendar_builder->load_page_by_title($calendar_title);
		try{
			if(!$calendar_builder->is_page_exist()){
				throw new Page_Not_Found_Exception($calendar_title);
			}
			$calendar_builder->clean_nodes($build_plan);		
			foreach($data as $row_id => $row){					
				$path = $row[$build_plan['path']];
				$post_title = $row[$build_plan['post_title']];						

				$edit_settings = array();
				foreach($build_plan['post_content'] as $selector_value => $settings){									
					if(is_array($settings)){		
						$edit_settings[$selector_value] = array(
							'value' => $row[$settings['column_id']],
							'selector_type' => $settings['selector_type'],
							'change_attr' => $settings['change_attr']
						);
					}
				}				
				$page_builder->load_page_by_path($path);			
				try{			
					if(!$page_builder->is_page_exist()){				
						throw new Page_Not_Found_Exception($path);
					}
					$page_builder->set_title($post_title);
					$page_builder->edit_content($edit_settings);														

					/*
					'calendar' => array(
						'selector_type' => 'id',
						'selector_prefix' => 'cnumb', 
						'calendar_date' => 'A',
						'calendar_path' => 'I',
						'node_builder' => 'calendar',
						'calendar_content' => array(					
							'picture_path' => 'J',	
							'calendar_cost' => 'E',		
							'calendar_duration' => 'G'		
						)	
					)
					*/			 
					if($build_plan['calendar'] != null && $build_plan['cleaner'] != null){												
						$calendar = $build_plan['calendar'];				
						$selector_prefix = $calendar['selector_prefix'];				
						//$day = (int)explode(' ', $row[$calendar['calendar_date']])[0];													
						$date = $row[$calendar['calendar_date']];
						try{
							$day = (int)($date[0] . $date[1]);
						}catch(Exception $e){
							$day = '';
						}
						//if($day != null){																					
							if($calendar_builder->is_page_exist()){						
								$content = array(
									'curse_path' => $row[$calendar['calendar_content']['curse_path']],
									'curse_name' => $row[$calendar['calendar_content']['curse_name']],
									'picture_path' => $row[$calendar['calendar_content']['picture_path']],
									'calendar_cost' => $row[$calendar['calendar_content']['calendar_cost']],		
									'calendar_duration' => $row[$calendar['calendar_content']['calendar_duration']]
								);
								$calendar_settings = array(
									'selector' => $selector_prefix . $day,
									'selector_type' => $calendar['selector_type'],
									'content' => $content,
									'node_builder' => $calendar['node_builder']
								);																		
								$calendar_builder->build_nodes($calendar_settings);							
							}					
						//}
					}			

					//Save page changes
					$page_builder->build();												
				}catch(Page_Not_Found_Exception $e){
					throw $e;
				}
			}			
			//Save page changes
			$calendar_builder->build();			
		}catch(Page_Not_Found_Exception $e){			
			//$calendar_builder->restore();			
			throw $e;			
		}
	}	
}