<?php
/**
 * 
 * @package    
 * @license    LICENSE.txt
 * @author     averta <info@averta.net>
 * @link       https://bitbucket.org/averta/
 * @copyright  (c) 2010-2023 averta <info@averta.net>
 */


add_filter( 'woocommerce_format_sale_price',          'auxshp_change_price_order',             10, 3 );
add_filter( 'woocommerce_checkout_fields',            'auxshp_change_checkout_fields'                );
add_filter('woocommerce_show_page_title',             'auxshp_disable_archive_page_title',     10    );
add_filter('woocommerce_catalog_orderby',             'auxshp_change_catalog_orderby',         10    );

add_action( 'woocommerce_single_product_summary',     'auxshp_template_single_wishlist_share', 45    );
add_action( 'woocommerce_after_shop_loop_item_title', 'auxshp_loop_product_meta',              12    );
add_action( 'woocommerce_after_shop_loop_item'      , 'auxshp_loop_product_tools',             12    );
add_action( 'woocommerce_after_shop_loop_item'      , 'auxshp_loop_after_shop_loop_item',      9999  );
add_action( 'woocommerce_shop_loop_item_title'      , 'auxshp_loop_before_item_title',         1     );
add_action( 'woocommerce_archive_description'       , 'auxshp_archive_page_title_description', 1     );

add_action( 'woocommerce_before_shop_loop_item_title', 'auxshp_get_product_thumbnail', 11 );

add_action( 'auxshp_share_section', 'auxshp_single_wishlist', 10 );
add_action( 'auxshp_share_section', 'auxshp_single_share', 20 );

add_action( 'woocommerce_after_single_product', 'auxshp_single_page_navigation' );


remove_action( 'woocommerce_proceed_to_checkout',     'woocommerce_button_proceed_to_checkout', 20 );
add_action( 'woocommerce_proceed_to_checkout',        'auxshp_change_checkout_button_text',     20 );


/**
 * Disable WooCommerce Default Page Title.
 */
function auxshp_disable_archive_page_title() {

    if( ! auxin_is_true( auxin_get_option( 'product_archive_disable_page_title', '1' ) ) ) {
        return false;
    }

}

/**
 * Display breadcrumb instead of woocommerce default header title.
 */
function auxshp_archive_page_title_description() {

    $disable_page_title = auxin_get_option( 'product_archive_disable_page_title', '1' );
    $display_breadcrumb = auxin_get_option( 'product_archive_display_breadcrumb_header', '0' );

    if( auxin_is_true( $disable_page_title ) && auxin_is_true( $display_breadcrumb ) ) {
        auxin_the_breadcrumbs();
    }

}

/**
 * Display breadcrumb instead of woocommerce default header title.
 */
function auxshp_change_catalog_orderby() {

    return array(
        'menu_order' => __( 'Default', 'auxin-shop' ),
        'popularity' => __( 'Popularity', 'auxin-shop' ),
        'rating'     => __( 'Rating', 'auxin-shop' ),
        'date'       => __( 'Newness', 'auxin-shop' ),
        'price'      => __( 'Low Price', 'auxin-shop' ),
        'price-desc' => __( 'High Price', 'auxin-shop' )
    );

}

/**
 * Function for changing price order (Showing display price before regular price).
 */
function auxshp_change_price_order( $price, $regular_price, $sale_price ) {

    $price = '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';

    return $price;
}


/**
 * Output the product wishlist button.
 *
 * @subpackage  Product
 */
function auxshp_template_single_wishlist_share() {

    global $product;

    if ( 'default' == $show_wishlist = auxin_get_post_meta( $product->get_id(), '_product_single_display_wishlist', 'default' ) ) {
        $show_wishlist = auxin_get_option( 'product_single_display_wishlist', '1' );
    }

    if ( 'default' == $show_share = auxin_get_post_meta( $product->get_id(), '_product_single_display_share', 'default' ) ) {
        $show_share = auxin_get_option( 'product_single_display_share', '1' );
    }

    if ( auxin_is_true( $show_wishlist ) || auxin_is_true( $show_share ) ) {
        wc_get_template( 'single-product/wishlist-share.php' );
    }

}

