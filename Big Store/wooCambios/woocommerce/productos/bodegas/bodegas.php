<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

// Registra taxonomia para las bodegas

add_action( 'init', 'create_bodega_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts
 
function create_bodega_hierarchical_taxonomy() {
 
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
 
  $labels = array(
    'name' => _x( 'Bodegas', 'taxonomy general name' ),
    'singular_name' => _x( 'Bodega', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Bodegas' ),
    'all_items' => __( 'Todas las Bodegas' ),
    'parent_item' => __( 'Bodega Relacionada' ),
    'parent_item_colon' => __( 'Bodega Relacionada:' ),
    'edit_item' => __( 'Editar Bodega' ), 
    'update_item' => __( 'Subir Bodega' ),
    'add_new_item' => __( 'Añadir Nueva Bodega' ),
    'new_item_name' => __( 'Nuevo Nombre de Bodega' ),
    'menu_name' => __( 'Bodegas' ),
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
    register_taxonomy( 'pwb-bodega', array( 'product' ), $args );
    register_taxonomy_for_object_type( 'pwb-bodega', 'product' );

 
}

//Register taxonomy API for WC
add_action( 'rest_api_init', 'register_rest_field_for_custom_taxonomy_bodega' );
function register_rest_field_for_custom_taxonomy_bodega() {
    

    register_rest_field('product', "pwb-bodega", array(
        'get_callback'    => 'product_get_callback_bodega',
        'update_callback'    => 'product_update_callback_bodega',
        'schema' => null,
    ));    

}
        //Get Taxonomy record in wc REST API
         function product_get_callback_bodega($post, $attr, $request, $object_type)
        {
            $terms = array();

            // Get terms
            foreach (wp_get_post_terms( $post[ 'id' ],'pwb-bodega') as $term) {
                $terms[] = array(
                    'id'        => $term->term_id,
                    'name'      => $term->name,
                    'slug'      => $term->slug,
                    'estado'  => get_term_meta($term->term_id, 'estado_bodega', true),
                    'ciudad'  => get_term_meta($term->term_id, 'ciudad_bodega', true),
                    'direccion'  => get_term_meta($term->term_id, 'direccion_bodega', true),
                    'Codigo Postal'  => get_term_meta($term->term_id, 'postal_code_bodega', true),
                    'latitud'  => get_term_meta($term->term_id, 'latitud_bodega', true),
                    'longitud'  => get_term_meta($term->term_id, 'longitud_bodega', true),
                    'Nombre de contacto'  => get_term_meta($term->term_id, 'contacto_bodega', true),
                    'Tel. de contacto'  => get_term_meta($term->term_id, 'tel_contacto_bodega', true),
                    'Tel. de Bodega'  => get_term_meta($term->term_id, 'tel_contacto_bodega1', true)
                );
            }

            return $terms;
        }
        
         //Update Taxonomy record in wc REST API
         function product_update_callback_bodega($values, $post, $attr, $request, $object_type)
        {   
            // Post ID
            $postId = $post->get_id();
            
            //Example: $values = [2,4,3];                
            
            // Set terms
           wp_set_object_terms( $postId, $values , 'pwb-bodega');
}