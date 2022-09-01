<?php
 /**
 * Plugin Name:       Big Store
 * Plugin URI:        http://www.webmasteryagency.com
 * Description:       Estructura de la eCommerce Bigcom ajustada a Woocommerce, Este plugins registra todos los campos necesarios para que Bigcom pueda funcionar de forma optima.
 * Version:           1.1.1
 * Requires at least: 5.2
 * Requires PHP:      7.2.2
 * Author:            Jose Pinto
 * Author URI:        http://www.webmasteryagency.com
 * License:           GPL v3 or later
 * Domain Path: /lang
 * Text Domain: BigExpress
 */

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

//Aqui se definen las constantes

define('Woo_Big_RUTA',plugin_dir_path(__FILE__));
define( 'Woo_Big_URL', plugin_dir_url( __FILE__ ) );

// Archivos Externos

// Incluye metodo de envio para woocommerce
include(Woo_Big_RUTA.'/Envios/envios.php');

//Crea campos para los productos de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/config.php');

// Configuracion de correos en el area de pedidos
include(Woo_Big_RUTA.'/wooCambios/woocommerce/templates/emails-config-woo.php');

// Agrega Boton para mensaje al WhatsApp desde las Ordenes de Woocommerce
include(Woo_Big_RUTA.'/WooWhatsApp/wc-whatsapp.php');

// Agrega apartado para añadir el codigo de google reviews para valoraciones de clientes por emails
include(Woo_Big_RUTA.'/GoogleReviews/google-customer-reviews.php');

// Agrega la ventana modal del carrito de woocommerce en el frontend
include(Woo_Big_RUTA.'/CartPopup/jp-cp-main.php');

// Crea el menu de opciones
include(Woo_Big_RUTA.'/includes/adminMenu.php');


//  Enqueue Scripts and Styles

function styele_proyect_main(){
    if (is_user_logged_in()) {
        wp_enqueue_style('style-proyect', Woo_Big_URL . '/assets/style.css', array(), time(), 'all');
        wp_enqueue_script( 'javascript_proyect', Woo_Big_URL . 'assets/main.js', array( 'jquery' ), true );
    }
}
add_action('admin_enqueue_scripts', 'styele_proyect_main');