<?php
//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

add_action ('woocommerce_order_items_table', 'optigem_sendungsnummer', 20);
		

	function optigem_sendungsnummer( $order ) {
	
	if (get_field('__codigo_de_seguimiento', $order->id)) { // Only show if field is filled
         
      $trackingCode = get_field('__codigo_de_seguimiento', $order->id);

	}

	if (get_field('__nombre_del_transportista', $order->id)) { // Only show if field is filled
         
        $nameTransport = get_field('__nombre_del_transportista', $order->id);
  
    }

      if (get_field('__fecha_de_recogida', $order->id)) { // Only show if field is filled
         
        $dateTransport = get_field('__fecha_de_recogida', $order->id);
  
    }

      if (get_field('__enlace_al_sitio_web_del_transportista', $order->id)) { // Only show if field is filled
         
        $siteTransport = get_field('__enlace_al_sitio_web_del_transportista', $order->id);
    }

    if (get_field('__pedido_enviado', $order->id) == 1 ) { // Only show if field is filled
         
        echo "<div class='jp-info-seg'><h5 class='jp-info-date'>Información de seguimiento</h5><div class='jp-info-ped'>Tu pedido ha sido recogido por <b>$nameTransport</b> el <b>$dateTransport</b>. Tu código de seguimiento es <b>$trackingCode</b>. Seguimiento en vivo en <a href='$siteTransport' target='_blank'>$siteTransport</a></div></div>";
    }else{
        echo '';
    }
    
}