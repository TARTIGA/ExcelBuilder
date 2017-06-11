<?php
require_once(__DIR__ . '/node-selector/class-id-selector.php');
require_once(__DIR__ . '/node-selector/class-class-selector.php');
require_once(__DIR__ . '/node-editor/class-value-editor.php');
require_once(__DIR__ . '/node-editor/class-attr-editor.php');
require_once(__DIR__ . '/node-builder/class-calendar-builder.php');
require_once(__DIR__ . '/node-cleaner/class-default-cleaner.php');

class DOM_Editor{
	private $dom;	

	public function __construct(){
		$this->dom = new DOMDocument();						
		$this->selectors = array(
			'id' => new ID_Selector($this->dom),
			'class' => new Class_Selector($this->dom)
		);

		$this->editors = array(			
			'value' => new Value_Editor(null)
		);

		$this->node_builders = array(
			'calendar' => new Calendar_Builder()
		);
		
		$this->node_cleaner = new Default_Cleaner($this->dom);
	}

	public function load_html($html){		
		$this->dom->loadHTML($html);						
	}

	public function edit_content($edit_settings){
		foreach($edit_settings as $selector_value => $settings){
			$selector = $this->selectors[$settings['selector_type']];
			if($selector != null){
				$nodes = $selector->select($selector_value);				
				if($nodes != null){
					$editor = $this->editors[$settings['change_attr']];					
					if($editor == null){
						$editor = new Attr_Editor($nodes);
						$editor->edit(
							array(
								'change_attr' => $settings['change_attr'],
								'value' => $settings['value']
							)
						);
						continue;
					}
					$editor->set_nodes($nodes);										
					$editor->edit($settings['value']);
				}				
			}
		}
	}	

	public function clean_nodes($build_settings){
		$cleaner_settings = $build_settings['cleaner'];		
		if($cleaner_settings != null){
			$selector_value = $cleaner_settings['selector_value'];
			$selector_type = $cleaner_settings['selector_type'];			
			if($selector_type != null && $selector_value != null){				
				$selector = $this->selectors[$cleaner_settings['selector_type']];				
				if($selector != null){
					$nodes = $selector->select($selector_value);					
					if($nodes != null){
						$this->node_cleaner->clean($nodes);
					}
				}					
			}
		}		
	}

	public function build_nodes($build_settings){		
		$selector_value = $build_settings['selector'];
		$selector_type = $build_settings['selector_type'];		
		if($selector_value != null && $selector_type != null){						
			$selector = $this->selectors[$selector_type];			
			if($selector != null){				
				$nodes = $selector->select($selector_value);				
				$node_builder_name = $build_settings['node_builder'];
				if($node_builder_name != null){
					$node_builder = $this->node_builders[$node_builder_name];					
					if($node_builder != null){
						$build_settings['content']['dom'] = $this->dom;
						foreach($nodes as $node){
							$node_builder->build($node, $build_settings['content']);
						}
					}
				}
			}			
		}		
	}	

	public function to_string(){		
		$body = $this->dom->getElementsByTagName('body')->item(0);				
		return htmlspecialchars_decode($this->dom->saveHTML($body));			
	}
}