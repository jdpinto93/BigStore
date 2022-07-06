<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

// Agrega los campos adicionales a las Bodegas

class MetaBodegas{
	private $meta_fields = array(
                array(
                    'label' => 'Estado',
                    'id' => 'estado_bodega',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Ciudad',
                    'id' => 'ciudad_bodega',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Dirección',
                    'id' => 'direccion_bodega',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Codigo Postal',
                    'id' => 'postal_code_bodega',
                    'type' => 'number',
                ),
    
                array(
                    'label' => 'Latitud',
                    'id' => 'latitud_bodega',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Longitud',
                    'id' => 'longitud_bodega',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Nombre de contacto',
                    'id' => 'contacto_bodega',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Telefono de Contacto',
                    'id' => 'tel_contacto_bodega',
                    'type' => 'tel',
                ),
    
                array(
                    'label' => 'Telefono de Bodega',
                    'id' => 'tel_contacto_bodega1',
                    'type' => 'tel',
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
if (class_exists('MetaBodegas')) {
	new MetaBodegas;
};
