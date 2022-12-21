<?php

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_63a34123e2711',
        'title' => 'Ajustes Generales',
        'fields' => array(
            array(
                'key' => 'field_63a34161e6044',
                'label' => 'Envios',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_63a341a6b3c77',
                'label' => 'Costo de Envio',
                'name' => 'shipping_cost_field',
                'type' => 'number',
                'instructions' => 'Agregue el valor que determinara el costo de envio en pesos mexicanos, tome en consideracion que este es el cobro que se hace por cada 5 kilos de peso en masa o peso volumetrico.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 99,
                'placeholder' => '',
                'prepend' => 'Mx',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_63a34316b3c78',
                'label' => 'Peso Maximo Permitido',
                'name' => '_max_wehight',
                'type' => 'number',
                'instructions' => 'Establezca un peso maximo permitido por cada pedido segun la paqueteria que este ocupando',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 60,
                'placeholder' => '',
                'prepend' => 'Kg',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_63a3439bb3c79',
                'label' => 'Mensaje a mostrar cuando un pedido ocupe el peso maximo',
                'name' => '__message_max_wehight',
                'type' => 'textarea',
                'instructions' => 'Escriba un mensaje que le sera mostrado al usuario cuando este exceda el peso maximo permitido por la paqueteria que esta ocupando.
    
    Este Campo Recibe 3 parametros en el siguiente Orden.
    
    %d = Peso total del carrito
    %d = Peso Maximo Permitido
    %s = Metodo deEnvio Publicado
    
    Tome en consideracion al momento de redactar su mensaje asi como se muestra en el mensaje por defecto.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'Disculpe, usted tiene en su carrito %d kg y excede la cantidad maxima de %d kg para %s lamentamos informarle que nuestra paqueteria no podra hacer un solo envio por lo que sugerimos que haga varios pedidos sin exceder el limite permitido.',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'bigcom-general-settings',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 1,
    ));
    
    endif;