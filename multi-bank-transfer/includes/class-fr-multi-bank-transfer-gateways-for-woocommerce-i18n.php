<?php

defined( 'ABSPATH' ) || die;

class Fr_Multi_Bank_Transfer_Gateways_For_Woocommerce_I18n {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'fr-multi-bank-transfer-gateways-for-woocommerce', false, plugin_basename( FR_MULTI_BANK_TRANSFER_GATEWAYS_FOR_WOOCOMMERCE_DIR ) . '/languages/' );
	}
}
