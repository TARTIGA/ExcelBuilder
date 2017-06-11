<?php
/*
Plugin Name: Excel Builder
Plugin URI: 
Description: Excel Builder description.
Version: 1.0
Author: Denis Evdokimov
Author URI: 
*/
define('EXCEL_BUILDER__PLUGIN_DIR', plugin_dir_path( __FILE__ ));
require_once(EXCEL_BUILDER__PLUGIN_DIR . 'src/Maycenter/Controller/class-main-controller.php');	
error_reporting(E_ERROR | E_WARNING | E_PARSE);
add_action('add_attachment', array( 'Main_Controller', 'upload' ));
?>