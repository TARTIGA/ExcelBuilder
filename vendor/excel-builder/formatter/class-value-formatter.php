<?php
require_once(__DIR__ . '/class-formatter.php');

class Value_Formatter extends Formatter{
	public function formate($cell){
		return $cell->getValue();
	}
}