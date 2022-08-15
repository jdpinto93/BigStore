<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action('admin_menu', 'crear_menu');
function crear_menu() {

    add_menu_page('Admin', 'Admin Bigcom', 'manage_options', 'bigcom-panel', 'output_panel_bigcom', 'dashicons-admin-tools', '1');
}

function output_panel_bigcom() {
// Crea el menu de opciones de Datos
include(RAI_RUTA.'/includes/panelBigcom/panelBigcom.php');
}

// Crea el menu de opciones de whatsApp
include(RAI_RUTA.'/includes/subMenus/whatsApp.php');
