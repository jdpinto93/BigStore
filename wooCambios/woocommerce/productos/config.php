<?php

//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die( "Bye bye" );


// Agrega la taxonomia "Bodega" al producto de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/bodegas/bodegas.php');

// Agrega campos a la taxonomia "Bodega" al producto de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/bodegas/camposBodegas.php');

// Agrega el campo del ean al inventario de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/ean/ean.php');

// Agrega el campo del sat al inventario de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/sat/sat.php');

// Agrega el campo de mpn al producto de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/mpn/mpn.php');

// Agrega el campo de upc al inventario de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/upc/upc.php');

// Agrega la taxonomia de las marcas al campo de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/marcas/camposMarca.php');

// Agrega Campos a la taxonomia de las marcas al campo de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/marcas/marca-producto.php');

// Agrega la taxonomia de los proveedores al producto de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/proveedores/proveedores.php');

// Agrega campos adicionales a la categorias de los productos de woocommerce
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/categoria/categoria.php');

// Agrega un campo de editor al producto la ficha de producto de woocommerce que es capaz de leer la biblioteca de medios
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/pdfProduct/pdfProduct.php');

// Agrega un campo de editor al producto la ficha de producto de woocommerce que es capaz de leer la biblioteca de medios
//include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/hightligyhProduct/higthlight.php');

// Elimina las imagenes de los productos cuando el mismo es eliminado
include(Woo_Big_RUTA.'/wooCambios/woocommerce/productos/delete-product-images/wdpi.php');



