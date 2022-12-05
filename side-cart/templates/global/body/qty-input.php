<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="xoo-wsc-qty-box xoo-wsc-qtb-<?php echo $qtyDesign ?>">

	<?php do_action( 'xoo_wsc_before_quantity_input_field' ); ?>

	<span class="xoo-wsc-minus xoo-wsc-chng">-</span>

	<input
		type="number"
		class="<?php echo esc_attr( join( ' ', (array) $wsc_classes ) ); ?>"
		step="<?php echo esc_attr( $step ); ?>"
		min="<?php echo esc_attr( $min_value ); ?>"
		max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
		value="<?php echo esc_attr( $quantity ); ?>"
		placeholder="<?php echo esc_attr( $placeholder ); ?>"
		inputmode="<?php echo esc_attr( $inputmode ); ?>" />

	<?php do_action( 'xoo_wsc_after_quantity_input_field' ); ?>

	<span class="xoo-wsc-plus xoo-wsc-chng">+</span>

</div>