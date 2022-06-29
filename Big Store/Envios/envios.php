<?php
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
                        'MX', // Unites States of America
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
 
                /**
                 * This function is used to calculate the shipping cost. Within this function we can check for weights, dimensions and other parameters.
                 *
                 * @access public
                 * @param mixed $package
                 * @return void
                 */
                public function calculate_shipping( $package = array() ) {
                    
                    $weight = 0;
                    $cost = 0;
                    $country = $package["destination"]["country"];
 
                    foreach ( $package['contents'] as $item_id => $values ) 
                    { 
                        $_product = $values['data']; 
                        $weight = $weight + $_product->get_weight() * $values['quantity']; 
                    }
 
                    $weight = wc_get_weight( $weight, 'kg' );
 
                    if( $weight <= 10 ) {

                        $cost = $weight*20;

                    } else {
 
                        $cost = $weight*15;
 
                    }
 
                    $countryZones = array(
                        'MX' => 0,
                        );
 
                    $zonePrices = array(
                        0 => 0,
                        );
 
                    $zoneFromCountry = $countryZones[ $country ];
                    $priceFromZone = $zonePrices[ $zoneFromCountry ];
 
                    $cost += $priceFromZone;
 
                    $rate = array(
                        'id' => $this->id,
                        'label' => $this->title,
                        'cost' => $cost
                    );
 
                    $this->add_rate( $rate );
                    
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