if ( ! function_exists('woocommerce_template_loop_product_title') ) {

    function woocommerce_template_loop_product_title( $echo = true ) {
        global $product;

        $html = sprintf( '<a href="%s" class="%s"><h3 class="auxshp-title-heading">%s</h3></a>',
            esc_url( get_permalink( $product->get_id() ) ),
            esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'auxshp-label auxshp-loop-title' ) ),
            get_the_title()
        );

        if( $echo ){
            echo $html;
        } else {
            return $html;
        }
    }

}

function auxshp_single_product_meta() {
    wc_get_template( 'single-product/meta.php' );
}

function auxshp_loop_product_meta() {
    wc_get_template( 'loop/meta.php' );
}

function auxshp_loop_product_tools() {
    wc_get_template( 'loop/tools.php' );
}

function auxshp_loop_before_item_title(){
    echo '<div class="auxshp-entry-main">';
}

function auxshp_loop_after_shop_loop_item(){
    echo '</div>';
}

function auxshp_get_product_thumbnail( $args = array()  ) {

    global $post, $product, $woocommerce, $aux_content_width;

    $defaults = array(
        'size'            => '',
        'gallery'         => true,
        'class'           => '',
        'preloadable'     => false,
        'preload_preview' => true,
        'preload_bgcolor' => '',
        'content_width'   => $aux_content_width,
    );

    $args = wp_parse_args( $args, $defaults );

    extract( $args  );

    $image_size         = apply_filters( 'single_product_archive_thumbnail_size', $size );
    $image_size         = wc_get_image_size( $image_size );
    $image_id           = get_post_thumbnail_id();
    $attachment_ids     = auxshp_get_gallery_image_ids( $product );
    $image_aspect_ratio = auxin_get_option( 'product_index_thumb_ratio', '1.33' );
    $desktop_cnum       = wc_get_default_products_per_row();
    $column_media_width = auxin_get_content_column_width( $desktop_cnum, 15,  $content_width );

    if ( has_post_thumbnail() ) {

        if ( 'default' == $related_number = auxin_get_post_meta( $post->ID, '_product_related_posts_column_number', 'default' ) ) {
            $related_number = auxin_get_option( 'product_related_posts_column_number', '4' );
        }


        if ( 'default' == $template = auxin_get_post_meta( $post->ID, '_product_single_template', 'default' ) ) {
            $template = auxin_get_option( 'product_single_template', 'slider' );
        }

        if ( 'custom' === $image_aspect_ratio ) {
            $image_aspect_ratio = auxin_get_option( 'product_index_thumb_ratio_custom', '1' );
        }

        if ( 'wide' === $template || 'wide-center' === $template ) {
            $image_aspect_ratio = 1;
        }

        $image_aspect_ratio         = apply_filters( 'auxin_product_thumbnail_aspect_ratio', $image_aspect_ratio );

        if ( empty( $size ) ) {
            $size = array( 'width' => $column_media_width, 'height' => $column_media_width * $image_aspect_ratio );
        }

        if ( $attachment_ids ) {
            echo '<span class="aux-flipper-images">';
        }

        echo auxin_get_the_responsive_attachment(
                $image_id,
                array(
                    'quality'              => 100,
                    'upscale'              => true,
                    'crop'                 => true,
                    'add_hw'               => true, // whether add width and height attr or not
                    'attr'                 => array(
                        'class'                => 'auxshp-product-image auxshp-attachment ' . $class,
                        'data-original-width'  => $image_size['width'],
                        'data-original-height' => $image_size['height'],
                        'data-original-src'    => wp_get_attachment_image_src( $image_id, 'full'  )[0]
                    ),
                    'size'                 => $size,
                    'image_sizes'          => 'auto',
                    'srcset_sizes'         => 'auto',
                    'original_src'         => false,
                    'preloadable'          => $preloadable,
                    'preload_preview'      => $preload_preview,
                    'preload_bgcolor'      => $preload_bgcolor,
                )

            );

        if ( $attachment_ids && $gallery ) {

            $attachment_ids     = array_values( $attachment_ids );
            $secondary_image_id = $attachment_ids['0'];

            echo auxin_get_the_responsive_attachment(
                $secondary_image_id,
                array(
                    'quality'         => 100,
                    'upscale'         => true,
                    'crop'            => true,
                    'add_hw'          => true, // whether add width and height attr or not
                    'attr'            => array(
                                            'class'                => 'auxshp-product-secondary-image auxshp-attachment ' . $class,
                                            'data-original-width'  => $image_size['width'],
                                            'data-original-height' => $image_size['height'],
                                            'data-original-src'    => wp_get_attachment_image_src( $secondary_image_id, 'full' )[0]
                                         ),
                    'size'            => $size,
                    'image_sizes'     => 'auto',
                    'srcset_sizes'    => 'auto',
                    'original_src'    => false,
                    'preloadable'     => $preloadable,
                    'preload_preview' => $preload_preview,
                    'preload_bgcolor' => $preload_bgcolor,
                )

            );


        }

        echo '</span>';

    } elseif ( wc_placeholder_img_src() ) {
        echo wc_placeholder_img( $image_size );
    }

    echo '</a>';

}

