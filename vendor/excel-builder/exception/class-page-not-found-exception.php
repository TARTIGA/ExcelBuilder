<?php 

class Page_Not_Found_Exception extends Exception {
	private $page_location;
	
	public function __construct($page_location){
		$this->page_location = $page_location;
		$this->message = 'Page not found exception: Page with location "' . $this->page_location . '", not found!';
		$this->code = 7;
	}

	public function set_page_location($page_location){
		$this->page_location = $page_location;
		$this->message = 'Page not found exception: Page with location "' . $this->page_location . '", not found!';
	}

	public function get_page_location(){
		return $this->page_location;
	}
}