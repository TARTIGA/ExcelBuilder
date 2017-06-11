<?php  
require_once(__DIR__ . '/class-validator.php');
require_once(__DIR__ . '/../exception/class-validate-exception.php');

class Not_Null_Validator extends Validator{		

	public function validate($value){		
		if($value == null){			
			throw new Validate_Exception('Validate exception: validate value must be not null', 2);			
		}		
	}	
}