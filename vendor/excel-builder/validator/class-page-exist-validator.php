<?php  
require_once(__DIR__ . '/class-validator.php');
require_once(__DIR__ . '/../exception/class-validate-exception.php');

class Page_Exist_Validator extends Validator{		 	
	public function validate($value){				
		if($this->rules['exist_by'] != null){
			switch($this->rules['exist_by']){				
				case 'path':
					$this->validate_by_path($value);
					break;
				case 'title':
					$this->validate_by_title($value);
					break;
				default:
					$this->validate_by_path($value);
					break;
			}
		}		
	}

	private function validate_by_path($path){
		if(get_page_by_path($path) == null){
			throw new Validate_Exception('Validate exception: validate value must content exist page path', 5);
		}
	}
	
	private function validate_by_title($title){
		if(get_page_by_title($title) == null){
			throw new Validate_Exception('Validate exception: validate value must content exist page title', 6);
		}
	}
}