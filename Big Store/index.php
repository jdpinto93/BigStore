<?php
 
/**
 * Plugin Name: Big Store
 * Plugin URI: http://www.webmasteryagency.com
 * Description: Método de envío personalizado para WooCommerce y bigcom.com.mx Poer Deal
 * Version: 1.0.2
 * Author: Jose Pinto
 * Domain Path: /lang
 * Text Domain: BigExpress
 */

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

define('RAI_RUTA',plugin_dir_path(__FILE__));


// Archivos Externos

// Incluye metodo de envio para woocommerce
include(RAI_RUTA.'/Envios/envios.php');

//Crea campos para los productos de woocommerce
include(RAI_RUTA.'/wooCambios/woocommerce/productos/config.php');

// Registra la taxonomia "marca" a los productos de woocommerce
include(RAI_RUTA.'/wooCambios/woocommerce/productos/marca-producto.php');

// Registra la taxonomia "marca" a los productos de woocommerce
include(RAI_RUTA.'/wooCambios/woocommerce/productos/bodegas.php');

// Registra la taxonomia "marca" a los productos de woocommerce
include(RAI_RUTA.'/wooCambios/woocommerce/productos/proveedores.php');

// Configuracion de correos en el area de pedidos
include(RAI_RUTA.'/wooCambios/woocommerce/templates/emails-config-woo.php');

// Agrega el campo de Gtin al inventario de Woocommerce
include(RAI_RUTA.'/wooCambios/gtin/gtin.php');

// Agrega el campo de UPC al inventario de Woocommerce
include(RAI_RUTA.'/wooCambios/upc/upc.php');

// Agrega el campo de MPN al inventario de Woocommerce
include(RAI_RUTA.'/wooCambios/mpn/mpn.php');

// Agrega el campo de EAN al inventario de Woocommerce
include(RAI_RUTA.'/wooCambios/ean/ean.php');

// Agrega Boton para mensaje al WhatsApp desde las Ordenes de Woocommerce
include(RAI_RUTA.'/WooWhatsApp/wc-whatsapp.php');

// Agrega apartado para añadir el codigo de google reviews para valoraciones de clientes por emails
include(RAI_RUTA.'/GoogleReviews/google-customer-reviews.php');

// Agrega la ventana modal del carrito de woocommerce en el frontend
include(RAI_RUTA.'/CartPopup/jp-cp-main.php');