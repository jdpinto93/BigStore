<?php echo '<h1> Bienvenidos al panel de administracion </h1>'; ?>

<br>

<div class="contenTarjetas">

<?php // Inicio de Las tarjetas ?>

  <div class="tarjetasAdmin">
    <img src="https://s3-bigcom.s3.amazonaws.com/bigStore/settings.png" class="img-thumbnail border-0" alt="...">
    <div class="infotarjeta">
    <h3 class="titleAdmin">Ajustes Generales</h3><br>
    <a href="options-general.php?page=bigcom-general-settings" class="botonTarjetas">Ir a Configuracion</a>
    </div>
  </div>

          <?php if ( get_field( '_check__whatsapp', 'option' ) == 1 ) :?>
  <div class="tarjetasAdmin">
      <img src="https://s3-bigcom.s3.amazonaws.com/bigStore/whatsAppLogo.png" class="img-thumbnail border-0" alt="...">
    <div class="infotarjeta"> 
      <h3 class="titleAdmin">Configuracion de WhatsApp</h3><br>        
      <a href="options-general.php?page=option-menu-whatsApp" class="botonTarjetas">Ir a Configuracion</a>
    </div>
  </div>
          <?php endif; ?>

          <?php if ( get_field( '_check__merchant_id', 'option' ) == 1 ) : ?>
  <div class="tarjetasAdmin">
      <img src="https://s3-bigcom.s3.amazonaws.com/bigStore/googleReview.png" class="img-thumbnail border-0" alt="...">
    <div class="infotarjeta">
      <h3  class="titleAdmin">Configuración de Merchant ID</h3><br>
      <a href="options-general.php?page=ecr_gcr" class="botonTarjetas">Ir a Configuracion</a>
    </div>
  </div>
          <?php endif; ?>

          <?php if ( get_field( '_check__configuracion_carrito', 'option' ) == 1 ) : ?>

  <div class="tarjetasAdmin tarjetas-admin-whatsapp" >
      <img src="https://s3-bigcom.s3.amazonaws.com/bigStore/wooCart.png" class="img-thumbnail border-0" alt="...">
    <div class="infotarjeta">
      <h3  class="titleAdmin">Configuración de Carrito</h3><br>
      <a href="admin.php?page=side-cart-woocommerce-settings" class="botonTarjetas">Ir a Configuracion</a>
    </div>
  </div>
          <?php endif; ?>

          <?php if ( get_field( '_check__checkout_form', 'option' ) == 1 ) : ?>

  <div class="tarjetasAdmin">
      <img src="https://s3-bigcom.s3.amazonaws.com/bigStore/checkoutEditor.png" class="img-thumbnail border-0" alt="...">
    <div class="infotarjeta">
      <h3 class="titleAdmin">Campos Checkout</h3><br>
      <a href="admin.php?page=th_checkout_field_editor_pro" class="botonTarjetas">Ir a Configuracion</a>
    </div>
  </div>
          <?php endif; ?>

          <?php if ( get_field( '_check__flies_upload', 'option' ) == 1 ) : ?>

  <div class="tarjetasAdmin">
      <img src="https://s3-bigcom.s3.amazonaws.com/bigStore/fileUploader.png" class="img-thumbnail border-0" alt="...">
    <div class="infotarjeta">
      <h3  class="titleAdmin">Comprobante de Pago</h3><br>
      <a href="admin.php?page=wc-settings&tab=alg_wc_checkout_files_upload" class="botonTarjetas">Ir a Configuracion</a>
    </div>
  </div>
          <?php endif; ?>
          
          <?php if ( get_field( '_check__bac_duplicator', 'option' ) == 1 ) : ?>

  <div class="tarjetasAdmin">
      <img src="https://s3-bigcom.s3.amazonaws.com/bigStore/bacTransfer.png" class="img-thumbnail border-0" alt="...">
    <div class="infotarjeta">
      <h3  class="titleAdmin">Transferencia Bancaria</h3><br>
      <a href="admin.php?page=wc-settings&tab=checkout" class="botonTarjetas">Ir a Configuracion</a>
    </div>
  </div>
          <?php endif; ?>

          <?php if ( get_field( '_check__email_config', 'option' ) == 1 ) : ?>

  <div class="tarjetasAdmin">
      <img src="https://s3-bigcom.s3.amazonaws.com/bigStore/woo]Emails.jpg" class="img-thumbnail border-0" alt="...">
    <div class="infotarjeta">
      <h3 class="titleAdmin">Configuracion de Emails</h3><br>
      <a href="edit.php?post_type=viwec_template" class="botonTarjetas">Ir a Configuracion</a>    
    </div>
  </div>
          <?php endif; ?>

          <?php if ( get_field( '_check__orders_config', 'option' ) == 1 ) : ?>

  <div class="tarjetasAdmin">
    <img src="https://s3-bigcom.s3.amazonaws.com/bigStore/manageOrders.png" class="img-thumbnail border-0" alt="...">
    <div class="infotarjeta">
    <h3  class="titleAdmin">Configuración de Pedidos</h3><br>
      <a href="edit.php?post_type=wc_order_status" class="botonTarjetas">Ir a Configuracion</a>
    </div>
  </div>
          <?php endif; ?>

          <?php if ( get_field( '_check__personalizador', 'option' ) == 1 ) : ?>

  <div class="tarjetasAdmin">
      <img src="https://s3-bigcom.s3.amazonaws.com/bigStore/Proyecto nuevo.png" class="img-thumbnail border-0" alt="...">
    <div class="infotarjeta">
      <h3  class="titleAdmin">Personalizar txt Botones</h3><br>
      <a href="admin.php?page=wc-settings&tab=customizer" class="botonTarjetas">Ir a Configuracion</a>
    </div>
  </div>
          <?php endif; ?>

          <?php if ( get_field( '_check__setting_shipping', 'option' ) == 1 ) : ?>

  <div class="tarjetasAdmin">
      <img src="https://s3-bigcom.s3.amazonaws.com/bigStore/multiShipping.png" class="img-thumbnail border-0" alt="...">
    <div class="infotarjeta">
      <h3  class="titleAdmin">Configuración de Direccines</h3><br>
      <a href="options-general.php?page=wcmca-option-menu" class="botonTarjetas">Ir a Configuracion</a>
    </div>
  </div>
          <?php endif; ?>

  <?php // Final de Las tarjetas ?>

</div>