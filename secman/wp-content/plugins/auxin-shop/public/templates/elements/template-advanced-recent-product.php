<?php
function auxin_advanced_recent_products( $args= array() ) {

    global $post;

    $defaults = array (
    	'product_type'          => '',    // available values : recent, featured, top_rated, sale, deal, best_selling
        'title'                 => '',    // header title (required)
        'subtitle'              => '',    // header subtitle
        'cat'                   => '',
        'num'                   => '8',   // max generated entry
        'image_aspect_ratio'    => 0.75,
        'preloadable'           => false,
        'preload_preview'       => true,
        'preload_bgcolor'       => '',
        'exclude_without_media' => 0,
        'order_by'              => 'date',
        'order'                 => 'DESC',
        'only_products__in'     => '',   // display only these post IDs. array or string comma separated
        'include'               => '',    // include these post IDs in result too. array or string comma separated
        'exclude'               => '',    // exclude these post IDs from result. array or string comma separated
        'offset'                => '',
        'show_filters'          => '1',
        'filter_by'             => 'product_cat',
        'filter_style'          => 'aux-slideup',
        'filter_align'          => 'aux-center',
        'display_price'         => true,
        'display_rating'        => true,
        'display_meta_fields'   => false,
        'display_add_to_cart'   => true,
        'display_wishlist'      => true,
        'display_sale_badge'    => true,
        'display_feat_badge'    => true,
        'display_title'         => true,
        'display_categories'    => true,
        'display_content'       => false,
        'desc_char_num'        => 10,
        'desktop_cnum'          => 4,
        'tablet_cnum'           => 'inherit',
        'phone_cnum'            => '1',
        'post_type'             => 'product',
        'taxonomy'              => 'product_cat', // the taxonomy that we intent to display in post info
        'tax_args'              => '',
        'content_width'         => '',
        'extra_classes'         => '',
        'terms'                 => ' ',
        'template_part_file'    => 'template-advanced-recent-product',
        'extra_template_path'   =>  AUXSHP_PUB_DIR . '/templates/elements',
        'universal_id'          => '',
        'use_wp_query'          => false, // true to use the global wp_query, false to use internal custom query
        'reset_query'           => true,
        'wp_query_args'         => array(), // additional wp_query args
        'query_args'            => array(),
        'custom_wp_query'       => '',
        'base'                  => 'aux_advance_recent_products',
        'base_class'            => 'aux-widget-recent-products-pro',
        'paged'                 => 1,
        'show_pagination'       => '',
    );

    $args = wp_parse_args( $args, $defaults );

    if( ( empty( $args['terms'] ) || $args['terms'] === "all" ) && !empty( $args['cat'] ) ) {
        $tax_args = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $args['cat']
            )
        );
    } else if ( ! empty( $args['terms'] ) ) {
        $tax_args = array(
            array(
                'taxonomy' => $args['taxonomy'],
                'field'    => 'term_id',
                'terms'    => $args['terms']
            )
        );
    } else if ( empty( $args['cat'] ) ) {
        $tax_args = array();
    }

    if ( empty( $args['cat'] ) && $args['taxonomy'] == 'product_tag'  && $args['terms'] === "all" ) {
        $tax_args = [];
    }

    $query_args = array(
        'post_type'             => 'product',
        'posts_per_page'        => $args['num'],
        'orderby'               => $args['order_by'],
        'order'                 => $args['order'],
        'tax_query'             => $tax_args,
        'post_status'           => 'publish',
        'include_posts__in'     => $args['include'], // include posts in this list
        'posts__not_in'         => $args['exclude'], // exclude posts in this list
        'posts__in'             => $args['only_products__in'], // only posts in this list
        'exclude_without_media' => $args['exclude_without_media'],
        'paged'                 => $args['paged']
    );

    if ( !empty( $args['offset'] ) ) {
        $query_args['offset'] = $args['offset'];
    }

    if ( isset( $args['meta_key'] ) ) {
        $query_args['meta_key'] = $args['meta_key'];
    }


    // add the additional query args if available
    if( $args['query_args'] ){
        $query_args = wp_parse_args( $query_args, $args['query_args'] );
    }

    if ( $args['product_type'] ) {
        switch ( $args['product_type'] ) {
            case 'featured':
                $query_args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                );
                break;

            case 'best_selling':
                $query_args['orderby'] = 'meta_value_num';
                break;

            case 'sale':
                $query_args['meta_query'] = WC()->query->get_meta_query();
                $query_args['post__in'] = wc_get_product_ids_on_sale();
                break;

            case 'deal':
                $today = time();
                $query_args['meta_query'] = array (
                    'relation' => 'AND',
                    array (
                        'key' => '_sale_price_dates_from',
                        'value' => '',
                        'compare' => '!='
                    ),
                    array (
                        'key' => '_sale_price_dates_from',
                        'value' => $today,
                        'compare' => '<='
                    ),
                    array (
                        'key' => '_sale_price_dates_to',
                        'value' => '',
                        'compare' => '!='
                    ),
                    array (
                        'key' => '_sale_price_dates_to',
                        'value' => $today,
                        'compare' => '>='
                    ),
                );
                break;

            case 'top_rated':
                $query_args['meta_query'] = WC()->query->get_meta_query();
                add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
                break;
            default: // i.e. recent product
                $query_args['meta_query'] = WC()->query->get_meta_query();
                break;
        }
    }

    ob_start();

    // pass the args through the auxin query parser
    $wp_query = new WP_Query( auxin_parse_query_args( $query_args ) );

    $have_posts = $wp_query->have_posts();

    if( $have_posts ){

        while ( $wp_query->have_posts() ) {

            $wp_query->the_post();
            $post = get_post();

            $the_format = get_post_format( $post );

            global $post, $product, $auxshp_wishlist;

            $cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );

            ?>

            <div <?php wc_product_class( 'aux-col', $product ); ?>>
            <?php

                echo '<div class="aux-shop-badges-wrapper">';

                    if ( $product->is_on_sale() && auxin_is_true( $args['display_sale_badge'] ) ) {
                        woocommerce_show_product_loop_sale_flash();
                    }
                    if ( $product->is_featured() &&  auxin_is_true( $args['display_feat_badge'] ) ) {
                        echo '<span class="aux-product-featured-badge">' .  __('Hot', 'auxin-shop' ) . '</span>';
                    }

                echo '</div>';

                woocommerce_template_loop_product_link_open();

                auxshp_get_product_thumbnail( array(
                    'size'            => $args['image_size'],
                    'gallery'         => true,
                    'class'           => $args['image_class'],
                    'preloadable'     => $args['preloadable'],
                    'preload_preview' => $args['preload_preview'],
                    'preload_bgcolor' => $args['preload_bgcolor'],
                    'content_width'   => $args['content_width']
                ) );


                woocommerce_template_loop_product_link_close();

                echo '<div class="auxshp-entry-main">';

                    echo '<div class="aux-shop-info-wrapper">';

                        if ( auxin_is_true( $args['display_title'] ) ) {
                            woocommerce_template_loop_product_title();
                        }

                        if ( auxin_is_true( $args['display_price'] ) ) {
                            woocommerce_template_loop_price();
                        }

                    echo '</div>';

                    if ( auxin_is_true( $args['display_meta_fields'] ) ) {
                        $meta_fields = auxin_get_post_meta( $post->ID, 'aux_product_pair_fields', '' );
                        echo auxin_meta_fields_output( $meta_fields );
                    }

                    echo '<div class="aux-shop-meta-wrapper">';

                        if ( auxin_is_true( $args['display_categories'] ) && $cat_count > 0 ) {
                            echo wc_get_product_category_list( $product->get_id(), ', ', '<em class="aux-shop-meta-terms">', '</em>' );
                        }

                        if ( auxin_is_true( $args['display_rating'] ) ) {
                            woocommerce_template_loop_rating();
                        }

                    echo '</div>';

                    if ( auxin_is_true( $args['display_content'] ) ) {
                        echo '<div class="aux-shop-desc-wrapper">';
                             echo auxin_the_trim_excerpt( null, $args['desc_char_num'] );
                        echo '</div>';
                    }

                    if ( auxin_is_true( $args['display_add_to_cart'] ) || auxin_is_true( $args['display_wishlist'] ) ) {

                    echo '<div class="aux-shop-btns-wrapper">';

                        if ( auxin_is_true( $args['display_add_to_cart'] ) ) {

                            if( auxin_is_true( auxin_get_option( 'product_index_ajax_add_to_cart', '1' ) ) ) {
                                $class = 'button aux-ajax-add-to-cart add_to_cart_button';
                            }

                            echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" data-verify_nonce="%s" class="%s" data-product-type="%s"><i class="aux-ico auxicon-handbag"></i><span>%s</span></a>',
                                    esc_url( $product->add_to_cart_url() ),
                                    esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                    esc_attr( $product->get_id() ),
                                    esc_attr( $product->get_sku() ),
                                    esc_attr( wp_create_nonce( 'aux_add_to_cart-' . $product->get_id() ) ),
                                    esc_attr( isset( $class ) ? $class : 'button add_to_cart_button' ),
                                    esc_attr( $product->get_type() ),
                                    esc_html( $product->add_to_cart_text() )
                                ),
                            $product );
                        }


                        $wishlist_class = 'available-add';

                        if ( $auxshp_wishlist->in_wishlist( $product->get_id() ) ) {
                            $wishlist_class = 'available-remove';
                        }

                        if ( auxin_is_true( $args['display_wishlist'] ) ) {
                            wc_get_template( 'loop/wishlist.php', [ 'from' => 'widget' ] );
                        }

                        if ( auxin_is_true( $args['display_quicklook']) ) {

                            echo '<div class="aux-shop-quicklook-wrapper">';
                                printf('<a rel="nofollow" class="%s" data-product-id="%s" data-product-type="%s" data-verify-nonce="%s"><i class="aux-quicklook-icon aux-ico auxicon-eye-1"></i></a>', 'aux-shop-quicklook', $product->get_id(), $product->get_type(), wp_create_nonce( 'aux-quicklook-' . $product->get_id() ) );
                            echo '</div>';

                        }

                    echo '</div>';

                    }

                echo '</div>';
            ?> </div> <?php

        }
        
        if ( !empty( $args['show_pagination'] ) ) {
            auxin_the_paginate_nav( [
                'wp_query' => $wp_query,
                'current'  => $args['paged']
            ] );
        }

    }


    if( $args['reset_query'] ){
        wp_reset_postdata();
    }

    // return false if no result found
    if( ! $have_posts ){
        ob_get_clean();
        return false;
    }

    return ob_get_clean();
};
