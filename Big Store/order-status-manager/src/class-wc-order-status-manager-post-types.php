<?php


defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_5_0 as Framework;

/**
 * Order Status Manager Post Types
 *
 * @since 1.0.0
 */
class WC_Order_Status_Manager_Post_Types {


	/**
	 * Initialize and register the Order Status Manager post types
	 *
	 * @since 1.0.0
	 */
	public static function initialize() {

		self::init_user_roles();
		self::init_post_types();
		self::register_post_status();

		add_filter( 'post_updated_messages',      array( __CLASS__, 'updated_messages' ) );
		add_filter( 'bulk_post_updated_messages', array( __CLASS__, 'bulk_updated_messages' ), 10, 2 );
	}


	/**
	 * Init WooCommerce Order Status Manager user roles
	 *
	 * @since 1.0.0
	 */
	private static function init_user_roles() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) && ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}

		if ( is_object( $wp_roles ) ) {
			$wp_roles->add_cap( 'shop_manager',  'manage_woocommerce_order_status_emails' );
			$wp_roles->add_cap( 'administrator', 'manage_woocommerce_order_status_emails' );
		}
	}


	/**
	 * Init WooCommerce Order Status Manager post types
	 *
	 * @since 1.0.0
	 */
	private static function init_post_types() {

		// Register wc_order_status post type for custom order statuses
		register_post_type( 'wc_order_status', array(
			'labels' => array(
				'name'               => __( 'Estados de Pedido', 'woocommerce-order-status-manager' ),
				'singular_name'      => __( 'Estado de Pedido', 'woocommerce-order-status-manager' ),
				'menu_name'          => _x( 'Estados de Pedido', 'Admin menu name', 'woocommerce-order-status-manager' ),
				'add_new'            => __( 'Añadir Estados de Pedido', 'woocommerce-order-status-manager' ),
				'add_new_item'       => __( 'Añadir nuevo Estado de Pedido', 'woocommerce-order-status-manager' ),
				'edit'               => __( 'Editar Estados de Pedido', 'woocommerce-order-status-manager' ),
				'edit_item'          => __( 'Editar Estados de Pedido', 'woocommerce-order-status-manager' ),
				'new_item'           => __( 'Nuevo Estado de Pedido', 'woocommerce-order-status-manager' ),
				'view'               => __( 'Ver Estados de Pedido', 'woocommerce-order-status-manager' ),
				'view_item'          => __( 'Ver Estados de Pedido', 'woocommerce-order-status-manager' ),
				'search_items'       => __( 'Buscar Estados de Pedido', 'woocommerce-order-status-manager' ),
				'not_found'          => __( 'Sin Estados de Pedido', 'woocommerce-order-status-manager' ),
				'not_found_in_trash' => __( 'No hay Estados de Pedido en papelera', 'woocommerce-order-status-manager' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'capability_type'     => 'post',
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_in_menu'        => false,
			'hierarchical'        => false,
			'rewrite'             => false,
			'query_var'           => false,
			'supports'            => array(
				'title',
				'page-attributes',
			),
			'show_in_nav_menus'   => false,
		));

		// Register wc_order_email post type for custom emails
		// Note - can't use wc_order_status_email, as that is 1 character too long (max 20 chars)
		register_post_type( 'wc_order_email', array (
				'labels' => array(
					'name'               => __( 'Email de Estados de Pedido ', 'woocommerce-order-status-manager' ),
					'singular_name'      => __( 'Email de Estados de Pedido', 'woocommerce-order-status-manager' ),
					'menu_name'          => _x( 'Email deEstados de Pedido', 'Admin menu name', 'woocommerce-order-status-manager' ),
					'add_new'            => __( 'Añadir email a Estados de Pedido', 'woocommerce-order-status-manager' ),
					'add_new_item'       => __( 'Añadir nuevo email a Estados de Pedido', 'woocommerce-order-status-manager' ),
					'edit'               => __( 'Editar', 'woocommerce-order-status-manager' ),
					'edit_item'          => __( 'Editar Email a Estados de Pedido', 'woocommerce-order-status-manager' ),
					'new_item'           => __( 'Nuevo Email de Estados de Pedido', 'woocommerce-order-status-manager' ),
					'view'               => __( 'Ver Email de Estados de Pedido', 'woocommerce-order-status-manager' ),
					'view_item'          => __( 'Ver Email de Estados de Pedido', 'woocommerce-order-status-manager' ),
					'search_items'       => __( 'Buscar Emails de Estados de Pedido', 'woocommerce-order-status-manager' ),
					'not_found'          => __( 'No hay Emails para Estados de Pedido', 'woocommerce-order-status-manager' ),
					'not_found_in_trash' => __( 'No hay emails para Estados de Pedido en papelera', 'woocommerce-order-status-manager' ),
				),
				'public'              => false,
				'show_ui'             => true,
				'capability_type'     => 'post',
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_in_menu'        => false,
				'hierarchical'        => false,
				'rewrite'             => false,
				'query_var'           => false,
				'supports'            => array(
					'title',
				),
				'show_in_nav_menus'   => false,
		) );
	}


	/**
	 * Customize order status & email updated messages
	 *
	 * @since 1.0.0
	 * @param array $messages Original messages
	 * @return array $messages Modified messages
	 */
	public static function updated_messages( $messages ) {

		$post             = get_post();
		$post_type        = get_post_type( $post );

		$messages['wc_order_status'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Order Status saved.', 'woocommerce-order-status-manager' ),
			2  => __( 'Custom field updated.', 'woocommerce-order-status-manager' ),
			3  => __( 'Custom field deleted.', 'woocommerce-order-status-manager' ),
			4  => __( 'Order Status saved.', 'woocommerce-order-status-manager' ),
			5  => '', // Unused for order statuses
			6  => __( 'Order Status saved.', 'woocommerce-order-status-manager' ), // Original: Post published
			7  => __( 'Order Status saved.', 'woocommerce-order-status-manager' ),
			8  => '', // Unused for order statuses
			9  => '', // Unused for order statuses
			10 => __( 'Order Status saved.', 'woocommerce-order-status-manager' ), // Original: Post draft updated
		);

		$customize_email_link = sprintf( ' <a href="%s">%s</a>', esc_url( admin_url( 'admin.php?page=wc-settings&tab=email&section=wc_order_status_email_' . esc_attr( $post->ID ) ) ), __( 'Customize Email', 'woocommerce-order-status-manager' ) );

		$messages['wc_order_email'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Order Status Email saved.', 'woocommerce-order-status-manager' ) . $customize_email_link,
			2  => __( 'Custom field updated.', 'woocommerce-order-status-manager' ),
			3  => __( 'Custom field deleted.', 'woocommerce-order-status-manager' ),
			4  => __( 'Order Status Email saved.', 'woocommerce-order-status-manager' ) . $customize_email_link,
			5  => '', // Unused for order statuses
			6  => __( 'Order Status Email saved.', 'woocommerce-order-status-manager' ) . $customize_email_link, // Original: Post published
			7  => __( 'Order Status Email saved.', 'woocommerce-order-status-manager' ) . $customize_email_link,
			8  => '', // Unused for order statuses
			9  => '', // Unused for order statuses
			10 => __( 'Order Status Email saved.', 'woocommerce-order-status-manager' ) . $customize_email_link, // Original: Post draft updated
		);

		return $messages;
	}


	/**
	 * Customize order status & email bulk updated messages
	 *
	 * @since 1.0.0
	 * @param array $messages Original messages
	 * @param array $bulk_counts
	 * @return array $messages Modified messages
	 */
	public static function bulk_updated_messages( $messages, $bulk_counts ) {

		$messages['wc_order_status'] = array(
			'updated'   => _n( '%s order status updated.', '%s order statuses updated.', $bulk_counts['updated'], 'woocommerce-order-status-manager' ),
			'locked'    => _n( '%s order status not updated, somebody is editing it.', '%s order statuses not updated, somebody is editing them.', $bulk_counts['locked'], 'woocommerce-order-status-manager' ),
			'deleted'   => _n( '%s order status permanently deleted.', '%s order statuses permanently deleted.', $bulk_counts['deleted'], 'woocommerce-order-status-manager' ),
			'trashed'   => _n( '%s order status moved to the Trash.', '%s order statuses moved to the Trash.', $bulk_counts['trashed'], 'woocommerce-order-status-manager' ),
			'untrashed' => _n( '%s order status restored from the Trash.', '%s order statuses restored from the Trash.', $bulk_counts['untrashed'], 'woocommerce-order-status-manager' ),
		);

		$messages['wc_order_email'] = array(
			'updated'   => _n( '%s order status email updated.', '%s order status emails updated.', $bulk_counts['updated'], 'woocommerce-order-status-manager' ),
			'locked'    => _n( '%s order status email not updated, somebody is editing it.', '%s order status emails not updated, somebody is editing them.', $bulk_counts['locked'], 'woocommerce-order-status-manager' ),
			'deleted'   => _n( '%s order status email permanently deleted.', '%s order status emails permanently deleted.', $bulk_counts['deleted'], 'woocommerce-order-status-manager' ),
			'trashed'   => _n( '%s order status email moved to the Trash.', '%s order status emails moved to the Trash.', $bulk_counts['trashed'], 'woocommerce-order-status-manager' ),
			'untrashed' => _n( '%s order status email restored from the Trash.', '%s order status emails restored from the Trash.', $bulk_counts['untrashed'], 'woocommerce-order-status-manager' ),
		);

		return $messages;
	}


	/**
	 * Register custom order statuses for orders
	 *
	 * @since 1.0.0
	 */
	public static function register_post_status() {

		foreach ( wc_get_order_statuses() as $slug => $name ) {

			// Don't register manually registered statuses
			if ( wc_order_status_manager()->get_order_statuses_instance()->is_core_status( $slug ) ) {
				continue;
			}

			register_post_status( $slug, array(
				'label'                     => $name,
				'public'                    => false,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( $name . ' <span class="count">(%s)</span>', $name . ' <span class="count">(%s)</span>', 'woocommerce-order-status-manager' ),
			) );
		}
	}


}
