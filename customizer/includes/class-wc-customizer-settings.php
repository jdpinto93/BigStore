<?php
defined( 'ABSPATH' ) or exit;

/**
 * Settings
 *
 * Adds UX for adding/modifying customizations
 *
 * @since 2.0.0
 */
class WC_Customizer_Settings extends WC_Settings_Page {


	/**
	 * Add various admin hooks/filters
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		$this->id    = 'customizer';
		$this->label = __( 'Customizer', 'BigExpress' );

		parent::__construct();

		$this->customizations = get_option( 'wc_customizer_active_customizations', array() );
	}


	/**
	 * Get sections
	 *
	 * @since 2.0.0
	 * @return array
	 */
	public function get_sections() {

		return array(
			'shop_loop'    => __( 'Shop Loop', 'BigExpress' ),
			'product_page' => __( 'Product Page', 'BigExpress' ),
			'checkout'     => __( 'Checkout', 'BigExpress' ),
			'misc'         => __( 'Misc', 'BigExpress' )
		);
	}


	/**
	 * Render the settings for the current section
	 *
	 * @since 2.0.0
	 */
	public function output() {

		$settings = $this->get_settings();

		// inject the actual setting value before outputting the fields
		// ::output_fields() uses get_option() but customizations are stored
		// in a single option so this dynamically returns the correct value
		foreach ( $this->customizations as $filter => $value ) {

			add_filter( "pre_option_{$filter}", array( $this, 'get_customization' ) );
		}

		WC_Admin_Settings::output_fields( $settings );
	}


	/**
	 * Return the customization value for the given filter
	 *
	 * @since 2.0.0
	 * @return string
	 */
	public function get_customization() {

		$filter = str_replace( 'pre_option_', '', current_filter() );

		return isset( $this->customizations[ $filter ] ) ? $this->customizations[ $filter ] : '';
	}


	/**
	 * Save the customizations
	 *
	 * @since 2.0.0
	 */
	public function save() {

		foreach ( $this->get_settings() as $field ) {

			// skip titles, etc
			if ( ! isset( $field['id'] ) ) {
				continue;
			}

			if ( ! empty( $_POST[ $field['id'] ] ) ) {

				$this->customizations[ $field['id'] ] = wp_kses_post( stripslashes( $_POST[ $field['id'] ] ) );

			} elseif ( isset( $this->customizations[ $field['id'] ] ) ) {

				unset( $this->customizations[ $field['id'] ] );
			}
		}

		update_option( 'wc_customizer_active_customizations', $this->customizations );
	}


