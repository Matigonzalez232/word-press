<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/share.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

do_action( 'auxshp-before-single-wishlist' );

global $product; 

if ( auxin_is_true( auxin_get_option( 'product_wishlist_use_ti_plugin', false ) ) ) {
    echo do_shortcode( '[ti_wishlists_addtowishlist]' );
} else {
    global $auxshp_wishlist;

    $wishlist_class = 'available-add';
    $whislist_text = __( 'Add to wishlist', 'auxin-shop' );
    
    if ( $auxshp_wishlist->in_wishlist( $product->get_id() ) ) {
        $wishlist_class = 'available-remove';
        $whislist_text = __( 'Remove from wishlist', 'auxin-shop' );
    }
    $wishlist_icon = auxin_get_option( 'product_single_wishlist_button_icon', 'auxicon-heart-2' ) ;    
?>

    <div class="auxshp-wishlist-wrapper">
        <span class="auxshp-wishlist <?php echo esc_attr( $wishlist_class ); ?>" data-auxshp-product_id="<?php echo esc_attr( $product->get_id() ); ?>" data-auxshp-verify_nonce="<?php echo wp_create_nonce( 'remove_wishlist-' . $product->get_id() ); ?>">
            <?php if ( 'icon' == auxin_get_option( 'product_single_like_button_type', 'icon' ) ) { ?>
                <span class="auxshp-sw-icon auxshp-wishlist-icon <?php echo esc_attr( $wishlist_icon ); ?>"></span>
            <?php } ?>
            <span class="auxshp-wishlist-text">
            <?php echo $whislist_text; ?></span>
        </span>
    </div>

<?php 
}
do_action( 'auxshp-after-single-wishlist' ); ?>
