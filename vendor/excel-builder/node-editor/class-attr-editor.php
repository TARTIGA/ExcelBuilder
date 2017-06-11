<?php
require_once(__DIR__ . '/class-node-editor.php');

class Attr_Editor extends Node_Editor{

	public function edit($attrs){		
		if(count($attrs) > 1){
			$attr = $attrs['change_attr'];
			$value = $attrs['value'];
			if($attr != null && $value != null){
				foreach($this->nodes as $node){
					$node->setAttribute($attr, $value);
				}				
			}
		}
	}

}
