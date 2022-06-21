<?php

//Cambiar texto "Add to cart" de WooCommerce

// Para cambiarlo en la single
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' );
function woocommerce_custom_single_add_to_cart_text() {
return __( 'Comprar', 'woocommerce' );
}

// Para cambiarlo en el archive
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );
function woocommerce_custom_product_add_to_cart_text() {
return __( 'Comprar', 'woocommerce' );
}


//AÑADIMOS NUESTRO CAMPO PRECIO DONACIÓN
     add_action( 'woocommerce_product_options_pricing', 'wc_cost_product_field' );
     function wc_cost_product_field() {
         woocommerce_wp_text_input( array( 'id' => '_cost', 'class' => 'wc_input_price short', 'label' => __( 'Costo', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')' ) );
     }

//GUARDAMOS EL NUEVO VALOR DEL CAMPO PRECIO DONACIÓN
     add_action( 'save_post', 'wc_cost_save_product' );
     function wc_cost_save_product( $product_id ) {
      if (wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce'))         return;     if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )         return;     if ( isset( $_POST['_cost'] ) ) {         if ( is_numeric( $_POST['_cost'] ) )             update_post_meta( $product_id, '_cost', $_POST['_cost'] );     } else delete_post_meta( $product_id, '_cost' ); }