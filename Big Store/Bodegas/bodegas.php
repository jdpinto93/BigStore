<?php

// Crea el post type --> Bodegas
function jp_bodega() {

	$labels = array(
		'name'                  => _x( 'bodegas', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'bodega', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Bodegas', 'text_domain' ),
		'name_admin_bar'        => __( 'Bodegas', 'text_domain' ),
		'archives'              => __( 'Bodehas', 'text_domain' ),
		'attributes'            => __( 'Atribudos de bodegas', 'text_domain' ),
		'parent_item_colon'     => __( 'Bodega Relacionada', 'text_domain' ),
		'all_items'             => __( 'Todas las Bodegas', 'text_domain' ),
		'add_new_item'          => __( 'añadir nueva Bodega', 'text_domain' ),
		'add_new'               => __( 'Añadir Nueva', 'text_domain' ),
		'new_item'              => __( 'Nueva Bodega', 'text_domain' ),
		'edit_item'             => __( 'Editar Bodega', 'text_domain' ),
		'update_item'           => __( 'Subir bodega', 'text_domain' ),
		'view_item'             => __( 'Ver Bodega', 'text_domain' ),
		'view_items'            => __( 'Ver Bodega', 'text_domain' ),
		'search_items'          => __( 'Buscar Bodega', 'text_domain' ),
		'not_found'             => __( 'Sin Resultados', 'text_domain' ),
		'not_found_in_trash'    => __( 'Sin bodegas en papelera', 'text_domain' ),
		'featured_image'        => __( 'Imagen de la bodega', 'text_domain' ),
		'set_featured_image'    => __( 'Establecer imagen destacada', 'text_domain' ),
		'remove_featured_image' => __( 'Eliminar bodega', 'text_domain' ),
		'use_featured_image'    => __( 'Usar imagen de bodega', 'text_domain' ),
		'insert_into_item'      => __( 'Insertar Bodega', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Cargar a las bodegas', 'text_domain' ),
		'items_list'            => __( 'Lista de Bodegas', 'text_domain' ),
		'items_list_navigation' => __( 'Navegar entre las bodegas', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de bodegas', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'bodega', 'text_domain' ),
		'description'           => __( 'En este apartado se definen las bodegas incluidas por proveedores en Bigcom', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-location-alt',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'bodega', $args );

}
add_action( 'init', 'jp_bodega', 0 );


// Crea la taxonomia --> Proveedores para el post type --> Bodega
function jp_proveedores() {

	$labels = array(
		'name'                       => _x( 'Proveedores', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Proveedor', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Proveedores', 'text_domain' ),
		'all_items'                  => __( 'Todos los proveedores', 'text_domain' ),
		'parent_item'                => __( 'Proveedores relacionados', 'text_domain' ),
		'parent_item_colon'          => __( 'proveedor relacionado', 'text_domain' ),
		'new_item_name'              => __( 'Nuevo proveedor', 'text_domain' ),
		'add_new_item'               => __( 'Añadir nuevo proveedor', 'text_domain' ),
		'edit_item'                  => __( 'Editar Proveedor', 'text_domain' ),
		'update_item'                => __( 'Subir proveedor', 'text_domain' ),
		'view_item'                  => __( 'Ver Proveedor', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separar proveedores por comas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Añadir o remover proveedor', 'text_domain' ),
		'choose_from_most_used'      => __( 'Elige entre los más usados', 'text_domain' ),
		'popular_items'              => __( 'Proveedor destacado', 'text_domain' ),
		'search_items'               => __( 'Buscar Proveedores', 'text_domain' ),
		'not_found'                  => __( 'Sin resultados', 'text_domain' ),
		'no_terms'                   => __( 'Sin proveedores', 'text_domain' ),
		'items_list'                 => __( 'Lista de Proveedores', 'text_domain' ),
		'items_list_navigation'      => __( 'Navegar por lista de proveedores', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'proveedores', array( 'bodega' ), $args );

}
add_action( 'init', 'jp_proveedores', 0 );



