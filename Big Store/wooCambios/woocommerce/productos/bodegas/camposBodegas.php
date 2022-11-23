<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

class JpBodegas{
	private $meta_fields = array(
                array(
                    'label' => 'Calle',
                    'id' => 'direccion_calle',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Numero Exterior',
                    'id' => 'jp_num_exterior',
                    'type' => 'number',
                ),
    
                array(
                    'label' => 'Numero Interior',
                    'id' => 'jp_num_interior',
                    'type' => 'number',
                ),
    
                array(
                    'label' => 'Colonia',
                    'id' => 'jp_direccion_colonia',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Estado',
                    'id' => '_jpdireccion_estado',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Municipio',
                    'id' => 'jp_direccion_municipio',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Codigo Postal',
                    'id' => 'postal_code_bodega',
                    'type' => 'number',
                ),
    
                array(
                    'label' => 'Nombre de contacto',
                    'id' => 'contacto_bodega',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Telefono Movil',
                    'id' => 'tel_contacto_bodega',
                    'type' => 'tel',
                ),
    
                array(
                    'label' => 'Telefono Fijo',
                    'id' => 'tel_contacto_bodega1',
                    'type' => 'tel',
                ),
    
                array(
                    'label' => 'Entre calles',
                    'id' => 'jp_entre_calles',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Indicaciones',
                    'id' => 'jp_indicaciones',
                    'type' => 'textarea',
                )

	);
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'pwb-bodega_add_form_fields', array( $this, 'create_fields' ), 10, 2 );
			add_action( 'pwb-bodega_edit_form_fields', array( $this, 'edit_fields' ),  10, 2 );
			add_action( 'created_pwb-bodega', array( $this, 'save_fields' ), 10, 1 );
			add_action( 'edited_pwb-bodega',  array( $this, 'save_fields' ), 10, 1 ); 
		}
	}
    
	public function create_fields( $taxonomy ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_term_meta( $term->term_id, $meta_field['id'], true );
			switch ( $meta_field['type'] ) {
                
                                case 'textarea':
                                    $input = sprintf(
                                        '<textarea id="%s" name="%s" rows="5">%s</textarea>',
                                        $meta_field['id'],
                                        $meta_field['id'],
                                        $meta_value
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
	public function edit_fields( $term, $taxonomy ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_term_meta( $term->term_id, $meta_field['id'], true );
			switch ( $meta_field['type'] ) {
                
                                case 'textarea':
                                    $input = sprintf(
                                        '<textarea id="%s" name="%s" rows="5">%s</textarea>',
                                        $meta_field['id'],
                                        $meta_field['id'],
                                        $meta_value
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
if (class_exists('JpBodegas')) {
	new JpBodegas;
};



