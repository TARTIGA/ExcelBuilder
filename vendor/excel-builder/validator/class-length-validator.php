<?php  
require_once(__DIR__ . '/class-validator.php');
require_once(__DIR__ . '/../exception/class-validate-exception.php');

class Length_Validator extends Validator{
	/**
	 @param array(
	 * 		'min_length' => int	default NULL	
	 * 		'max_length' => int	default NULL	
	 *)
	 */	 	
	public function validate($value){				
		if($this->rules != null){			
			if($this->rules['min_length'] != null){
				if(strlen((string)$value) < $this->rules['min_length']){
					throw new Validate_Exception('Validate exception: validate value must be more than \'min_length\'', 0);
				}
			}			
			if($this->rules['max_length'] != null){
				if(strlen((string)$value) > $this->rules['max_length']){
					throw new Validate_Exception('Validate exception: validate value must be less than \'max_length\'', 1);
				}
			}
		}		
	}
	
}