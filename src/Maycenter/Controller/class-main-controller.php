<?php 
require_once(__DIR__ . '/../Entity/class-school.php');

class Main_Controller {
	private $school;	

	public static function upload($post_ID) {
		$file = get_attached_file($post_ID);
		$main_controller = new Main_Controller();
		$main_controller->school = new School($file);		

		$pattern = array(			
			'A' => array(
				'type' => 'value',								
				'rules' => array(					
					'not_null' => true
					//'day' => true					
					//'date' => true					
				)				
			),
			'B' => array(
				'type' => 'value',				
				'rules' => array(
					'not_null' => true,
					/*
					'length' => array(
						'min_length' => 1,
						'max_length' => 100
					)
					*/
					'page_exist' => array(
						'exist_by' => 'path'
					)
				)				
			),
			'C' => array(
				'type' => 'value',
				/*
				'rules' => array(
					'not_null' => true,
					'length' => array(
						'min_length' => 1,
						'max_length' => 100
					)
				)
				*/
			),
			'D' => array(
				'type' => 'value',
				/*
				'rules' => array(
					'not_null' => true,
					'length' => array(
						'min_length' => 1,
						'max_length' => 100
					)
				)
				*/
			),
			'E' => array(
				'type' => 'value',
				/*
				'rules' => array(
					'not_null' => true,
					'length' => array(
						'min_length' => 1,
						'max_length' => 100
					)
				)
				*/
			),
			'F' => array(
				'type' => 'value',
				/*
				'rules' => array(
					'not_null' => true,
					'length' => array(
						'min_length' => 1,
						'max_length' => 100
					)
				)
				*/
			),
			'G' => array(
				'type' => 'value',
				/*
				'rules' => array(
					'not_null' => true,
					'length' => array(
						'min_length' => 1,
						'max_length' => 100
					)
				)
				*/
			),
			'H'=> array(
				'type' => 'value',
				/*
				'rules' => array(
					'not_null' => true,
					'length' => array(
						'min_length' => 2,
						'max_length' => 100
					)
				)
				*/
			),
			'I'=> array(
				'type' => 'value'				
			)
		);
					
		$build_plan = array(
			'path' => 'B',
			'post_title' => 'C',			
			'post_content' => array(
				'maycenter_date_label' => array(
					'selector_type' => 'class',
					'column_id' => 'A',
					'change_attr' => 'value'					
				),
				'maycenter_curse_name_label' => array(
					'selector_type' => 'class',
					'column_id' => 'C',
					'change_attr' => 'value'					
				),
				'maycenter_curse_cost_label' => array(
					'selector_type' => 'class',
					'column_id' => 'D',
					'change_attr' => 'value'					
				),				
				'id4' => 'E',
				'maycenter_curse_duration_label' => array(
					'selector_type' => 'class',
					'column_id' => 'F',
					'change_attr' => 'value'					
				),
				'id6' => 'G',				
				'contact_form_pop' => array(
					'selector_type' => 'id',
					'column_id' => 'H',
					'change_attr' => 'value'					
				)								
			),
			'cleaner' => array(
				'selector_type' => 'class',
				'selector_value' => 'raspy'
			),
			'calendar' => array(
				'selector_type' => 'id',
				'selector_prefix' => 'cnumb', 
				'calendar_date' => 'A',				
				'node_builder' => 'calendar',
				'calendar_content' => array(
					'curse_path' =>	'B',				
					'curse_name' => 'C',
					'picture_path' => 'I',	
					'calendar_cost' => 'E',		
					'calendar_duration' => 'G'		
				)	
			)				
		);		
		/*
		$new_school_data = null;
		do{
			if($main_controller->school->is_calendar_exist()){
				try{
					$new_school_data = $main_controller->school->read_by_pattern($pattern);														
					$main_controller->school->save($new_school_data, $build_plan);
				}catch(Validate_Exception $e){
					error_log($e->getMessage() . ' in ' . $e->get_cell());
					break;
				}				
			}
		}while($main_controller->school->next_shedule() != null);
		*/
		$main_controller->school->update($pattern, $build_plan);		
	}	
	
}