<?php
 /**
 * Plugin Name:       Big Store
 * Plugin URI:        http://www.webmasteryagency.com
 * Description:       Estructura de la eCommerce Bigcom ajustada a Woocommerce, Este plugins registra todos los campos necesarios para que Bigcom pueda funcionar de forma optima.
 * Version:           1.1.9
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

// Inicia Modulos de Bigcom

add_action('init', 'add_module_bigcom');
function add_module_bigcom(){

    if ( get_field( '_check__whatsapp', 'option' ) == 1 ) :
        //Crea Pagina de Opciones de WhatsApp
        require(Woo_Big_RUTA . '/includes/panelBigcom/optionsWhatsApp.php');
        // Agrega Boton para mensaje al WhatsApp desde las Ordenes de Woocommerce
        require(Woo_Big_RUTA.'/WooWhatsApp/wc-whatsapp.php');
    endif;

    if ( get_field( '_check__merchant_id', 'option' ) == 1 ) :
// Agrega apartado para añadir el codigo de google reviews para valoraciones de clientes por emails
        require(Woo_Big_RUTA.'/GoogleReviews/google-customer-reviews.php');
    endif;

    if ( get_field( '_check__flies_upload', 'option' ) == 1 ) :
        // Permite Añadir un boton para subir el comprobante de pago al finalizar la compra o en mi cuenta
        require(Woo_Big_RUTA.'/files-upload/files-upload.php');
    endif;

    if ( get_field( '_check__bac_duplicator', 'option' ) == 1 ) :
        // Permite duplicar la funcionalidad de pago por transferencia bancaria en woocommerce
        require(Woo_Big_RUTA.'/multi-bank-transfer/bank-transfer.php');
    endif;

    if ( get_field( '_check__personalizador', 'option' ) == 1 ) :
        // Crea un menu para controlar el texto de los botones de woocommerce
        require(Woo_Big_RUTA.'/EdidTextWoo/EdidTextWoo.php');
    endif;

}

// Incluye Archivos Externos

// Permite a los usuarios Agregar Varias direcciones al momento de Pagar
include(Woo_Big_RUTA.'/multipleAddresses/multipleAddresses.php');

//Crea un metodo de envios para Woocommerce BigExpress
include(Woo_Big_RUTA.'/wooCambios/woocommerce/envios/envios.php');

// Crea un menu para controlar el texto de los botones de woocommerce
include(Woo_Big_RUTA.'/email-template-customizer/email-template-customizer.php');

// Agrega la funcionalidad para modificar el formulario de pago de woocommerce
include(Woo_Big_RUTA.'/field-editor/field-editor.php');

// Agrega el carrito laterañ de woocommerce en el frontend
include(Woo_Big_RUTA.'/side-cart/cart-main.php');

//Crea campos y ajustes para los productos de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/config.php');

// Configuracion de correos en el area de pedidos
include(Woo_Big_RUTA.'/wooCambios/woocommerce/emails/emails-config-woo.php');

// Crea el menu de opciones para el panel de administracion de Bigcom
include(Woo_Big_RUTA.'/includes/adminMenu.php');

// Crea un menu para controlar el estatus de las ordenes de pedido
include(Woo_Big_RUTA.'/order-status-manager/woocommerce-order-status-manager.php');

// Editar el PHP De bigcom desde el Plugin de estructura
include(Woo_Big_RUTA.'/assetesFront/functions.php');


//  Enqueue Scripts and Styles

function styele_proyect_main(){
    if (is_user_logged_in()) {
        wp_enqueue_style('style-proyect', Woo_Big_URL . '/assets/style.css', array(), time(), 'all');
        wp_enqueue_script( 'javascript_proyect', Woo_Big_URL . 'assets/main.js', array( 'jquery' ), true );
    }
}
add_action('admin_enqueue_scripts', 'styele_proyect_main');

//  Enqueue Scripts and Styles Frontend


function styele_proyect_front(){
	
    wp_enqueue_style( 'style-proyect-front', Woo_Big_URL .'/assetesFront/styleFront.css', false, '1.2.1');
    
    wp_enqueue_script( 'javascript-proyect-front', Woo_Big_URL.'/assetesFront/mainFront.js', array ( 'jquery' ), 1.2, true);

}
add_action('wp_enqueue_scripts', 'styele_proyect_front');

//Oculta los menu de administracion para limpiar el escritorio

function remove_menus(){
    remove_menu_page( 'edit-comments.php' );        //Comentarios
	remove_menu_page( 'upload.php' );                 //Media
    remove_menu_page( 'themes.php' );               //Appearance
    remove_menu_page( 'plugins.php' );              //Plugins
    remove_menu_page( 'users.php' );                //Users
    remove_menu_page( 'edit.php' );                 //Entradas
    remove_menu_page( 'tools.php' );                //Herramientas
    remove_menu_page( 'options-general.php' );      //Ajustes
 //   remove_menu_page( 'edit.php?post_type=page' );  //Paginas
  }
add_action( 'admin_menu', 'remove_menus' );