<?php

abstract class Node_Cleaner{
	protected $dom;

	public function __construct($dom){
		$this->dom = $dom;
	}

	abstract public function clean($nodes);
	
	public function set_dom($dom){
		$this->dom = $dom;
	}

	public function get_dom(){
		return $this->dom;
	}
}