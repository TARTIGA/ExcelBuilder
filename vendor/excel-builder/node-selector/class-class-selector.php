<?php  
require_once(__DIR__ . '/class-node-selector.php');

class Class_Selector extends Node_Selector{
	public function select($selector_value){		
		$xpath = new DomXPath($this->dom);
		$node_list = $xpath->query("//*[contains(@class, '$selector_value')]");		
		$nodes = array();
		if($node_list != null){
			foreach($node_list as $node){
				array_push($nodes, $node);
			}
		}
		return $nodes;
	}
}
