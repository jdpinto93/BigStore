<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::cart_header() );

?>

<div class="xoo-wsch-top">

	<?php if( $showNotifications ): ?>
		<?php xoo_wsc_cart()->print_notices_html( 'cart' ); ?>
	<?php endif; ?>

	<?php if( $showBasket ): ?>
		<div class="xoo-wsch-basket">
			<span class="xoo-wscb-icon xoo-wsc-icon-bag2"></span>
			<span class="xoo-wscb-count"><?php echo xoo_wsc_cart()->get_cart_count() ?></span>
		</div>
	<?php endif; ?>

	<?php if( $heading ): ?>
		<span class="xoo-wsch-text"><?php echo $heading ?></span>
	<?php endif; ?>

	<?php if( $showCloseIcon ): ?>
		<span class="xoo-wsch-close <?php echo  $close_icon ?>"></span>
	<?php endif; ?>

</div>

<?php xoo_wsc_helper()->get_template( 'global/header/shipping-bar.php' ) ?>