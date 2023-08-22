<?php
/**
 * Add  Wishlist Icon To Header if WC is Active
 *
 * @return string            The HTML Output
 */

function auxin_wc_wishlist( $args = array() ){

    $wishlist_id  = get_option( 'auxshp_wishlist_page' );
    $wishlist_url = get_permalink( $wishlist_id );

    $defaults   = array(
            'css_class'      => '',
            'icon_class' => 'auxicon-heart-3',
    );

    $args = wp_parse_args( $args, $defaults );

    $output  = '<div class="aux-wishlist-header-wrapper ' . esc_attr( $args['css_class'] ) . '">';
    $output .= '<a class="aux-wishlist-url" href="' . esc_url( $wishlist_url ) . '">';
    $output .= '<i class="' . $args['icon_class'] . '"></i>';
    $output .= '</a>';
    $output .= '</div>';

    echo $output;

}

/**
 * Generate Meta fields output
 *
 * @return string            The HTML Output
 */
function auxin_meta_fields_output( $fields ){

    if ( empty( $fields ) ) {
        return;
    }

    $array = json_decode( $fields, true );

    $output = '<div class="aux-shop-meta-fields">';

    foreach ( $array['meta-fields'] as $key => $value ) {
        $output .= '<div class="aux-shop-meta-field">';
            $output .= '<span class="aux-shop-meta-key">' . esc_attr( $value['meta-key'] )  . '</span>';
            $output .= '<span class="aux-shop-meta-value">' . esc_attr( $value['meta-value'] ) . '</span>';
        $output .= '</div>';
    }

    $output .= '</div>';


    return $output;

}

/**
 * Change Image aspect ratio of related products
 *
 * @return float  image aspect ratio
 */
function auxin_related_product_thumbnail_aspect_ratio( $image_aspect_ratio ) {

    if( $custom_aspect_ratio = auxin_get_option('product_related_image_aspect_ratio' ) ){
        return $custom_aspect_ratio;
    }

    return $image_aspect_ratio;
}