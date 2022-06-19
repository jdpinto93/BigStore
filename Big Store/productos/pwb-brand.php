<?php

//Registro de Taxonomia Marcas --> Productos
// Taxonomy Key: pwb-brand

function jd_pwb_brand() {

	$labels = array(
		'name'                       => _x( 'Marcas', 'Taxonomy General Name', 'jd_pwb_brand' ),
		'singular_name'              => _x( 'Marca', 'Taxonomy Singular Name', 'jd_pwb_brand' ),
		'menu_name'                  => __( 'Marca', 'jd_pwb_brand' ),
		'all_items'                  => __( 'Todas las marcas', 'jd_pwb_brand' ),
		'parent_item'                => __( 'Marca relacionada', 'jd_pwb_brand' ),
		'parent_item_colon'          => __( 'Marcas relacionadas', 'jd_pwb_brand' ),
		'new_item_name'              => __( 'Nueva Marca', 'jd_pwb_brand' ),
		'add_new_item'               => __( 'Añadir nueva marca', 'jd_pwb_brand' ),
		'edit_item'                  => __( 'Editar Marca', 'jd_pwb_brand' ),
		'update_item'                => __( 'Subir Marca', 'jd_pwb_brand' ),
		'view_item'                  => __( 'Ver Marca', 'jd_pwb_brand' ),
		'separate_items_with_commas' => __( 'Separar Marcas por comas', 'jd_pwb_brand' ),
		'add_or_remove_items'        => __( 'Añadir o quitar Marca', 'jd_pwb_brand' ),
		'choose_from_most_used'      => __( 'Marcas mas utilizadas', 'jd_pwb_brand' ),
		'popular_items'              => __( 'Marca destacada', 'jd_pwb_brand' ),
		'search_items'               => __( 'Buscar Marca', 'jd_pwb_brand' ),
		'not_found'                  => __( 'Sin resultados', 'jd_pwb_brand' ),
		'no_terms'                   => __( 'No hay Marcas', 'jd_pwb_brand' ),
		'items_list'                 => __( 'Lista de Marcas', 'jd_pwb_brand' ),
		'items_list_navigation'      => __( 'Navegar por las marcas', 'jd_pwb_brand' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'pwb-brand', array( 'product' ), $args );

}
add_action( 'init', 'jd_pwb_brand', 0 );
