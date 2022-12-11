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
    $pedido_enviado = get_field( 'msj_pedido_enviado', 'option' );
    $validando_pago = get_field( 'msj_validando_pago', 'option' );
    $pedido_fallido = get_field( 'msj_pedido_fallido', 'option' );
    $procesando_pedido = get_field( 'msj_procesando_pedido', 'option' );
    $pedido_completado = get_field( 'msj_pedido_completado', 'option' );
    $pedido_cancelado = get_field( 'msj_pedido_cancelado', 'option' );
    $cod_area = get_field( 'codigo_de_area', 'option' );

    if (isset($number_clients)) {
        //take the number for order with invitates
        $pedido = $order_id->get_id();
        $number_invitates = $order_id->get_billing_phone();
        $result = $number_invitates;
    } else {
        $result = $number_clients;
    }
    $text_validando_pago = "Pedido Nro.$pedido, $first_name $last_name. $validando_pago.";
    $text_procesando_pedido = "Pedido Nro.$pedido, $first_name $last_name. $procesando_pedido.";
    $text_pedido_enviado = "Pedido Nro.$pedido, $first_name $last_name. $pedido_enviado";
    $text_pedido_completado = "Pedido Nro.$pedido, $first_name $last_name. $pedido_completado.";
    $text_pedido_fallido = "Pedido Nro.$pedido, $first_name $last_name. $pedido_fallido.";
    $text_pedido_cancelado = "Pedido Nro.$pedido, $first_name $last_name. $pedido_cancelado.";

    
    
    
    ?>

<div>
<div>.</div>
	<p>Enviar WhatsApp:</p>
<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_validando_pago; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span>Validando</a>

<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_procesando_pedido; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span>Procesando</a>
</div>
<div>
<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_pedido_enviado; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span>Enviado</a>

<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_pedido_completado; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span>Completado</a>
</div>
<div>
<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_pedido_fallido; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span>Fallido</a>

<a id="whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area; ?><?php echo $result; ?>&text=<?php echo $text_pedido_cancelado; ?>"
    target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span>Cancelado</a>
</div>
<?php
}
add_action('woocommerce_admin_order_data_after_order_details', 'whatsapp_btn_in_order');

