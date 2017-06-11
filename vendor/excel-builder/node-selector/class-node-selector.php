<?php  

abstract class Node_Selector{
	protected $dom;

	public function __construct($dom){
		$this->dom = $dom;		
	}

	abstract public function select($selector_value);

	public function set_dom($dom){
		$this->dom = $dom;
	}

	public function get_dom(){
		return $this->dom;
	}
}