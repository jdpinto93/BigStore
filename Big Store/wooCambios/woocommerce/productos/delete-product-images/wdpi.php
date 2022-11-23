<?php 

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );


	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
	{

		add_action("before_delete_post","woocommerce_delete_product_attached_images",10,1);

			function woocommerce_delete_product_attached_images($post_id)
			{
			 global $wpdb;
					  $arg = array(
							'post_parent' => $post_id,
							'post_type'   => 'attachment', 
							'numberposts' => -1,
							'post_status' => 'any' 
					); 
					$childrens = get_children( $arg);
					if($childrens):
						foreach($childrens as $attachment):   
						 wp_delete_attachment( $attachment->ID, true ); 
						 $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE post_id = ".$attachment->ID);
						 wp_delete_post($attachment->ID,true ); 
						endforeach; 
					endif; 
			}
	} else {
       
		echo "<div class='error'><p>WooCommerce plugin is not activated. Please install and activate it to use Woocommerce Delete Product Images Plugin</p> </div>";

}