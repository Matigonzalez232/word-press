<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

/**
 * Button markup has changed.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart" method="post" enctype='multipart/form-data'>
	<div class="group_table">
		<?php
			$quantites_required = false;
			$grouped_product_columns = apply_filters(
				'woocommerce_grouped_product_columns',
				array(
					'quantity',
					'label',
					'price',
				),
				$product
			);
			$show_add_to_cart_button = false;

			do_action( 'woocommerce_grouped_product_list_before', $grouped_product_columns, $quantites_required, $product );

			foreach ( $grouped_products as $grouped_product ) {
				$post_object        = get_post( $grouped_product->get_id() );
				$quantites_required = $quantites_required || ( $grouped_product->is_purchasable() && ! $grouped_product->has_options() );

				if ( $grouped_product->is_in_stock() ) {
					$show_add_to_cart_button = true;
				}

				setup_postdata( $GLOBALS['post'] =& $post_object );
				?>
				<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( ! $grouped_product->is_purchasable() || $grouped_product->has_options() ) : ?>
						<?php woocommerce_template_loop_add_to_cart(); ?>

					<?php elseif ( $grouped_product->is_sold_individually() ) : ?>
						<input type="checkbox" name="<?php echo esc_attr( 'quantity[' . $grouped_product->get_id() . ']' ); ?>" value="1" class="wc-grouped-product-add-to-cart-checkbox" />

					<?php else : ?>
						<?php
							/**
							 * @since 3.0.0.
							 */
							do_action( 'woocommerce_before_add_to_cart_quantity' );

							woocommerce_quantity_input( array(
								'input_name'  => 'quantity[' . $grouped_product->get_id() . ']',
								'input_value' => isset( $_POST['quantity'][ $grouped_product->get_id() ] ) ? wc_stock_amount( $_POST['quantity'][ $grouped_product->get_id() ] ) : 0,
								'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product ),
								'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product->get_max_purchase_quantity(), $grouped_product ),
							) );

							/**
							 * @since 3.0.0.
							 */
							do_action( 'woocommerce_after_add_to_cart_quantity' );
						?>
					<?php endif; ?>
					<div class="label">
						<label for="product-<?php echo esc_attr( $grouped_product->get_id() ); ?>">
							<?php echo $product->is_visible() ? '<a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', get_permalink(), $grouped_product->get_id() ) ) . '">' . get_the_title() . '</a>' : get_the_title(); ?>
						</label>
					</div>
					<?php do_action( 'woocommerce_grouped_product_list_before_price', $grouped_product ); ?>
					<div class="price">
						<?php
							echo $grouped_product->get_price_html();
							echo wc_get_stock_html( $grouped_product );
						?>
					</div>
				</div>
				<?php
			}
			wp_reset_postdata();
		?>
	</div>

	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />

	<?php if ( $quantites_required && $show_add_to_cart_button ) : ?>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<button type="submit" class="auxshp-add-to-cart single_add_to_cart_button aux-button aux-exlarge aux-black aux-uppercase <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><span class="aux-overlay"></span><span class="aux-text"><?php echo esc_html( $product->single_add_to_cart_text() ); ?> </span></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php endif; ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
