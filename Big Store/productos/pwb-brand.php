<?php

//Registro de Taxonomia Marcas --> Productos
// Taxonomy Key: pwb-brand

function jd_pwb_brand() {

	$labels = array(
		'name'                       => _x( 'Marcas', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Marca', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Marca', 'text_domain' ),
		'all_items'                  => __( 'Todas las marcas', 'text_domain' ),
		'parent_item'                => __( 'Marca relacionada', 'text_domain' ),
		'parent_item_colon'          => __( 'Marcas relacionadas', 'text_domain' ),
		'new_item_name'              => __( 'Nueva Marca', 'text_domain' ),
		'add_new_item'               => __( 'Añadir nueva marca', 'text_domain' ),
		'edit_item'                  => __( 'Editar Marca', 'text_domain' ),
		'update_item'                => __( 'Subir Marca', 'text_domain' ),
		'view_item'                  => __( 'Ver Marca', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separar Marcas por comas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Añadir o quitar Marca', 'text_domain' ),
		'choose_from_most_used'      => __( 'Marcas mas utilizadas', 'text_domain' ),
		'popular_items'              => __( 'Marca destacada', 'text_domain' ),
		'search_items'               => __( 'Buscar Marca', 'text_domain' ),
		'not_found'                  => __( 'Sin resultados', 'text_domain' ),
		'no_terms'                   => __( 'No hay Marcas', 'text_domain' ),
		'items_list'                 => __( 'Lista de Marcas', 'text_domain' ),
		'items_list_navigation'      => __( 'Navegar por las marcas', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'pwb-brand', array( 'product' ), $args );

}
add_action( 'init', 'jd_pwb_brand', 0 );

