<?php 
class WCMCA_OptionPage
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
				'page_title' 	=> 'Ajustes a Campos de Varias direcciones para un cliente',
				'menu_title'	=> 'Direcciones',
				'menu_slug' 	=> 'wcmca-option-menu',
				'capability'	=> 'manage_options',
				'parent_slug'	=> 'options-general.php',
				'update_button' => __('Guardar', 'acf'),
				'redirect'		=> false
			));

			add_action( 'current_screen', array($this, 'cl_set_global_options_pages') );
			add_action( 'plugins_loaded', array($this, 'switch_language') );
		}
	}
	function switch_language()
	{
		if(wcmca_get_value_if_set($_GET, 'page', "") == 'acf-wcmca-option-menu')
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
		"woocommerce_page_acf-wcmca-option-menu"
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