	/**
	 * Return admin fields in proper format for outputting / saving
	 *
	 * @since 1.1.0
	 *
	 * @return array
	 */
	public function get_settings() {

		$settings = array(

			'shop_loop' =>

				array(

					array(
						'title' => __( 'Add to Cart Button Text', 'BigExpress' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'add_to_cart_text',
						'title'    => __( 'Simple Product', 'BigExpress' ),
						'desc_tip' => __( 'Changes the add to cart button text for simple products on all loop pages', 'BigExpress' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'variable_add_to_cart_text',
						'title'    => __( 'Variable Product', 'BigExpress' ),
						'desc_tip' => __( 'Changes the add to cart button text for variable products on all loop pages', 'BigExpress' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'grouped_add_to_cart_text',
						'title'    => __( 'Grouped Product', 'BigExpress' ),
						'desc_tip' => __( 'Changes the add to cart button text for grouped products on all loop pages', 'BigExpress' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'out_of_stock_add_to_cart_text',
						'title'    => __( 'Out of Stock Product', 'BigExpress' ),
						'desc_tip' => __( 'Changes the add to cart button text for out of stock products on all loop pages', 'BigExpress' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Sale Flash', 'BigExpress' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'loop_sale_flash_text',
						'title'    => __( 'Sale badge text', 'BigExpress' ),
						'desc_tip' => __( 'Changes text for the sale flash on all loop pages. Default: "Sale!"', 'BigExpress' ),
						'type'     => 'text',
						/* translators: Placeholders: %1$s - <code>, %2$s - </code> */
						'desc'     => sprintf( __( 'Use %1$s{percent}%2$s to insert percent off, e.g., "{percent} off!"', 'BigExpress' ), '<code>', '</code>' ) . '<br />' . __( 'Shows "up to n%" for grouped or variable products if multiple percentages are possible.', 'BigExpress' ),
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Layout', 'BigExpress' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'loop_shop_per_page',
						'title'    => __( 'Products displayed per page', 'BigExpress' ),
						'desc_tip' => __( 'Changes the number of products displayed per page', 'BigExpress' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'loop_shop_columns',
						'title'    => __( 'Product columns displayed per page', 'BigExpress' ),
						'desc_tip' => __( 'Changes the number of columns displayed per page', 'BigExpress' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_product_thumbnails_columns',
						'title'    => __( 'Product thumbnail columns displayed', 'BigExpress' ),
						'desc_tip' => __( 'Changes the number of product thumbnail columns displayed', 'BigExpress' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' )

				),

			'product_page' =>

				array(

					array(
						'title' => __( 'Tab Titles', 'BigExpress' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'woocommerce_product_description_tab_title',
						'title'    => __( 'Product Description', 'BigExpress' ),
						'desc_tip' => __( 'Changes the Production Description tab title', 'BigExpress' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_product_additional_information_tab_title',
						'title'    => __( 'Additional Information', 'BigExpress' ),
						'desc_tip' => __( 'Changes the Additional Information tab title', 'BigExpress' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Tab Content Headings', 'BigExpress' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'woocommerce_product_description_heading',
						'title'    => __( 'Product Description', 'BigExpress' ),
						'desc_tip' => __( 'Changes the Product Description tab heading', 'BigExpress' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_product_additional_information_heading',
						'title'    => __( 'Additional Information', 'BigExpress' ),
						'desc_tip' => __( 'Changes the Additional Information tab heading', 'BigExpress' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Add to Cart Button Text', 'BigExpress' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'single_add_to_cart_text',
						'title'    => __( 'All Product Types', 'BigExpress' ),
						'desc_tip' => __( 'Changes the Add to Cart button text on the single product page for all product type', 'BigExpress' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Out of Stock Text', 'BigExpress' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'single_out_of_stock_text',
						'title'    => __( 'Out of Stock text', 'BigExpress' ),
						'desc_tip' => __( 'Changes text for the out of stock on product pages. Default: "Out of stock"', 'BigExpress' ),
						'type'     => 'text',
					),

					array(
						'id'       => 'single_backorder_text',
						'title'    => __( 'Backorder text', 'BigExpress' ),
						'desc_tip' => __( 'Changes text for the backorder on product pages. Default: "Available on backorder"', 'BigExpress' ),
						'type'     => 'text',
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Sale Flash', 'BigExpress' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'single_sale_flash_text',
						'title'    => __( 'Sale badge text', 'BigExpress' ),
						'desc_tip' => __( 'Changes text for the sale flash on product pages. Default: "Sale!"', 'BigExpress' ),
						'type'     => 'text',
						/* translators: Placeholders: %1$s - <code>, %2$s - </code> */
						'desc'     => sprintf( __( 'Use %1$s{percent}%2$s to insert percent off, e.g., "{percent} off!"', 'BigExpress' ), '<code>', '</code>' ) . '<br />' . __( 'Shows "up to n%" for grouped or variable products if multiple percentages are possible.', 'BigExpress' ),
					),

					array( 'type' => 'sectionend' ),
				),

			'checkout' =>

				array(

					array(
						'title' => __( 'Messages', 'BigExpress' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'woocommerce_checkout_must_be_logged_in_message',
						'title'    => __( 'Must be logged in text', 'BigExpress' ),
						'desc_tip' => __( 'Changes the message displayed when a customer must be logged in to checkout', 'BigExpress' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_checkout_coupon_message',
						'title'    => __( 'Coupon text', 'BigExpress' ),
						'desc_tip' => __( 'Changes the message displayed if the coupon form is enabled on checkout', 'BigExpress' ),
						'type'     => 'text',
						'desc'     => sprintf( '<code>%s ' . esc_attr( '<a href="#" class="showcoupon">%s</a>' ) . '</code>', 'Have a coupon?', 'Click here to enter your code' ),
					),

					array(
						'id'       => 'woocommerce_checkout_login_message',
						'title'    => __( 'Login text', 'BigExpress' ),
						'desc_tip' => __( 'Changes the message displayed if customers can login at checkout', 'BigExpress' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Misc', 'BigExpress' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'woocommerce_create_account_default_checked',
						'title'    => __( 'Create Account checkbox default' ),
						'desc_tip' => __( 'Control the default state for the Create Account checkbox', 'BigExpress' ),
						'type'     => 'select',
						'options'  => array(
							'customizer_true'  => __( 'Checked', 'BigExpress' ),
							'customizer_false' => __( 'Unchecked', 'BigExpress' ),
						),
						'default'  => 'customizer_false',
					),

					array(
						'id'       => 'woocommerce_order_button_text',
						'title'    => __( 'Submit Order button', 'BigExpress' ),
						'desc_tip' => __( 'Changes the Place Order button text on checkout', 'BigExpress' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' )

				),

			'misc' =>

				array(

					array(
						'title' => __( 'Tax', 'BigExpress' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'woocommerce_rate_label',
						'title'    => __( 'Tax Label', 'BigExpress' ),
						'desc_tip' => __( 'Changes the Taxes label. Defaults to Tax for USA, VAT for European countries', 'BigExpress' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_countries_inc_tax_or_vat',
						'title'    => __( 'Including Tax Label', 'BigExpress' ),
						'desc_tip' => __( 'Changes the Including Taxes label. Defaults to Inc. tax for USA, Inc. VAT for European countries', 'BigExpress' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_countries_ex_tax_or_vat',
						'title'    => __( 'Excluding Tax Label', 'BigExpress' ),
						'desc_tip' => __( 'Changes the Excluding Taxes label. Defaults to Exc. tax for USA, Exc. VAT for European countries', 'BigExpress' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' ),

				),
		);

		/**
		 * Filters the available customizer settings.
		 *
		 * @since 2.6.0
		 *
		 * @param array $settings the plugin settings
		 */
		$settings = apply_filters( 'wc_customizer_settings', $settings );

		$current_section = isset( $GLOBALS['current_section'] ) ? $GLOBALS['current_section'] : 'shop_loop';

		return isset( $settings[ $current_section ] ) ?  $settings[ $current_section ] : $settings['shop_loop'];
	}


}

// setup settings
return wc_customizer()->settings = new WC_Customizer_Settings();
