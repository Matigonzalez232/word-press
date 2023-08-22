<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( $related_products ) {

    if( ! function_exists('auxin_get_the_related_posts') ){
        return __( 'Please activate "Auxin Elements" plugin to show related products.' );
    }

    $related_products_ids = array();

    foreach ( $related_products as $post ) {
        $related_products_ids[] = $post->get_id();
    }

    if ( '' === $related_section_label = auxin_get_post_meta( $product->get_id(), '_product_related_posts_label', '' ) ) {
        $related_section_label = auxin_get_option('product_related_posts_label', __( 'Related Products', 'auxin-shop' ) );
    }

    if ( 'default' == $related_col_num = auxin_get_post_meta( $product->get_id(), '_product_related_posts_column_number', 'default' ) ) {
        $related_col_num = auxin_get_option('product_related_posts_column_number', 4 );
    }

    if ( 'default' == $show_cats = auxin_get_post_meta( $product->get_id(), '_product_related_posts_display_categories', 'default' ) ) {
        $show_cats = auxin_get_option('product_related_posts_display_categories', true );
    }

    if ( 'default' == $preview_mode = auxin_get_post_meta( $product->get_id(), '_product_related_posts_preview_mode', 'default' ) ) {
        $preview_mode = auxin_get_option( 'product_related_posts_preview_mode', 'grid' );
    }

    if ( 'default' == $center = auxin_get_post_meta( $product->get_id(), '_product_related_posts_align_center', 'default' ) ) {
        $center = auxin_get_option( 'product_related_posts_align_center', false );
    }

    if ( 'default' == $autoplay = auxin_get_post_meta( $product->get_id(), '_product_related_posts_carousel_autoplay', 'default' ) ) {
        $autoplay = auxin_get_option( 'product_related_posts_carousel_autoplay', false );
    }

    // the recent posts args
    $args = array(
        'title'                       => apply_filters( 'woocommerce_product_related_products_heading', $related_section_label ),
        'taxonomy'                    => array( 'product-cat', 'product-tag' ),
        'desktop_cnum'                => $related_col_num,
        'tablet_cnum'                 => 2,
        'phone_cnum'                  => 1,
        'display_title'               => true,
        'show_info'                   => true,
        'show_date'                   => false,
        'author_or_readmore'          => '', // readmore, author, none
        'display_categories'          => auxin_is_true( $show_cats ),
        'wp_query_args'               => array(),
        'content_layout'              => 'entry-boxed', // entry-boxed
        'post_info_position'          => 'after-title',
        'preview_mode'                => $preview_mode,
        'grid_table_hover'            => 'bgimage-bgcolor',
        'ignore_media'                => false, // whether to ignore media for this
        'exclude'                     => '',
        'only_posts__in'              => $related_products_ids,
        'order_by'                    => $orderby,
        'exclude_post_formats_in'     => array(), // the list od post formats to exclude
        'display_like'                => false,
        'extra_classes'               => auxin_is_true( $center ) ? 'aux-text-align-center': '',
        'extra_column_classes'        => 'auxshp-related-items',
        'custom_el_id'                => '',
        'carousel_autoplay'           => auxin_is_true( $autoplay ),
        'full_width'                  => false,
        'carousel_navigation'         => 'perpage',
        'carousel_navigation_control' => 'bullets',
        'carousel_loop'               => 1,
        'base_class'                  => 'products-loop related-products aux-widget-related-products',
        'text_alignment'              => '',
        'container_start_tag'         => '<div class="container auxshp-related-products">',
        'container_end_tag'           => '</div>',
        'use_wp_query'                => false,
        'template_part_file'          => 'woocommerce/content-product',
        'extra_template_path'         =>  AUXSHP_PUB_DIR . '/templates/'
    );

    // get snap option
    if( 'default' == $snap_related_item = auxin_get_post_meta( $product->get_id(), '_product_related_posts_snap_items', 'default' ) ) {
        $snap_related_item = auxin_get_option( 'product_related_posts_snap_items', false );
    }
    $args['carousel_space'] = $snap_related_item = auxin_is_true( $snap_related_item )? 0: 30;

    // whether the wapper is full width or not
    // get full width option
    if( 'default' == $full_width = auxin_get_post_meta( $product->get_id(), '_product_related_posts_full_width', 'default' ) ) {
        $full_width = auxin_get_option( 'product_related_posts_full_width', false );
    }
    
    if( auxin_is_true( $full_width ) ){
         $args['base_class'] .= ' auxshp-no-margin';
    }

    // whether to snap the items (0 space between the items)
    if( $args['carousel_space'] === 0 ){
        $args['extra_column_classes'] .= ' aux-no-gutter';
    }

    add_filter( 'auxin_product_thumbnail_aspect_ratio', 'auxin_related_product_thumbnail_aspect_ratio');
    
    echo auxin_get_the_related_posts( $args );

    remove_filter( 'auxin_product_thumbnail_aspect_ratio', 'auxin_related_product_thumbnail_aspect_ratio');
}
