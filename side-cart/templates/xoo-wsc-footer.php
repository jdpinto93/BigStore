<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::cart_footer() );

?>

<?php xoo_wsc_helper()->get_template( 'global/footer/extras.php' ) ?>

<?php xoo_wsc_helper()->get_template( 'global/footer/totals.php' ) ?>

<?php xoo_wsc_helper()->get_template( 'global/footer/buttons.php' ); ?>