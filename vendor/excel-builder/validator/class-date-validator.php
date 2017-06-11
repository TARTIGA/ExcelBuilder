<?php  
require_once(__DIR__ . '/class-validator.php');
require_once(__DIR__ . '/../exception/class-validate-exception.php');

class Date_Validator extends Validator{		 	
	public function validate($value){		
		$e = new Validate_Exception('Validate exception: validate value must be date', 3);		
		if($value == null){			
			throw $e;
		}		
		$split_date = explode('.', $value);
		if(count($split_date) != 3){
			throw $e;
		}
		if(!checkdate($split_date[1], $split_date[0], $split_date[2])){
			throw $e;
		}		
	}
	
}