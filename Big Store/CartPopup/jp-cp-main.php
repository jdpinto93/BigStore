<?php
if(!defined('ABSPATH')){
	return; 	
}


define("JP_CP_PATH", plugin_dir_path(__FILE__));
define("JP_CP_URL", plugins_url('',__FILE__));
define("JP_CP_VERSION",1.6);

//Admin Settings
include_once JP_CP_PATH.'/admin/jp-cp-admin.php';

//Init plugin
function jp_cp_rock_the_world(){
	global $jp_cp_gl_atcem_value;
	
	//If mobile
	if(!$jp_cp_gl_atcem_value){
		if(wp_is_mobile()){
			return;
		}
	}
	require_once JP_CP_PATH.'/includes/class-jp-cp.php';
	//Start the plugin
	Jp_CP::get_instance();
}
add_action('plugins_loaded','jp_cp_rock_the_world');