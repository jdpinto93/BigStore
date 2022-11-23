<?php

class Met_higthlig_ {
	private $config = '{"title":"FeaturesLogo","description":"Aqui se muestran algunos incentivos de compra","prefix":"big","domain":"BigExpress","class_name":"Met_higthlig_","post-type":["post"],"context":"side","priority":"default","cpt":"product","fields":[{"type":"media","label":"FeaturesLogo","button-text":"Subir","return":"id","modal-title":"Cargar Archivo","modal-button":"Cargar Archivo","id":"_featureslogo"}]}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
		$this->process_cpts();
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
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

	public function admin_enqueue_scripts() {
		global $typenow;
		if ( in_array( $typenow, $this->config['post-type'] ) ) {
			wp_enqueue_media();
		}
	}

	public function admin_head() {
		global $typenow;
		if ( in_array( $typenow, $this->config['post-type'] ) ) {
			?><script>
				jQuery.noConflict();
				(function($) {
					$(function() {
						$('body').on('click', '.rwp-media-toggle', function(e) {
							e.preventDefault();
							let button = $(this);
							let rwpMediaUploader = null;
							rwpMediaUploader = wp.media({
								title: button.data('modal-title'),
								button: {
									text: button.data('modal-button')
								},
								multiple: true
							}).on('select', function() {
								let attachment = rwpMediaUploader.state().get('selection').first().toJSON();
								button.prev().val(attachment[button.data('return')]);
							}).open();
						});
					});
				})(jQuery);
			</script><?php
			?><?php
		}
	}

	public function save_post( $post_id ) {
		foreach ( $this->config['fields'] as $field ) {
			switch ( $field['type'] ) {
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
		$this->fields_div();
	}

	private function fields_div() {
		foreach ( $this->config['fields'] as $field ) {
			?><div class="components-base-control">
				<div class="components-base-control__field"><?php
					$this->label( $field );
					$this->field( $field );
				?></div>
			</div><?php
		}
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			case 'media':
				printf(
					'<label class="components-base-control__label" for="%s_button">%s</label>',
					$field['id'], $field['label']
				);
				break;
			default:
				printf(
					'<label class="components-base-control__label" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
			case 'media':
				$this->input( $field );
				$this->media_button( $field );
				break;
			default:
				$this->input( $field );
		}
	}

	private function input( $field ) {
		if ( $field['type'] === 'media' ) {
			$field['type'] = 'text';
		}
		printf(
			'<input class="components-text-control__input %s" id="%s" name="%s" %s type="%s" value="%s">',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function media_button( $field ) {
		printf(
			' <button class="button rwp-media-toggle" data-modal-button="%s" data-modal-title="%s" data-return="%s" id="%s_button" name="%s_button" type="button">%s</button>',
			isset( $field['modal-button'] ) ? $field['modal-button'] : __( 'Select this file', 'BigExpress' ),
			isset( $field['modal-title'] ) ? $field['modal-title'] : __( 'Choose a file', 'BigExpress' ),
			$field['return'],
			$field['id'], $field['id'],
			isset( $field['button-text'] ) ? $field['button-text'] : __( 'Upload', 'BigExpress' )
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
new Met_higthlig_;
