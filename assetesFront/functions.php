<?php
//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

/*
 * Remove product data tabs
 */

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

		//unset( $tabs['description'] );      	// Remove the description tab
		unset( $tabs['reviews'] ); 			// Remove the reviews tab
		unset( $tabs['additional_information'] );  	// Remove the additional information tab
    return $tabs;
}


/*
 * Funcion de iconos para medios de pagos
 */

add_filter('woocommerce_gateway_icon', function ($contenido, $id) {
    if ('bacs' == $id)
      //  return '<img src="https://i.postimg.cc/Zn9XpD7R/banco-santander.png" alt="Pago con transferencia">';
    return $contenido;
}, 10, 2);

add_filter('woocommerce_gateway_icon', function ($contenido, $id) {
    if ('cod' == $id)
     //   return '<img src="https://i.postimg.cc/cHhR5ZYW/Atrato-full-color-png-removebg-preview.png" alt="Pago con atrato">';
    return $contenido;
}, 10, 2);

add_filter('woocommerce_gateway_icon', function ($contenido, $id) {

    if ('bank_transfer_1' == $id)
      //  return '<img src="https://i.postimg.cc/h4VkckDq/log-efectivo.jpg" alt="Pago con reserve">';
    return $contenido;
}, 10, 2);

/*************************************************************************************
 * Add a custom product data tab
 *
 */
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
	
	// Adds the new tab
	
	$tabs['test_tab'] = array(
		'title' 	=> __( 'Informacion Tecnica', 'woocommerce' ),
		'priority' 	=> 20,
		'callback' 	=> 'ficha_tecnica'
	);
	$tabs['test_tab2'] = array(
		'title' 	=> __( '¿Porque Comprar?', 'woocommerce' ),
		'priority' 	=> 30,
		'callback' 	=> '_porque_comprar'

	);
	    if(empty(get_field('__ficha_product'))){
			unset( $tabs['test_tab'] );
		}elseif(empty(get_field('__reazon_to_buy_product'))){
			unset( $tabs['test_tab2'] );
		}else{
			return $tabs;
		}
}

function doc_product_pdf(){
	
    // only on the product page
    if ( ! is_product() ) {
        return;
    }
	
    global $product;
	
	$pfgProductic = get_field('__document_products');
	
	if(!empty($pfgProductic)){
		echo '<h2>Documentos del Producto</h2>';
		echo $pfgProductic;	
	}else{
		echo '<style>#elementor-tab-title-2224{display: none!important;}</style>';
		echo '<style>#elementor-tab-content-2224{display: none!important;}</style>';
	}
}

add_shortcode('short_pdf_product', 'doc_product_pdf');

function doc_product_video(){
	
    // only on the product page
    if ( ! is_product() ) {
        return;
    }
	
    global $product;
	
	$videoProductic = get_field('__videos_product');
	
	if(!empty($videoProductic)){
		echo '<h2>Videos del Producto</h2>';
		echo $videoProductic;	
	}else{
		echo '<style>#elementor-tab-title-2225{display: none!important;}</style>';
		echo '<style>#elementor-tab-content-2225{display: none!important;}</style>';
	}
}

add_shortcode('short_video_product', 'doc_product_video');

function doc_reviews_ic(){
	
    // only on the product page
    if ( ! is_product() ) {
        return;
    }
	
    global $product;
	
	$reviewsProductic = get_field('__reviews_product');
	
	if(!empty($reviewsProductic)){
		echo '<h2>Opiniones del Producto</h2>';
		echo $reviewsProductic;	
	}else{
		echo '<style>#elementor-tab-title-2226{display: none!important;}</style>';
		echo '<style>#elementor-tab-content-2226{display: none!important;}</style>';
	}
}

add_shortcode('short_reviews_product', 'doc_reviews_ic');

function ficha_tecnica( ){
   
    // only on the product page
    if ( ! is_product() ) {
        return;
    }
	
    global $product;
	
	$fichaProductic = get_field('__ficha_product');

	if(!empty($fichaProductic)){
		echo '<h2>Información Técnica</h2>';
		echo $fichaProductic;
	}else{
		echo '<style>#elementor-tab-title-2222{display: none!important;}</style>';
		echo '<style>#elementor-tab-content-2222{display: none!important;}</style>';
	}
}
add_shortcode('short_ficha_tecnica', 'ficha_tecnica');

function _porque_comprar(){

    // only on the product page
    if ( ! is_product() ) {
        return;
    }
	
    global $product;
	
	$reazonToBuy = get_field('__reazon_to_buy_product');
	
	if(!empty($reazonToBuy)){
		echo '<h2>¿Porque Comprar?</h2>';
		echo $reazonToBuy;
	}else{
		echo '<style>#elementor-tab-title-2223{display: none!important;}</style>';
		echo '<style>#elementor-tab-content-2223{display: none!important;}</style>';
	}
}

add_shortcode( 'short_porque_comprar', '_porque_comprar' );

function display_custom_product_description( $atts ){

    // only on the product page
    if ( ! is_product() ) {
        return;
    }

    $atts = shortcode_atts( array(
        'id' => get_the_id(),
    ), $atts, 'custom_product_description' );

    global $product;

    if ( ! is_a( $product, 'WC_Product') )
        $product = wc_get_product($atts['id']);

    return $product->get_description();
}

add_shortcode( 'description_product_data', 'display_custom_product_description' );

/*
 * Desvincular el email de nuevo pedido de los CRON
 */

add_filter( 'woocommerce_defer_transactional_emails', '__return_false' );

/*
 * Modificar mensaje del footer
 */

function remove_footer_admin (){
    echo '<span id="footer-thankyou">Derechos Reservados <a href="https://bigcom.com.mx/" target="_blank">Bigcom</a></span>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

/*
 * Eliminar el logo nativo de wordpress
 */

function example_admin_bar_remove_logo() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'wp-logo' );
}
add_action( 'wp_before_admin_bar_render', 'example_admin_bar_remove_logo', 0 );

/*
 * Marcar el checkbox de envio de direccion permanentemente.
 */

add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );

function preloader_gift() {
		if( is_shop()){
		?><div class="preloader">
				<div>
					<p><img src="http://localhost/storeBigcom/wp-content/uploads/2022/11/75400-shopping-bag.gif" /></p>
				</div>
		</div><?php
			}elseif(is_tax()){
		?><div class="preloader">
				<div>
					<p><img src="http://localhost/storeBigcom/wp-content/uploads/2022/11/75400-shopping-bag.gif" /></p>
				</div>
		</div><?php
	}
}
add_action( 'wp_head', 'preloader_gift' );