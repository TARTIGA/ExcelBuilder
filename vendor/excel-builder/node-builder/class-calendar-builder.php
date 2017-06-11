<?php
require_once(__DIR__ . '/class-node-builder.php');

class Calendar_Builder extends Node_Builder{	
	private $root;
	private $dom;	

	public function build($node, $build_settings){		
		if($node != null){
			$this->dom = $build_settings['dom'];
			$curse_path = $build_settings['curse_path'];				
			
			$this->root = $node;		
			$xpath = new DomXPath($this->dom);
			$node_list = $xpath->query("//*[contains(@class, '$curse_path')]", $this->root);						
			foreach($node_list as $node){			
				$node->parentNode->removeChild($node);
			}					
			$element = $this->create_node($build_settings);		
			$this->root->appendChild($element);				
		}
	}

	private function create_node($build_settings){
		$curse_name = $build_settings['curse_name'];
		$picture_path = $build_settings['picture_path'];
		$calendar_cost = $build_settings['calendar_cost'];
		$calendar_duration = $build_settings['calendar_duration'];
		$curse_path = $build_settings['curse_path'];				
		$curse_link = site_url() . '/' . $curse_path;		

		$template = '
			<div class="raspy ' . $curse_path . '"> 
			<a title="' . $curse_name . '" href="' . $curse_link . '"> <img src="' . $picture_path . '" alt="' . $curse_name . '" width="100%" class="alignnone size-full"> </a> 
			<center> 
			<a title="' . $curse_name . '" href="' . $curse_link . '" style="color: #e83c3c;" class="nameRasp"> ' . $curse_name . ' </a> 
			</center> 
			<div class="price"> 
			<table> 
			 <tbody> 
			  <tr> 
			   <td> <img src="http://maycenter.ru/wp-content/uploads/2014/11/rouble.png" alt="rouble" width="20" height="20" class="alignnone size-full">' . $calendar_cost . '</td> 
			  </tr>
			  <tr> 
			   <td style="text-align: left;"> <img src="http://maycenter.ru/wp-content/uploads/2014/11/time.png" alt="time" width="20" height="18" class="alignnone size-full">' . $calendar_duration . '</td> 
			  </tr> 
			 </tbody> 
			</table> 
			</div> 
			</div> 
			<p>&nbsp;</p>';		
		
		$element = $this->dom->createTextNode($template);			
		return $element;
	}
	
}