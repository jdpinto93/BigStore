<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

// Agrega la taxonomia "Bodega" al producto de woocommerce
include(RAI_RUTA.'/wooCambios/woocommerce/productos/bodegas/bodegas.php');

// Agrega el campo del ean al inventario de woocommerce
include(RAI_RUTA.'/wooCambios/woocommerce/productos/ean/ean.php');

// Agrega el campo de mpn al producto de woocommerce
include(RAI_RUTA.'/wooCambios/woocommerce/productos/mpn/mpn.php');

// Agrega el campo de upc al inventario de woocommerce
include(RAI_RUTA.'/wooCambios/woocommerce/productos/upc/upc.php');

// Agrega la taxonomia de las marcas al campo de woocommerce
include(RAI_RUTA.'/wooCambios/woocommerce/productos/marcas/marca-producto.php');

// Agrega la taxonomia de los proveedores al producto de woocommerce
include(RAI_RUTA.'/wooCambios/woocommerce/productos/proveedores/proveedores.php');

//Cambiar texto "Add to cart" de WooCommerce

// Para cambiarlo en la single
function woocommerce_custom_single_add_to_cart_text(){
     return __('Comprar', 'woocommerce');
}
add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text');

// Para cambiarlo en el archive
function woocommerce_custom_product_add_to_cart_text(){
     return __('Comprar', 'woocommerce');
}
add_filter('woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text');

//AÑADIMOS NUESTRO CAMPO PRECIO DE COSTO
function wc_cost_product_field(){
     woocommerce_wp_text_input(array('id' => '_cost', 'class' => 'wc_input_price short', 'label' => __('Precio de Costo', 'woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')'));
}
add_action('woocommerce_product_options_pricing', 'wc_cost_product_field');

//GUARDAMOS EL NUEVO VALOR DEL CAMPO PRECIO DE COSTO

function wc_cost_save_product($product_id)
{
     if (wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce'))         return;
     if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)         return;
     if (isset($_POST['_cost'])) {
          if (is_numeric($_POST['_cost']))             update_post_meta($product_id, '_cost', $_POST['_cost']);
     } else delete_post_meta($product_id, '_cost');
}
add_action('save_post', 'wc_cost_save_product');