<?php

if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Ajustes Bigcom',
        'menu_title'    => 'settings',
        'menu_slug'     => 'bigcom-general-settings',
        'capability'    => 'manage_options',
        'parent_slug'	=> 'options-general.php',
        'update_button' => __('Guardar Cambios', 'acf'),
        'updated_message' => __("Datos Guardados", 'acf'),
        'redirect'      => false
    ));
}
?>