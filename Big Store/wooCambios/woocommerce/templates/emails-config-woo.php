<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

//Desvincula el email de nuevo pedido de los CRON --> On Hold
add_filter( 'woocommerce_defer_transactional_emails', '__return_false' );

// borra estado de pedido Pending payment

function misha_change_statuses_order( $wc_statuses_arr ){
	$new_statuses_arr = array(
		'wc-on-hold' => $wc_statuses_arr['wc-on-hold'], // 7
		'wc-processing' => $wc_statuses_arr['wc-processing'], // 1
		'wc-completed' => $wc_statuses_arr['wc-completed'], // 2
		'wc-failed' => $wc_statuses_arr['wc-failed'], // 5
		'wc-cancelled' => $wc_statuses_arr['wc-cancelled'], // 3
		'wc-refunded' => $wc_statuses_arr['wc-refunded'], // 4
	);
return $new_statuses_arr;
}
add_filter( 'wc_order_statuses', 'misha_change_statuses_order' );

//Copiar el email de fallido y cancelado al cliente
function send_custom_email_notifications( $order_id, $old_status, $new_status, $order ){
    if ( $new_status == 'cancelled' || $new_status == 'failed' ){
        $wc_emails = WC()->mailer()->get_emails(); // Get all WC_emails objects instances
        $customer_email = $order->get_billing_email(); // The customer email
    }

    if ( $new_status == 'cancelled' ) {
        // change the recipient of this instance
        $wc_emails['WC_Email_Cancelled_Order']->recipient = $customer_email;
        // Sending the email from this instance
        $wc_emails['WC_Email_Cancelled_Order']->trigger( $order_id );
    } 
    elseif ( $new_status == 'failed' ) {
        // change the recipient of this instance
        $wc_emails['WC_Email_Failed_Order']->recipient = $customer_email;
        // Sending the email from this instance
        $wc_emails['WC_Email_Failed_Order']->trigger( $order_id );
    } 
}
add_action('woocommerce_order_status_changed', 'send_custom_email_notifications', 10, 4 );

// Cambiar nombres de los estados de pedido

function ts_rename_order_status_msg( $order_statuses ) {

$order_statuses['wc-completed'] = _x( 'Pedido Enviado', 'Order status', 'woocommerce' );

$order_statuses['wc-processing'] = _x( 'Procesando Pedido', 'Order status', 'woocommerce' );

$order_statuses['wc-on-hold'] = _x( 'Validando Pago', 'Order status', 'woocommerce' );

$order_statuses['wc-failed'] = _x( 'Pedido Fallido', 'Order status', 'woocommerce' );
	
$order_statuses['wc-cancelled'] = _x( 'Pedido Cancelado', 'Order status', 'woocommerce' );

$order_statuses['wc-refunded'] = _x( 'Pedido Reembolsado', 'Order status', 'woocommerce' );
return $order_statuses;
}
add_filter( 'wc_order_statuses', 'ts_rename_order_status_msg', 20, 1 );

//Crear un nuevo estado para los pedidos de WooCommerce

// Añadir nuevos estados a un pedido en Woocommerce, por ejemplo: completado
// Registrar Estado del pedido completado - hello-elementor es el text_domain

function wpex_wc_register_post_statuses_completado() {
    register_post_status( 'wc-order-sent', array(
    'label' => _x( 'Completado', 'WooCommerce Order status', 'hello-elementor' ),
    'public' => true,
    'exclude_from_search' => false,
    'show_in_admin_all_list' => true,
    'show_in_admin_status_list' => true,
    'label_count' => _n_noop( 'Completado (%s)', 'Completado (%s)', 'hello-elementor' )
    ) );
    }
    add_filter( 'init', 'wpex_wc_register_post_statuses_completado' );
    
    // Añadir Estado del pedido Completado a WooCommerce
    function wpex_wc_add_order_statuses_completado( $order_statuses ) {
    $order_statuses['wc-order-sent'] = _x( 'Completado', 'WooCommerce Order status', 'hello-elementor' );
    return $order_statuses;
    }
    add_filter( 'wc_order_statuses', 'wpex_wc_add_order_statuses_completado' );
    
    // Email que se envía cuando el estado del pedido está en Completado
    
    function email_shipping_notification( $order_id, $checkout=null ) {
    global $woocommerce;
    
    $order = new WC_Order( $order_id );
    
    //error_log( $order->status );
    
    if($order->status === 'order-sent' ) {
    
    // Mensaje del email.
    $mailer = $woocommerce->mailer();
    
    $message_body = __( '¡Gracias por tu compra¡ esperamos que te guste!  Si es así, ¿considerarías publicar una reseña en línea? Esto nos ayuda a seguir brindando excelentes productos y ayuda a los compradores potenciales a tomar decisiones confiables. 🙏.
    ¿Podría? Dejarnos un comentario sobre su experiencia de compra en Facebook o Google  
    
    Google: https://g.page/r/CSsGtczHG8DXEB0/review 
    
    Facebook: https://www.facebook.com/BigcomOficial/reviews/?ref=page_internal
    
    ¡Muchas gracias!, disfruta tus productos', 'hello-elementor' );
    
    $message = $mailer->wrap_message(
    // Mensaje en header.
    sprintf( __( 'Su pedido ha sido completado', 'hello-elementor' ), $order->get_order_number() ), $message_body );
    
    // Asunto del mensaje.
    $result = $mailer->send( $order->billing_email, sprintf( __( 'Su pedido ha sido completado desde Catando Vino', 'text_domain' ), $order->get_order_number() ), $message );
    
    //error_log( $result );
    }
    
    }
    add_action( 'woocommerce_order_status_changed', 'email_shipping_notification');