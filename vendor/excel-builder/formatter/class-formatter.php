<?php
require_once(__DIR__ . '/../PHPExcel_1.8.0/PHPExcel.php');

abstract class Formatter{
	abstract public function formate($cell);
}