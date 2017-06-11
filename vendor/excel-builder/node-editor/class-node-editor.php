<?php  

abstract class Node_Editor{
	protected $nodes;

	public function __construct($nodes){
		$this->nodes = $nodes;
	}

	abstract public function edit($value);

	public function set_nodes($nodes){
		$this->nodes = $nodes;
	}

	public function get_nodes(){
		return $this->nodes;
	}
}