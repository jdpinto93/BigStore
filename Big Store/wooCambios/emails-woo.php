<?php

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

// Nuevo estado de pedidos --> Calificacion de pedidos

function add_shipping_progress_to_order_statuses( $order_statuses ) {
    $new_order_statuses = array();
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[ $key ] = $status;
        if ( 'wc-completed' === $key ) {
            $new_order_statuses['wc-shipping-progress'] = 'Por Calificar';
        }
    }
    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'add_shipping_progress_to_order_statuses' );

// Agregamos correo al nuevo estado de pedido --> "Por Calificar"

function email_shipping_notification( $order_id, $checkout=null ) {
   global $woocommerce;
   $order = new WC_Order( $order_id );
   //error_log( $order->status );
   if($order->status === 'shipping-progress' ) {
      // Mensaje del email.
      $mailer 		= $woocommerce->mailer();
      $message_body = __( '¡Gracias por tu compra¡ esperamos que te guste!  Si es así, ¿considerarías publicar una reseña en línea? Esto nos ayuda a seguir brindando excelentes productos y ayuda a los compradores potenciales a tomar decisiones confiables. 🙏.
¿Podría? Dejarnos un comentario sobre su experiencia de compra en Facebook o Google  

Google: https://g.page/r/CSsGtczHG8DXEB0/review 

Facebook: https://www.facebook.com/BigcomOficial/reviews/?ref=page_internal

¡Muchas gracias!, disfruta tus productos', 'text_domain'  );

      $message 		= $mailer->wrap_message(
      // Mensaje en header.
      sprintf( __( 'Bigcom, Power Deal.', 'text_domain'  ), $order->get_order_number() ), $message_body );
      // Asunto del mensaje.
	  $result = $mailer->send( $order->billing_email, sprintf( __( 'Es nuestra prioridad darte la mejor atencion.', 'text_domain'  ), $order->get_order_number() ), $message );
	  //error_log( $result );
	}
}
add_action( 'woocommerce_order_status_changed', 'email_shipping_notification');