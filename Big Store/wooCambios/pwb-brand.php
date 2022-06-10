<?php

//Registro de Taxonomia Marcas --> Productos
// Taxonomy Key: pwb-brand

function jd_pwb_brand() {

	$labels = array(
		'name'                       => _x( 'Marcas', 'Taxonomy General Name', 'brpduct' ),
		'singular_name'              => _x( 'Marca', 'Taxonomy Singular Name', 'brpduct' ),
		'menu_name'                  => __( 'Marca', 'brpduct' ),
		'all_items'                  => __( 'Todas las marcas', 'brpduct' ),
		'parent_item'                => __( 'Marca relacionada', 'brpduct' ),
		'parent_item_colon'          => __( 'Marcas relacionadas', 'brpduct' ),
		'new_item_name'              => __( 'Nueva Marca', 'brpduct' ),
		'add_new_item'               => __( 'Añadir nueva marca', 'brpduct' ),
		'edit_item'                  => __( 'Editar Marca', 'brpduct' ),
		'update_item'                => __( 'Subir Marca', 'brpduct' ),
		'view_item'                  => __( 'Ver Marca', 'brpduct' ),
		'separate_items_with_commas' => __( 'Separar Marcas por comas', 'brpduct' ),
		'add_or_remove_items'        => __( 'Añadir o quitar Marca', 'brpduct' ),
		'choose_from_most_used'      => __( 'Marcas mas utilizadas', 'brpduct' ),
		'popular_items'              => __( 'Marca destacada', 'brpduct' ),
		'search_items'               => __( 'Buscar Marca', 'brpduct' ),
		'not_found'                  => __( 'Sin resultados', 'brpduct' ),
		'no_terms'                   => __( 'No hay Marcas', 'brpduct' ),
		'items_list'                 => __( 'Lista de Marcas', 'brpduct' ),
		'items_list_navigation'      => __( 'Navegar por las marcas', 'brpduct' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'pwb-brand', array( 'product' ), $args );

}
add_action( 'init', 'jd_pwb_brand', 0 );

