<?php 
/**
 * Changes in WooCommerce without removing or adding things
 * Using WooCommerce hooks
 *
 * 
 * @package    
 * @license    LICENSE.txt
 * @author     averta <info@averta.net>
 * @link       https://bitbucket.org/averta/
 * @copyright  (c) 2010-2023 averta <info@averta.net>
 */

/**
 * woocommerce_single_product_summary hook.
 *
 * @hooked woocommerce_template_single_title - 5
 * @hooked woocommerce_template_single_rating - 10
 * @hooked woocommerce_template_single_price - 10
 * @hooked woocommerce_template_single_excerpt - 20
 * @hooked woocommerce_template_single_add_to_cart - 30
 * @hooked woocommerce_template_single_meta - 40
 * @hooked woocommerce_template_single_sharing - 50
 */

add_action( 'init', 'auxshp_remove_woo_actions' );

function auxshp_remove_woo_actions() {

    remove_action( 'woocommerce_single_product_summary',        'woocommerce_template_single_rating',                   10 );
    remove_action( 'woocommerce_single_product_summary',        'woocommerce_template_single_meta',                     40 );
    remove_action( 'woocommerce_single_product_summary',        'woocommerce_template_single_sharing',                  50 );
    remove_action( 'woocommerce_after_shop_loop',               'woocommerce_pagination',                               10 );
    remove_action( 'woocommerce_after_shop_loop_item_title',    'woocommerce_template_loop_rating',                     5  );
    remove_action( 'woocommerce_after_shop_loop_item',          'woocommerce_template_loop_add_to_cart'                    );
    remove_action( 'woocommerce_after_shop_loop_item',          'woocommerce_template_loop_product_link_close',         10 );
    remove_action( 'woocommerce_before_shop_loop_item_title',   'woocommerce_template_loop_product_thumbnail',          10 );
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash',                  10 );
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images',                      20 );
    remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_output_product_data_tabs',                 10 );
    remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_output_related_products',                  20 );
    remove_action( 'woocommerce_cart_collaterals',              'woocommerce_cross_sell_display'                           );
    remove_action( 'woocommerce_widget_shopping_cart_buttons',  'woocommerce_widget_shopping_cart_button_view_cart',    10 );
    remove_action( 'woocommerce_widget_shopping_cart_buttons',  'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

    $widget_area = auxin_get_option('product_index_custom_widget_area', 'no');

    if ( auxin_is_true( $widget_area ) ) {
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

        add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 20 );
        add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 40 );
    }

}

// Add meta again, after sharing section in single product page
add_action( 'woocommerce_single_product_summary',                 'woocommerce_template_single_meta' ,   60 );
add_action( 'woocommerce_single_product_summary',                 'woocommerce_show_product_sale_flash',  8 );
add_action( 'woocommerce_before_shop_loop_item_title',            'woocommerce_template_loop_product_link_close', 12 );

// Disable description tab heading
add_filter( 'woocommerce_product_description_heading',            '__return_false' );
// Disable additional information tab heading
add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );
// Disable WooCommerce Default styles
add_filter( 'woocommerce_enqueue_styles',                         '__return_false' );


add_action( 'quicklook_product_summary', 'woocommerce_template_single_rating', 5 );
add_action( 'quicklook_product_summary', 'woocommerce_template_single_title', 10 );
add_action( 'quicklook_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'quicklook_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'quicklook_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'quicklook_product_summary', 'auxshp_single_product_meta', 40 );

/**
 * Display Sales Badge as a Percentage
 */

function auxin_show_sale_percentage( $output, $post, $product ) {

    $custom_sales_badge = auxin_get_option('product_index_custom_sale_badge', '0');
    $sales_badge_text   = auxin_get_option('product_index_custom_sale_badge_text',  __( 'Sale!', 'auxin-shop' ) );

    if ( $product->is_on_sale() &&  auxin_is_true( $custom_sales_badge ) ) {

        if ( $product->is_type( 'simple' ) ) {

            $sale_price    = $product->get_sale_price();
            $regular_price = $product->get_regular_price();
            $sale          = ceil(( ($regular_price - $sale_price) / $regular_price ) * 100);

            if ( !empty( $regular_price ) && !empty( $sale_price ) && $regular_price > $sale_price ) {
                $output = '<span class="auxin-onsale-badge">' . $sales_badge_text . $sale . '%</span>';
            }

        } else {
            $output = '<span class="auxin-onsale-badge">' . $sales_badge_text . '</span>';
        }

        return $output;

    } else {
        return '<span class="onsale">' . $sales_badge_text . '</span>';
    }

}

add_filter( 'woocommerce_sale_flash', 'auxin_show_sale_percentage', 10, 3 );

/**
 * Add Pagination to Woocommerce Loop 
 */

function auxshp_pagination() {
    auxin_the_paginate_nav(
        array( 'css_class' => esc_attr( auxin_get_option('product_index_pagination_skin') ) )
    );
}

add_action( 'woocommerce_after_shop_loop', 'auxshp_pagination', 10 );


/**
 * Change the Size avatar in Review Section
 */
 
function auxshp_review_avatar_size() {
    $size = auxin_get_option( 'product_single_review_avatar_size', '60' );
    return $size;
}

add_filter('woocommerce_review_gravatar_size', 'auxshp_review_avatar_size' );


/**
 * Load the Variation Swatch  in  quickview
 */
 

if ( class_exists('TA_WC_Variation_Swatches') ) { 
    add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array('TA_WC_Variation_Swatches_Frontend', 'get_swatch_html'), 100, 2 );
    add_filter( 'tawcvs_swatch_html', array( 'TA_WC_Variation_Swatches_Frontend', 'swatch_html' ), 5, 4 );
}



