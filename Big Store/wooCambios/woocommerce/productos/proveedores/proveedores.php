<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

// Register Custom Taxonomy
function jp_proveedor() {

	$labels = array(
		'name'                       => _x( 'Proveedores', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Proveedor', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Proveedores', 'text_domain' ),
		'all_items'                  => __( 'Todas los proveedores', 'text_domain' ),
		'parent_item'                => __( 'Proveedor relacionado', 'text_domain' ),
		'parent_item_colon'          => __( 'Proveedor relacionado:', 'text_domain' ),
		'new_item_name'              => __( 'Nuevo Proveedor', 'text_domain' ),
		'add_new_item'               => __( 'Añadir Nuevo Proveedor', 'text_domain' ),
		'edit_item'                  => __( 'Editar proveedor', 'text_domain' ),
		'update_item'                => __( 'Cargar proveedor', 'text_domain' ),
		'view_item'                  => __( 'Ver proveedor', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separar proveedor por comas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Añadir o eliminar proveedores', 'text_domain' ),
		'choose_from_most_used'      => __( 'proveedores mas usadas', 'text_domain' ),
		'popular_items'              => __( 'proveedores favoritos', 'text_domain' ),
		'search_items'               => __( 'Buscar proveedores', 'text_domain' ),
		'not_found'                  => __( 'Sin Resultados', 'text_domain' ),
		'no_terms'                   => __( 'No hay proveedores', 'text_domain' ),
		'items_list'                 => __( 'Lista de proveedores', 'text_domain' ),
		'items_list_navigation'      => __( 'Navegar por lista de proveedores', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'pwb-proveedor', array( 'product' ), $args );

}
add_action( 'init', 'jp_proveedor', 0 );