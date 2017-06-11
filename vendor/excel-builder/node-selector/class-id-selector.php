<?php
require_once(__DIR__ . '/class-node-selector.php');

class ID_Selector extends Node_Selector{
	public function select($selector_value){				
		return array($this->dom->getElementById($selector_value));
	}
}