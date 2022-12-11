<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

/**
 * Documentos del Producto = get_post_meta( get_the_ID(), '__document_products', true )
 * Ficha Tecnica del Producto = get_post_meta( get_the_ID(), '__ficha_product', true )
 * HigthLigt Del Producto = get_post_meta( get_the_ID(), '__higthlit_product', true )
 * Razones de Compra del Producto = get_post_meta( get_the_ID(), '__reazon_to_buy_product', true )
 * Puntos Importantes = get_post_meta( get_the_ID(), '__bullet_points_product', true )
 */
class product_dates {
	private $config = '{"title":"Documentos del Producto","description":"Fiche tecnica, Features Logos, Documentos del Producto, Bullet Points, Reazon to Buy.","prefix":"__","domain":"BigExpress","class_name":"product_dates","post-type":["post"],"context":"normal","priority":"low","cpt":"product","fields":[{"type":"editor","label":"Documentos del Producto","wpautop":"1","media-buttons":"1","teeny":"1","id":"__document_products"},{"type":"editor","label":"Ficha Tecnica del Producto","id":"__ficha_product"},{"type":"editor","label":"HigthLigt Del Producto","wpautop":"1","media-buttons":"1","teeny":"1","id":"__higthlit_product"},{"type":"editor","label":"Razones de Compra del Producto","wpautop":"1","media-buttons":"1","teeny":"1","id":"__reazon_to_buy_product"},{"type":"editor","label":"Puntos Importantes","wpautop":"1","media-buttons":"1","teeny":"1","id":"__bullet_points_product"}]}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
		$this->process_cpts();
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'admin_head', [ $this, 'admin_head' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );
	}

	public function process_cpts() {
		if ( !empty( $this->config['cpt'] ) ) {
			if ( empty( $this->config['post-type'] ) ) {
				$this->config['post-type'] = [];
			}
			$parts = explode( ',', $this->config['cpt'] );
			$parts = array_map( 'trim', $parts );
			$this->config['post-type'] = array_merge( $this->config['post-type'], $parts );
		}
	}

	public function add_meta_boxes() {
		foreach ( $this->config['post-type'] as $screen ) {
			add_meta_box(
				sanitize_title( $this->config['title'] ),
				$this->config['title'],
				[ $this, 'add_meta_box_callback' ],
				$screen,
				$this->config['context'],
				$this->config['priority']
			);
		}
	}

	public function admin_head() {
		global $typenow;
		if ( in_array( $typenow, $this->config['post-type'] ) ) {
			?><?php
		}
	}

	public function save_post( $post_id ) {
		foreach ( $this->config['fields'] as $field ) {
			switch ( $field['type'] ) {
				case 'editor':
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = wp_filter_post_kses( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
					break;
				default:
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
			}
		}
	}

	public function add_meta_box_callback() {
		echo '<div class="rwp-description">' . $this->config['description'] . '</div>';
		$this->fields_table();
	}

	private function fields_table() {
		?><table class="form-table" role="presentation">
			<tbody><?php
				foreach ( $this->config['fields'] as $field ) {
					?><tr>
						<th scope="row"><?php $this->label( $field ); ?></th>
						<td><?php $this->field( $field ); ?></td>
					</tr><?php
				}
			?></tbody>
		</table><?php
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			case 'editor':
				echo '<div class="">' . $field['label'] . '</div>';
				break;
			default:
				printf(
					'<label class="" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
			case 'editor':
				$this->editor( $field );
				break;
			default:
				$this->input( $field );
		}
	}

	private function editor( $field ) {
		wp_editor( $this->value( $field ), $field['id'], [
			'wpautop' => isset( $field['wpautop'] ) ? true : false,
			'media_buttons' => isset( $field['media-buttons'] ) ? true : false,
			'textarea_name' => $field['id'],
			'textarea_rows' => isset( $field['rows'] ) ? isset( $field['rows'] ) : 20,
			'teeny' => isset( $field['teeny'] ) ? true : false
		] );
	}

	private function input( $field ) {
		printf(
			'<input class="regular-text %s" id="%s" name="%s" %s type="%s" value="%s">',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = $field['default'];
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}

}
new product_dates;