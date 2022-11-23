<?php


defined( 'ABSPATH' ) or exit;


echo $email_heading . "\n\n";

if ( $email_body_text ) {
	echo "\n\n" . $email_body_text . "\n\n";
}

echo "****************************************************\n\n";

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email );

/* translators: Placeholders: %s - order number */
echo sprintf( __( 'Order number: %s', 'woocommerce-order-status-manager' ), $order->get_order_number() ) . "\n";

if ( $date_created = $order->get_date_created() ) {

	/* translators: Placeholders: %s - order date */
	echo sprintf( __( 'Order date: %s', 'woocommerce-order-status-manager' ), date_i18n( wc_date_format(), $date_created->getTimestamp() ) ) . "\n";
}

do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

echo "\n";

$email_order_items = array(
	'show_download_links' => $show_download_links,
	'show_sku'            => false,
	'show_purchase_note'  => $show_purchase_note,
	'plain_text'          => true
);

echo wc_get_email_order_items( $order, $email_order_items );

echo "----------\n\n";

if ( $totals = $order->get_order_item_totals() ) {
	foreach ( $totals as $total ) {
		echo $total['label'] . "\t " . $total['value'] . "\n";
	}
}

echo "\n****************************************************\n\n";

do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email );

echo esc_html__( 'Your details', 'woocommerce-order-status-manager' ) . "\n\n";

if ( $billing_email = $order->get_billing_email() ) {
	echo esc_html__( 'Email:', 'woocommerce-order-status-manager' ); echo $billing_email . "\n";
}

if ( $billing_phone = $order->get_billing_phone() ) {
	echo esc_html__( 'Tel:', 'woocommerce-order-status-manager' ); ?> <?php echo $billing_phone . "\n";
}

wc_get_template( 'emails/plain/email-addresses.php', array( 'order' => $order ) );

echo "\n****************************************************\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
