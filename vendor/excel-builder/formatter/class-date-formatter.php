<?php
require_once(__DIR__ . '/class-formatter.php');

class Date_Formatter extends Formatter{
	public function formate($cell){
		$date = NULL;		
		if(PHPExcel_Shared_Date::isDateTime($cell)) {
		    $date = date("d.m.Y", PHPExcel_Shared_Date::ExcelToPHP($cell->getValue())); 
		}
		return $date;
	}
}