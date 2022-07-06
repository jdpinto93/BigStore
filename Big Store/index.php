<?php
 /**
 * Plugin Name:       Big Store
 * Plugin URI:        http://www.webmasteryagency.com
 * Description:       Estructura de la eCommerce Bigcom ajustada a Woocommerce, Este plugins registra todos los campos necesarios para que Bigcom pueda funcionar de forma optima.
 * Version:           1.0.7
 * Requires at least: 5.2
 * Requires PHP:      7.4.2
 * Author:            Jose Pinto
 * Author URI:        http://www.webmasteryagency.com
 * License:           GPL v3 or later
 * Domain Path: /lang
 * Text Domain: BigExpress
 */

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

define('RAI_RUTA',plugin_dir_path(__FILE__));

// Plugin URL
define( 'Woo_Big_URL', plugin_dir_url( __FILE__ ) );


// Archivos Externos

// Incluye metodo de envio para woocommerce
include(RAI_RUTA.'/Envios/envios.php');

//Crea campos para los productos de woocommerce
include(RAI_RUTA.'/wooCambios/woocommerce/productos/config.php');

// Configuracion de correos en el area de pedidos
include(RAI_RUTA.'/wooCambios/woocommerce/templates/emails-config-woo.php');

// Agrega Boton para mensaje al WhatsApp desde las Ordenes de Woocommerce
include(RAI_RUTA.'/WooWhatsApp/wc-whatsapp.php');

// Agrega apartado para añadir el codigo de google reviews para valoraciones de clientes por emails
include(RAI_RUTA.'/GoogleReviews/google-customer-reviews.php');

// Agrega la ventana modal del carrito de woocommerce en el frontend
include(RAI_RUTA.'/CartPopup/jp-cp-main.php');