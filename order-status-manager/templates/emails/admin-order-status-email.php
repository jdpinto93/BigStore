<?php


defined( 'ABSPATH' ) or exit;


?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php if ( $email_body_text ) : ?>
	<div id="body_text"><?php echo $email_body_text; ?></div>
<?php endif; ?>

<?php do_action( 'woocommerce_email_before_order_table', $order, true, false, $email ); ?>

<h2>
	<a href="<?php echo admin_url( 'post.php?post=' . $order->get_id() . '&action=edit' ); ?>">
		<?php /* translators: Placeholders: %s - order number */
		printf( __( 'Order: %s', 'woocommerce-order-status-manager' ), $order->get_order_number() ); ?>
	</a>

	<?php if ( $date_created = $order->get_date_created() ) : ?>
		(<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', $date_created->getTimestamp() ), date_i18n( wc_date_format(), $date_created->getTimestamp() ) ); ?>)
	<?php endif; ?>

</h2>

<table class="td" cellspacing="0" cellpadding="6" style="width: 100%;" border="1">
	<thead>
		<tr>
			<th class="td" scope="col" style="text-align: left;"><?php esc_html_e( 'Product', 'woocommerce-order-status-manager' ); ?></th>
			<th class="td" scope="col" style="text-align: left;"><?php esc_html_e( 'Quantity', 'woocommerce-order-status-manager' ); ?></th>
			<th class="td" scope="col" style="text-align: left;"><?php esc_html_e( 'Price', 'woocommerce-order-status-manager' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php

		$email_order_items = array(
			'show_sku' => true,
		);

		echo wc_get_email_order_items( $order, $email_order_items );

		?>
	</tbody>
	<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				foreach ( $totals as $total ) {
					$i++;
					?><tr>
						<th class="td" scope="row" colspan="2" style="text-align: left; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['label']; ?></th>
						<td class="td" style="text-align: left; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['value']; ?></td>
					</tr><?php
				}
			}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_email_after_order_table', $order, true, false, $email ); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, true, false, $email ); ?>

<h2><?php esc_html_e( 'Customer details', 'woocommerce-order-status-manager' ); ?></h2>

<?php if ( $billing_email = $order->get_billing_email() ) : ?>
	<p><strong><?php esc_html_e( 'Email:', 'woocommerce-order-status-manager' ); ?></strong> <?php echo $billing_email; ?></p>
<?php endif; ?>

<?php if ( $billing_phone = $order->get_billing_phone() ) : ?>
	<p><strong><?php esc_html_e( 'Tel:', 'woocommerce-order-status-manager' ); ?></strong> <?php echo $billing_phone; ?></p>
<?php endif; ?>

<?php wc_get_template( 'emails/email-addresses.php', array( 'order' => $order ) ); ?>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
