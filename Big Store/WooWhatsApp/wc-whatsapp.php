<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

// Crea Los botones de WhatsApp en Las ordenes de Woocommerce
include(Woo_Big_RUTA.'/WooWhatsApp/includes/whatsapp_btn_in_order.php');

// Crea in botone de WhatsApp en Las acciones de pedidos de Woocommerce
include(Woo_Big_RUTA.'/WooWhatsApp/includes/whatsapp_btn_in_list_order.php');

// Encola los estilos de los botones
include(Woo_Big_RUTA.'/WooWhatsApp/includes/enqueue_files.php');