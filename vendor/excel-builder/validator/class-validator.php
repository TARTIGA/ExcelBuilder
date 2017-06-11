<?php

abstract class Validator{
	protected $rules;

	abstract public function validate($value);

	public function set_rules($rules){
		$this->rules = $rules;
	}

	public function get_rules(){
		return $this->rules;
	}
}