function auxshp_get_gallery_image_ids( $product ) {
    if ( ! is_a( $product, 'WC_Product' ) || ! auxin_is_true( auxin_get_option( 'product_index_display_image_flipper', '1' ) ) ) {
        return;
    }
    if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
        return $product->get_gallery_image_ids();
    } else {
        return $product->get_gallery_attachment_ids();
    }
}



function auxshp_single_share() {

    global $product;

    if ( 'default' == $show_share = auxin_get_post_meta( $product->get_id(), '_product_single_display_share', 'default' ) ) {
        $show_share = auxin_get_option( 'product_single_display_share', '1' );
    }

    if ( auxin_is_true( $show_share ) ) {
        wc_get_template( 'single-product/share.php' );
    }

}

function auxshp_single_wishlist() {

    global $product;

    if ( 'default' == $show_wishlist = auxin_get_post_meta( $product->get_id(), '_product_single_display_wishlist', 'default' ) ) {
        $show_wishlist = auxin_get_option( 'product_single_display_wishlist', '1' );
    }

    if ( auxin_is_true( $show_wishlist ) ) {
        wc_get_template( 'single-product/wishlist.php' );
    }

}

function auxshp_single_page_navigation() {

    if ( class_exists( 'ElementorPro\Modules\ThemeBuilder\Module' ) && ! empty( $singles = ElementorPro\Modules\ThemeBuilder\Module::instance()->get_conditions_manager()->get_documents_for_location( 'single' ) ) ) {
        foreach( $singles as $id => $obj ) {
            if ( $obj instanceof ElementorPro\Modules\Woocommerce\Documents\Product ) {
                return;
            }
        }
    }

    global $product;

    if ( empty ( $product ) ) return;

    // get next/prev portfolio button
    if( 'default' == $display_next_prev = auxin_get_post_meta( $product->get_id(), '_show_next_prev_nav', 'default' ) ){
        $display_next_prev = auxin_get_option( 'show_product_single_next_prev_nav', false );
    }
    $display_next_prev = auxin_is_true( $display_next_prev )? true: false;

    if( $display_next_prev ) {
        if( 'default' == $next_prev_skin = auxin_get_post_meta( $product->get_id(), '_next_prev_nav_skin', 'default' ) ){
            $next_prev_skin = auxin_get_option( 'product_single_next_prev_nav_skin', false );
        }
        auxin_single_page_navigation( array(
            'prev_text'      => __( 'Previous Product', 'auxin-shop' ),
            'next_text'      => __( 'Next Product'    , 'auxin-shop' ),
            'taxonomy'       => 'product_cat',
            'skin'           => $next_prev_skin // minimal, thumb-no-arrow, thumb-arrow, boxed-image
        ));
    }

}


function auxshp_change_checkout_fields( $fields ) {
    foreach ($fields as &$fieldset) {
        foreach ($fieldset as &$field) {
            // add form-control to the actual input
            $field['input_class'][] = 'aux-input-text aux-large';
        }
    }
    return $fields;
}

function auxshp_change_checkout_button_text() {
  ?>
       <a href="<?php echo esc_url( wc_get_checkout_url() );?>" class="checkout-button button alt wc-forward aux-button-block aux-button aux-exlarge aux-black aux-uppercase"><?php esc_html_e( 'Proceed to checkout', 'auxin-shop' ); ?></a>
  <?php
}

/**
 * Function for override our custom woocommerce widgets
 */

