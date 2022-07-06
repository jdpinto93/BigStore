<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 **/
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    /**
     * Plugin Code
     */

    /**
     * Enqueue Scripts and Styles
     */
    require_once plugin_dir_path(__FILE__) . 'includes/enqueue_files.php';

    /**
     * Add the WhatsApp Button in the WooCommerce Order
     */
    require_once plugin_dir_path(__FILE__) . 'includes/whatsapp_btn_in_order.php';

    /**
     * Add the WhatsApp Button in the List of Orders in WooCommerce
     */
    require_once plugin_dir_path(__FILE__) . 'includes/whatsapp_btn_in_list_order.php';
}
