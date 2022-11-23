<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );

//Desvincula el email de nuevo pedido de los CRON --> On Hold
add_filter( 'woocommerce_defer_transactional_emails', '__return_false' );
