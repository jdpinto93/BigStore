<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Settings Page: WhatsApp
// Retrieving values: get_option( 'your_field_id' )
class WhatsApp_Settings_Page {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wph_create_settings' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_fields' ) );
	}

	public function wph_create_settings() {
		$page_title = 'whatsApp';
		$menu_title = 'Ajustes whatsApp';
		$capability = 'manage_options';
		$slug = 'WhatsApp';
		$callback = array($this, 'wph_settings_content');
                $icon = 'dashicons-admin-customizer';
		$position = 2;
		add_options_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
		
	}
    
	public function wph_settings_content() { ?>
		<div class="wrap">
			<h1>whatsApp</h1>
			<?php settings_errors(); ?>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'WhatsApp' );
					do_settings_sections( 'WhatsApp' );
					submit_button();
				?>
			</form>
		</div> <?php
	}

	public function wph_setup_sections() {
		add_settings_section( 'WhatsApp_section', 'Panel de Configuraciones de mensajes de WhatsApp', array(), 'WhatsApp' );
	}

	public function wph_setup_fields() {
		$fields = array(
					array(
						'section' => 'WhatsApp_section',
						'label' => 'Código de Área',
						'placeholder' => '52',
						'id' => 'codigo_de_area',
						'desc' => 'POR FAVOR INTRUDUZCA SU CODIGO DE AREA SEGUN EL PAIS QUE PERTENEZCA SOLO NUMEROS COMO SE INDICA EN EL EJEMPLO',
						'type' => 'number',
					),

					array(
                        'section' => 'WhatsApp_section',
                        'label' => 'Mensaje Global',
                        'id' => 'msj_global',
                        'desc' => 'POR FAVOR ESCRIBE UN MENSAJE DE WHATSAPP PARA ENVIAR DE FORMA GLOBAL DESDE LAS ACCIONES DEL PEDIDO',
                        'type' => 'textarea',
                    ),

                    array(
                        'section' => 'WhatsApp_section',
                        'label' => 'Validando Pago',
                        'id' => 'msj_validando_pago',
                        'desc' => 'POR FAVOR ESCRIBE UN MENSAJE DE WHATSAPP PARA ENVIAR CUANDO SE ESTE VALIDANDO EL PAGO',
                        'type' => 'textarea',
                    ),
        
                    array(
                        'section' => 'WhatsApp_section',
                        'label' => 'Pedido Enviado',
                        'id' => 'msj_pedido_enviado',
                        'desc' => 'POR FAVOR ESCRIBE UN MENSAJE DE WHATSAPP PARA ENVIAR CUANDO EL PEDIDO ESTE ENVIADO',
                        'type' => 'textarea',
                    ),
        
                    array(
                        'section' => 'WhatsApp_section',
                        'label' => 'Pedido Fallido',
                        'id' => 'msj_pedido_fallido',
                        'desc' => 'POR FAVOR ESCRIBE UN MENSAJE DE WHATSAPP PARA ENVIAR CUANDO EL PEDIDO FALLE',
                        'type' => 'textarea',
                    ),
        
                    array(
                        'section' => 'WhatsApp_section',
                        'label' => 'Procesando Pedido',
                        'id' => 'msj_procesando_pedido',
                        'desc' => 'POR FAVOR ESCRIBE UN MENSAJE DE WHATSAPP PARA ENVIAR CUANDO SE ESTE PROCESANDO EL PEDIDO',
                        'type' => 'textarea',
                    ),
        
                    array(
                        'section' => 'WhatsApp_section',
                        'label' => 'Pedido Completado',
                        'id' => 'msj_pedido_completado',
                        'desc' => 'POR FAVOR ESCRIBE UN MENSAJE DE WHATSAPP PARA ENVIAR CUANDO EL PROCESO DE COMPRA ESTE COMPLETO',
                        'type' => 'textarea',
                    ),
        
                    array(
                        'section' => 'WhatsApp_section',
                        'label' => 'Pedido Cancelado',
                        'id' => 'msj_pedido_cancelado',
                        'desc' => 'POR FAVOR ESCRIBE UN MENSAJE DE WHATSAPP PARA ENVIAR CUANDO SI ELPROCESO DE COMPRA SE CANCELA',
                        'type' => 'textarea',
                    )
		);
		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'wph_field_callback' ), 'WhatsApp', $field['section'], $field );
			register_setting( 'WhatsApp', $field['id'] );
		}
	}
	public function wph_field_callback( $field ) {
		$value = get_option( $field['id'] );
		$placeholder = '';
		if ( isset($field['placeholder']) ) {
			$placeholder = $field['placeholder'];
		}
		switch ( $field['type'] ) {
            
            
                        case 'textarea':
                            printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>',
                                $field['id'],
                                $placeholder,
                                $value
                                );
                                break;
            
			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$placeholder,
					$value
				);
		}
		if( isset($field['desc']) ) {
			if( $desc = $field['desc'] ) {
				printf( '<p class="description">%s </p>', $desc );
			}
		}
	}
    
}
new WhatsApp_Settings_Page();
                