function auxshp_override_woocommerce_widgets() {

    // UnRegister The Default Price Filter widget in Woocommerce
    if ( class_exists( 'WC_Widget_Price_Filter' ) ) {
        unregister_widget( 'WC_Widget_Price_Filter' );

        // Register Our Custom Price Filter widget
        include_once( 'widgets/class-auxshp-wc-widget-price-filter.php' );
        register_widget( 'AUXSHP_WC_Widget_Price_Filter' );

  }

    // UnRegister The Default Recent Reviews widget in Woocommerce
    if ( class_exists( 'WC_Widget_Recent_Reviews' ) ) {
        unregister_widget( 'WC_Widget_Recent_Reviews' );

        // Register Our Custom Recent Reviews widget
        include_once( 'widgets/class-auxshp-wc-widget-recent-reviews.php' );
        register_widget( 'AUXSHP_WC_Widget_Recent_Reviews' );

  }

    if ( class_exists( 'WC_Widget_Layered_Nav' ) ) {
        unregister_widget( 'WC_Widget_Layered_Nav' );

        // Register Our Custom Recent Reviews widget
        include_once( 'widgets/class-auxshp-wc-widget-layered-nav.php' );
        register_widget( 'AUXSHP_WC_Widget_Layered_Nav' );

  }

}

add_action( 'widgets_init', 'auxshp_override_woocommerce_widgets', 15 );


/**
 * Function For Change The WooCommerce Cart Item Remove Button in mini-cart.php
 */
function auxshp_filter_woocommerce_cart_item_remove_link( $sprintf, $cart_item_key ) {

    $sprintf = str_replace( 'class="remove"', 'class="remove auxshp-card-items-remove aux-svg-symbol aux-small-cross"', $sprintf );
    return str_replace( '&times;', '', $sprintf );

};

add_filter( 'woocommerce_cart_item_remove_link', 'auxshp_filter_woocommerce_cart_item_remove_link', 10, 2 );


/**
 * Remove parentheses from reviews counter in tabs section
 */
function auxshp_remove_parentheses_from_reviews_counter( $default, $key ) {

    return str_replace( array( '(', ')' ), array( '<span class="aux-reviews-number">', '</span>' ), $default );

}

add_filter( 'woocommerce_product_reviews_tab_title', 'auxshp_remove_parentheses_from_reviews_counter', 98, 2 );

/**
 * Add Shop Widget Area Button to shop Page
 */

function auxshp_custom_widget_area_btn() {
    $widget_area = auxin_get_option('product_index_custom_widget_area', 'no');

    if ( auxin_is_true( $widget_area) ) { ;?>
        <a href="#" class="aux-shop-custom-widget-area-btn">
            <span class="aux-filter-by"><?php  _e('Filter ', 'auxin-shop') ;?> <span class="aux-filter-name"><i class="auxicon-chevron-down-1"></i></span></span>
        </a><?php
    } else {
        return;
    }

}

add_action('woocommerce_before_shop_loop', 'auxshp_custom_widget_area_btn', 40);


/**
 * Add Shop Widget Area  to shop Page
 */

function auxshp_custom_widget_area() {
    $widget_area = auxin_get_option('product_index_custom_widget_area', 'no');

    if ( auxin_is_true( $widget_area) ) { ;?>

            <aside class="aux-shop-widget-area">
                <div class="aux-wrapper">
                    <div class="aux-container aux-fold">
                        <div class="aux-row aux-de-col4 aux-tb-col2 aux-mb-col1 "> <?php
                            foreach ( range( 1, 4 ) as $num  ) {
                                ; ?>
                                <div class="aux-widget-area aux-col">
                                    <?php

                                    if ( is_active_sidebar( 'aux-shop-'.$num.'-sidebar-widget-area' ) ) {
                                        dynamic_sidebar( 'aux-shop-'.$num.'-sidebar-widget-area' );
                                    }

                                    ?>
                                </div>

                            <?php }
                         ?>
                        </div>
                    </div>
                </div>
            </aside>
        <?php
    } else {
        return;
    }

}

add_action('woocommerce_before_shop_loop', 'auxshp_custom_widget_area', 50);


/**
 * Abilty to set Number of products in Shop page
 */

