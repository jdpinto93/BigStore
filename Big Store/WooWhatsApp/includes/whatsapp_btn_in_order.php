<?php
/**
 * Prevent Data Leaks
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function whatsapp_btn_in_order($order_id){
    $result;
    $customer_id = (int) $order_id->user_id;

    //Take the number for orders with clients
    $number_clients = get_user_meta($customer_id, 'billing_phone', true);
    $first_name = get_user_meta($customer_id, 'billing_first_name', true);
    $last_name = get_user_meta($customer_id, 'billing_last_name', true);
    $pedido_enviado = get_option( 'msj_pedido_enviado' );
    $validando_pago = get_option( 'msj_validando_pago' );
    $pedido_fallido = get_option( 'msj_pedido_fallido' );
    $procesando_pedido = get_option( 'msj_procesando_pedido' );
    $pedido_completado = get_option( 'msj_pedido_completado' );
    $pedido_cancelado = get_option( 'msj_pedido_cancelado' );
    $cod_area = get_option( 'codigo_de_area' );

    if (isset($number_clients)) {
        //take the number for order with invitates
        $order_id->get_id();
        $number_invitates = $order_id->get_billing_phone();
        $result = $number_invitates;
    } else {
        $result = $number_clients;
    }
    $text_validando_pago = "Hola $first_name $last_name. $validando_pago.";
    $text_procesando_pedido = "Hola $first_name $last_name. $procesando_pedido.";
    $text_pedido_enviado = "Hola $first_name $last_name. $pedido_enviado";
    $text_pedido_completado = "Hola $first_name $last_name. $pedido_completado.";
    $text_pedido_fallido = "Hola $first_name $last_name. $pedido_fallido.";
    $text_pedido_cancelado = "Hola $first_name $last_name. $pedido_cancelado.";

    
    
    
    ?>
<p>Enviar WhatsApp:</p>
<div>
<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_validando_pago; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span> Validando Pago</a>

<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_procesando_pedido; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span> Procesando Pedido</a>
</div>
<div>
<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_pedido_enviado; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span> Pedido Enviado</a>

<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_pedido_completado; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span> Pedido Completado</a>
</div>
<div>
<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_pedido_fallido; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span> Pedido Fallido</a>

<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_pedido_cancelado; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span> Pedido Cancelado</a>
</div>
<?php
}
add_action('woocommerce_admin_order_data_after_order_details', 'whatsapp_btn_in_order');

