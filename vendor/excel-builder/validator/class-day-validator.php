<?php  
require_once(__DIR__ . '/class-validator.php');
require_once(__DIR__ . '/../exception/class-validate-exception.php');

class Day_Validator extends Validator{		 	
	public function validate($value){		
		$e = new Validate_Exception('Validate exception: validate value must content day', 4);		
		if($value == null){			
			throw $e;
		}		
		if(!is_numeric($value[0] . $value[1])){
			throw $e;	
		}
	}
	
}