function auxshp_number_of_product_in_shop_page_output() {

    global $wp_query;

    $widget_area = auxin_get_option('product_index_custom_widget_area', 'no');
    $posts_per_page  = isset( $_GET['posts_per_page'] ) ? $_GET['posts_per_page'] : $wp_query->get('posts_per_page');

    if ( auxin_is_true( $widget_area) ) {
        ;?>

        <div class="aux-shop-product-number-text">
            <p><?php echo __( 'Number of show in page', 'auxin-shop' );?></p>
        </div>

        <div class="aux-shop-product-number aux-filters aux-dropdown-filter aux-left">
            <span class="aux-filter-by">
                <span class="aux-filter-name">
                    <?php echo $posts_per_page ;?>
                </span>
                <i class="auxicon-chevron-down-1"></i>
            </span>

            <ul>
                <?php foreach ( range( 4, 10 ) as $number  ) : ?>
                    <li class="aux-filter-item"><a href="<?php echo add_query_arg( 'posts_per_page', $number );?>"><span><?php echo esc_html( $number ); ?></span></a></li>
                <?php endforeach; ?>
            </ul>

        </div>
    <?php
    } else {
        return;
    }

}

add_action('woocommerce_before_shop_loop', 'auxshp_number_of_product_in_shop_page_output', 10);


/**
 * Prepare the Woocommerce Loop for Number of products in Shop page
 */

function auxshp_product_query_number( $q ) {
    $posts_per_page  = isset( $_GET['posts_per_page'] ) ? $_GET['posts_per_page'] : '';

    if ( is_shop() && ( $q->get( 'wc_query' ) === 'product_query' ) && ! empty( $posts_per_page ) ) {
        $q->set( 'posts_per_page', $posts_per_page );
    }

}

add_action( 'woocommerce_product_query', 'auxshp_product_query_number' );


/**
 * Register the Widgets Area in Shop Page
 */

function auxshp_register_widget() {

    $widget_area = auxin_get_option('product_index_custom_widget_area', 'no');

    if ( auxin_is_true( $widget_area ) ) {

    $shop_names = array( "First", "Second", "Third", "Fourth" );
    $col_nums = 4;

        for ( $i=1; $i <= $col_nums; $i++ ) {

            register_sidebar( array(
                'name'          => sprintf(__( 'Shop Page %s Widget Area', 'auxin-shop'), $shop_names[ $i - 1 ]),
                'id'            => 'aux-shop-'.$i.'-sidebar-widget-area',
                'description'   => sprintf(__( 'The %s column in shop widget area.' , 'auxin-shop'), $shop_names[ $i - 1 ]),
                'before_widget' => '<section id="%1$s" class="widget-container %2$s _ph_">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            ) );
        }

    }

}

add_action( 'widgets_init', 'auxshp_register_widget' );


/**
 * Register the Widgets Area in Shop Page
 */

function auxshp_resolve_add_to_cart_redirect( $url = false ) {

    if( ! empty( $url ) ) { return $url ; }

    return get_bloginfo('wpurl').add_query_arg(array(), remove_query_arg('add-to-cart'));
}

// commentd this function  on shop That would make some error when we use add to cart button
// add_action('woocommerce_add_to_cart_redirect', 'auxshp_resolve_add_to_cart_redirect');


/**
 * Register pair value repeater controller in woocommerce general tab
 */

function auxin_pair_value_repeater_field() {

    $args = array(
        'id' => 'aux_product_pair_fields',
        'label' => __( 'Product Custom Fields', 'auxin-shop' ),
        'class' => 'aux-product-custom-fields aux-input-is-hidden',
        'custom_attributes' => array(
            'data-is-json' => 'true'
        )
    );

    woocommerce_wp_text_input( $args );
    echo auxin_pair_value_repeater_html();

}

   add_action( 'woocommerce_product_options_advanced', 'auxin_pair_value_repeater_field' );


/**
 * save the pair value repeater controller in woocommerce general tab
 */

function auxin_save_pair_value_repeater_field( $post_id ) {
    $product = wc_get_product( $post_id );
    $title = isset( $_POST['aux_product_pair_fields'] ) ? $_POST['aux_product_pair_fields'] : '';
    $product->update_meta_data( 'aux_product_pair_fields', wp_unslash($title) );
    $product->save();
}

add_action( 'woocommerce_process_product_meta', 'auxin_save_pair_value_repeater_field' );