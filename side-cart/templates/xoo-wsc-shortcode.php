<?php

if ( ! defined( 'ABSPATH' ) || !WC() || !WC()->cart ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::cart_shortcode() );

?>


<div class="xoo-wsc-sc-cont">
	<div class="xoo-wsc-cart-trigger">

		<span class="xoo-wsc-sc-count"><?php echo xoo_wsc_cart()->get_cart_count() ?></span>

		<?php if( $customBasketIcon ): ?>
			<span class="xoo-wsc-sc-bki"><img src="<?php echo $customBasketIcon ?>"></span>
		<?php else: ?>
			<span class="xoo-wsc-sc-bki <?php echo $basketIcon ?>"></span>
		<?php endif; ?>

		<span class="xoo-wsc-sc-subt">
			<?php echo WC()->cart->get_cart_subtotal() ?>
		</span>

		<?php do_action( 'xoo_wsc_cart_shortcode_content' ); ?>

	</div>
</div>