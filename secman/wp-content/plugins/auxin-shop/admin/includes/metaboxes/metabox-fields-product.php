<?php
/**
 * Add metaboxes for products
 *
 * 
 * @package    
 * @license    LICENSE.txt
 * @author     averta <info@averta.net>
 * @link       https://bitbucket.org/averta/
 * @copyright  (c) 2010-2023 averta <info@averta.net>
*/

/*======================================================================*/

function auxin_push_metabox_models_product( $models ){

    // Load general metabox models
    locate_template( AUXIN_CON . 'admin/metaboxes/metabox-fields-general-slider-setting.php' , true, true);
    locate_template( AUXIN_CON . 'admin/metaboxes/metabox-fields-general-bg-setting.php'     , true, true);
    locate_template( AUXIN_CON . 'admin/metaboxes/metabox-fields-general-title-setting.php'  , true, true);
    locate_template( AUXIN_CON . 'admin/metaboxes/metabox-fields-general-advanced.php'       , true, true);
    locate_template( AUXIN_CON . 'admin/metaboxes/metabox-fields-general-layout.php'         , true, true);

    include_once( 'metabox-fields-product-info.php' );
    include_once( 'metabox-fields-product-related.php' );

    // Attach general common metabox models to hub
    $models[] = array(
        'model'     => auxshp_metabox_fields_product_info(),
        'priority'  => 10
    );

    $models[] = array(
        'model'     => auxshp_metabox_fields_product_related(),
        'priority'  => 20
    );

    $models[] = array(
        'model'     => auxin_metabox_fields_general_layout(),
        'priority'  => 30
    );

    $models[] = array(
        'model'     => auxin_metabox_fields_general_title() ,
        'priority'  => 40
    );

    $models[] = array(
        'model'     => auxin_metabox_fields_general_background(),
        'priority'  => 50
    );

    $models[] = array(
        'model'     => auxin_metabox_fields_general_slider(),
        'priority'  => 60
    );

    $models[] = array(
        'model'     => auxin_metabox_fields_general_advanced(),
        'priority'  => 70
    );

    return $models;
}

add_filter( 'auxin_admin_metabox_models_product', 'auxin_push_metabox_models_product' );
