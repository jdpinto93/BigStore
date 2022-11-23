<?php
/**
 * WooCommerce SAT Admin
 * @since       0.1.0
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'Woo_SAT_Admin' ) ) {

    /**
     * Woo_SAT_Admin class
     *
     * @since       0.2.0
     */
    class Woo_SAT_Admin {

        /**
         * @var         Woo_SAT_Admin $instance The one true Woo_SAT_Admin
         * @since       0.2.0
         */
        private static $instance;
        public static $errorpath = '../php-error-log.php';
        public static $active = array();
        // sample: error_log("meta: " . $meta . "\r\n",3,self::$errorpath);

        /**
         * Get active instance
         *
         * @access      public
         * @since       0.2.0
         * @return      object self::$instance The one true Woo_SAT_Admin
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new Woo_SAT_Admin();
                self::$instance->hooks();
            }

            return self::$instance;
        }


        /**
         * Include necessary files
         *
         * @access      private
         * @since       0.2.0
         * @return      void
         */
        private function hooks() {

            add_filter( 'woocommerce_get_settings_products', array( $this,  'sat_settings' ), 10, 2 );

            add_action( 'woocommerce_product_options_inventory_product_data', array( $this, 'product_tn_field' ) );
            add_action( 'woocommerce_process_product_meta', array( $this, 'save_product_tn' ) );

            add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'variation_tn_field' ), 10, 3 );
            add_action( 'woocommerce_save_product_variation', array( $this, 'save_variations' ), 10, 2 );

        }

        /**
         * Add SAT Field
         *
         * @since       0.1.0
         * @return      void
         */
        public function product_tn_field() {

            global $post;

            $option_text = get_option( 'hwp_sat_text' );

            $label = ( !empty( $option_text ) ? $option_text : 'SAT' );

            //add SAT field for variations
            woocommerce_wp_text_input( 
                array(    
                 'id' => 'hwp_product_sat',
                 'label' => $label,
                 'desc_tip' => 'true',
                 'description' => 'INTRODUZCA EL VALOR DE SAT DEL PRODUCTO',
                 'value'       => get_post_meta( $post->ID, 'hwp_product_sat', true ),
                )
            );

        }

        /**
         * Add SAT Field for variations
         *
         * @since       0.1.0
         * @return      void
         */
        public function variation_tn_field( $loop, $variation_data, $variation ) {

            $option_text = get_option( 'hwp_sat_text' );

            $label = ( !empty( $option_text ) ? $option_text : 'SAT' );

            //add SAT field for variations
            woocommerce_wp_text_input( 
                array(    
                 'id' => 'hwp_var_sat[' . $variation->ID . ']',
                 'label' => $label,
                 'desc_tip' => 'true',
                 'description' => 'Unique SAT for variation? Enter it here.',
                 'value'       => get_post_meta( $variation->ID, 'hwp_var_sat', true ),
                )
            );

        }

        /**
         * Save variation settings
         *
         * @since       0.1.0
         * @return      void
         */
        public function save_variations( $post_id ) {

           $tn_post = $_POST['hwp_var_sat'][ $post_id ];

           // save
           if( isset( $tn_post ) ) {
              update_post_meta( $post_id, 'hwp_var_sat', esc_attr( $tn_post ) );
           }

           // remove if meta is empty
           $tn_meta = get_post_meta( $post_id,'hwp_var_sat', true );

           if ( empty( $tn_meta ) ) {
              delete_post_meta( $post_id, 'hwp_var_sat', '' );
           }

        }

        /**
         * Save simple product SAT settings
         *
         * @since       0.1.0
         * @return      void
         */
        public function save_product_tn( $post_id ) {

            $sat_post = $_POST['hwp_product_sat'];

            // save the sat
            if( isset( $sat_post ) ) {
                update_post_meta( $post_id, 'hwp_product_sat', esc_attr( $sat_post ) );
            }

            // remove if SAT meta is empty
            $sat_meta = get_post_meta( $post_id, 'hwp_product_sat', true );

            if( empty( $sat_meta ) ) {
                delete_post_meta( $post_id, 'hwp_product_sat', '' );
            }

        }

        /**
         * Add settings
         *
         * @access      public
         * @since       0.1
         */
        public function sat_settings( $settings, $current_section ) {

            /**
             * Check the current section is what we want
             **/
            if ( $current_section == 'inventory' ) {
                // Add Title to the Settings
                $settings[] = array( 'name' => __( 'Configurar SAT', 'woo-add-sat' ), 'type' => 'title', 'desc' => __( 'Las siguientes opciones se utilizan cambiar los valores de SAT', 'woo-add-sat' ), 'id' => 'woo-add-sat' );
                // Add first checkbox option
                $settings[] = array(
                    'name'     => __( '¿Ocultar SAT en páginas de un solo producto?', 'woo-add-sat' ),
                    //'desc_tip' => __( 'This will output the SAT on your product pages.', 'woo-add-sat' ),
                    'id'       => 'hwp_display_sat',
                    'type'     => 'checkbox',
                    'css'      => 'min-width:300px;',
                );
                
                $settings[] = array( 'type' => 'sectionend', 'id' => 'woo-add-sat' );

                $settings[] = array(
                    'name'     => __( 'Cambiar Nombre SAT', 'woo-add-sat' ),
                    'desc_tip' => __( 'Enter the label you\'d like to use instead of SAT.', 'woo-add-sat' ),
                    'id'       => 'hwp_sat_text',
                    'type'     => 'text',
                    'placeholder' => 'SAT',
                );
                
                $settings[] = array( 'type' => 'sectionend', 'id' => 'hwp_sat_text' );

                return $settings;
            
            /**
             * If not, return the standard settings
             **/
            } else {
                return $settings;
            }

        }

    }

    $Woo_SAT_Admin = new Woo_SAT_Admin();
    $Woo_SAT_Admin->instance();

} // end class_exists check