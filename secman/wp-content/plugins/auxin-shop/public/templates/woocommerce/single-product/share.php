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
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

 
/**
 * Only the last line is like share.php template file
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>
<?php do_action( 'auxshp-before-single-share' ); ?>
<?php $share_icon = auxin_get_option( 'product_single_share_button_icon', 'auxicon-share' ) ; ?>
<div class="auxshp-share-wrapper">
    <div class="aux-share-btn aux-tooltip-socials aux-tooltip-dark aux-socials">
        <?php if ( 'icon' == auxin_get_option( 'product_single_share_button_type', 'icon' ) ) { ?>
            <span class="aux-icon <?php echo esc_attr( $share_icon ); ?>"></span>
        <?php } ?>
        <span class="aux-text"><?php _e( 'Share', 'auxin-shop' ); ?></span>
    </div>
</div>

<?php do_action( 'auxshp-after-single-share' ); ?>

<?php do_action( 'woocommerce_share' ); // Sharing plugins can hook into here ?>