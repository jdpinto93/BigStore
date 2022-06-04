<?php
 
/**
 * Plugin Name: Big Store
 * Plugin URI: http://www.webmasteryagency.com
 * Description: Método de envío personalizado para WooCommerce y bigcom.com.mx Poer Deal
 * Version: 1.0.0
 * Author: Jose Pinto
 * Domain Path: /lang
 * Text Domain: BigExpress
 */

define('RAI_RUTA',plugin_dir_path(__FILE__));
define('RAI_NOMBRE','Big Store');

// Archivos Externos

// Incluye los post para la informacion de las bodegas
include(RAI_RUTA.'/Bodegas/bodegas.php');

// Incluye los campos de informacion para bodegas
include(RAI_RUTA.'/Bodegas/campos-bodegas.php');

// Incluye metodo de envio para woocommerce
include(RAI_RUTA.'/envios/envios.php');

//Crea campos para los productos de woocommerce
include(RAI_RUTA.'/productos/campos-productos.php');

// Registra la taxonomia "marca" a los productos de woocommerce
include(RAI_RUTA.'/productos/pwb-brand.php');
