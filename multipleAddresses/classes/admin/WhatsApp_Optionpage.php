<?php
class WhatsApp_OptionPage
{
	public function __construct()
	{
		$this->init_options_menu();
	}
	function init_options_menu()
	{
		if( function_exists('acf_add_options_page') ) 
		{
			acf_add_options_page(array(
				'page_title' 	=> 'Ajustes de Mensajes deWhatsApp',
				'menu_title'	=> 'Ajestes de WhatsApp',
				'menu_slug' 	=> 'option-menu-whatsApp',
				'capability'	=> 'manage_options',
				'parent_slug'	=> 'options-general.php',
				'update_button' => __('Actualizar Mensajes', 'acf'),
				'redirect'		=> false
			));

			add_action( 'current_screen', array($this, 'cl_set_global_options_pages') );
			add_action( 'plugins_loaded', array($this, 'switch_language') );
		}
	}
	function switch_language()
	{
		if(wcmca_get_value_if_set($_GET, 'page', "") == 'acf-option-menu-whatsApp')
		{
			global $wcmca_wpml_helper;
			$wcmca_wpml_helper->switch_to_default_language();
		}
	}
	/**
	 * Force ACF to use only the default language on some options pages
	 */
	function cl_set_global_options_pages($current_screen) 
	{
	  if(!is_admin())
		  return;
	  
	 //wcmca_var_dump($current_screen->id);
	  
	  $page_ids = array(
		"woocommerce_page_acf-option-menu-whatsApp"
	  );
	  //wcmca_var_dump($current_screen->id);
	  if (in_array($current_screen->id, $page_ids)) 
	  {
		global $wcmca_wpml_helper;
		$wcmca_wpml_helper->switch_to_default_language();
		add_filter('acf/settings/current_language', array(&$this, 'cl_acf_set_language'), 100);
	  }
	}
	

	function cl_acf_set_language() 
	{
	  return acf_get_setting('default_language');
	}
}
?>