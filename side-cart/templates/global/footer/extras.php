<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::footer_extras() );

?>

<?php

//Empty cart link
if( $emptyCartLink && !WC()->cart->is_empty() ){
	echo '<span class="xoo-wsc-ecl">'.__( 'Empty Cart', 'side-cart-woocommerce' ).'</span>';
}

?>

<div class="xoo-wsc-ft-extras">

	<?php if( $showCoupon && !WC()->cart->is_empty() ): ?>

		<div class="xoo-wsc-ftx-row xoo-wsc-ftx-coupon">

			<span class="xoo-wsc-ftx-icon <?php echo $couponIcon; ?>"></span>

			<?php if( WC()->cart->get_coupons() ): ?>

				<div class="xoo-wsc-ftx-coups">
					<div>
						<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ): ?>
							<div class="xoo-wsc-remove-coupon" data-code="<?php echo $code ?>"><?php echo wc_cart_totals_coupon_label( $coupon ) ?><span class=" xoo-wsc-icon-cross"></span></div>
						<?php endforeach; ?>
					</div>
					<span class="xoo-wsc-toggle-slider" data-slider="coupon"><?php _e( 'Apply', 'side-cart-woocommerce' ); ?></span>
				</div>

			<?php else: ?>

				<span class="xoo-wsc-toggle-slider" data-slider="coupon"><?php _e( 'Have a Promo Code?', 'side-cart-woocommerce' ); ?></span>

			<?php endif; ?>

		</div>

	<?php endif; ?>

	<?php do_action( 'xoo_wsc_extras_content' ); ?>
	
</div>