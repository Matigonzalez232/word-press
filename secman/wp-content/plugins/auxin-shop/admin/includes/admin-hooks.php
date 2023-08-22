<?php
/**
 * Admin actions and filters
 *
 * 
 * @package    
 * @license    LICENSE.txt
 * @author     averta <info@averta.net>
 * @link       https://bitbucket.org/averta/
 * @copyright  (c) 2010-2023 averta <info@averta.net>
 *
 */

/**
 * Render metafield sections for page and post edit panel
 *
 */
function auxshp_add_post_type_metafields(){

    // Load metabox fields on admin
    if( is_admin() ){

        $metabox_args = array(
            'post_type'     => 'product',
            'hub_id'        => 'axi_meta_hub_'. 'product',
            'hub_title'     => __('Product Options', 'auxin-shop' ),
            'to_post_types' => array('product')
        );
        auxin_maybe_render_metabox_hub_for_post_type( $metabox_args );

    }

}
add_action( 'init', 'auxshp_add_post_type_metafields' );


/**
 * Triggers an action after plugin was updated to new version.
 *
 * @return void
 */
function auxshp_after_plugin_update(){
    if( AUXSHP_VERSION !== get_transient( 'auxin_' . AUXSHP_SLUG . '_version' ) ){
        set_transient( 'auxin_' . AUXSHP_SLUG . '_version', AUXSHP_VERSION, MONTH_IN_SECONDS );

        do_action( 'auxin_plugin_updated', true, AUXSHP_SLUG, AUXSHP_VERSION, AUXSHP_BASE_NAME );
    }
}
add_action( "admin_init", "auxshp_after_plugin_update");

/**
 * Activate the "product" post-type in active_post_types of AuxinConfig Class
 *
 * @return Array
 */
function auxshp_activate_product_post_type( $post_types ){
    // Activate product post type
    $post_types['product'] = true;
    // Then return post_types config
    return $post_types;
}
add_filter( "auxin_active_post_types", "auxshp_activate_product_post_type");
