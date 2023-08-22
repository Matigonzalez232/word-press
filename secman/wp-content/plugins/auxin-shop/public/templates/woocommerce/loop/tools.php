<?php
/**
 * Tools for content loop
 *
 * @package   Auxin Shop
 * @author    averta [averta.net]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $auxshp_wishlist;

$display_tools = array(
                    'display_add_to_cart' => auxin_get_option( 'product_index_display_add_to_cart'   , '1' ),
                    'display_share'       => auxin_get_option( 'product_index_display_share'         , '1' ),
                    'display_wishlist'    => auxin_get_option( 'product_index_display_wishlist'      , '1' ),
                    'display_quicklook'   => auxin_get_option( 'product_index_display_quicklook'      , '0' ),
                );

if ( in_array( '1', $display_tools ) ) {
    // Set wishlist status
    $wishlist_class = 'available-add';
    if ( $auxshp_wishlist->in_wishlist( $product->get_id() ) ) {
        $wishlist_class = 'available-remove';
    }
    // Extract variable
    extract( $display_tools );
?>

    <div class="loop-tools-wrapper">
        <div class="aux-product-tools">
        <?php
            // Add to cart button
            if ( auxin_is_true( $display_add_to_cart ) ) {

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
            //Add wishlist button
            if ( auxin_is_true( $display_wishlist ) ) {
                wc_get_template( 'loop/wishlist.php' );
            }
            // Add share button
            if ( auxin_is_true( $display_share ) ) {
        ?>
                <div class="auxshp-share-wrapper">
                    <div class="aux-share-btn aux-tooltip-socials aux-tooltip-dark aux-socials">
                        <span class="aux-icon auxicon-share"></span>
                    </div>
                </div>
        <?php
            }

            if ( auxin_is_true( $display_quicklook ) ) {
        ?>
                <div class="aux-shop-quicklook-wrapper">
                    <a rel="nofollow" class="aux-shop-quicklook" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" data-product-type="<?php echo esc_attr( $product->get_type() ); ?>" data-verify-nonce="<?php echo wp_create_nonce( 'aux-quicklook-' . $product->get_id() ); ?>">
                        <i class="aux-quicklook-icon aux-ico auxicon-eye-1"></i>
                    </a>
                </div>
        <?php

            }
        ?>
        </div>
    </div>

<?php
}
