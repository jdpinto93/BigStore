<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


extract( Xoo_Wsc_Template_Args::footer_buttons() );

do_action( 'xoo_wsc_before_footer_btns' );

$buttonHTML = '<a href="%1$s" class="%2$s">%3$s</a>';

?>
<div class="xoo-wsc-ft-buttons-cont">

	<?php foreach ( $buttons as $key => $button_data ){

		if( !$button_data['label'] ) continue;
		$button_data['class'][] = 'xoo-wsc-ft-btn-'.$key;

		printf(
			$buttonHTML,
			esc_attr( $button_data['url'] ),
			implode( ' ', $button_data['class'] ),
			esc_html( $button_data['label'] )
		);

	} ?>

</div>

<?php do_action( 'xoo_wsc_after_footer_btns' ); ?>

<div class="xoo-wsc-payment-btns">
	<?php do_action( 'xoo_wsc_payment_buttons' ); ?>
</div>