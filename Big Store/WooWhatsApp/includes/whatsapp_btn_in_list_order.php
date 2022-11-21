<?php
/**
 * Prevent Data Leaks
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function add_whatsapp_btn_in_list_orders($order)
{
    $order->get_id();
    $number = $order->get_billing_phone();
    $first_name = $order->get_billing_first_name();
    $last_name = $order->get_billing_last_name();
    $mensaje_global = get_option( 'msj_global' );
    $cod_area = get_option( 'codigo_de_area' );
    $pedido = $order->get_id();

    $text_mensaje_global = "Pedido Nro.$pedido, $first_name $last_name. $mensaje_global.";
    ?>
<a id="whatsapp" class="" href="https://api.whatsapp.com/send?phone=<?php echo $cod_area ?><?php echo $number ?>&text=<?php echo $text_mensaje_global; ?>"
target="_blank" aria-label="WhatsApp"><span class="dashicons dashicons-whatsapp"></span> WhatsApp</a>
<?php
}
add_action('woocommerce_admin_order_actions_start', 'add_whatsapp_btn_in_list_orders');