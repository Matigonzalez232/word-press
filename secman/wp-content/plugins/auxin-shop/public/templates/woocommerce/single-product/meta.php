<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

$cat_count = get_the_terms( $post->ID, 'product_cat' );
$cat_count = is_array( $cat_count ) ? count( $cat_count ) : 0;

$tag_count = get_the_terms( $post->ID, 'product_tag' );
$tag_count = is_array( $tag_count ) ? count( $tag_count ) : 0;

?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' );

    if ( 'default' == $show_sku = auxin_get_post_meta( $product->get_id(), '_product_single_display_sku', 'default' ) ) {
        $show_sku = auxin_get_option( 'product_single_display_sku', '1' );
    }

    if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) && auxin_is_true( $show_sku ) ) : ?>
        <div class="auxshp-sku-wrapper auxshp-meta-section">
            <span class="sku-lable auxshp-label label-default"><?php _e( 'SKU', 'auxin-shop' ); ?></span> 
            <span class="sku-value" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'auxin-shop' ); ?></span>
        </div>
    <?php endif; ?>

    <?php 

    if ( 'default' == $show_cats = auxin_get_post_meta( $product->get_id(), '_product_single_display_category', 'default' ) ) {
        $show_cats = auxin_get_option( 'product_single_display_category', '1' );
    }

    if ( auxin_is_true( $show_cats ) && $cat_count > 0 ) : ?>
    <div class="auxshp-cats-wrapper auxshp-meta-section">
        <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="auxshp-label label-default auxshp-product-cats posted_in">' . _n( 'Category', 'Categories', $cat_count, 'auxin-shop' ) . '</span><span class="auxshp-meta-terms">', '</span>' ); ?>
    </div>
    <?php endif; ?>
    <?php

    if ( 'default' == $show_tags = auxin_get_post_meta( $product->get_id(), '_product_single_display_tag', 'default' ) ) {
        $show_tags = auxin_get_option( 'product_single_display_tag', '1' );
    }

    if ( auxin_is_true( $show_tags ) && $tag_count > 0 ) : ?>
    <div class="auxshp-tags-wrapper auxshp-meta-section">
        <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="auxshp-label label-default auxshp-product-tags tagged_as">' . _n( 'Tag', 'Tags', $tag_count, 'auxin-shop' ) . '</span><span class="auxshp-meta-terms">', '</span>' ); ?>
    </div>
    <?php endif; ?>
    <?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
