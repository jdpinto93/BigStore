<?php


defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_5_0 as Framework;

/**
 * Integrations handler for third party extensions and plugins compatibility.
 *
 * Adds integrations for:
 *
 * - WooCommerce Subscriptions
 *
 * @since 1.13.3
 */
class WC_Order_Status_Manager_Integrations {


	/** @var \SkyVerge\WooCommerce\Order_Status_Manager\Integration\Subscriptions|null */
	private $subscriptions;


	/**
	 * Loads integrations.
	 *
	 * @since 1.13.3
	 */
	public function __construct() {

		// Subscriptions
		if ( wc_order_status_manager()->is_plugin_active( 'woocommerce-subscriptions.php' ) ) {

			require_once( wc_order_status_manager()->get_plugin_path() . '/src/integrations/woocommerce-subscriptions/class-wc-order-status-manager-integration-subscriptions.php' );

			$this->subscriptions = new \SkyVerge\WooCommerce\Order_Status_Manager\Integration\Subscriptions();
		}
	}


	/**
	 * Gets the Subscriptions' integration handler instance.
	 *
	 * @since 1.3.3
	 *
	 * @return \SkyVerge\WooCommerce\Order_Status_Manager\Integration\Subscriptions|null
	 */
	public function get_subscriptions_instance() {

		return $this->subscriptions;
	}


}
