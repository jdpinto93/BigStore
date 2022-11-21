<?php

/*
 * Remove product data tabs
 */

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

		//unset( $tabs['description'] );      	// Remove the description tab
		unset( $tabs['reviews'] ); 			// Remove the reviews tab
		//unset( $tabs['additional_information'] );  	// Remove the additional information tab
    return $tabs;
}


/*
 * Funcion de iconos para medios de pagos
 */

add_filter('woocommerce_gateway_icon', function ($contenido, $id) {
    if ('bacs' == $id)
      //  return '<img src="https://i.postimg.cc/Zn9XpD7R/banco-santander.png" alt="Pago con transferencia">';
    return $contenido;
}, 10, 2);

add_filter('woocommerce_gateway_icon', function ($contenido, $id) {
    if ('cod' == $id)
     //   return '<img src="https://i.postimg.cc/cHhR5ZYW/Atrato-full-color-png-removebg-preview.png" alt="Pago con atrato">';
    return $contenido;
}, 10, 2);

add_filter('woocommerce_gateway_icon', function ($contenido, $id) {

    if ('bank_transfer_1' == $id)
      //  return '<img src="https://i.postimg.cc/h4VkckDq/log-efectivo.jpg" alt="Pago con reserve">';
    return $contenido;
}, 10, 2);

/*************************************************************************************
 * Add a custom product data tab
 *

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
	
	// Adds the new tab
	
	$tabs['test_tab'] = array(
		'title' 	=> __( 'Informacion Tecnica', 'woocommerce' ),
		'priority' 	=> 10,
		'callback' 	=> 'ficha_tecnica'
	);		
	$tabs['test_tab2'] = array(
		'title' 	=> __( '¿Porque Comprar?', 'woocommerce' ),
		'priority' 	=> 20,
		'callback' 	=> 'porque_comprar_icecat'

	);

		return $tabs;
}


//tabs de ficha tecnica
function ficha_tecnica(){
    require "/data/www/html/bigcom_com_mx/servicios/xentra/xentra-icecat2.php";
	$icecat_json =$icecat;
echo '<section class="">  <div style="width=100%;">';
   if (isset($icecat_json->FeaturesGroups)) {
     $FeaturesGroups=$icecat_json->FeaturesGroups;
        foreach($FeaturesGroups as $k => $Featuresgroup){
                   //-----------inicio table-------------//
echo '<div class="bigcomdivficha">';
    echo '<table class="bigcomtableficha">';
 		if (isset($Featuresgroup->FeatureGroup->Name->Value)) { 
			echo '<h3 class="bigcomnombreficha">'.$Featuresgroup->FeatureGroup->Name->Value.'</h3>';
}
	if (isset($Featuresgroup->Features)) {
        $Features=$Featuresgroup->Features;
             foreach($Features as $k => $Feature){
                echo '<tr class="bigcomfichatr">
                   <td style="width:50%">'.$Feature->Feature->Name->Value.' </td>
                      <td style="width:50%">'.$Feature->PresentationValue.' </td>
      			</tr>';
			}  
      }
echo '</table>';
	echo '</div>';
      	  } 
      }
   echo '</div></section>';
}
add_shortcode('ficha_tecnica_icecad', 'ficha_tecnica');

//tabs de razones de compra
function porque_comprar_icecat(){
  require "/data/www/html/bigcom_com_mx/servicios/xentra/xentra-icecat2.php";
  $icecat_json =$icecat;

echo '<div class="bigcomsectionReasonsToBuy" style="width=100%;display:block;">';
	if (isset($icecat_json->ReasonsToBuy )) {
		$ReasonsToBuy=$icecat_json->ReasonsToBuy;
		echo '<h1 class="bigcomReasonsToBuy">Razones para comprar</h1>';
		if(sizeof($ReasonsToBuy) > 0){
		   }
echo '<div class="bigcomdivfichaReasons">';
echo '<table class="bigcomtableficha">';
	foreach($ReasonsToBuy as $k => $Reasons){
		if (isset($Reasons->Title)) { 
echo '<tr class="bigcomfichatrt">
		<td style="width:100%">'.$Reasons->Title.' </td>
	</tr>';
}
	if (isset($Reasons->Value)) { 
echo '<tr class="bigcomfichatrv">
		<td style="width:100%">'.$Reasons->Value.' </td>
  	</tr>';
	}
}
	echo '</table>';
		echo '</div>';
	}
  echo '</div>';
}
add_shortcode('razon_icecad', 'porque_comprar_icecat');

************************************************************************************/

/*
 * Desvincular el email de nuevo pedido de los CRON
 */

add_filter( 'woocommerce_defer_transactional_emails', '__return_false' );

/*
 * Modificar mensaje del footer
 */

function remove_footer_admin (){
    echo '<span id="footer-thankyou">Derechos Reservados <a href="https://bigcom.com.mx/" target="_blank">Bigcom</a></span>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

/*
 * Eliminar el logo nativo de wordpress
 */

function example_admin_bar_remove_logo() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'wp-logo' );
}
add_action( 'wp_before_admin_bar_render', 'example_admin_bar_remove_logo', 0 );

/*
 * Marcar el checkbox de envio de direccion permanentemente.
 */

add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );

function preloader_gift() {
		if( is_shop()){
		?><div class="preloader">
				<div>
					<p><img src="http://localhost/storeBigcom/wp-content/uploads/2022/11/75400-shopping-bag.gif" /></p>
				</div>
		</div><?php
			}elseif(is_tax()){
		?><div class="preloader">
				<div>
					<p><img src="http://localhost/storeBigcom/wp-content/uploads/2022/11/75400-shopping-bag.gif" /></p>
				</div>
		</div><?php
	}
}
add_action( 'wp_head', 'preloader_gift' );