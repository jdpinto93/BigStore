<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::shipping_bar() );

if( !$showBar || empty( $data ) ) return;

?>

<div class="xoo-wsc-ship-bar-cont">
	<span class="xoo-wsc-sb-txt"><?php echo $text; ?></span>
	<div class="xoo-wsc-sb-bar">
		<span style="width: <?php esc_attr_e( $data['fill_percentage'] ); ?>%"></span>
	</div>
</div>