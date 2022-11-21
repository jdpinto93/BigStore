<?php
/**
 * WooCommerce EAN Functions
 * @since       0.1.0
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'Woo_EAN_Functions' ) ) {

    /**
     * Woo_EAN_Functions class
     *
     * @since       0.2.0
     */
    class Woo_EAN_Functions {

        /**
         * @var         Woo_EAN_Functions $instance The one true Woo_EAN_Functions
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
         * @return      object self::$instance The one true Woo_EAN_Functions
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new Woo_EAN_Functions();
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

            add_action( 'wp_enqueue_scripts', array( $this, 'scripts_styles' ) );

            add_action( 'woocommerce_product_meta_end', array( $this, 'maybe_display_tn' ) );

            add_filter( 'woocommerce_structured_data_product', array( $this, 'add_ean_to_structured_data' ), 10, 2 );

        }

        /**
         * Load scripts
         *
         * @since       0.1.0
         * @return      void
         */
        public function scripts_styles( $hook ) {

            if( !is_product() )
                return;

            global $post;

            // Use minified libraries if SCRIPT_DEBUG is turned off
            $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

            wp_enqueue_script( 'woo-add-ean', Woo_EAN_URL . 'assets/js/woo-add-ean' . $suffix . '.js', array( 'wc-add-to-cart-variation', 'jquery' ), Woo_EAN_VER, true );

            $localized = array(
                "ean" => get_post_meta( $post->ID, 'hwp_product_ean', 1 )
            );

            $variations;

            // handle variations pre 3.2
            if( self::get_wc_version() < 3.2 ) {

                $product = new WC_Product( $post->ID );

                $vars = new WC_Product_Variable( $post->ID );
                $variations = $vars->get_available_variations();

            } else {

                // 3.2 + variations
                global $product;

                if( !is_object($product) ) {
                    $product = wc_get_product( $post->ID );
                }

                if( is_object($product) && $product->is_type( 'variable' ) ) {

                    $variations = $product->get_available_variations();

                }

                if( function_exists('is_composite_product') && is_composite_product() || is_object($product) && $product->is_type( 'composite' ) ) {

                    $localized["is_composite"] = true;

                    $components = $product->get_composite_data();
                    foreach ( $components as $component_id => $component ) {
                        $comp = $product->get_component($component_id);

                        $product_ids = $comp->get_options();

                        foreach ($product_ids as $id) {

                            $variable_product = new WC_Product_Variable( $id );

                            $composite_variations[] = $variable_product->get_available_variations();

                        }
                    }

                } elseif( class_exists('WC_Product_Bundle') && $product->is_type('bundle') ) {

                    // reusing composite code because it's essentially the same thing
                    $localized["is_composite"] = true;

                    $bundle_items = $product->get_bundled_items();

                    foreach ( $bundle_items as $product ) {

                        $wc_product = wc_get_product( $product->product_id );

                        if( $wc_product->is_type('variable') ) {
                            $composite_variations[] = $wc_product->get_available_variations();
                        }

                    }

                }
            }

            if( !empty( $variations ) ) {

                foreach ( $variations as $variation ) {
                    if( !empty( $variation ) && $variation['variation_is_active'] != false ) {

                        $localized["variation_eans"][$variation['variation_id']] = get_post_meta( $variation['variation_id'], 'hwp_var_ean', 1 );

                    }
                }

            }

            if( !empty( $composite_variations ) ) {
                foreach ( $composite_variations as $id => $comp_variation ) {

                    foreach ( $comp_variation as $variation ) {
                        if( !empty( $variation ) && $variation['variation_is_active'] != false ) {

                            $localized["composite_variation_eans"][$variation['variation_id']] = get_post_meta( $variation['variation_id'], 'hwp_var_ean', 1 );

                        }
                    }
                }
            }

            wp_localize_script( 'woo-add-ean', 'wooEanVars', $localized );

        }

        /**
         * Get WooCommerce version number
         *
         * @since       0.1.0
         * @return      int
         */
        public static function get_wc_version() {
            global $woocommerce;
            return floatval( $woocommerce->version );
        }

        /**
         * Load scripts
         *
         * @since       0.1.0
         * @return      void
         */
        public function maybe_display_tn() {

            global $post;
            $ean = get_post_meta( $post->ID, 'hwp_product_ean', 1 );
            $display = get_option( 'hwp_display_ean' );
            $label = ( !empty( get_option( 'hwp_ean_text' ) ) ? get_option( 'hwp_ean_text' ) : 'EAN' );

            if( !empty( $display ) && 'yes' === $display )
             return;

            if( !empty( $ean ) ) {

                echo '<span class="hwp-ean">' . esc_html__( $label . ': ', 'woo-add-ean' ) . '<span>' . get_post_meta( $post->ID, 'hwp_product_ean', 1 ) . '</span></span>';

            }

        }

        /**
         * Adds EAN field to product JSON-LD.
         *
         * @since       0.5.0
         * @return      array    Modified WooCommerce product structured data.
         */
        public function add_ean_to_structured_data( $markup, $product ) {
		
            // Bail if product variable not available
            if ( ! $product ) { return $markup; }
            
            $product_id = $product->get_id();
            $ean = get_post_meta( $product_id, 'hwp_product_ean', 1 );
            $markup['ean'] = trim($ean);
            return $markup;
        
        }

    }

    $Woo_EAN_Functions = new Woo_EAN_Functions();
    $Woo_EAN_Functions->instance();

} // end class_exists check