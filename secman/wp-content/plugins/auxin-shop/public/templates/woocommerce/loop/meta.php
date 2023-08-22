<?php
/**
 * Loop Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/rating.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = get_the_terms( $post->ID, 'product_cat' );
$cat_count = is_array( $cat_count ) ? count( $cat_count ) : 0;

$tag_count = get_the_terms( $post->ID, 'product_tag' );
$tag_count = is_array( $tag_count ) ? count( $tag_count ) : 0;
?>
<div class="loop-meta-wrapper">
    <div class="product_meta">
        <?php

        if ( 'default' == $show_cats = auxin_get_post_meta( $product->get_id(), '_product_related_posts_display_categories', 'default' ) ) {
            $show_cats = auxin_get_option('product_related_posts_display_categories', '1' );
        }

        $show_cats = is_shop() ? auxin_get_option('product_index_display_category', '1' ) : $show_cats;

        if ( auxin_is_true( $show_cats ) && $cat_count > 0 ) {
            echo wc_get_product_category_list( $product->get_id(), ', ', '<em class="auxshp-meta-terms">', '</em>' );
        } ?>
    </div>
</div>

<?php


