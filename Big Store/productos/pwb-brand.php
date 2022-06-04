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

// Registro de campo para las marcas --> Agrega un campo media para El logo de la marca



class Metabox{
	private $meta_fields = array(
                array(
                    'label' => 'Logo Marca',
                    'id' => 'brand_logo',
                    'type' => 'media',
                )

	);
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'pwb-brand_add_form_fields', array( $this, 'create_fields' ), 10, 2 );
			add_action( 'pwb-brand_edit_form_fields', array( $this, 'edit_fields' ),  10, 2 );
			add_action( 'created_pwb-brand', array( $this, 'save_fields' ), 10, 1 );
			add_action( 'edited_pwb-brand',  array( $this, 'save_fields' ), 10, 1 ); 
                        add_action( 'admin_footer', array( $this, 'media_fields' ) );
			add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
            
		}
	}
    
    public function media_fields() {
		?><script>
			jQuery(document).ready(function($){
				if ( typeof wp.media !== 'undefined' ) {
					var _custom_media = true,
					_orig_send_attachment = wp.media.editor.send.attachment;
					$('.taxokey-media').click(function(e) {
						var send_attachment_bkp = wp.media.editor.send.attachment;
						var button = $(this);
						var id = button.attr('id').replace('_button', '');
						_custom_media = true;
							wp.media.editor.send.attachment = function(props, attachment){
							if ( _custom_media ) {
								$('input#'+id).val(attachment.id);
								$('div#preview'+id).css('background-image', 'url('+attachment.url+')');
							} else {
								return _orig_send_attachment.apply( this, [props, attachment] );
							};
						}
						wp.media.editor.open(button);
						return false;
					});
					$('.add_media').on('click', function(){
						_custom_media = false;
					});
					$('.remove-media').on('click', function(){
						var parent = $(this).parents('td');
						parent.find('input[type="text"]').val('');
						parent.find('div').css('background-image', 'url()');
					});
				}
			});
		</script><?php
	}

	public function create_fields( $taxonomy ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			if ( empty( $meta_value ) ) {
				if ( isset( $meta_field['default'] ) ) {
					$meta_value = $meta_field['default'];
				}
			}
			switch ( $meta_field['type'] ) {
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? '' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= '<div class="form-field">'.$this->format_rows( $label, $input ).'</div>';
		}
		echo $output;
	}
	public function edit_fields( $term, $taxonomy ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_term_meta( $term->term_id, $meta_field['id'], true );
			switch ( $meta_field['type'] ) {
                
                                case 'media':
                                    $meta_url = '';
                                        if ($meta_value) {
                                            $meta_url = wp_get_attachment_url($meta_value);
                                        }
                                    $input = sprintf(
                                        '<input style="display:none;" id="%s" name="%s" type="text" value="%s"><div id="preview%s" style="margin-right:10px;border:2px solid #eee;display:inline-block;width: 100px;height:100px;background-image:url(%s);background-size:contain;background-repeat:no-repeat;"></div><input style="width: 19%%;margin-right:5px;" class="button taxokey-media" id="%s_button" name="%s_button" type="button" value="Select" /><input style="width: 19%%;" class="button remove-media" id="%s_buttonremove" name="%s_buttonremove" type="button" value="Clear" />',
                                        $meta_field['id'],
                                        $meta_field['id'],
                                        $meta_value,
                                        $meta_field['id'],
                                        $meta_url,
                                        $meta_field['id'],
                                        $meta_field['id'],
                                        $meta_field['id'],
                                        $meta_field['id']
                                    );
                                    break;

				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? '' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<div class="form-field">' . $output . '</div>';
	}
	public function format_rows( $label, $input ) {
		return '<tr class="form-field"><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}
	public function save_fields( $term_id ) {
		foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_term_meta( $term_id, $meta_field['id'], $_POST[ $meta_field['id']] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_term_meta( $term_id, $meta_field['id'], '0' );
			}
		}
	}
}
if (class_exists('Metabox')) {
	new Metabox;
};
