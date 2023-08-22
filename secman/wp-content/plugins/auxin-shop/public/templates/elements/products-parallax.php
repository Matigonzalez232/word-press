<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $auxshp_wishlist;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$item_class = 'aux-parallax-item aux-inner-col';

if ( auxin_is_true($tilt) ) {
	$item_class .= ' aux-tilt-box';
}

?>

<div <?php wc_product_class( $item_class, $product ); ?>>
	<?php

	$column_media_width = auxin_get_content_column_width( $desktop_cnum, 15 );
    $size = array( 'width' => $column_media_width, 'height' => $column_media_width * $image_aspect_ratio );

    $image_class = '';

    if ( $colorized_shadow ) {
    	$image_class = 'aux-img-dynamic-dropshadow';
    }

	woocommerce_template_loop_product_link_open();

	auxshp_get_product_thumbnail( array(
        'size'            => $size,
        'gallery'         => false,
        'class'           =>  $image_class,
        'preloadable'     => $preloadable,
        'preload_preview' => $preload_preview,
        'preload_bgcolor' => $preload_bgcolor,
        'content_width'   => $content_width
    ) );

	if ( auxin_is_true( $display_sale_badge ) ) {
		woocommerce_show_product_loop_sale_flash();
	}

	woocommerce_template_loop_product_link_close();

	echo '<div class="auxshp-entry-main">';

		if ( $display_title ) {
			woocommerce_template_loop_product_title();
		}

		if ( $display_price ) {
			woocommerce_template_loop_price();
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
	        </div>
	    </div>

	</div>
</div>