/**
 * Change the request url for add to cart button in ajax requests
 */

function aux_ajax_add_to_cart_url_change( $url, $instance ) { 
    global $product;

    if ( empty( $product ) || $product->is_type('external') ) {
        return $url;
    }
    $url_type = auxin_get_option( 'product_index_add_to_cart_link' , 'add-to-cart ');

    // make filter magic happen here... 
    if ( wp_doing_ajax() ) {
        $url = trim($url, '/wp-admin/admin-ajax.php') ;
        return $url;
    } else if ( 'product-page' === $url_type ) {
        return get_permalink();
    } else {
        return $url;
    }

}; 
         
add_filter( 'woocommerce_product_add_to_cart_url', 'aux_ajax_add_to_cart_url_change', 10, 2 ); 


/**
 * Add Photoswipe Lightbox to Woocommerce default slider
 */
function auxin_single_product_lightbox( $html, $thumbnail_id ) {

    global $post;

    if ( 'default' == $use_wc_slider = auxin_get_post_meta( $post->ID, '_product_single_template_slider_type', 'default' ) ) {
        $use_wc_slider = auxin_get_option( 'product_single_template_slider_type', false );
    }

    if ( 'default' == $lightbox_enabled = auxin_get_post_meta( $post->ID, '_product_single_lightbox_enabled', 'default' ) ) {
        $lightbox_enabled = auxin_get_option( 'product_single_lightbox_enabled', '1' );
    }

    if( ! $lightbox_enabled || ! $use_wc_slider ) {
        return $html;
    }

    $attachment_metadata = wp_get_attachment_metadata( $thumbnail_id );
    $image_primary_meta  = is_array( $attachment_metadata ) ? $attachment_metadata: array( 'width' => 300 ,'height' => 300 );
    $main_src            = wp_get_attachment_image_src( $thumbnail_id, 'full' );
    $lightbox_attrs      = 'data-elementor-open-lightbox="no" class="auxshp-lightbox-btn aux-hide-text" data-original-src="' . $main_src[0] . '" data-original-width="' . $image_primary_meta['width'] . '" data-original-height="' . $image_primary_meta['height'] . '" ' . 'data-caption="' . auxin_attachment_caption( $thumbnail_id ) . '"';
    
    preg_match('#<div[^>]*>(.*?)</div>#', $html, $matches);
    $button_output = '<a href="'. $main_src[0] .'" '.$lightbox_attrs.'>open</a>';
    return str_replace($matches[1], $button_output . $matches[1], $html);
}; 
         
add_filter( 'woocommerce_single_product_image_thumbnail_html', 'auxin_single_product_lightbox', 10, 2 );

/**
 * Change the Woocommerce Add To Cart Button Text
 */
function auxin_add_to_cart_text( $text, $instance ) {

    $custom_text = auxin_get_option( 'product_index_add_to_cart_text',  __( 'Add to Cart', 'auxin-shop' ) );
    
    if ( !empty ( $custom_text ) ) {
        return $custom_text;
    }

    return $text;
}; 
         
// add the filter 
add_filter( 'woocommerce_product_add_to_cart_text', 'auxin_add_to_cart_text', 10, 2 ); 


add_filter( 'woocommerce_cross_sells_columns', function ( $columns ) {
	return 4;
});
 
add_filter( 'woocommerce_cross_sells_total', function ( $columns ) {
	return 4;
});
add_action( 'woocommerce_after_cart_table', 'woocommerce_cross_sell_display', 10 );

