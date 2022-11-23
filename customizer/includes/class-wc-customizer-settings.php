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
		$this->label = __( 'Personalizador', 'woocommerce-customizer' );

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
			'shop_loop'    => __( 'Loop de Producto', 'woocommerce-customizer' ),
			'product_page' => __( 'Producto Simple', 'woocommerce-customizer' ),
			'checkout'     => __( 'Pagina de Pago', 'woocommerce-customizer' ),
			'misc'         => __( 'Varios', 'woocommerce-customizer' )
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
						'title' => __( 'Texto del botón Agregar al carrito', 'woocommerce-customizer' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'add_to_cart_text',
						'title'    => __( 'Producto Simple', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el texto del botón Agregar al carrito para productos simples en todas las páginas', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'variable_add_to_cart_text',
						'title'    => __( 'Producto Variable', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el texto del botón Agregar al carrito para productos variables en todas las páginas', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'grouped_add_to_cart_text',
						'title'    => __( 'Grupo de Productos', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el texto del botón Agregar al carrito para productos agrupados en todas las páginas', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'out_of_stock_add_to_cart_text',
						'title'    => __( 'Producto Fuera de Stock', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el texto del botón Agregar al carrito para productos Fuera de Stock en todas las páginas', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Venta Rapida', 'woocommerce-customizer' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'loop_sale_flash_text',
						'title'    => __( 'Texto de la insignia de Oferta', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el texto de la insignia de oferta en todas las páginas.. Default: "Oferta!"', 'woocommerce-customizer' ),
						'type'     => 'text',
						/* translators: Placeholders: %1$s - <code>, %2$s - </code> */
						'desc'     => sprintf( __( 'Use %1$s{percent}%2$s to insert percent off, e.g., "{percent} off!"', 'woocommerce-customizer' ), '<code>', '</code>' ) . '<br />' . __( 'Shows "up to n%" for grouped or variable products if multiple percentages are possible.', 'woocommerce-customizer' ),
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Diseño', 'woocommerce-customizer' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'loop_shop_per_page',
						'title'    => __( 'Products displayed per page', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el número de productos mostrados por página', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'loop_shop_columns',
						'title'    => __( 'Columnas de productos mostradas por página', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el número de columnas mostradas por página', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_product_thumbnails_columns',
						'title'    => __( 'Columnas de miniaturas de productos mostradas', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el número de columnas de miniaturas de productos que se muestran', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' )

				),

			'product_page' =>

				array(

					array(
						'title' => __( 'Títulos de pestañas', 'woocommerce-customizer' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'woocommerce_product_description_tab_title',
						'title'    => __( 'Descripción del producto', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el título de la pestaña Descripción del producto', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_product_additional_information_tab_title',
						'title'    => __( 'Informacion Adicional', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el titulo de la pestaña de Informacion adicional del producto', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Encabezados de contenido de pestañas', 'woocommerce-customizer' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'woocommerce_product_description_heading',
						'title'    => __( 'Descripción del producto', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el encabezado de la pestaña Descripción del producto', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_product_additional_information_heading',
						'title'    => __( 'Informacion Adicional', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el encabezado de la pestaña Informacion Adicional del producto', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Texto del botón Agregar al carrito', 'woocommerce-customizer' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'single_add_to_cart_text',
						'title'    => __( 'Todos los tipos de productos', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el texto del botón Agregar al carrito en la página de un solo producto para todo tipo de producto', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Texto del banner de "Agotado"', 'woocommerce-customizer' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'single_out_of_stock_text',
						'title'    => __( 'Texto del banner de "Agotado"', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el texto de agotado en las páginas de productos.. Default: "Out of stock"', 'woocommerce-customizer' ),
						'type'     => 'text',
					),

					array(
						'id'       => 'single_backorder_text',
						'title'    => __( 'Texto de pedido pendiente', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el texto del pedido pendiente en las páginas de productos. Default: "Available on backorder"', 'woocommerce-customizer' ),
						'type'     => 'text',
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Venta Rapida', 'woocommerce-customizer' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'single_sale_flash_text',
						'title'    => __( 'Texto del Banner de Oferta', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambie el texto de Banner de Ofertas en la Pagina de Productos. Default: "Sale!"', 'woocommerce-customizer' ),
						'type'     => 'text',
						/* translators: Placeholders: %1$s - <code>, %2$s - </code> */
						'desc'     => sprintf( __( 'Use %1$s{percent}%2$s to insert percent off, e.g., "{percent} off!"', 'woocommerce-customizer' ), '<code>', '</code>' ) . '<br />' . __( 'Shows "up to n%" for grouped or variable products if multiple percentages are possible.', 'woocommerce-customizer' ),
					),

					array( 'type' => 'sectionend' ),
				),

			'checkout' =>

				array(

					array(
						'title' => __( 'Mensajes', 'woocommerce-customizer' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'woocommerce_checkout_must_be_logged_in_message',
						'title'    => __( 'Texto de "Debe Inicias Sesion"', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el mensaje que se muestra cuando un cliente debe iniciar sesión para pagar', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_checkout_coupon_message',
						'title'    => __( 'Texto del Cupon', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el mensaje que se muestra si el formulario de cupón está habilitado al finalizar la compra', 'woocommerce-customizer' ),
						'type'     => 'text',
						'desc'     => sprintf( '<code>%s ' . esc_attr( '<a href="#" class="showcoupon">%s</a>' ) . '</code>', 'Have a coupon?', 'Click here to enter your code' ),
					),

					array(
						'id'       => 'woocommerce_checkout_login_message',
						'title'    => __( 'Texto de "Iniciar Sesion"', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el mensaje que se muestra si los clientes pueden iniciar sesión al finalizar la compra', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' ),

					array(
						'title' => __( 'Varios', 'woocommerce-customizer' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'woocommerce_create_account_default_checked',
						'title'    => __( 'Checkbox "Crear una Cuenta"' ),
						'desc_tip' => __( 'Controle el estado predeterminado para la casilla de verificación Crear cuenta', 'woocommerce-customizer' ),
						'type'     => 'select',
						'options'  => array(
							'customizer_true'  => __( 'Checked', 'woocommerce-customizer' ),
							'customizer_false' => __( 'Unchecked', 'woocommerce-customizer' ),
						),
						'default'  => 'customizer_false',
					),

					array(
						'id'       => 'woocommerce_order_button_text',
						'title'    => __( 'Botón Enviar pedido', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia el texto del botón Realizar pedido al finalizar la compra', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array( 'type' => 'sectionend' )

				),

			'misc' =>

				array(

					array(
						'title' => __( 'Tax', 'woocommerce-customizer' ),
						'type'  => 'title'
					),

					array(
						'id'       => 'woocommerce_rate_label',
						'title'    => __( 'Etiqueta de Tax', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia la etiqueta de Impuestos. Los valores predeterminados son impuestos para EE. UU., IVA para países europeos', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_countries_inc_tax_or_vat',
						'title'    => __( 'Incluyendo etiqueta de impuestos', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia la etiqueta Impuestos incluidos. El valor predeterminado es Inc. tax para EE. UU., Inc. VAT para países europeos', 'woocommerce-customizer' ),
						'type'     => 'text'
					),

					array(
						'id'       => 'woocommerce_countries_ex_tax_or_vat',
						'title'    => __( 'Excluyendo la etiqueta de impuestos', 'woocommerce-customizer' ),
						'desc_tip' => __( 'Cambia la etiqueta Impuestos excluidos. Predeterminado a Exc. impuestos para EE. UU., Exc. IVA para países europeos', 'woocommerce-customizer' ),
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
