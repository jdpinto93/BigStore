<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

add_action( 'init', 'create_proveedores_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts
 
function create_proveedores_hierarchical_taxonomy() {
 
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
 
  $labels = array(
    'name' => _x( 'Proveedores', 'taxonomy general name' ),
    'singular_name' => _x( 'Proveedor', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Proveedor' ),
    'all_items' => __( 'Todas las Proveedores' ),
    'parent_item' => __( 'Proveedor Relacionada' ),
    'parent_item_colon' => __( 'Proveedor Relacionada:' ),
    'edit_item' => __( 'Editar Proveedor' ), 
    'update_item' => __( 'Subir Proveedor' ),
    'add_new_item' => __( 'Añadir Nuevo Proveedor' ),
    'new_item_name' => __( 'Nuevo Nombre de Proveedor' ),
    'menu_name' => __( 'Proveedores' ),
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
    register_taxonomy( 'pwb-proveedor', array( 'product' ), $args );
    register_taxonomy_for_object_type( 'pwb-proveedor', 'product' );

 
}

//Register taxonomy API for WC
add_action( 'rest_api_init', 'register_rest_field_for_custom_taxonomy_proveedors' );
function register_rest_field_for_custom_taxonomy_proveedors() {
    

    register_rest_field('product', "pwb-proveedor", array(
        'get_callback'    => 'product_get_callback_proveedor',
        'update_callback'    => 'product_update_callback_proveedor',
        'schema' => null,
    ));    

}
        //Get Taxonomy record in wc REST API
         function product_get_callback_proveedor($post, $attr, $request, $object_type)
        {
            $terms = array();

            // Get terms
            foreach (wp_get_post_terms( $post[ 'id' ],'pwb-proveedor') as $term) {
                $terms[] = array(
                    'id'        => $term->term_id,
                    'name'      => $term->name,
                    'slug'      => $term->slug,
                );
            }

            return $terms;
}

//Update Taxonomy record in wc REST API
     function product_update_callback_proveedor($values, $post, $attr, $request, $object_type)
    {   
        // Post ID            
        $postId = $post->id;
        
        //Example: $values = [2,4,3];    
 
         error_log("debug on values");
         error_log(json_encode($values));
                         
         $numarray = [];             
         foreach($values as $value){
             $numarray[] = (int)$value['id'];
         }
          
       wp_set_object_terms( $postId, $numarray , 'pwb-proveedor');
        
        
    }