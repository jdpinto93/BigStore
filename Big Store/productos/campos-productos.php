<?php

// Meta Box Class: ImformacionDeProductosMetaBox
// Get the field value: $metavalue = get_post_meta( $post_id, $field_id, true );
class ImformacionDeProductosMetaBox{

	private $screen = array(
		'product',
                        
	);

	private $meta_fields = array(
                array(
                    'label' => 'Costo',
                    'id' => '_cost',
                    'type' => 'number',
                ),
    
                array(
                    'label' => 'Marca',
                    'id' => 'brand',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Mpn',
                    'id' => 'mpn',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'Gtin',
                    'id' => '_gtin',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'upc',
                    'id' => 'upc',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'ean',
                    'id' => 'ean',
                    'type' => 'text',
                )

	);

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}

	public function add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box(
				'ImformacionDeProductos',
				__( 'ImformacionDeProductos', '' ),
				array( $this, 'meta_box_callback' ),
				$single_screen,
				'normal',
				'default'
			);
		}
	}

	public function meta_box_callback( $post ) {
		wp_nonce_field( 'ImformacionDeProductos_data', 'ImformacionDeProductos_nonce' );
		$this->field_generator( $post );
	}
	public function field_generator( $post ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) ) {
				if ( isset( $meta_field['default'] ) ) {
					$meta_value = $meta_field['default'];
				}
			}
			switch ( $meta_field['type'] ) {
				default:
                                    $input = sprintf(
                                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                                        $meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
                                        $meta_field['id'],
                                        $meta_field['id'],
                                        $meta_field['type'],
                                        $meta_value
                                    );
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	public function format_rows( $label, $input ) {
		return '<tr><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}

	public function save_fields( $post_id ) {
		if ( ! isset( $_POST['ImformacionDeProductos_nonce'] ) )
			return $post_id;
		$nonce = $_POST['ImformacionDeProductos_nonce'];
		if ( !wp_verify_nonce( $nonce, 'ImformacionDeProductos_data' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
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
				update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $meta_field['id'], '0' );
			}
		}
	}
}

if (class_exists('ImformacionDeProductosMetabox')) {
	new ImformacionDeProductosMetabox;
};