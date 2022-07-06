<?php

add_action( 'init', 'create_brands_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts
 
function create_brands_hierarchical_taxonomy() {
 
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
 
  $labels = array(
    'name' => _x( 'Marcas', 'taxonomy general name' ),
    'singular_name' => _x( 'Marca', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Marcas' ),
    'all_items' => __( 'Todas las Marcas' ),
    'parent_item' => __( 'Marca Relacionada' ),
    'parent_item_colon' => __( 'Marca Relacionada:' ),
    'edit_item' => __( 'Editar Marca' ), 
    'update_item' => __( 'Subir Marca' ),
    'add_new_item' => __( 'Añadir Nueva Marca' ),
    'new_item_name' => __( 'Nuevo Nombre de Marca' ),
    'menu_name' => __( 'Marcas' ),
  );    
  
    $capabilities = array(
        'manage_terms'               => 'manage_woocommerce',
        'edit_terms'                 => 'manage_woocommerce',
        'delete_terms'               => 'manage_woocommerce',
        'assign_terms'               => 'manage_woocommerce',
    ); 
 
// Now register the taxonomy
     $args = array(
        'labels'                     => $labels,
        'show_in_rest'               => true,       
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => false,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'capabilities'               => $capabilities,
        
    
    );
    register_taxonomy( 'pwb-brand', array( 'product' ), $args );
    register_taxonomy_for_object_type( 'pwb-brand', 'product' );

 
}

//Register taxonomy API for WC
add_action( 'rest_api_init', 'register_rest_field_for_custom_taxonomy_brands' );
function register_rest_field_for_custom_taxonomy_brands() {
    

    register_rest_field('product', "pwb-brand", array(
        'get_callback'    => 'product_get_callback',
        'update_callback'    => 'product_update_callback',
        'schema' => null,
    ));    

}
        //Get Taxonomy record in wc REST API
         function product_get_callback($post, $attr, $request, $object_type)
        {
            $terms = array();

            // Get terms
            foreach (wp_get_post_terms( $post[ 'id' ],'pwb-brand') as $term) {
                $terms[] = array(
                    'id'        => $term->term_id,
                    'name'      => $term->name,
                    'slug'      => $term->slug,
                    'brand_logo'  => get_term_meta($term->term_id, 'brand_logo', true),
                    'Banner de Marca'  => get_term_meta($term->term_id, 'banner_brand', true)
                );
            }

            return $terms;
        }
        
         //Update Taxonomy record in wc REST API
         function product_update_callback($values, $post, $attr, $request, $object_type)
        {   
            // Post ID
            $postId = $post->get_id();
            
            //Example: $values = [2,4,3];                
            
            // Set terms
           wp_set_object_terms( $postId, $values , 'pwb-brand');
}