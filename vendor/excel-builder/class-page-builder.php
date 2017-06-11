<?php
require_once(__DIR__ . '/class-dom-editor.php');

class Page_Builder {
	private $page;	
	private $editor;
	private $page_backup;		

	public function load_page_by_path($path){		
		$this->page = get_page_by_path($path);
		$this->page_backup = clone $this->page;		
		$this->editor = new DOM_Editor(); 
		$metadata = '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
		$this->editor->load_html($metadata . $this->page->post_content);		
	}

	public function load_page_by_title($title){		
		$this->page = get_page_by_title($title);		
		$this->page_backup = clone $this->page;
		$this->editor = new DOM_Editor(); 
		$metadata = '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
		$this->editor->load_html($metadata . $this->page->post_content);		
	}

	public function get_page(){
		return $this->page;
	}

	public function is_page_exist(){
		if($this->page != null){			
			return true;
		}
		return false;
	}

	public static function is_page_exist_by_title($title){
		$page = get_page_by_title($title);
		if($page != null){			
			return true;
		}
		return false;
	}
	
	public function set_title($post_title){		
		$this->page->post_title = $post_title;				
	}
	
	public function edit_content($edit_settings){				
		$this->editor->edit_content($edit_settings);
		$this->page->post_content = $this->editor->to_string();
	}
	
	public function build_nodes($build_settings){
		$this->editor->build_nodes($build_settings);		
		$this->page->post_content = $this->editor->to_string();
	}

	public function clean_nodes($build_settings){
		$this->editor->clean_nodes($build_settings);				
	}

	public function build(){
		/*
		error_log('Build page:');		
		error_log($this->page->post_content);
		*/
		wp_update_post($this->page);
	}	

	public function restore(){
		$this->page = $this->page_backup;		
		$this->build();
	}
}