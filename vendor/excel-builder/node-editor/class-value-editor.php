<?php  
require_once(__DIR__ . '/class-node-editor.php');

class Value_Editor extends Node_Editor{

	public function edit($value){		
		foreach($this->nodes as $node){
			$node->nodeValue = $value;
		}		
	}
}
