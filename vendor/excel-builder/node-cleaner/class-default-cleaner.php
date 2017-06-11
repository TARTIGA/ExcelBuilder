<?php
require_once(__DIR__ . '/class-node-cleaner.php');

class Default_Cleaner extends Node_Cleaner{
	public function clean($nodes){
		foreach($nodes as $node){			
			$node->parentNode->removeChild($node);
		}		
	}
}	