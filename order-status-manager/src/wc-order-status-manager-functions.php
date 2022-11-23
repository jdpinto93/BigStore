<?php


defined( 'ABSPATH' ) or exit;

/**
 * Get order status posts
 *
 * @since 1.5.0
 * @param array $args Optional. List of get_post args
 * @return \WP_Post[] Array of WP_Post objects
 */
function wc_order_status_manager_get_order_status_posts( $args = array() ) {

	$defaults = array(
		'post_type'        => 'wc_order_status',
		'post_status'      => 'publish',
		'posts_per_page'   => -1,
		'suppress_filters' => false,
		'orderby'          => 'menu_order',
		'order'            => 'ASC',
	);

	$posts = wp_cache_get( 'wc_order_status_manager_order_status_posts' );

	if ( ! $posts ) {

		$posts = get_posts( wp_parse_args( $args, $defaults ) );

		// expire cache after 1 second to avoid potential issues with persistent caching
		wp_cache_set( 'wc_order_status_manager_order_status_posts', $posts, null, 1 );
	}

	return $posts;
}
