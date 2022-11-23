<?php
defined( 'ABSPATH' ) || die;
class Fr_Multi_Bank_Transfer_Gateways_For_Woocommerce_Admin {

	public function add_action_links( $action_links ) {
		array_unshift(
			$action_links,
			sprintf(
				'<a href="%s">%s</a>',
				admin_url( 'admin.php?page=wc-settings&tab=checkout#fr_multi_bank_transfer_gateways_for_woocommerce_bank_number' ),
				__(
					'Settings',
					'fr-multi-bank-transfer-gateways-for-woocommerce'
				)
			)
		);

		return $action_links;
	}

	public function add_custom_checkout_settings( $settings ) {
		$new_settings = array();

		foreach ( $settings as $value ) {
			$new_settings[] = $value;

			if ( array_key_exists( 'type', $value ) && 'payment_gateways' === $value['type'] ) {
				$new_settings[] = array(
					'title'             => __( 'Number of additional bank transfer gateways', 'fr-multi-bank-transfer-gateways-for-woocommerce' ),
					'desc'              => __( 'How many bank transfer gateways do you want to add?', 'fr-multi-bank-transfer-gateways-for-woocommerce' ),
					'id'                => 'fr_multi_bank_transfer_gateways_for_woocommerce_bank_number',
					'type'              => 'number',
					'desc_tip'          => true,
					'custom_attributes' => array(
						'min' => 0,
					),
				);
			}
		}

		return $new_settings;
	}

	/**
	 * Register payment gateways.
	 *
	 * Hooked on `woocommerce_payment_gateways` filter.
	 *
	 * @since 1.0.0
	 * @access private
	 * @param array $gateways Payment gateways.
	 * @return array Modified payment gateways.
	 */
	public function add_gateway_classes( $gateways ) {
		$bank_number = get_option( 'fr_multi_bank_transfer_gateways_for_woocommerce_bank_number', 0 );
		if ( $bank_number < 1 ) {
			return $gateways;
		}

		require_once FR_MULTI_BANK_TRANSFER_GATEWAYS_FOR_WOOCOMMERCE_DIR . 'includes/gateways/class-fr-multi-bank-transfer-gateways-for-woocommerce-bank-transfer.php';

		for ( $i = 1; $i <= $bank_number; $i++ ) {
			$args = array(
				'id'           => "bank_transfer_$i",
				/* translators: %d: bank transfer number */
				'method_title' => sprintf( __( 'Bank Transfer %d', 'fr-multi-bank-transfer-gateways-for-woocommerce' ), $i ),
			);

			$gateways[] = new Fr_Multi_Bank_Transfer_Gateways_For_Woocommerce_Bank_Transfer( $args );
		}

		// Backward compatibility. The classes may be used by other plugins or themes.
		// TODO: remove on version 2.0.0.
		for ( $i = 1; $i <= $bank_number && $i <= 10; $i++ ) {
			require_once FR_MULTI_BANK_TRANSFER_GATEWAYS_FOR_WOOCOMMERCE_DIR . "includes/gateways/class-fr-multi-bank-transfer-gateways-for-woocommerce-bank-transfer-$i.php";
		}

		return $gateways;
	}
}
