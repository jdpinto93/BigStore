<?php

if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title' 	=> 'Ajustes de Mensajes deWhatsApp',
        'menu_title'	=> 'Ajestes de WhatsApp',
        'menu_slug' 	=> 'option-menu-whatsApp',
        'capability'	=> 'manage_options',
        'parent_slug'	=> 'options-general.php',
        'update_button' => __('Actualizar Mensajes', 'acf'),
        'updated_message' => __("Datos Guardados", 'acf'),
        'redirect'		=> false
    ));
}

?>