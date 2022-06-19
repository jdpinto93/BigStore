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

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

define('RAI_RUTA',plugin_dir_path(__FILE__));


// Archivos Externos

// Incluye los post para la informacion de las bodegas
include(RAI_RUTA.'/Bodegas/bodegas.php');

// Incluye los campos de informacion para bodegas
include(RAI_RUTA.'/Bodegas/campos-bodegas.php');

// Incluye metodo de envio para woocommerce
include(RAI_RUTA.'/Envios/envios.php');

//Crea campos para los productos de woocommerce
include(RAI_RUTA.'/wooCambios/campos-productos.php');

// Registra la taxonomia "marca" a los productos de woocommerce
include(RAI_RUTA.'/wooCambios/pwb-brand.php');

// Registra los cambios en la modalidad de correos de woocommerce
include(RAI_RUTA.'/wooCambios/emails-woo.php');

// Registra los cambios en la modalidad de correos de woocommerce
include(RAI_RUTA.'/wooCambios/ajustesWoo.php');

// Agrega el campo de Gtin al inventario de Woocommerce
include(RAI_RUTA.'/wooCambios/gtin/gtin.php');

// Agrega el campo de UPC al inventario de Woocommerce
include(RAI_RUTA.'/wooCambios/upc/upc.php');

// Agrega el campo de MPN al inventario de Woocommerce
include(RAI_RUTA.'/wooCambios/mpn/mpn.php');

// Agrega el campo de EAN al inventario de Woocommerce
include(RAI_RUTA.'/wooCambios/ean/ean.php');