<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::footer_totals() );

?>

<?php if( WC()->cart->is_empty() ) return; ?>

<div class="xoo-wsc-ft-totals">
	<?php foreach( $totals as $key => $data ): ?>
		<div class="xoo-wsc-ft-amt xoo-wsc-ft-amt-<?php echo $key; ?> <?php echo isset( $data['action'] ) ? $data['action'] : '' ?>">
			<span class="xoo-wsc-ft-amt-label"><?php echo $data['label'] ?></span>
			<span class="xoo-wsc-ft-amt-value"><?php echo $data['value'] ?></span>
		</div>
	<?php endforeach; ?>

	<?php do_action( 'xoo_wsc_totals_end' ); ?>

</div>