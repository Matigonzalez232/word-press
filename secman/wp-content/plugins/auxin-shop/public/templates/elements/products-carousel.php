<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $auxshp_wishlist;

$cat_count      = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$featured_color = get_post_meta( $post->ID, 'auxin_product_featured_color_enabled', true ) ? get_post_meta( $post->ID, 'auxin_product_featured_color', true ) : auxin_get_option( 'product_single_featured_color' );
$featured_color = !empty( $featured_color ) ? 'data-featured-color='. esc_attr( $featured_color )  : '' ;
$extra_class    = auxin_is_true( $display_featured_color ) ? esc_attr( 'aux-featured-color' ) : '';
$meta_fields 	= auxin_get_post_meta( $post->ID, 'aux_product_pair_fields', '' );
?>

<div <?php wc_product_class( 'aux-col', $product ); ?>>
	<?php

    $image_class = '';

	woocommerce_template_loop_product_link_open();

	auxshp_get_product_thumbnail( array(
        'size'            => $size,
        'gallery'         => true,
        'class'           => '',
        'preloadable'     => $preloadable,
        'preload_preview' => $preload_preview,
        'preload_bgcolor' => $preload_bgcolor,
        'content_width'   => $content_width
    ) );

	if ( auxin_is_true( $display_sale_badge ) ) {
		woocommerce_show_product_loop_sale_flash();
	}
	echo '<div class="auxshp-entry-main ' . esc_attr( $extra_class ) . '"' . $featured_color  . '>';

		if ( $display_title ) {
			woocommerce_template_loop_product_title();
		}

		if ( $display_price ) {
			woocommerce_template_loop_price();
		}


		if ( auxin_is_true( $display_meta_fields ) ) {
			echo auxin_meta_fields_output( $meta_fields );
		}

		if ( auxin_is_true( $display_rating ) ) {
			woocommerce_template_loop_rating();
		}

		if ( auxin_is_true( $display_content ) ) {
			echo '<div class="aux-shop-desc-wrapper">';
				 echo auxin_the_trim_excerpt( null, $desc_char_num );
			echo '</div>';
		}

		?>
		<div class="loop-meta-wrapper">
		    <div class="product_meta">
		        <?php
		        if ( auxin_is_true( $display_categories ) && $cat_count > 0 ) {
		            echo wc_get_product_category_list( $product->get_id(), ', ', '<em class="auxshp-meta-terms">', '</em>' );
		        } ?>
		    </div>
		</div>

		<div class="loop-tools-wrapper">
	       <div class="aux-product-tools">
	        <?php

	            $wishlist_class = 'available-add';
			    if ( $auxshp_wishlist->in_wishlist( $product->get_id() ) ) {
			        $wishlist_class = 'available-remove';
			    }

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
	            } ?>

	            <?php if ( auxin_is_true( $display_wishlist ) ) : 
					wc_get_template( 'loop/wishlist.php' );
				endif; 
				?>
	            <?php if ( auxin_is_true( $display_share ) ) : ?>
	                <div class="auxshp-share-wrapper">
	                    <div class="aux-share-btn aux-tooltip-socials aux-tooltip-dark aux-socials">
	                        <span class="aux-icon auxicon-share"></span>
	                    </div>
	                </div>
	        	<?php endif; ?>
				<?php
				if ( auxin_is_true( $display_quicklook ) ) {

					echo '<div class="aux-shop-quicklook-wrapper">';
						printf('<a rel="nofollow" class="%s" data-product-id="%s" data-product-type="%s" data-verify-nonce="%s"><i class="aux-quicklook-icon aux-ico auxicon-eye-1"></i></a>', 'aux-shop-quicklook', $product->get_id(), $product->get_type(), wp_create_nonce( 'aux-quicklook-' . $product->get_id() ) );
					echo '</div>';

				}
				?>
	        </div>
	    </div>

	</div>
</div>
