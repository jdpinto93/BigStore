<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

/*
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
    function bigmx_shipping_method() {
        if ( ! class_exists( 'BigExpress_Shipping_Method' ) ) {
            class BigExpress_Shipping_Method extends WC_Shipping_Method {
                /**
                 * Constructor for your shipping class
                 *
                 * @access public
                 * @return void
                 */
                public function __construct() {
                    $this->id                 = 'bigmx'; 
                    $this->method_title       = __( 'BigExpress Shipping', 'bigmx' );  
                    $this->method_description = __( 'Custom Shipping Method for BigExpress', 'bigmx' ); 
 
                    // Availability & Countries
                    $this->availability = 'including';
                    $this->countries = array(
                        'MX', // Mexico
                        );
 
                    $this->init();
 
                    $this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';   
                    $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'BigExpress Shipping', 'bigmx' );
                }
 
                /**
                 * Init your settings
                 *
                 * @access public
                 * @return void
                 */
                function init() {
                    // Load the settings API
                    $this->init_form_fields(); 
                    $this->init_settings(); 
 
                    // Save settings in admin if you have any defined
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }
 
                /**
                 * Define settings field for this shipping
                 * @return void 
                 */
                function init_form_fields() { 
 
                    $this->form_fields = array(
 
                     'enabled' => array(
                          'title' => __( 'Enable', 'bigmx' ),
                          'type' => 'checkbox',
                          'description' => __( 'Enable this shipping.', 'bigmx' ),
                          'default' => 'yes'
                          ),
 
                     'title' => array(
                        'title' => __( 'Title', 'bigmx' ),
                          'type' => 'text',
                          'description' => __( 'Title to be display on site', 'bigmx' ),
                          'default' => __( 'BigExpress Shipping', 'bigmx' )
                          ),
 
                     'weight' => array(
                        'title' => __( 'Weight (kg)', 'bigmx' ),
                          'type' => 'number',
                          'description' => __( 'Maximum allowed weight', 'bigmx' ),
                          'default' => 100
                          ),
                    );
 
                }

                // Función que calcula el peso volumétrico del pedido
public function calculate_volumetric_weight( $package = array() ) {
    // Calcula el peso volumétrico del pedido en función del volumen y la densidad
    $volume = 0;
    foreach ( $package['contents'] as $item_id => $values ) {
        $_product = $values['data'];
        $volume = $volume + $_product->get_width() * $_product->get_height() * $_product->get_length() * $values['quantity'];
    }
    $volumetric_weight = ceil( $volume / 5000 );

    return $volumetric_weight;
}


// Función que calcula el coste del envío
public function calculate_shipping( $package = array() ) {
    // Obtiene el peso del pedido
    $weight = 0;
    foreach ( $package['contents'] as $item_id => $values ) {
        $_product = $values['data'];
        $weight = $weight + $_product->get_weight() * $values['quantity'];
    }

    // Obtiene el peso volumétrico del pedido
    $volumetric_weight = $this->calculate_volumetric_weight( $package );

    // Toma el peso más alto (peso real o peso volumétrico)
    $total_weight = max( $weight, $volumetric_weight );

    // Calcula el coste del envío en función del peso
    $cost = ceil( $total_weight / 5 ) * 99;

    // Establece el coste del envío
    $this->add_rate( array(
        'id' => $this->id,
        'label' => $this->title,
        'cost' => $cost,
    ) );
}
            }
        
        }
    }
 
    add_action( 'woocommerce_shipping_init', 'bigmx_shipping_method' );
 
    function add_bigmx_shipping_method( $methods ) {
        $methods[] = 'BigExpress_Shipping_Method';
        return $methods;
    }
 
    add_filter( 'woocommerce_shipping_methods', 'add_bigmx_shipping_method' );
 
    function bigmx_validate_order( $posted )   {
 
        $packages = WC()->shipping->get_packages();
 
        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
         
        if( is_array( $chosen_methods ) && in_array( 'bigmx', $chosen_methods ) ) {
             
            foreach ( $packages as $i => $package ) {
 
                if ( $chosen_methods[ $i ] != "bigmx" ) {
                             
                    continue;
                             
                }
 
                $BigExpress_Shipping_Method = new BigExpress_Shipping_Method();
                $weightLimit = (int) $BigExpress_Shipping_Method->settings['weight'];
                $weight = 0;
 
                foreach ( $package['contents'] as $item_id => $values ) 
                { 
                    $_product = $values['data']; 
                    $weight = $weight + $_product->get_weight() * $values['quantity']; 
                }
 
                $weight = wc_get_weight( $weight, 'kg' );
                
                if( $weight > $weightLimit ) {
 
                        $message = sprintf( __( 'Disculpe, usted tiene en su carrito %d kg y excede la cantidad maxima de %d kg para %s lamentamos informarle que nuestra paqueteria no podra hacer un solo envio por lo que sugerimos que haga varios pedidos sin exceder el limite permitido', 'bigmx' ), $weight, $weightLimit, $BigExpress_Shipping_Method->title );
                             
                        $messageType = "error";
 
                        if( ! wc_has_notice( $message, $messageType ) ) {
                         
                            wc_add_notice( $message, $messageType );
                      
                        }
                }
                
            }       
        } 
    }
 
    add_action( 'woocommerce_review_order_before_cart_contents', 'bigmx_validate_order' , 10 );
    add_action( 'woocommerce_after_checkout_validation', 'bigmx_validate_order' , 10 );
}